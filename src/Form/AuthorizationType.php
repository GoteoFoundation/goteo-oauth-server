<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AuthorizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accept', CheckboxType::class, [
                'required' => false,
            ])
            ->add('refuse', CheckboxType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class);
    }
}