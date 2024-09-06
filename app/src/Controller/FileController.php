<?php

namespace App\Controller;

use App\Form\FileUploadForm;
use App\UseCase\FileUpload\FileUploaderHandler;
use App\UseCase\FileUpload\UploadFileEntryDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FileController extends AbstractController
{
    public function __construct(private readonly FileUploaderHandler $handler)
    {
    }

    #[Route('/upload', name: 'upload', methods: ['GET', 'POST'])]
    public function upload(Request $request): Response
    {
        $form = $this->createForm(FileUploadForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('file')->getData();

            if ($uploadedFile) {
                $dto = UploadFileEntryDto::createFromUploadedFile($uploadedFile);
                $this->handler->handle($dto);
                // тут редирект на создание warrantly в аргументах должен быть recongnnizedtext
            }
        }

        return $this->render('recognize/file_upload.html.twig', [
            'form' => $form,
        ]);
    }
}
