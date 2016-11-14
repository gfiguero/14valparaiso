<?php

namespace Unisystem\FrontpageBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->setChildrenAttribute('id', 'top-menu');

        $menu->addChild('frontpage.notice.link', array('route' => 'unisystem_frontpage_notice'))->setAttribute('icon', 'newspaper-o fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
        $menu->addChild('frontpage.officer.link', array('route' => 'unisystem_frontpage_officer'))->setAttribute('icon', 'star fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
        $menu->addChild('frontpage.member.link', array('route' => 'unisystem_frontpage_member'))->setAttribute('icon', 'users fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
        $menu->addChild('frontpage.academy.link', array('route' => 'unisystem_frontpage_academy'))->setAttribute('icon', 'mortar-board fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
        $menu->addChild('frontpage.equipment.link', array('route' => 'unisystem_frontpage_resource'))->setAttribute('icon', 'truck fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
        $menu->addChild('frontpage.history.link', array('route' => 'unisystem_frontpage_history'))->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');
//        $menu->addChild('frontpage.admin.link', array('route' => 'member_index'))->setAttribute('icon', 'sign-in fa-fw')->setAttribute('translation_domain', 'UnisystemFrontpageBundle');

        return $menu;

    }

}