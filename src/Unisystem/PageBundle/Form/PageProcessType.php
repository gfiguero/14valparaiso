<?php

namespace Unisystem\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageProcessType extends AbstractType
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
                'label' => 'pageprocess.form.name',
                'translation_domain' => 'UnisystemPageBundle',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unisystem\PageBundle\Entity\PageProcess'
        ));
    }
}
