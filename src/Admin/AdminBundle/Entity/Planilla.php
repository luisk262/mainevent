<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planilla
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Planilla
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
     * @ORM\Column(name="id_hojadevida", type="integer")
     */
    private $idHojadevida;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_solicitud", type="integer")
     */
    private $idSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="telCel", type="string", length=100)
     */
    private $telCel;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=100)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="asistencia", type="string", length=10)
     */
    private $asistencia;

    /**
     * @var integer
     *
     * @ORM\Column(name="calificacion", type="integer")
     */
    private $calificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;


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
     * Set idHojadevida
     *
     * @param integer $idHojadevida
     *
     * @return Planilla
     */
    public function setIdHojadevida($idHojadevida)
    {
        $this->idHojadevida = $idHojadevida;

        return $this;
    }

    /**
     * Get idHojadevida
     *
     * @return integer
     */
    public function getIdHojadevida()
    {
        return $this->idHojadevida;
    }

    /**
     * Set idSolicitud
     *
     * @param integer $idSolicitud
     *
     * @return Planilla
     */
    public function setIdSolicitud($idSolicitud)
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    /**
     * Get idSolicitud
     *
     * @return integer
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    /**
     * Set telCel
     *
     * @param string $telCel
     *
     * @return Planilla
     */
    public function setTelCel($telCel)
    {
        $this->telCel = $telCel;

        return $this;
    }

    /**
     * Get telCel
     *
     * @return string
     */
    public function getTelCel()
    {
        return $this->telCel;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Planilla
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Planilla
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return Planilla
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set asistencia
     *
     * @param string $asistencia
     *
     * @return Planilla
     */
    public function setAsistencia($asistencia)
    {
        $this->asistencia = $asistencia;

        return $this;
    }

    /**
     * Get asistencia
     *
     * @return string
     */
    public function getAsistencia()
    {
        return $this->asistencia;
    }

    /**
     * Set calificacion
     *
     * @param integer $calificacion
     *
     * @return Planilla
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return integer
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Planilla
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }
}

