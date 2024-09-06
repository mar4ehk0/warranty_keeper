<?php

namespace App\OCR\Yandex\UseCase\CreateIAMToken\Service;

use App\OCR\Yandex\Entity\IAMToken;
use App\OCR\Yandex\Factory\IAMTokenFactory;
use App\OCR\Yandex\UseCase\CreateIAMToken\Exception\CouldNotSendRequestForIAMTokenException;
use App\OCR\Yandex\UseCase\CreateIAMToken\Exception\CouldNotValidateResponseException;
use JsonException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class IAMTokenClient
{
    public function __construct(
        private HttpClientInterface $client,
        private IAMTokenFactory $IAMTokenFactory,
        private readonly string $yandexIamTokenV1Url
    ) {
    }

    public function getAIMToken(string $jwt): IAMToken
    {
        try {
            $body = json_encode(['jwt' => $jwt], JSON_THROW_ON_ERROR);

            $response = $this->client->request(
                'POST',
                $this->yandexIamTokenV1Url,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => '*/*',
                    ],
                    'body' => $body,
                ]
            );

            $this->validateResponse($response);

            $value = $response->toArray()['iamToken'];

            return $this->IAMTokenFactory->create($value);
        } catch (JsonException $e) {
            throw CouldNotSendRequestForIAMTokenException::withJwt($jwt);
        } catch (ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e) {
            throw CouldNotSendRequestForIAMTokenException::withBody($body);
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function validateResponse(ResponseInterface $response): void
    {
        $content = $response->toArray();

        if (empty($content)) {
            throw CouldNotValidateResponseException::thatEmptyResponse();
        }

        if (empty($content['iamToken'])) {
            throw CouldNotValidateResponseException::thatFieldIamTokenEmpty();
        }
    }
}
