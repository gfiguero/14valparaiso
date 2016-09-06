<?php

namespace Unisystem\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'form.name',
                'translation_domain' => 'UnisystemUserBundle'
            ))
            ->add('username', null, array(
                'label' => 'form.username',
                'translation_domain' => 'UnisystemUserBundle'
            ))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'form.email',
                'translation_domain' => 'UnisystemUserBundle'
            ))
            ->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
                'label' => 'form.current_password',
                'translation_domain' => 'UnisystemUserBundle',
                'mapped' => false,
                'constraints' => new UserPassword(),
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'unisystem_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
