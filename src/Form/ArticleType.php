<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'help' => "Le titre de l'article, utlilisé dans l'url",
                'empty_data' => '',
                'attr' => [
                    'placeholder' => "Le titre de l'article, utlilisé dans l'url"]
            ])
            ->add('content', TextareaType::class, ['empty_data' => ''])
            ->add('author', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 3])]
            ])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn'], ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
//            'csrf_protection' => true,
        ]);
    }

}