<?php

namespace App\Form;

use App\Service\OptionsProvider\AlgorithmOptionsProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class SimilarityFormType extends AbstractType
{
    public function __construct(private AlgorithmOptionsProvider $algorithmOptionsProvider)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text1', TextareaType::class, [
                'required' => false,
                'label' => 'Text1',
                'attr' => [
                    'help' => 'test',
                    'class' => ' form-control'
                ],
                'label_attr' => [
                    'style' => 'text-align: center; width: 100%'
                ]
            ])
            ->add('additional_text1', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'help' => 'test',
                    'class' => ' form-control'
                ],
                'label_attr' => [
                    'style' => 'text-align: center; width: 100%'
                ]
            ])
            ->add('text2', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'help' => 'test',
                    'class' => ' form-control'
                ],
                'label_attr' => [
                    'style' => 'text-align: center; width: 100%'
                ]
            ])
            ->add('additional_text2', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'help' => 'test',
                    'class' => ' form-control'
                ],
                'label_attr' => [
                    'style' => 'text-align: center; width: 100%'
                ]
            ])
            ->add('algorithm', ChoiceType::class, [
                'required' => false,
                'choices' => array_flip($this->algorithmOptionsProvider->getAlgorithms()),
                'choice_attr' => function($key) {
                    return ['title' => $this->algorithmOptionsProvider->getAlgorithmDescriptionBasedOnKey($key), 'class' => 'custom-control-input'];
                },
                'data' => '0',
                'placeholder' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('generateTexts', ButtonType::class, [
                'attr' => [
                    'class' => 'generate-text'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'submit'
                ]
            ])
            ->add('result', TextareaType::class, [
                'required' => false,
                'disabled' => 'disabled',
                'attr' => [
                    'class' => ' form-control'
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'similaritipsum_similarity';
    }
}

