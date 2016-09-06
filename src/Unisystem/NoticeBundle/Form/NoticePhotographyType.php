<?php

namespace Unisystem\NoticeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticePhotographyType extends AbstractType
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
                'label' => 'noticephotography.form.name',
                'translation_domain' => 'UnisystemNoticeBundle',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unisystem\NoticeBundle\Entity\NoticePhotography'
        ));
    }
}
