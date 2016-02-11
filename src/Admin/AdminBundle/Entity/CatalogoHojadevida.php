<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CatalogoHojadevida
 *
 * @ORM\Table(name="catalogo_hojadevida", indexes={@ORM\Index(name="Id_Catalogo", columns={"Id_Catalogo"}), @ORM\Index(name="Id_Hojadevida", columns={"Id_Hojadevida"})})
 * @ORM\Entity
 */
class CatalogoHojadevida
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Hojadevida
     *
     * @ORM\ManyToOne(targetEntity="Hojadevida" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Hojadevida", referencedColumnName="idHv")
     * })
     */
    private $idHojadevida;

    /**
     * @var \Catalogo
     *
     * @ORM\ManyToOne(targetEntity="Catalogo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Catalogo", referencedColumnName="Id_Cata")
     * })
     */
    private $idCatalogo;



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
     * @param \Admin\AdminBundle\Entity\Hojadevida $idHojadevida
     *
     * @return CatalogoHojadevida
     */
    public function setIdHojadevida(\Admin\AdminBundle\Entity\Hojadevida $idHojadevida = null)
    {
        $this->idHojadevida = $idHojadevida;

        return $this;
    }

    /**
     * Get idHojadevida
     *
     * @return \Admin\AdminBundle\Entity\Hojadevida
     */
    public function getIdHojadevida()
    {
        return $this->idHojadevida;
    }

    /**
     * Set idCatalogo
     *
     * @param \Admin\AdminBundle\Entity\Catalogo $idCatalogo
     *
     * @return CatalogoHojadevida
     */
    public function setIdCatalogo(\Admin\AdminBundle\Entity\Catalogo $idCatalogo = null)
    {
        $this->idCatalogo = $idCatalogo;

        return $this;
    }

    /**
     * Get idCatalogo
     *
     * @return \Admin\AdminBundle\Entity\Catalogo
     */
    public function getIdCatalogo()
    {
        return $this->idCatalogo;
    }
}
