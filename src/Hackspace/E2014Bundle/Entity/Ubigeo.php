<?php

namespace Hackspace\E2014Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ubigeo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Hackspace\E2014Bundle\Entity\UbigeoRepository")
 */
class Ubigeo
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
     * @var string
     *
     * @ORM\Column(name="ubigeo", type="text", nullable=true)
     */
    private $ubigeo;

    /**
     * @var string
     *
     * @ORM\Column(name="ubigeo_dep", type="text", nullable=true)
     */
    private $ubigeo_dep;

    /**
     * @var string
     *
     * @ORM\Column(name="ubigeo_pro", type="text", nullable=true)
     */
    private $ubigeo_pro;

    /**
     * @var string
     *
     * @ORM\Column(name="ubigeo_dis", type="text", nullable=true)
     */
    private $ubigeo_dis;

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
     * Set ubigeo
     *
     * @param  string $ubigeo
     * @return Ubigeo
     */
    public function setUbigeo($ubigeo)
    {
        $this->ubigeo = $ubigeo;

        return $this;
    }

    /**
     * Get ubigeo
     *
     * @return string
     */
    public function getUbigeo()
    {
        return $this->ubigeo;
    }

    /**
     * Set ubigeo_dep
     *
     * @param  string $ubigeoDep
     * @return Ubigeo
     */
    public function setUbigeoDep($ubigeoDep)
    {
        $this->ubigeo_dep = $ubigeoDep;

        return $this;
    }

    /**
     * Get ubigeo_dep
     *
     * @return string
     */
    public function getUbigeoDep()
    {
        return $this->ubigeo_dep;
    }

    /**
     * Set ubigeo_pro
     *
     * @param  string $ubigeoPro
     * @return Ubigeo
     */
    public function setUbigeoPro($ubigeoPro)
    {
        $this->ubigeo_pro = $ubigeoPro;

        return $this;
    }

    /**
     * Get ubigeo_pro
     *
     * @return string
     */
    public function getUbigeoPro()
    {
        return $this->ubigeo_pro;
    }

    /**
     * Set ubigeo_dis
     *
     * @param  string $ubigeoDis
     * @return Ubigeo
     */
    public function setUbigeoDis($ubigeoDis)
    {
        $this->ubigeo_dis = $ubigeoDis;

        return $this;
    }

    /**
     * Get ubigeo_dis
     *
     * @return string
     */
    public function getUbigeoDis()
    {
        return $this->ubigeo_dis;
    }

    function __toString()
    {
        $strUbigeo = $this->ubigeo_dep;

        $strUbigeo .= (!empty($this->ubigeo_pro)) ? ', ' . $this->ubigeo_pro : '';

        $strUbigeo .= (!empty($this->ubigeo_dis)) ? ', ' . $this->ubigeo_dis : '';

        return $strUbigeo;
    }
}
