<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('accept_or_refuse', ChoiceType::class, [
                'label' => $this->translator->trans("authorization.accept_or_refuse.label", domain: "authorization"),
                'choices' => $this->acceptOrRefuseChoices(),
                'attr' => [
                    'class' => 'form-check'
                ],
                'expanded' => true,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => $this->translator->trans("authorization.submit.label", domain: "authorization")
            ]);
    }

    private function acceptOrRefuseChoices(): array
    {
        return [
            $this->translator->trans('authorization.accept.label', domain: "authorization") => 'accept',
            $this->translator->trans('authorization.refuse.label', domain: "authorization") => 'refuse'
        ];
    }
}