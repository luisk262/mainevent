<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolicitudCatalogo
 *
 * @ORM\Table(name="solicitud_catalogo", indexes={@ORM\Index(name="Id_Solicitudes", columns={"Id_Solicitudes"}), @ORM\Index(name="Id_Catalogos", columns={"Id_Catalogos"})})
 * @ORM\Entity
 */
class SolicitudCatalogo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Solicitud
     *
     * @ORM\ManyToOne(targetEntity="Solicitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Solicitudes", referencedColumnName="id_Solicitud")
     * })
     */
    private $idSolicitudes;

    /**
     * @var \Catalogo
     *
     * @ORM\ManyToOne(targetEntity="Catalogo",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Catalogos", referencedColumnName="Id_Cata")
     * })
     */
    private $idCatalogos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Estado", type="string", length=100, nullable=false)
     */
    private $estado;
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return SolicitudCatalogo
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
     * Set idSolicitudes
     *
     * @param \Admin\AdminBundle\Entity\Solicitud $idSolicitudes
     *
     * @return SolicitudCatalogo
     */
    public function setIdSolicitudes(\Admin\AdminBundle\Entity\Solicitud $idSolicitudes = null)
    {
        $this->idSolicitudes = $idSolicitudes;

        return $this;
    }

    /**
     * Get idSolicitudes
     *
     * @return \Admin\AdminBundle\Entity\Solicitud
     */
    public function getIdSolicitudes()
    {
        return $this->idSolicitudes;
    }

    /**
     * Set idCatalogos
     *
     * @param \Admin\AdminBundle\Entity\Catalogo $idCatalogos
     *
     * @return SolicitudCatalogo
     */
    public function setIdCatalogos(\Admin\AdminBundle\Entity\Catalogo $idCatalogos = null)
    {
        $this->idCatalogos = $idCatalogos;

        return $this;
    }

    /**
     * Get idCatalogos
     *
     * @return \Admin\AdminBundle\Entity\Catalogo
     */
    public function getIdCatalogos()
    {
        return $this->idCatalogos;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return SolicitudCatalogo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaupdate
     *
     * @param \DateTime $fechaupdate
     *
     * @return SolicitudCatalogo
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
