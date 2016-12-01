<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array(
                'label' => 'Titre'
                )
            )
            ->add('resume', TextType::class, array(
                'label' => 'Résumé'
                )
            )
            ->add('contenu', TextareaType::class, array(
                'label' => 'Contenu'
                )
            )

            ->add('categories', EntityType::class, array(
              'class' => 'BlogBundle:Category',
              'choice_label' => 'nom',
            ))

            ->add('published', CheckboxType::class, array(
                'label' => 'Publié',
                'required' => false
                )
            )
            ->add('date', DateTimeType::class, array(
                'label' => 'Date de publication',
                'input'=>'datetime',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'required' => true
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'BlogBundle\Entity\Article'
        ));
    }
}
