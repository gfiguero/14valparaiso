<?php

namespace Unisystem\AdminBundle\Menu;

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
        $menu->addChild('frontpage.index.link', array('route' => 'unisystem_frontpage_main'))->setAttribute('icon', 'flag fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
//        $menu->addChild('security.login.link', array('route' => 'fos_user_security_login'))->setAttribute('icon', 'sign-in fa-fw')->setAttribute('translation_domain', 'UnisystemUserBundle');
        $menu->addChild('security.logout.link', array('route' => 'unisystem_frontpage_logout'))->setAttribute('icon', 'sign-out fa-fw')->setAttribute('translation_domain', 'UnisystemUserBundle');
//        $menu->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setAttribute('icon', 'user fa-fw')->setAttribute('translation_domain', 'UnisystemUserBundle');
//        $menu->addChild('registration.link', array('route' => 'fos_user_registration_register'))->setAttribute('icon', 'pencil-square-o fa-fw')->setAttribute('translation_domain', 'UnisystemUserBundle');
//        $menu->addChild('user.list.link', array('route' => 'user_index'))->setAttribute('icon', 'group fa-fw')->setAttribute('translation_domain', 'UnisystemUserBundle');

        return $menu;

    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {

        $sidemenu = $factory->createItem('root');
        $sidemenu->setChildrenAttribute('class', 'nav');
        $sidemenu->setChildrenAttribute('id', 'side-menu');

//        $menu->addChild('page.menu.group')->setAttribute('icon', 'clone fa-fw')->setAttribute('translation_domain', 'UnisystemPageBundle');
//        $menu['page.menu.group']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['page.menu.group']->addChild('page.menu.page', array('route' => 'page_index'))->setAttribute('translation_domain', 'UnisystemPageBundle');
//        $menu['page.menu.group']->addChild('page.menu.photography', array('route' => 'page_photography_index'))->setAttribute('translation_domain', 'UnisystemPageBundle');
//        $menu['page.menu.group']->addChild('page.menu.service', array('route' => 'page_service_index'))->setAttribute('translation_domain', 'UnisystemPageBundle');
//        $menu['page.menu.group']->addChild('page.menu.process', array('route' => 'page_process_index'))->setAttribute('translation_domain', 'UnisystemPageBundle');
//        $menu['page.menu.group']->addChild('page.menu.publication', array('route' => 'page_publication_index'))->setAttribute('translation_domain', 'UnisystemPageBundle');

//        $menu->addChild('product.menu')->setAttribute('icon', 'cube fa-fw')->setAttribute('translation_domain', 'UnisystemProductBundle');
//        $menu['product.menu']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['product.menu']->addChild('product.list', array('route' => 'product_index'))->setAttribute('translation_domain', 'UnisystemProductBundle');
//        $menu['product.menu']->addChild('product.photography', array('route' => 'product_photography_index'))->setAttribute('translation_domain', 'UnisystemProductBundle');
//        $menu['product.menu']->addChild('product.category', array('route' => 'product_category_index'))->setAttribute('translation_domain', 'UnisystemProductBundle');
//        $menu['product.menu']->addChild('product.property', array('route' => 'product_property_index'))->setAttribute('translation_domain', 'UnisystemProductBundle');

//        $menu->addChild('notice.menu')->setAttribute('icon', 'newspaper-o fa-fw')->setAttribute('translation_domain', 'UnisystemNoticeBundle');
//        $menu['notice.menu']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['notice.menu']->addChild('notice.list', array('route' => 'notice_index'))->setAttribute('translation_domain', 'UnisystemNoticeBundle');
//        $menu['notice.menu']->addChild('notice.photography', array('route' => 'notice_photography_index'))->setAttribute('translation_domain', 'UnisystemNoticeBundle');
//        $menu['notice.menu']->addChild('notice.category', array('route' => 'notice_category_index'))->setAttribute('translation_domain', 'UnisystemNoticeBundle');

        $sidemenu->addChild('member.sidemenu.root')->setAttribute('icon', 'users fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['member.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['member.sidemenu.root']->addChild('member.sidemenu.index', array('route' => 'member_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['member.sidemenu.root']->addChild('member.sidemenu.course', array('route' => 'member_course_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['member.sidemenu.root']->addChild('member.sidemenu.role', array('route' => 'member_role_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');

        $sidemenu->addChild('resource.sidemenu.root')->setAttribute('icon', 'truck fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['resource.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['resource.sidemenu.root']->addChild('resource.sidemenu.index', array('route' => 'resource_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');

        $sidemenu->addChild('history.sidemenu.root')->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['history.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['history.sidemenu.root']->addChild('history.sidemenu.index', array('route' => 'history_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');

        $sidemenu->addChild('notice.sidemenu.root')->setAttribute('icon', 'newspaper-o fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['notice.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['notice.sidemenu.root']->addChild('notice.sidemenu.index', array('route' => 'notice_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');

        $sidemenu->addChild('academy.sidemenu.root')->setAttribute('icon', 'graduation-cap fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['academy.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['academy.sidemenu.root']->addChild('academy.sidemenu.future', array('route' => 'academy_future'))->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['academy.sidemenu.root']->addChild('academy.sidemenu.past', array('route' => 'academy_past'))->setAttribute('translation_domain', 'UnisystemAdminBundle');

        $sidemenu->addChild('main.sidemenu.root')->setAttribute('icon', 'home fa-fw')->setAttribute('translation_domain', 'UnisystemAdminBundle');
        $sidemenu['main.sidemenu.root']->setChildrenAttribute('class', 'nav nav-second-level collapse');
        $sidemenu['main.sidemenu.root']->addChild('main.photography.sidemenu.index', array('route' => 'main_photography_index'))->setAttribute('translation_domain', 'UnisystemAdminBundle');
//        $menu->addChild('document.menu')->setAttribute('icon', 'file fa-fw')->setAttribute('translation_domain', 'UnisystemDocumentBundle');
//        $menu['document.menu']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['document.menu']->addChild('document.list', array('route' => 'document_index'))->setAttribute('translation_domain', 'UnisystemDocumentBundle');
//        $menu['document.menu']->addChild('document.category', array('route' => 'document_category_index'))->setAttribute('translation_domain', 'UnisystemDocumentBundle');

//        $menu->addChild('admin.author', array('route' => 'author_index'))->setAttribute('icon', 'copyright fa-fw');
//        $menu->addChild('admin.appraisement', array('route' => 'appraisement_index'))->setAttribute('icon', 'star-half-o fa-fw');
//        $menu->addChild('admin.capture', array('route' => 'capture_index'))->setAttribute('icon', 'camera fa-fw');
//        $menu->addChild('admin.category', array('route' => 'category_index'))->setAttribute('icon', 'check-square fa-fw');
//        $menu->addChild('admin.datetime', array('route' => 'datetime_index'))->setAttribute('icon', 'calendar fa-fw');
//        $menu->addChild('admin.place', array('route' => 'place_index'))->setAttribute('icon', 'map-marker fa-fw');
//        $menu->addChild('admin.tag', array('route' => 'tag_index'))->setAttribute('icon', 'tags fa-fw');
//        $menu->addChild('admin.album', array('route' => 'album_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.photography', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.gallery', array('route' => 'gallery_index'))->setAttribute('icon', 'picture-o fa-fw');

//        $menu->addChild('member', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'users fa-fw');
//        $menu->addChild('admin.author', array('route' => 'author_index'))->setAttribute('icon', 'copyright fa-fw');
//        $menu->addChild('admin.appraisement', array('route' => 'appraisement_index'))->setAttribute('icon', 'star-half-o fa-fw');
//        $menu->addChild('admin.capture', array('route' => 'capture_index'))->setAttribute('icon', 'camera fa-fw');
//        $menu->addChild('admin.category', array('route' => 'category_index'))->setAttribute('icon', 'check-square fa-fw');
//        $menu->addChild('admin.datetime', array('route' => 'datetime_index'))->setAttribute('icon', 'calendar fa-fw');
//        $menu->addChild('admin.place', array('route' => 'place_index'))->setAttribute('icon', 'map-marker fa-fw');
//        $menu->addChild('admin.tag', array('route' => 'tag_index'))->setAttribute('icon', 'tags fa-fw');
//        $menu->addChild('admin.album', array('route' => 'album_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.photography', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.gallery', array('route' => 'gallery_index'))->setAttribute('icon', 'picture-o fa-fw');


//        $menu->addChild('appraisement', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'star-half-o fa-fw');
//        $menu->addChild('shot', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'camera fa-fw');
//        $menu->addChild('tag', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'tags fa-fw');
//        $menu->addChild('album', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'book fa-fw');
//        $menu->addChild('category', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'check-square fa-fw');


//        $menu->addChild('photo.index', array('route' => 'member_index'))->setAttribute('icon', 'photo fa-fw');
//        $menu->addChild('process_index', array('route' => 'member_index'))->setAttribute('icon', 'paper-plane fa-fw');
//        $menu->addChild('member_control')->setAttribute('icon', 'sitemap fa-fw');
//        $menu['member_control']->addChild('memberrole_index', array('route' => 'member_index'));

//        $menu->addChild('notice_control')->setAttribute('icon', 'newspaper-o fa-fw');
//        $menu['notice_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['notice_control']->addChild('notice_index', array('route' => 'member_index'));
//        $menu['notice_control']->addChild('noticecategory_index', array('route' => 'member_index'));

//        $menu->addChild('publication_index', array('route' => 'member_index'))->setAttribute('icon', 'bullhorn fa-fw');
//        $menu->addChild('report_index', array('route' => 'member_index'))->setAttribute('icon', 'flag fa-fw');
//        $menu->addChild('document_index', array('route' => 'member_index'))->setAttribute('icon', 'check fa-fw');
//        $menu->addChild('link_index', array('route' => 'member_index'))->setAttribute('icon', 'external-link fa-fw');

        return $sidemenu;

    }

}