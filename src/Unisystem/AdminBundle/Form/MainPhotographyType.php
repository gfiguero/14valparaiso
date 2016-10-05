<?php

namespace Unisystem\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainPhotographyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'main.photography.form.title',
                'translation_domain' => 'UnisystemAdminBundle',
            ))
            ->add('caption', null, array( 
                'label' => 'main.photography.form.caption',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('file', 'fileinput', array(
                'label' => 'main.photography.form.photography',
                'translation_domain' => 'UnisystemAdminBundle',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unisystem\AdminBundle\Entity\MainPhotography'
        ));
    }
}
