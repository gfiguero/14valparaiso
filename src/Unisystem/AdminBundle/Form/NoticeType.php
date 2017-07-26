<?php

namespace Unisystem\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => 'notice.form.title',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('content', null, array(
                'label' => 'notice.form.content',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))
            ->add('photographies', 'bootstrap_collection', array(
                'label' => 'notice.form.photographies',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
                'by_reference' => false,
                'entry_type' => 'Unisystem\AdminBundle\Form\NoticePhotographyType',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_button_text' => 'Eliminar',
                'add_button_text' => 'Agregar',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unisystem\AdminBundle\Entity\Notice'
        ));
    }
}
