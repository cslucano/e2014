<?php

namespace Hackspace\E2014Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BasicQueryType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', 'text', [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'candidato, partido, region, ciudad, ...',
                ]
            ])
            ->add('location', 'text', [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'region, distrito, ciudad, ...',
                ]
            ])
            ->add('name', 'text', [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'nombre de candidato',
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Hackspace\E2014Bundle\Entity\BasicQuery',
            'csrf_protection' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bq';
    }
}
