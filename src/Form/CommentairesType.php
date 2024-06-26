<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Commentaires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Description')
            ->add('Auteur')
            ->add('Title')
            ->add('Date', null, [
                'widget' => 'single_text',
            ])
            ->add('articles', EntityType::class, [
                'class' => Articles::class,
                'choice_label' => 'Title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
