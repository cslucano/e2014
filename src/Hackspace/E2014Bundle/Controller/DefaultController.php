<?php

namespace Hackspace\E2014Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HackspaceE2014Bundle:Default:index.html.twig', []);
    }

    public function candidatosAction()
    {
        return $this->render('HackspaceE2014Bundle:Default:candidatos.html.twig', []);
    }

    public function infocandidatoAction()
    {
        return $this->render('HackspaceE2014Bundle:Default:infocandidato.html.twig', []);
    }
}
