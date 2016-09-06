<?php

namespace Unisystem\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'user.form.email',
                'translation_domain' => 'UnisystemUserBundle',
                'attr' => array(
                    'class' => 'text-center',
                    'placeholder' => 'user.form.email',
                    'label_col' => 4,
                    'widget_col' => 8,
                    'input_group' => array(
                        'prepend' => '.icon-envelope',
                    ),
                ),
            ))
            ->add('username', null, array(
                'label' => 'user.form.username',
                'translation_domain' => 'UnisystemUserBundle',
                'attr' => array(
                    'class' => 'text-center',
                    'placeholder' => 'user.form.username',
                    'label_col' => 4,
                    'widget_col' => 8,
                    'input_group' => array(
                        'prepend' => '.icon-user',
                    ),
                ),
            ))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'UnisystemUserBundle'),
                'first_options' => array(
                    'label' => 'user.form.password',
                    'attr' => array(
                        'class' => 'text-center',
                        'placeholder' => 'user.form.password',
                        'input_group' => array(
                            'prepend' => '.icon-key',
                        ),
                    ),
                ),
                'second_options' => array(
                    'label' => 'user.form.password_confirmation',
                    'attr' => array(
                        'class' => 'text-center',
                        'placeholder' => 'user.form.password_confirmation',
                        'input_group' => array(
                            'prepend' => '.icon-key',
                        ),
                    ),
                ),
                'invalid_message' => 'user.password.mismatch',
                'attr' => array(
                    'label_col' => 4,
                    'widget_col' => 8,
                ),
            ))
            ->add('name', null, array(
                'label' => 'user.form.name',
                'translation_domain' => 'UnisystemUserBundle',
                'attr' => array(
                    'class' => 'text-center',
                    'placeholder' => 'user.form.name',
                    'label_col' => 4,
                    'widget_col' => 8,
                ),
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'unisystem_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}