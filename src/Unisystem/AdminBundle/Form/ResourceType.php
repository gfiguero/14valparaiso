<?php

namespace Unisystem\AdminBundle\Form;

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
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('description', null, array( 
                'label' => 'resource.form.description',
                'translation_domain' => 'UnisystemAdminBundle',
                'attr' => array( 'class' => 'switch', 'label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            )) 
            ->add('file', 'fileinput', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'resource.form.photography',
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
            'data_class' => 'Unisystem\AdminBundle\Entity\Resource'
        ));
    }
}
