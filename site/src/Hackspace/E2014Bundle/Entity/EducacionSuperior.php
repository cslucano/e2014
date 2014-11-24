<?php

namespace Hackspace\E2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="Candidato", inversedBy="educacion_superior")
     */
    private $candidato;

    /**
     * @var integer
     *
     * @ORM\Column(name="candidato_jne_id", type="integer", nullable=true)
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
     * @ORM\Column(name="id_educacion", type="integer", nullable=true)
     */
    private $id_educacion;

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

    /**
     * @var string
     *
     * @ORM\Column(name="ubigeo", type="text", nullable=true)
     */
    private $ubigeo;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCandidatoJneId()
    {
        return $this->candidato_jne_id;
    }

    /**
     * @param int $candidato_jne_id
     *
     * @return $this
     */
    public function setCandidatoJneId($candidato_jne_id)
    {
        $this->candidato_jne_id = $candidato_jne_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeMod()
    {
        return $this->fe_mod;
    }

    /**
     * @param string $fe_mod
     *
     * @return $this
     */
    public function setFeMod($fe_mod)
    {
        $this->fe_mod = $fe_mod;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdEducacion()
    {
        return $this->id_educacion;
    }

    /**
     * @param int $id_educacion
     *
     * @return $this
     */
    public function setIdEducacion($id_educacion)
    {
        $this->id_educacion = $id_educacion;

        return $this;
    }

    /**
     * @return int
     */
    public function getMesInicio()
    {
        return $this->mes_inicio;
    }

    /**
     * @param int $mes_inicio
     *
     * @return $this
     */
    public function setMesInicio($mes_inicio)
    {
        $this->mes_inicio = $mes_inicio;

        return $this;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param string $pais
     *
     * @return $this
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgNoUniversitario()
    {
        return $this->fg_no_universitario;
    }

    /**
     * @param string $fg_no_universitario
     *
     * @return $this
     */
    public function setFgNoUniversitario($fg_no_universitario)
    {
        $this->fg_no_universitario = $fg_no_universitario;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgEstudioRealizado()
    {
        return $this->fg_estudio_realizado;
    }

    /**
     * @param string $fg_estudio_realizado
     *
     * @return $this
     */
    public function setFgEstudioRealizado($fg_estudio_realizado)
    {
        $this->fg_estudio_realizado = $fg_estudio_realizado;

        return $this;
    }

    /**
     * @return string
     */
    public function getNombreEstudio()
    {
        return $this->nombre_estudio;
    }

    /**
     * @param string $nombre_estudio
     *
     * @return $this
     */
    public function setNombreEstudio($nombre_estudio)
    {
        $this->nombre_estudio = $nombre_estudio;

        return $this;
    }

    /**
     * @return string
     */
    public function getLugarEstudio()
    {
        return $this->lugar_estudio;
    }

    /**
     * @param string $lugar_estudio
     *
     * @return $this
     */
    public function setLugarEstudio($lugar_estudio)
    {
        $this->lugar_estudio = $lugar_estudio;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgEstado()
    {
        return $this->fg_estado;
    }

    /**
     * @param string $fg_estado
     *
     * @return $this
     */
    public function setFgEstado($fg_estado)
    {
        $this->fg_estado = $fg_estado;

        return $this;
    }

    /**
     * @return int
     */
    public function getFgHastaActualidad()
    {
        return $this->fg_hasta_actualidad;
    }

    /**
     * @param int $fg_hasta_actualidad
     *
     * @return $this
     */
    public function setFgHastaActualidad($fg_hasta_actualidad)
    {
        $this->fg_hasta_actualidad = $fg_hasta_actualidad;

        return $this;
    }

    /**
     * @return int
     */
    public function getAnoInicio()
    {
        return $this->ano_inicio;
    }

    /**
     * @param int $ano_inicio
     *
     * @return $this
     */
    public function setAnoInicio($ano_inicio)
    {
        $this->ano_inicio = $ano_inicio;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }

    /**
     * @param string $tipo_documento
     *
     * @return $this
     */
    public function setTipoDocumento($tipo_documento)
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }

    /**
     * @return int
     */
    public function getTipoPostgrado()
    {
        return $this->tipo_postgrado;
    }

    /**
     * @param int $tipo_postgrado
     *
     * @return $this
     */
    public function setTipoPostgrado($tipo_postgrado)
    {
        $this->tipo_postgrado = $tipo_postgrado;

        return $this;
    }

    /**
     * @return int
     */
    public function getMesFinal()
    {
        return $this->mes_final;
    }

    /**
     * @param int $mes_final
     *
     * @return $this
     */
    public function setMesFinal($mes_final)
    {
        $this->mes_final = $mes_final;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodAnr()
    {
        return $this->cod_anr;
    }

    /**
     * @param string $cod_anr
     *
     * @return $this
     */
    public function setCodAnr($cod_anr)
    {
        $this->cod_anr = $cod_anr;

        return $this;
    }

    /**
     * @return string
     */
    public function getEli()
    {
        return $this->eli;
    }

    /**
     * @param string $eli
     *
     * @return $this
     */
    public function setEli($eli)
    {
        $this->eli = $eli;

        return $this;
    }

    /**
     * @return string
     */
    public function getNombreCentro()
    {
        return $this->nombre_centro;
    }

    /**
     * @param string $nombre_centro
     *
     * @return $this
     */
    public function setNombreCentro($nombre_centro)
    {
        $this->nombre_centro = $nombre_centro;

        return $this;
    }

    /**
     * @return string
     */
    public function getCre()
    {
        return $this->cre;
    }

    /**
     * @param string $cre
     *
     * @return $this
     */
    public function setCre($cre)
    {
        $this->cre = $cre;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoGrado()
    {
        return $this->tipo_grado;
    }

    /**
     * @param string $tipo_grado
     *
     * @return $this
     */
    public function setTipoGrado($tipo_grado)
    {
        $this->tipo_grado = $tipo_grado;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgExtrangero()
    {
        return $this->fg_extrangero;
    }

    /**
     * @param string $fg_extrangero
     *
     * @return $this
     */
    public function setFgExtrangero($fg_extrangero)
    {
        $this->fg_extrangero = $fg_extrangero;

        return $this;
    }

    /**
     * @return string
     */
    public function getOtroTipoDocumento()
    {
        return $this->otro_tipo_documento;
    }

    /**
     * @param string $otro_tipo_documento
     *
     * @return $this
     */
    public function setOtroTipoDocumento($otro_tipo_documento)
    {
        $this->otro_tipo_documento = $otro_tipo_documento;

        return $this;
    }

    /**
     * @return string
     */
    public function getNombreCarrera()
    {
        return $this->nombre_carrera;
    }

    /**
     * @param string $nombre_carrera
     *
     * @return $this
     */
    public function setNombreCarrera($nombre_carrera)
    {
        $this->nombre_carrera = $nombre_carrera;

        return $this;
    }

    /**
     * @return string
     */
    public function getOtroTipoGrado()
    {
        return $this->otro_tipo_grado;
    }

    /**
     * @param string $otro_tipo_grado
     *
     * @return $this
     */
    public function setOtroTipoGrado($otro_tipo_grado)
    {
        $this->otro_tipo_grado = $otro_tipo_grado;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoEstudio()
    {
        return $this->tipo_estudio;
    }

    /**
     * @param string $tipo_estudio
     *
     * @return $this
     */
    public function setTipoEstudio($tipo_estudio)
    {
        $this->tipo_estudio = $tipo_estudio;

        return $this;
    }

    /**
     * @return string
     */
    public function getFgConcluido()
    {
        return $this->fg_concluido;
    }

    /**
     * @param string $fg_concluido
     *
     * @return $this
     */
    public function setFgConcluido($fg_concluido)
    {
        $this->fg_concluido = $fg_concluido;

        return $this;
    }

    /**
     * @return int
     */
    public function getAnoFinal()
    {
        return $this->ano_final;
    }

    /**
     * @param int $ano_final
     *
     * @return $this
     */
    public function setAnoFinal($ano_final)
    {
        $this->ano_final = $ano_final;

        return $this;
    }

    /**
     * @return string
     */
    public function getUbigeo()
    {
        return $this->ubigeo;
    }

    /**
     * @param string $ubigeo
     *
     * @return $this
     */
    public function setUbigeo($ubigeo)
    {
        $this->ubigeo = $ubigeo;

        return $this;
    }
}
