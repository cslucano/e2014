<?php

namespace Hackspace\E2014Bundle\Business;

use Hackspace\E2014Bundle\Entity\BasicQuery;
use Hackspace\E2014Bundle\Form\BasicQueryType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class QFormHandler
{
    /** @var \Symfony\Component\Form\FormFactory $formFactory */
    protected $formFactory;

    /** @var  boolean $is_valid */
    public $is_valid;

    /** @var  BasicQuery $data */
    public $data;

    /** @var  ParameterBag $cookies */
    public $cookies;

    /** @var  Form $form */
    public $form;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function handleRequest(Request $request)
    {
        $form = $this->getQForm();

        $form->handleRequest($request);

        $this->is_valid = $form->isValid();
        $this->data = $form->getData();
        $this->cookies = $request->cookies;
        $this->form = $form;
    }

    public function getQForm()
    {
        $type = new BasicQueryType();
        $data = new BasicQuery();

        $form = $this->formFactory->create(
            $type,
            $data,
            $this->getDefaultFormOptions()
        );

        return $form;
    }

    public function getDefaultFormOptions()
    {
        return [
            'method' => 'GET',
        ];
    }
}
