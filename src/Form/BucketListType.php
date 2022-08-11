<?php

namespace App\Form;

use App\Entity\BucketList;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class BucketListType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'attr' => [
                    'class'=>'form-control',
                    'minlength' => 2,
                    'maxlength' => 50
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class'=>'form-label mt-4'
                ],
                'constraints'=>[
                    new Assert\Length(['min' => 2, 'max' => 100]),
                    new Assert\NotBlank()
                ]
            ])->add('description',TextareaType::class,[
                    'attr'=> [
                        'class'=>'form-control',
                        'row'  => 3,
                        'col' => 3
                    ],
                    'label' => 'Description',
                    'label_attr' =>[
                        'class' => 'form-label mt-4'
                    ]
            ])->add('author',TextType::class,[
                    'attr'=> [
                        'class' => 'form-control',
                        'minlength'=> 2,
                        'maxlength'=>50
                    ],
                    'label'=>'Auteur',
                    'label_attr'=>[
                        'class'=>'form-label'
                    ]
                ])->add('category', EntityType::class,[
                'class' => Category::class,
                'attr' => [
                    'class'=>'form-select'
                ],
                'label' => 'Catégorie'


            ])
            ->add('submit',SubmitType::class,[
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ],
                    'label' => 'Créer une tache'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BucketList::class,
        ]);
    }
}
