<?php

namespace Unisystem\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontpageController extends Controller
{
    public function mainAction()
    {
        return $this->render('UnisystemFrontpageBundle:Page:main.html.twig');
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

    public function historyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $histories = $em->getRepository('UnisystemAdminBundle:History')->getFrontpageList();

        return $this->render('UnisystemFrontpageBundle:Page:history.html.twig', array(
            'histories' => $histories,
        ));
    }
}
