<?php

namespace Unisystem\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UnisystemUploadBundle:Default:index.html.twig');
    }
}
