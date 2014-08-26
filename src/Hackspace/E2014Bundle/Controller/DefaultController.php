<?php

namespace Hackspace\E2014Bundle\Controller;

use Hackspace\E2014Bundle\Entity\BasicQuery;
use Hackspace\E2014Bundle\Form\BasicQueryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new BasicQueryType(), new BasicQuery());

        return $this->render('HackspaceE2014Bundle:Default:index.html.twig', [
            'form' => $form->createView(),
        ]);
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
