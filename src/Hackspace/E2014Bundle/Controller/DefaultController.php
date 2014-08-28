<?php

namespace Hackspace\E2014Bundle\Controller;

use Hackspace\E2014Bundle\Entity\BasicQuery;
use Hackspace\E2014Bundle\Form\BasicQueryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->getBasicQueryForm();

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

    public function candidatosAction(Request $request)
    {
        $form = $this->getBasicQueryForm();
        $form->handleRequest($request);

        if($form->isValid())
        {
            $candidatos = [];

            return $this->render('HackspaceE2014Bundle:Default:candidatos.html.twig', [
                'form' => $form->createView(),
                'candidatos' => $candidatos,
            ]);
        }

        $form = $this->getBasicQueryForm();
        return $this->render('HackspaceE2014Bundle:Default:index.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    public function infocandidatoAction()
    {
        return $this->render('HackspaceE2014Bundle:Default:infocandidato.html.twig', []);
    }

    public function getBasicQueryForm()
    {
        $form = $this->createForm(new BasicQueryType(), new BasicQuery(),[
            'method' => 'GET',
        ]);

        return $form;
    }
}
