<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioCatalogo
 *
 * @ORM\Table(name="usuario_catalogo", indexes={@ORM\Index(name="Id_catalogo", columns={"Id_catalogo"}), @ORM\Index(name="Id_Usuario", columns={"Id_Usuario"})})
 * @ORM\Entity
 */
class UsuarioCatalogo
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
     * @var \Catalogo
     *
     * @ORM\ManyToOne(targetEntity="Catalogo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_catalogo", referencedColumnName="Id_Cata")
     * })
     */
    private $idCatalogo;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_Usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;


}

