<?php

namespace App\OCR\Yandex;

use App\Entity\File;
use App\OCR\Exception\CouldNotRecognizeTextException;
use App\OCR\Yandex\Exception\CouldNotValidateYandexOCRResponseException;
use App\OCR\Yandex\Repository\IAMTokenRepository;
use App\Service\RecognizedText\RecognizerClientInterface;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use JsonException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class YandexRecognizerClient implements RecognizerClientInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private IAMTokenRepository $IAMTokenRepository,
        private readonly string $yandexXFolderId,
        private readonly string $yandexRecognizeTextV1Url,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws CouldNotRecognizeTextException
     */
    public function sendRequest(File $file): string
    {
        try {
            $body = $this->createBody($file);

            $token = $this->IAMTokenRepository->getActiveToken(new DateTimeImmutable());

            $response = $this->client->request(
                'POST',
                $this->yandexRecognizeTextV1Url,
                [
                    'auth_bearer' => $token->getValue(),
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => '*/*',
                        'x-folder-id' => $this->yandexXFolderId,
                    ],
                    'body' => $body,
                ]
            );

            $this->validateResponse($response);

            return $response->toArray()['result']['textAnnotation']['fullText'];
        } catch (JsonException $e) {
            $this->logger->error(
                sprintf(
                    'Could not json encode data for sending response to Yandex OCR. Exception: %s. File: %s',
                    JsonException::class,
                    $file->getId()
                ),
                ['exception' => $e, 'file' => $file]
            );

            throw CouldNotRecognizeTextException::withFileId($file->getId(), $e);
        } catch (NonUniqueResultException|NoResultException $e) {
            $this->logger->error(
                sprintf(
                    'Check Token for Yandex OCR. It does not exit or there are several!. File: %s',
                    $file->getId()
                ),
                ['exception' => $e, 'file' => $file]
            );

            throw CouldNotRecognizeTextException::withFileIdThatWrongToken($file->getId(), $e);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    'Could not send Request to Yandex OCR that client has exception. File: %s',
                    $file->getId()
                ),
                ['exception' => $e, 'file' => $file]
            );

            throw CouldNotRecognizeTextException::withFileIdThatClientHasException($file->getId(), $e);
        } catch (CouldNotValidateYandexOCRResponseException $e) {
            $this->logger->error(
                sprintf('Could not validate Response from Yandex OCR. File: %s', $file->getId()),
                ['exception' => $e, 'file' => $file]
            );

            throw CouldNotRecognizeTextException::withFileIdThatWasNotValid($file->getId(), $e);
        }
    }

    /**
     * @throws JsonException
     */
    private function createBody(File $file): string
    {
        $content = file_get_contents($file->getPath());
        $encodedContent = base64_encode($content);

        return json_encode(
            [
                'mimeType' => 'JPEG',
                'languageCodes' => ['*'],
                'model' => 'page',
                'content' => $encodedContent,
            ],
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @throws CouldNotValidateYandexOCRResponseException
     */
    private function validateResponse(ResponseInterface $response): void
    {
        try {
            $content = $response->toArray();
        } catch (
            ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e
        ) {
            throw CouldNotValidateYandexOCRResponseException::hasException($e);
        }

        if (empty($content)) {
            throw CouldNotValidateYandexOCRResponseException::thatEmptyResponse();
        }

        if (empty($content['result'])) {
            throw CouldNotValidateYandexOCRResponseException::thatWrongField('result', 'is empty');
        }

        if (empty($content['result']['textAnnotation'])) {
            throw CouldNotValidateYandexOCRResponseException::thatWrongField('result->textAnnotation', 'is empty');
        }

        if (empty($content['result']['textAnnotation']['fullText'])) {
            throw CouldNotValidateYandexOCRResponseException::thatWrongField('result->textAnnotation->fullText', 'is empty');
        }
    }
}
