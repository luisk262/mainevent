<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notificaciones
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Notificaciones
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
     * @ORM\Column(name="id_catalogo", type="integer")
     */
    private $idCatalogo;

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
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="tarifa", type="string", length=255, nullable=true)
     */
    private $tarifa;

    /**
     * @var string
     *
     * @ORM\Column(name="informacion_general", type="string", length=255, nullable=true)
     */
    private $informacion_general;
/**
     * @var string
     *
     * @ORM\Column(name="informacion_detallada", type="string", length=255, nullable=true)
     */
    private $informacion_detallada;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaUpdate", type="datetime", nullable=true)
     */
    private $fechaupdate;

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
     * @return Notificaciones
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
     * Set idCatalogo
     *
     * @param integer $idCatalogo
     *
     * @return Notificaciones
     */
    public function setIdCatalogo($idCatalogo)
    {
        $this->idCatalogo = $idCatalogo;

        return $this;
    }

    /**
     * Get idCatalogo
     *
     * @return integer
     */
    public function getICatalogo()
    {
        return $this->idCatalogo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Notificaciones
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
     * @return Notificaciones
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
     * @return Notificaciones
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
     * Set visto
     *
     * @param string $estado
     *
     * @return Notificaciones
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get visto
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tariga
     *
     * @param string $tariga
     *
     * @return Notificaciones
     */
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;

        return $this;
    }

    /**
     * Get tariga
     *
     * @return string
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }

    /**
     * Set informacion
     *
     * @param string $informacion
     *
     * @return Notificaciones
     */
    public function setInformacion($informacion)
    {
        $this->informacion = $informacion;

        return $this;
    }

    /**
     * Get informacion
     *
     * @return string
     */
    public function getInformacion()
    {
        return $this->informacion;
    }

    /**
     * Get idCatalogo
     *
     * @return integer
     */
    public function getIdCatalogo()
    {
        return $this->idCatalogo;
    }

    /**
     * Set informacionGeneral
     *
     * @param string $informacionGeneral
     *
     * @return Notificaciones
     */
    public function setInformacionGeneral($informacionGeneral)
    {
        $this->informacion_general = $informacionGeneral;

        return $this;
    }

    /**
     * Get informacionGeneral
     *
     * @return string
     */
    public function getInformacionGeneral()
    {
        return $this->informacion_general;
    }

    /**
     * Set informacionDetallada
     *
     * @param string $informacionDetallada
     *
     * @return Notificaciones
     */
    public function setInformacionDetallada($informacionDetallada)
    {
        $this->informacion_detallada = $informacionDetallada;

        return $this;
    }

    /**
     * Get informacionDetallada
     *
     * @return string
     */
    public function getInformacionDetallada()
    {
        return $this->informacion_detallada;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Notificaciones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fechaupdate
     *
     * @param \DateTime $fechaupdate
     *
     * @return Notificaciones
     */
    public function setFechaupdate($fechaupdate)
    {
        $this->fechaupdate = $fechaupdate;

        return $this;
    }

    /**
     * Get fechaupdate
     *
     * @return \DateTime
     */
    public function getFechaupdate()
    {
        return $this->fechaupdate;
    }
}
