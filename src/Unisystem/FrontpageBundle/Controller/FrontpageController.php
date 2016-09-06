<?php

namespace Unisystem\FrontpageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontpageController extends Controller
{
    public function indexAction()
    {
        return $this->render(':Frontpage:index.html.twig');
    }

    public function memberAction()
    {
        $em = $this->getDoctrine()->getManager();
        $members = $em->getRepository('UnisystemMemberBundle:Member')->getFrontpageList();

        return $this->render(':Frontpage:member.html.twig', array(
            'members' => $members,
        ));
    }

    public function academyAction()
    {
        return $this->render(':Frontpage:academy.html.twig');
    }

    public function equipmentAction()
    {
        return $this->render(':Frontpage:equipment.html.twig');
    }

    public function historyAction()
    {
        return $this->render(':Frontpage:history.html.twig');
    }
}
