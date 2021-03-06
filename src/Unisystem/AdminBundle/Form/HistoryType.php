<?php

namespace Unisystem\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'stage.form.title',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('content', null, array( 
                'label' => 'stage.form.content',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('date', null, array( 
                'label' => 'stage.form.date',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('file', 'fileinput', array(
                'label' => 'stage.form.photography',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unisystem\AdminBundle\Entity\History'
        ));
    }
}
