<?php

namespace Hackspace\E2014Bundle\Entity;

/**
 * EducacionSuperior
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hackspace\E2014Bundle\Entity\EducacionSuperiorRepository")
 */
class EducacionSuperior
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="candidato_jne_id", type="integer")
     */
    private $candidato_jne_id;

    /**
     * @var string
     *
     * @ORM\Column(name="fe_mod", type="string", length=255, nullable=true)
     */
    private $fe_mod;

    /**
     * @var integer
     *
     * @ORM\Column(name="mes_inicio", type="integer", nullable=true)
     */
    private $mes_inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="fg_no_universitario", type="string", length=255, nullable=true)
     */
    private $fg_no_universitario;

    /**
     * @var string
     *
     * @ORM\Column(name="fg_estudio_realizado", type="string", length=255, nullable=true)
     */
    private $fg_estudio_realizado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_estudio", type="string", length=255, nullable=true)
     */
    private $nombre_estudio;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar_estudio", type="string", length=255, nullable=true)
     */
    private $lugar_estudio;

    /**
     * @var string
     *
     * @ORM\Column(name="fg_estado", type="string", length=255, nullable=true)
     */
    private $fg_estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="fg_hasta_actualidad", type="integer", nullable=true)
     */
    private $fg_hasta_actualidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="ano_inicio", type="integer", nullable=true)
     */
    private $ano_inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_documento", type="string", length=255, nullable=true)
     */
    private $tipo_documento;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_postgrado", type="integer", nullable=true)
     */
    private $tipo_postgrado;

    /**
     * @var integer
     *
     * @ORM\Column(name="mes_final", type="integer", nullable=true)
     */
    private $mes_final;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_anr", type="string", length=255, nullable=true)
     */
    private $cod_anr;

    /**
     * @var string
     *
     * @ORM\Column(name="eli", type="string", length=255, nullable=true)
     */
    private $eli;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_centro", type="string", length=255, nullable=true)
     */
    private $nombre_centro;

    /**
     * @var string
     *
     * @ORM\Column(name="cre", type="string", length=255, nullable=true)
     */
    private $cre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_grado", type="string", length=255, nullable=true)
     */
    private $tipo_grado;

    /**
     * @var string
     *
     * @ORM\Column(name="fg_extrangero", type="string", length=255, nullable=true)
     */
    private $fg_extrangero;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_tipo_documento", type="string", length=255, nullable=true)
     */
    private $otro_tipo_documento;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_carrera", type="string", length=255, nullable=true)
     */
    private $nombre_carrera;

    /**
     * @var string
     *
     * @ORM\Column(name="otro_tipo_grado", type="string", length=255, nullable=true)
     */
    private $otro_tipo_grado;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_estudio", type="string", length=255, nullable=true)
     */
    private $tipo_estudio;

    /**
     * @var string
     *
     * @ORM\Column(name="fg_concluido", type="string", length=255, nullable=true)
     */
    private $fg_concluido;

    /**
     * @var integer
     *
     * @ORM\Column(name="ano_final", type="integer", nullable=true)
     */
    private $ano_final;
}
