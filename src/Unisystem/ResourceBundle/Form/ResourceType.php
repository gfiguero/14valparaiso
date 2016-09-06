<?php

namespace Unisystem\ResourceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \DateTime;

class ResourceType extends AbstractType
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
                'label' => 'resource.form.name',
                'translation_domain' => 'UnisystemResourceBundle',
                'required' => false,
            )) 
            ->add('description', null, array( 
                'label' => 'resource.form.enabled',
                'translation_domain' => 'UnisystemResourceBundle',
                'attr' => array( 'class' => 'switch', 'label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            )) 
            ->add('file', 'resource_photography', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'resource.form.photography',
                'translation_domain' => 'UnisystemResourceBundle',
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
            'data_class' => 'Unisystem\ResourceBundle\Entity\Resource'
        ));
    }
}
