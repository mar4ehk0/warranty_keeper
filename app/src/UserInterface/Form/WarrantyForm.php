<?php

namespace App\UserInterface\Form;

use DateTimeImmutable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class WarrantyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
            )
            ->add(
                'human_description',
                TextareaType::class,
            )
            ->add(
                'warranty_until',
                DateTimeType::class,
                [
                    'input' => 'datetime_immutable',
                    'data' => new DateTimeImmutable('+1 year'),
                ]
            )
            ->add(
                'receipt',
                FileType::class,
                [
                    'mapped' => false,
                ]
            )
            ->add('save', SubmitType::class);
    }
}
