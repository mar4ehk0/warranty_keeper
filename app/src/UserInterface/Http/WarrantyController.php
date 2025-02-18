<?php

namespace App\UserInterface\Http;

use App\Application\Warranty\UseCase\WarrantyKeepUseCase;
use App\Application\Warranty\UseCase\WarrantyKeepUseCaseEntryDto;
use App\UserInterface\Form\WarrantyForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WarrantyController extends BaseController
{

    public function __construct(
        private readonly WarrantyKeepUseCase $useCase,
        private readonly ValidatorInterface $validator,
    ) {
    }
    #[Route('/upload', name: 'upload', methods: ['GET', 'POST'])]
    public function keep(Request $request): Response
    {
        $form = $this->createForm(WarrantyForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $receipt = $form->get('receipt')->getData();
            $humanDescription = $form->get('human_description')->getData();
            $warrantyUntil = $form->get('warranty_until')->getData();

            $dto = new WarrantyKeepUseCaseEntryDto($name, $humanDescription, $receipt, $warrantyUntil);

            $errors = $this->validator->validate($dto);
            if (count($errors) > 0) {
                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $this->useCase->run($dto);
            // редирект


//            if ($uploadedReceipt) {
//                $dto = UploadFileEntryDto::createFromUploadedFile($uploadedReceipt);
//                $this->handler->handle($dto);
//                // тут редирект на создание warrantly в аргументах должен быть recongnnizedtext
//            }
        }

        return $this->render('warranty/upload.html.twig', [
            'form' => $form,
        ]);
    }
}
