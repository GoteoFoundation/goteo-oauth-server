<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthorizationType extends AbstractType
{
    /** @var Translator $translator */
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accept', CheckboxType::class, [
                'label' => $this->translator->trans("Accept", domain: "authorization"),
                'required' => false,
            ])
            ->add('refuse', CheckboxType::class, [
                'label' => $this->translator->trans("Refuse", domain: "authorization"),
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans("Submit", domain: "authorization")
            ]);
    }
}