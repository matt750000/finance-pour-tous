<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nom complet',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom est requis.',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L’adresse e-mail est requise.',
                    ]),
                    new Assert\Email([
                        'message' => 'L’adresse {{ value }} n’est pas valide.',
                    ]),
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le sujet est requis.',
                    ]),
                    new Assert\Length([
                        'max' => 150,
                        'maxMessage' => 'Le sujet ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['rows' => 6],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le message ne peut pas être vide.',
                    ]),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
