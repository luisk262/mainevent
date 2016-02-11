<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioSolicitud
 *
 * @ORM\Table(name="usuario_solicitud", indexes={@ORM\Index(name="Id_Solicitud", columns={"Id_Solicitud"}), @ORM\Index(name="Id_Usuario", columns={"Id_Usuario"})})
 * @ORM\Entity
 */
class UsuarioSolicitud
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
     * @var \Solicitud
     *
     * @ORM\ManyToOne(targetEntity="Solicitud")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Solicitud", referencedColumnName="id_Solicitud")
     * })
     */
    private $idSolicitud;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;



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
     * Set idSolicitud
     *
     * @param \Admin\AdminBundle\Entity\Solicitud $idSolicitud
     *
     * @return UsuarioSolicitud
     */
    public function setIdSolicitud(\Admin\AdminBundle\Entity\Solicitud $idSolicitud = null)
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    /**
     * Get idSolicitud
     *
     * @return \Admin\AdminBundle\Entity\Solicitud
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    /**
     * Set idUsuario
     *
     * @param \Admin\AdminBundle\Entity\User $idUsuario
     *
     * @return UsuarioSolicitud
     */
    public function setIdUsuario(\Admin\AdminBundle\Entity\User $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \Admin\AdminBundle\Entity\User
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
