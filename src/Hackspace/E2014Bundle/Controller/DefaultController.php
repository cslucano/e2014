<?php

namespace Hackspace\E2014Bundle\Controller;

use Hackspace\E2014Bundle\Entity\BasicQuery;
use Hackspace\E2014Bundle\Form\BasicQueryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new BasicQueryType(), new BasicQuery());

        $filter = [
            'cargo' => [
                'alcalde',
                'regidor',
            ],
            'edad' => [
                '18-20',
                '21-30',
                '30-50',
                '50-más',
            ]
        ];

        $filterJson = json_encode($filter);

        $response = $this->render('HackspaceE2014Bundle:Default:index.html.twig', [
            'form' => $form->createView(),
        ]);

        $response->headers->setCookie(new Cookie('filtro', $filterJson));

        return $response;
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
