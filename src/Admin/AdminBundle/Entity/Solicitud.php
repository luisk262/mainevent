<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Solicitud
 *
 * @ORM\Table(name="solicitud")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class Solicitud {

    /**
     * @var integer
     *
     * @ORM\Column(name="id_Solicitud", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSolicitud;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Observaciones", type="text", length=65535, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="Estado", type="string", length=100, nullable=false)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fechainicio", type="date", nullable=true)
     */
    private $fechainicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fechafin", type="date", nullable=true)
     */
    private $fechafin;

    /**
     * @var string $image
     * @Assert\File( maxSize = "1024k",
     * mimeTypesMessage = "Carge una imagen valida")
     * @ORM\Column(name="image", type="string", length=255,nullable=true)
     */
    public $image;

    /**
     * @var string $file
     * @Assert\File( maxSize = "5120k",
     * mimeTypesMessage = "Carge una imagen valida")
     * @ORM\Column(name="File", type="string", length=255,nullable=true)
     */
    private $File;

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
     * Get idSolicitud
     *
     * @return integer
     */
    public function getIdSolicitud() {
        return $this->idSolicitud;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Solicitud
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Solicitud
     */
    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones() {
        return $this->observaciones;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Solicitud
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set fechaupdate
     *
     * @param \DateTime $fechaupdate
     *
     * @return Solicitud
     */
    public function setFechaupdate($fechaupdate) {
        $this->fechaupdate = $fechaupdate;

        return $this;
    }

    /**
     * Get fechaupdate
     *
     * @return \DateTime
     */
    public function getFechaupdate() {
        return $this->fechaupdate;
    }

    public function __toString() {
        return (string) $this->idSolicitud;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Solicitud
     */
    public function setEstado($estado) {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return Solicitud
     */
    public function setFechainicio($fechainicio) {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio() {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return Solicitud
     */
    public function setFechafin($fechafin) {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin() {
        return $this->fechafin;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Solicitud
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Solicitud
     */
    public function setFile($file) {
        $this->File = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile() {
        return $this->File;
    }

    public function getFullImagePath() {
        return null === $this->image ? null : $this->getUploadRootDir() . $this->image;
        //retorna la imagen para mostrar en web
    }

    public function getFullFilePath() {
        return null === $this->File ? null : $this->getUploadRootDir() . $this->File;
        //retorna la imagen para mostrar en web
    }

    protected function getUploadRootDir() {
        //ruta del dicrectorio donde se van a guardar los archivos

        return $this->getTmpUploadRootDir() . "/../" . $this->idSolicitud . "/";
    }

    protected function getTmpUploadRootDir() {
        //la ruta del directorio absoluta donde se deben guardar los documentos cargados
        return __DIR__ . '/../../../../web/upload/solicitud/tmp/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadImage() {
        //validamos si es una actualizacion o una nueva
        //si las fechas son diferentes es actualizacion de lo contrario es nuevo

        if ($this->fechaupdate != $this->fecha) {
            if ($this->image != null && $this->aux == null) {
                ///asignamos los nombres nuevos
                $tempImageName = time() . '_1.' . pathinfo((string) $this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                //borramos imagenes viejas
                $dir = $this->getUploadRootDir();
                /// guardamos en el servidor los archivos
                $this->setImageName($this->image->getClientOriginalName());
                $this->image->move($this->getUploadRootDir(), $tempImageName);

                //grabamos los nombres de archivo en el servidor
                $this->setImage($tempImageName);
            } else {
                $this->setImage($this->aux);
            }
            if ($this->File != null && $this->aux1 == null) {
                ///asignamos los nombres nuevos
                $tempImageName1 = time() . '_2.' . pathinfo((string) $this->File->getClientOriginalName(), PATHINFO_EXTENSION);

                //borramos imagenes viejas
                $dir = $this->getUploadRootDir();
                
                /// guardamos en el servidor los archivos
                $this->setFileName($this->File->getClientOriginalName());
                $this->File->move($this->getUploadRootDir(), $tempImageName1);

                //grabamos los nombres de archivo en el servidor
                $this->setFile($tempImageName1);
            } else {
                $this->setFile($this->aux1);
            }
        } else {
            if ($this->image != null) {
                $tempImageName = time() . '_1.' . pathinfo((string) $this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                if (!$this->idSolicitud) {
                    $this->setImageName($this->image->getClientOriginalName());
                    $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
                } else {
                    $this->image->move($this->getUploadRootDir(), $tempImageName);
                    unlink($this->getUploadRootDir() . $tempImageName);
                }
                $this->setImage($tempImageName);
            }
            if ($this->File != null) {
                $tempImageName1 = time() . '_2.' . pathinfo((string) $this->File->getClientOriginalName(), PATHINFO_EXTENSION);
                if (!$this->idSolicitud) {
                    $this->setFileName($this->File->getClientOriginalName());
                    $this->File->move($this->getTmpUploadRootDir(), $this->File->getClientOriginalName());
                } else {
                    $this->File->move($this->getUploadRootDir(), $tempImageName1);
                    unlink($this->getUploadRootDir() . $tempImageName1);
                }

                $this->setFile($tempImageName1);
            } else {
                //$this->File->move($this->getUploadRootDir(), $tempImageName1);
                // unlink($this->getUploadRootDir() . $tempImageName1);
                // $this->setFile($tempImageName1);
            }
        }
    }

    /**
     * @ORM\PostPersist()
     */
    public function moveImage() {
        if ($this->image != null) {
            if (!is_dir($this->getUploadRootDir())) {
                mkdir($this->getUploadRootDir(), 0777, true);
            }
            copy($this->getTmpUploadRootDir() . $this->getImageName(), $this->getFullImagePath());
            unlink($this->getTmpUploadRootDir() . $this->getImageName());
        }
        if ($this->File != null) {
            if (!is_dir($this->getUploadRootDir())) {
                mkdir($this->getUploadRootDir(), 0777, true);
            }
            copy($this->getTmpUploadRootDir() . $this->getFileName(), $this->getFullFilePath());
            unlink($this->getTmpUploadRootDir() . $this->getFileName());
        }
    }

    private $aux;
    private $aux1;

    /**
     * 
     * @ORM\PreRemove()
     */
    public function removeImage() {
        if ($this->image != null) {
            unlink($this->getFullImagePath());
        
        }
        if ($this->File != null) {
             unlink($this->getFullFilePath());
        }
        if($this->image != null or $this->File != null){
        rmdir($this->getUploadRootDir());    
        }
        
    }
    private $imagename;
    private $Filename;

    /**
     * Set image
     *
     * @param string $imagename
     * @return Hojadevida
     */
    public function setImageName($imagename) {
        $this->imagename = $imagename;

        return $this;
    }

    /**
     * Set image
     *
     * @param string $imagename
     * @return Hojadevida
     */
    public function setFileName($imagename) {
        $this->Filename = $imagename;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImageName() {
        return $this->imagename;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getFileName() {
        return $this->Filename;
    }

    /**
     * Set nombre
     *
     * @param string $Aux
     *
     * @return Solicitud
     */
    public function setAux($aux) {
        $this->aux = $aux;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getAux() {
        return $this->aux;
    }

    /**
     * Set nombre
     *
     * @param string $aux1
     *
     * @return Hojadevida
     */
    public function setAux1($aux1) {
        $this->aux1 = $aux1;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getAux1() {
        return $this->aux1;
    }

}
