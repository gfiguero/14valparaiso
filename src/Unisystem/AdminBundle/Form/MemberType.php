<?php

namespace Unisystem\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \DateTime;

class MemberType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('role', 'entity', array(
                'class' => 'UnisystemAdminBundle:MemberRole',
                'choice_label' => 'name',
                'attr' => array( 'label_col' => 3, 'widget_col' => 9, 'class' => 'member_role_multiselect' ),
                'label' => 'member.form.role',
                'translation_domain' => 'UnisystemAdminBundle',
            )) 
            ->add('courses', 'entity', array(
                'class' => 'UnisystemAdminBundle:MemberCourse',
                'choice_label' => 'name',
                'attr' => array( 'label_col' => 3, 'widget_col' => 9, 'class' => 'member_courses_multiselect' ),
                'label' => 'member.form.courses',
                'translation_domain' => 'UnisystemAdminBundle',
                'multiple' => true,
                'required' => false,
            ))
            ->add('previous_roles', 'entity', array(
                'class' => 'UnisystemAdminBundle:MemberRole',
                'choice_label' => 'name',
                'attr' => array( 'label_col' => 3, 'widget_col' => 9, 'class' => 'member_previous_roles_multiselect' ),
                'label' => 'member.form.previous_roles',
                'translation_domain' => 'UnisystemAdminBundle',
                'multiple' => true,
                'required' => false,
            )) 
            ->add('name', null, array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.name',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('code', null, array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.code',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('phone', null, array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.phone',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('email', null, array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.email',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))  
            ->add('birth_date', 'birthday', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.birth_date',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            ))  
            ->add('admission_date', 'birthday', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.admission_date',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('file', 'fileinput', array(
                'attr' => array( 'label_col' => 3, 'widget_col' => 9 ),
                'label' => 'member.form.photography',
                'translation_domain' => 'UnisystemAdminBundle',
                'required' => false,
            )) 
            ->add('enabled', null, array( 
                'label' => 'member.form.enabled',
                'translation_domain' => 'UnisystemAdminBundle',
                'attr' => array( 'class' => 'switch', 'label_col' => 3, 'widget_col' => 9 ),
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
            'data_class' => 'Unisystem\AdminBundle\Entity\Member'
        ));
    }
}
