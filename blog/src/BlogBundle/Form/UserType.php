<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, array(
                    'label' => 'Role',
                    'mapped' => true,
                    'multiple' => true,
                    'choices' => array(
                        'Administrateur' => 'ROLE_ADMIN',
                        'Utilisateur' => 'ROLE_USER',
                        'Rédacteur' => 'ROLE_REDACTEUR'
                    ) 
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
            'data_class' => 'BlogBundle\Entity\User'
        ));
    }
}
