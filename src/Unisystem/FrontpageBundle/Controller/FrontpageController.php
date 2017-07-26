<?php

namespace Unisystem\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontpageController extends Controller
{
    public function mainAction()
    {
        $em = $this->getDoctrine()->getManager();
        $photographies = $em->getRepository('UnisystemAdminBundle:MainPhotography')->findAll();
        $notices = $em->getRepository('UnisystemAdminBundle:Notice')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:main.html.twig', array(
            'photographies' => $photographies,
            'notices' => $notices,
        ));
    }

    public function memberAction()
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('UnisystemAdminBundle:Member')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:member.html.twig', array(
            'members' => $members,
        ));
    }

    public function officerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('UnisystemAdminBundle:Member')->getOfficerList();

        return $this->render('UnisystemFrontpageBundle:Page:officer.html.twig', array(
            'members' => $members,
        ));
    }

    public function academyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $academies = $em->getRepository('UnisystemAdminBundle:Academy')->getFutureList();

        return $this->render('UnisystemFrontpageBundle:Page:academy.html.twig', array(
            'academies' => $academies,
        ));
    }

    public function resourceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $resources = $em->getRepository('UnisystemAdminBundle:Resource')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:resource.html.twig', array(
            'resources' => $resources,
        ));
    }

    public function noticeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notices = $em->getRepository('UnisystemAdminBundle:Notice')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:notice.html.twig', array(
            'notices' => $notices,
        ));
    }

    public function historyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $histories = $em->getRepository('UnisystemAdminBundle:History')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:history.html.twig', array(
            'histories' => $histories,
        ));
    }
}
