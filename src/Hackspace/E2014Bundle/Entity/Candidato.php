<?php

namespace Hackspace\E2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidato
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hackspace\E2014Bundle\Entity\CandidatoRepository")
 */
class Candidato
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
     * @ORM\Column(name="org_pol", type="text", nullable=true)
     */
    private $org_pol;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo_autoridad", type="text", nullable=true)
     */
    private $cargo_autoridad;

    /**
     * @var string
     *
     * @ORM\Column(name="postula_ubigeo", type="text", nullable=true)
     */
    private $postula_ubigeo;

    /**
     * @var string
     *
     * @ORM\Column(name="postula_ubigeo_dep", type="text", nullable=true)
     */
    private $postula_ubigeo_dep;

    /**
     * @var string
     *
     * @ORM\Column(name="postula_ubigeo_pro", type="text", nullable=true)
     */
    private $postula_ubigeo_pro;

    /**
     * @var string
     *
     * @ORM\Column(name="postula_ubigeo_dis", type="text", nullable=true)
     */
    private $postula_ubigeo_dis;

    /**
     * @var string
     *
     * @ORM\Column(name="forma_designacion", type="text", nullable=true)
     */
    private $forma_designacion;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="text", nullable=true)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="appaterno", type="text", nullable=true)
     */
    private $appaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apmaterno", type="text", nullable=true)
     */
    private $apmaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="text", nullable=true)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="fdn", type="text", nullable=true)
     */
    private $fdn;

    /**
     * @var integer
     *
     * @ORM\Column(name="sexo", type="integer")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text", nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nac_pais", type="text", nullable=true)
     */
    private $nac_pais;

    /**
     * @var string
     *
     * @ORM\Column(name="nac_ubigeo", type="text", nullable=true)
     */
    private $nac_ubigeo;

    /**
     * @var string
     *
     * @ORM\Column(name="nac_ubigeo_dep", type="text", nullable=true)
     */
    private $nac_ubigeo_dep;

    /**
     * @var string
     *
     * @ORM\Column(name="nac_ubigeo_pro", type="text", nullable=true)
     */
    private $nac_ubigeo_pro;

    /**
     * @var string
     *
     * @ORM\Column(name="nac_ubigeo_dis", type="text", nullable=true)
     */
    private $nac_ubigeo_dis;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia", type="text", nullable=true)
     */
    private $residencia;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia_ubigeo", type="text", nullable=true)
     */
    private $residencia_ubigeo;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia_ubigeo_dep", type="text", nullable=true)
     */
    private $residencia_ubigeo_dep;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia_ubigeo_pro", type="text", nullable=true)
     */
    private $residencia_ubigeo_pro;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia_ubigeo_dis", type="text", nullable=true)
     */
    private $residencia_ubigeo_dis;

    /**
     * @var string
     *
     * @ORM\Column(name="residencia_tiempo", type="text", nullable=true)
     */
    private $residencia_tiempo;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set candidato_jne_id
     *
     * @param integer $candidatoJneId
     * @return Candidato
     */
    public function setCandidatoJneId($candidatoJneId)
    {
        $this->candidato_jne_id = $candidatoJneId;

        return $this;
    }

    /**
     * Get candidato_jne_id
     *
     * @return integer
     */
    public function getCandidatoJneId()
    {
        return $this->candidato_jne_id;
    }

    /**
     * Set org_pol
     *
     * @param string $orgPol
     * @return Candidato
     */
    public function setOrgPol($orgPol)
    {
        $this->org_pol = $orgPol;

        return $this;
    }

    /**
     * Get org_pol
     *
     * @return string
     */
    public function getOrgPol()
    {
        return $this->org_pol;
    }

    /**
     * Set cargo_autoridad
     *
     * @param string $cargoAutoridad
     * @return Candidato
     */
    public function setCargoAutoridad($cargoAutoridad)
    {
        $this->cargo_autoridad = $cargoAutoridad;

        return $this;
    }

    /**
     * Get cargo_autoridad
     *
     * @return string
     */
    public function getCargoAutoridad()
    {
        return $this->cargo_autoridad;
    }

    /**
     * Set postula_ubigeo
     *
     * @param string $postulaUbigeo
     * @return Candidato
     */
    public function setPostulaUbigeo($postulaUbigeo)
    {
        $this->postula_ubigeo = $postulaUbigeo;

        return $this;
    }

    /**
     * Get postula_ubigeo
     *
     * @return string
     */
    public function getPostulaUbigeo()
    {
        return $this->postula_ubigeo;
    }

    /**
     * Set postula_ubigeo_dep
     *
     * @param string $postulaUbigeoDep
     * @return Candidato
     */
    public function setPostulaUbigeoDep($postulaUbigeoDep)
    {
        $this->postula_ubigeo_dep = $postulaUbigeoDep;

        return $this;
    }

    /**
     * Get postula_ubigeo_dep
     *
     * @return string
     */
    public function getPostulaUbigeoDep()
    {
        return $this->postula_ubigeo_dep;
    }

    /**
     * Set postula_ubigeo_pro
     *
     * @param string $postulaUbigeoPro
     * @return Candidato
     */
    public function setPostulaUbigeoPro($postulaUbigeoPro)
    {
        $this->postula_ubigeo_pro = $postulaUbigeoPro;

        return $this;
    }

    /**
     * Get postula_ubigeo_pro
     *
     * @return string
     */
    public function getPostulaUbigeoPro()
    {
        return $this->postula_ubigeo_pro;
    }

    /**
     * Set postula_ubigeo_dis
     *
     * @param string $postulaUbigeoDis
     * @return Candidato
     */
    public function setPostulaUbigeoDis($postulaUbigeoDis)
    {
        $this->postula_ubigeo_dis = $postulaUbigeoDis;

        return $this;
    }

    /**
     * Get postula_ubigeo_dis
     *
     * @return string
     */
    public function getPostulaUbigeoDis()
    {
        return $this->postula_ubigeo_dis;
    }

    /**
     * Set forma_designacion
     *
     * @param string $formaDesignacion
     * @return Candidato
     */
    public function setFormaDesignacion($formaDesignacion)
    {
        $this->forma_designacion = $formaDesignacion;

        return $this;
    }

    /**
     * Get forma_designacion
     *
     * @return string
     */
    public function getFormaDesignacion()
    {
        return $this->forma_designacion;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Candidato
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set appaterno
     *
     * @param string $appaterno
     * @return Candidato
     */
    public function setAppaterno($appaterno)
    {
        $this->appaterno = $appaterno;

        return $this;
    }

    /**
     * Get appaterno
     *
     * @return string
     */
    public function getAppaterno()
    {
        return $this->appaterno;
    }

    /**
     * Set apmaterno
     *
     * @param string $apmaterno
     * @return Candidato
     */
    public function setApmaterno($apmaterno)
    {
        $this->apmaterno = $apmaterno;

        return $this;
    }

    /**
     * Get apmaterno
     *
     * @return string
     */
    public function getApmaterno()
    {
        return $this->apmaterno;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Candidato
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set fdn
     *
     * @param string $fdn
     * @return Candidato
     */
    public function setFdn($fdn)
    {
        $this->fdn = $fdn;

        return $this;
    }

    /**
     * Get fdn
     *
     * @return string
     */
    public function getFdn()
    {
        return $this->fdn;
    }

    /**
     * Set sexo
     *
     * @param integer $sexo
     * @return Candidato
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return integer
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Candidato
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nac_pais
     *
     * @param string $nacPais
     * @return Candidato
     */
    public function setNacPais($nacPais)
    {
        $this->nac_pais = $nacPais;

        return $this;
    }

    /**
     * Get nac_pais
     *
     * @return string
     */
    public function getNacPais()
    {
        return $this->nac_pais;
    }

    /**
     * Set nac_ubigeo
     *
     * @param string $nacUbigeo
     * @return Candidato
     */
    public function setNacUbigeo($nacUbigeo)
    {
        $this->nac_ubigeo = $nacUbigeo;

        return $this;
    }

    /**
     * Get nac_ubigeo
     *
     * @return string
     */
    public function getNacUbigeo()
    {
        return $this->nac_ubigeo;
    }

    /**
     * Set nac_ubigeo_dep
     *
     * @param string $nacUbigeoDep
     * @return Candidato
     */
    public function setNacUbigeoDep($nacUbigeoDep)
    {
        $this->nac_ubigeo_dep = $nacUbigeoDep;

        return $this;
    }

    /**
     * Get nac_ubigeo_dep
     *
     * @return string
     */
    public function getNacUbigeoDep()
    {
        return $this->nac_ubigeo_dep;
    }

    /**
     * Set nac_ubigeo_pro
     *
     * @param string $nacUbigeoPro
     * @return Candidato
     */
    public function setNacUbigeoPro($nacUbigeoPro)
    {
        $this->nac_ubigeo_pro = $nacUbigeoPro;

        return $this;
    }

    /**
     * Get nac_ubigeo_pro
     *
     * @return string
     */
    public function getNacUbigeoPro()
    {
        return $this->nac_ubigeo_pro;
    }

    /**
     * Set nac_ubigeo_dis
     *
     * @param string $nacUbigeoDis
     * @return Candidato
     */
    public function setNacUbigeoDis($nacUbigeoDis)
    {
        $this->nac_ubigeo_dis = $nacUbigeoDis;

        return $this;
    }

    /**
     * Get nac_ubigeo_dis
     *
     * @return string
     */
    public function getNacUbigeoDis()
    {
        return $this->nac_ubigeo_dis;
    }

    /**
     * Set residencia
     *
     * @param string $residencia
     * @return Candidato
     */
    public function setResidencia($residencia)
    {
        $this->residencia = $residencia;

        return $this;
    }

    /**
     * Get residencia
     *
     * @return string
     */
    public function getResidencia()
    {
        return $this->residencia;
    }

    /**
     * Set residencia_ubigeo
     *
     * @param string $residenciaUbigeo
     * @return Candidato
     */
    public function setResidenciaUbigeo($residenciaUbigeo)
    {
        $this->residencia_ubigeo = $residenciaUbigeo;

        return $this;
    }

    /**
     * Get residencia_ubigeo
     *
     * @return string
     */
    public function getResidenciaUbigeo()
    {
        return $this->residencia_ubigeo;
    }

    /**
     * Set residencia_ubigeo_dep
     *
     * @param string $residenciaUbigeoDep
     * @return Candidato
     */
    public function setResidenciaUbigeoDep($residenciaUbigeoDep)
    {
        $this->residencia_ubigeo_dep = $residenciaUbigeoDep;

        return $this;
    }

    /**
     * Get residencia_ubigeo_dep
     *
     * @return string
     */
    public function getResidenciaUbigeoDep()
    {
        return $this->residencia_ubigeo_dep;
    }

    /**
     * Set residencia_ubigeo_pro
     *
     * @param string $residenciaUbigeoPro
     * @return Candidato
     */
    public function setResidenciaUbigeoPro($residenciaUbigeoPro)
    {
        $this->residencia_ubigeo_pro = $residenciaUbigeoPro;

        return $this;
    }

    /**
     * Get residencia_ubigeo_pro
     *
     * @return string
     */
    public function getResidenciaUbigeoPro()
    {
        return $this->residencia_ubigeo_pro;
    }

    /**
     * Set residencia_ubigeo_dis
     *
     * @param string $residenciaUbigeoDis
     * @return Candidato
     */
    public function setResidenciaUbigeoDis($residenciaUbigeoDis)
    {
        $this->residencia_ubigeo_dis = $residenciaUbigeoDis;

        return $this;
    }

    /**
     * Get residencia_ubigeo_dis
     *
     * @return string
     */
    public function getResidenciaUbigeoDis()
    {
        return $this->residencia_ubigeo_dis;
    }

    /**
     * Set residencia_tiempo
     *
     * @param string $residenciaTiempo
     * @return Candidato
     */
    public function setResidenciaTiempo($residenciaTiempo)
    {
        $this->residencia_tiempo = $residenciaTiempo;

        return $this;
    }

    /**
     * Get residencia_tiempo
     *
     * @return string
     */
    public function getResidenciaTiempo()
    {
        return $this->residencia_tiempo;
    }
}
