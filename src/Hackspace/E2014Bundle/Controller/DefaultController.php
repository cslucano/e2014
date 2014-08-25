<?php

namespace Hackspace\E2014Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HackspaceE2014Bundle:Default:index.html.twig', array('name' => $name));
    }
}
