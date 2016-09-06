<?php

namespace Unisystem\ProcessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'stage.form.name',
                'translation_domain' => 'UnisystemProcessBundle',
                'required' => false,
            )) 
            ->add('description', null, array( 
                'label' => 'stage.form.enabled',
                'translation_domain' => 'UnisystemProcessBundle',
                'attr' => array( 'class' => 'switch', 'label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            )) 
            ->add('file', 'fileinput', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'stage.form.photography',
                'translation_domain' => 'UnisystemProcessBundle',
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
            'data_class' => 'Unisystem\ProcessBundle\Entity\Stage'
        ));
    }
}
