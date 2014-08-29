<?php

namespace Hackspace\E2014Bundle\Controller;

use Hackspace\E2014Bundle\Business\CSearcher;
use Hackspace\E2014Bundle\Business\QFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /** @var QFormHandler $qFormHandler */
        $qFormHandler = $this->container->get('hackspace_e2014.q_form_handler');

        $qFormHandler->handleRequest($request);

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
            'form' => $qFormHandler->form->createView(),
        ]);

        $response->headers->setCookie(new Cookie('filtro', $filterJson));

        return $response;
    }

    public function candidatosAction(Request $request)
    {
        /** @var QFormHandler $qFormHandler */
        $qFormHandler = $this->container->get('hackspace_e2014.q_form_handler');

        $qFormHandler->handleRequest($request);

        if ($qFormHandler->is_valid) {
            /** @var CSearcher $cSearcher */
            $cSearcher = $this->container->get('hackspace_e2014.c_searcher');

            $candidatos = $cSearcher->getCandidatos($qFormHandler->data);

            return $this->render('HackspaceE2014Bundle:Default:candidatos.html.twig', [
                'form' => $qFormHandler->form->createView(),
                'candidatos' => $candidatos,
            ]);
        }

        return $this->render('HackspaceE2014Bundle:Default:index.html.twig', [
            'form' => $qFormHandler->form->createView(),
        ]);
    }

    public function infocandidatoAction()
    {
        return $this->render('HackspaceE2014Bundle:Default:infocandidato.html.twig', []);
    }
}
