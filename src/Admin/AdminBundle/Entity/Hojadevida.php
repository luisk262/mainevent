<?php

namespace Admin\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hojadevida
 *
 * @ORM\Table(name="hojadevida")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class Hojadevida {

    /**
     * @var integer
     *
     * @ORM\Column(name="idHv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idhv;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Apellido", type="string", length=30, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_Casa", type="string", length=30, nullable=true)
     */
    private $telCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel_Ce", type="string", length=30, nullable=false)
     */
    private $telCe;

    /**
     * @var string
     *
     * @ORM\Column(name="Telefono_Adic", type="string", length=30, nullable=true)
     */
    private $telefonoAdic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha_Nac", type="date", nullable=false)
     */
    private $fechaNac;

    /**
     * @var string
     *
     * @ORM\Column(name="Tipo_Documento", type="string", length=2, nullable=false)
     */
    private $tipoDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="Nit", type="string", length=15, nullable=false)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexo", type="string", length=30, nullable=false)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="Lugar_Nacimiento", type="string", length=40, nullable=true)
     */
    private $lugarNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="Ciudad", type="string", length=25, nullable=true)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="Dir_Casa", type="string", length=40, nullable=true)
     */
    private $dirCasa;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_Personal", type="string", length=40, nullable=false)
     */
    private $emailPersonal;

    /**
     * @var string
     *
     * @ORM\Column(name="Estatura", type="string", length=20, nullable=true)
     */
    private $estatura;

    /**
     * @var string
     *
     * @ORM\Column(name="Piel", type="string", length=30, nullable=true)
     */
    private $piel;

    /**
     * @var string
     *
     * @ORM\Column(name="Ojos", type="string", length=30, nullable=true)
     */
    private $ojos;

    /**
     * @var string
     *
     * @ORM\Column(name="Pelo", type="string", length=30, nullable=true)
     */
    private $pelo;

    /**
     * @var string
     *
     * @ORM\Column(name="Peso", type="string", length=30, nullable=true)
     */
    private $peso;

    /**
     * @var string
     *
     * @ORM\Column(name="Experiencia_TV", type="text", nullable=true)
     */
    private $experienciaTv;

    /**
     * @var string
     *
     * @ORM\Column(name="Deportes", type="string", length=80, nullable=true)
     */
    private $deportes;

    /**
     * @var string
     *
     * @ORM\Column(name="Habilidades", type="string", length=80, nullable=true)
     */
    private $habilidades;

    /**
     * @var string
     *
     * @ORM\Column(name="Idiomas", type="string", length=80, nullable=true)
     */
    private $idiomas;

    /**
     * @var string
     *
     * @ORM\Column(name="Maneja", type="string", length=80, nullable=true)
     */
    private $maneja;

    /**
     * @var string
     *
     * @ORM\Column(name="Entidad_Salud", type="string", length=80, nullable=true)
     */
    private $entidadSalud;

    /**
     * @var string
     *
     * @ORM\Column(name="Categoria", type="string", length=30, nullable=true)
     */
    private $categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="Talla_Camisa", type="string", length=30, nullable=true)
     */
    private $tallaCamisa;

    /**
     * @var string
     *
     * @ORM\Column(name="Talla_Chaqueta", type="string", length=30, nullable=true)
     */
    private $tallaChaqueta;

    /**
     * @var string
     *
     * @ORM\Column(name="Talla_Pantalon", type="string", length=30, nullable=true)
     */
    private $tallaPantalon;

    /**
     * @var string
     *
     * @ORM\Column(name="Talla_Zapato", type="string", length=30, nullable=true)
     */
    private $tallaZapato;

    
    /**
     * @var string
     *
     * @ORM\Column(name="DV", type="string", length=2, nullable=true)
     */
    private $dv;

    /**
     * @var string
     *
     * @ORM\Column(name="Estado", type="string", length=10, nullable=true)
     */
    private $Estado;

    /**
     * @var string
     *
     * @ORM\Column(name="Tags", type="string", length=255, nullable=true)
     */
    private $Tags;

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
     * @var string $image
     * @Assert\File( maxSize = "1024k",
     * mimeTypesMessage = "Carge una imagen valida")
     * @ORM\Column(name="image", type="string", length=255)
     */
    public $image;

    /**
     * @var string $image1
     * @Assert\File( maxSize = "1024k",
     * mimeTypesMessage = "Carge una imagen valida")
     * @ORM\Column(name="image1", type="string", length=255)
     */
    private $image1;

    /**
     * @var string $image2
     * @Assert\File( maxSize = "1024k",
     * mimeTypesMessage = "Carge una imagen valida")
     * @ORM\Column(name="image2", type="string", length=255)
     */
    private $image2;
    private $imagename;
    private $image1name;
    private $image2name;

    /**


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
    public function setImage1Name($image1name) {
        $this->image1name = $image1name;

        return $this;
    }

    /**
     * Set image
     *
     * @param string $imagename
     * @return Hojadevida
     */
    public function setImage2Name($image2name) {
        $this->image2name = $image2name;

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
    public function getImage1Name() {
        return $this->image1name;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage2Name() {
        return $this->image2name;
    }

////
    public function getFullImagePath() {
        return null === $this->image ? null : $this->getUploadRootDir() . $this->image;
        //retorna la imagen para mostrar en web
    }

    public function getFullImage1Path() {
        return null === $this->image1 ? null : $this->getUploadRootDir() . $this->image1;
        //retorna la imagen para mostrar en web
    }

    public function getFullImage2Path() {
        return null === $this->image2 ? null : $this->getUploadRootDir() . $this->image2;
        //retorna la imagen para mostrar en web
    }

    protected function getUploadRootDir() {
        //ruta del dicrectorio donde se van a guardar los archivos
       
        return $this->getTmpUploadRootDir()."/../" . $this->nit . "/";
    }

    protected function getTmpUploadRootDir() {
        //la ruta del directorio absoluta donde se deben guardar los documentos cargados
        return __DIR__ . '/../../../../web/upload/Hojasdevida/tmp/';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function uploadImage() {
        //validamos si es una actualizacion o una nueva
        //si las fehcas son diferentes es actualizacion de lo contrario es nuevo
        if ($this->fechaupdate != $this->fecha) {
            if ($this->image != null) {
                ///asignamos los nombres nuevos
                $tempImageName = time() . '_1.' . pathinfo((string) $this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                //borramos imagenes viejas
                $dir = $this->getUploadRootDir();
                if (is_file($dir . $this->aux)) {
                    unlink($dir . $this->aux);
                }
                /// guardamos en el servidor los archivos
                $this->setImageName($this->image->getClientOriginalName());
                $this->image->move($this->getUploadRootDir(), $tempImageName);

                //grabamos los nombres de archivo en el servidor
                $this->setImage($tempImageName);
            } else {
                $this->setImage($this->aux);
            }
            if ($this->image1 != null) {
                ///asignamos los nombres nuevos
                $tempImageName1 = time() . '_2.' . pathinfo((string) $this->image1->getClientOriginalName(), PATHINFO_EXTENSION);

                //borramos imagenes viejas
                $dir = $this->getUploadRootDir();
                if (is_file($dir . $this->aux1)) {
                    unlink($dir . $this->aux1);
                }
                /// guardamos en el servidor los archivos
                $this->setImage1Name($this->image1->getClientOriginalName());
                $this->image1->move($this->getUploadRootDir(), $tempImageName1);

                //grabamos los nombres de archivo en el servidor
                $this->setImage1($tempImageName1);
            } else {
                $this->setImage1($this->aux1);
            }
            if ($this->image2 != Null) {
                ///asignamos los nombres nuevos
                $tempImageName2 = time() . '_3.' . pathinfo((string) $this->image2->getClientOriginalName(), PATHINFO_EXTENSION);
                //borramos imagenes viejas
                $dir = $this->getUploadRootDir();
                if (is_file($dir . $this->aux2)) {
                    unlink($dir . $this->aux2);
                }
                /// guardamos en el servidor los archivos
                $this->setImage2Name($this->image2->getClientOriginalName());
                $this->image2->move($this->getUploadRootDir(), $tempImageName2);

                //grabamos los nombres de archivo en el servidor
                $this->setImage2($tempImageName2);
            } else {
                $this->setImage2($this->aux2);
            }
        } else {
            if ((null === $this->image)or ( null === $this->image1)or ( null === $this->image2)) {
                return;
            }

            $tempImageName = time() . '_1.' . pathinfo((string) $this->image->getClientOriginalName(), PATHINFO_EXTENSION);
            $tempImageName1 = time() . '_2.' . pathinfo((string) $this->image1->getClientOriginalName(), PATHINFO_EXTENSION);
            $tempImageName2 = time() . '_3.' . pathinfo((string) $this->image2->getClientOriginalName(), PATHINFO_EXTENSION);
            if (!$this->idhv) {
                $this->setImageName($this->image->getClientOriginalName());
                $this->setImage1Name($this->image1->getClientOriginalName());
                $this->setImage2Name($this->image2->getClientOriginalName());
                $this->image->move($this->getTmpUploadRootDir(), $this->image->getClientOriginalName());
                $this->image1->move($this->getTmpUploadRootDir(), $this->image1->getClientOriginalName());
                $this->image2->move($this->getTmpUploadRootDir(), $this->image2->getClientOriginalName());
            } else {
                $this->image->move($this->getUploadRootDir(), $tempImageName);
                $this->image1->move($this->getUploadRootDir(), $tempImageName1);
                $this->image2->move($this->getUploadRootDir(), $tempImageName2);
                unlink($this->getUploadRootDir() . $tempImageName);
                unlink($this->getUploadRootDir() . $tempImageName1);
                unlink($this->getUploadRootDir() . $tempImageName2);
            }

            $this->setImage($tempImageName);
            $this->setImage1($tempImageName1);
            $this->setImage2($tempImageName2);
        }
    }

    /**
     * @ORM\PostPersist()
     */
    public function moveImage() {
        if ((null === $this->image)or ( null === $this->image1)or ( null === $this->image2)) {
            return;
        }
        if (!is_dir($this->getUploadRootDir())) {
            mkdir($this->getUploadRootDir(), 0777, true);
        }

        copy($this->getTmpUploadRootDir() . $this->getImageName(), $this->getFullImagePath());
        unlink($this->getTmpUploadRootDir() . $this->getImageName());
        copy($this->getTmpUploadRootDir() . $this->getImage1Name(), $this->getFullImage1Path());
        unlink($this->getTmpUploadRootDir() . $this->getImage1Name());
        copy($this->getTmpUploadRootDir() . $this->getImage2Name(), $this->getFullImage2Path());
        unlink($this->getTmpUploadRootDir() . $this->getImage2Name());
    }

    private $aux;
    private $aux1;
    private $aux2;

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hojadevida
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
     * @param string $nombre
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

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hojadevida
     */
    public function setAux2($aux2) {
        $this->aux2 = $aux2;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getAux2() {
        return $this->aux2;
    }

    /**
     * 
     * @ORM\PreRemove()
     */
    public function removeImage() {
        unlink($this->getFullImagePath());
        unlink($this->getFullImage1Path());
        unlink($this->getFullImage2Path());
        rmdir($this->getUploadRootDir());
    }

////////

    /**
     * Get idhv
     *
     * @return integer
     */
    public function getIdhv() {
        return $this->idhv;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Hojadevida
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Hojadevida
     */
    public function setApellido($apellido) {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido() {
        return $this->apellido;
    }

    /**
     * Set telCasa
     *
     * @param string $telCasa
     *
     * @return Hojadevida
     */
    public function setTelCasa($telCasa) {
        $this->telCasa = $telCasa;

        return $this;
    }

    /**
     * Get telCasa
     *
     * @return string
     */
    public function getTelCasa() {
        return $this->telCasa;
    }

    /**
     * Set telCe
     *
     * @param string $telCe
     *
     * @return Hojadevida
     */
    public function setTelCe($telCe) {
        $this->telCe = $telCe;

        return $this;
    }

    /**
     * Get telCe
     *
     * @return string
     */
    public function getTelCe() {
        return $this->telCe;
    }

    /**
     * Set telefonoAdic
     *
     * @param string $telefonoAdic
     *
     * @return Hojadevida
     */
    public function setTelefonoAdic($telefonoAdic) {
        $this->telefonoAdic = $telefonoAdic;

        return $this;
    }

    /**
     * Get telefonoAdic
     *
     * @return string
     */
    public function getTelefonoAdic() {
        return $this->telefonoAdic;
    }

    /**
     * Set fechaNac
     *
     * @param \DateTime $fechaNac
     *
     * @return Hojadevida
     */
    public function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;

        return $this;
    }

    /**
     * Get fechaNac
     *
     * @return \DateTime
     */
    public function getFechaNac() {
        return $this->fechaNac;
    }

    /**
     * Set tipoDocumento
     *
     * @param string $tipoDocumento
     *
     * @return Hojadevida
     */
    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    /**
     * Get tipoDocumento
     *
     * @return string
     */
    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    /**
     * Set nit
     *
     * @param string $nit
     *
     * @return Hojadevida
     */
    public function setNit($nit) {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit() {
        return $this->nit;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Hojadevida
     */
    public function setSexo($sexo) {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo() {
        return $this->sexo;
    }

    /**
     * Set lugarNacimiento
     *
     * @param string $lugarNacimiento
     *
     * @return Hojadevida
     */
    public function setLugarNacimiento($lugarNacimiento) {
        $this->lugarNacimiento = $lugarNacimiento;

        return $this;
    }

    /**
     * Get lugarNacimiento
     *
     * @return string
     */
    public function getLugarNacimiento() {
        return $this->lugarNacimiento;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return Hojadevida
     */
    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad() {
        return $this->ciudad;
    }

    /**
     * Set dirCasa
     *
     * @param string $dirCasa
     *
     * @return Hojadevida
     */
    public function setDirCasa($dirCasa) {
        $this->dirCasa = $dirCasa;

        return $this;
    }

    /**
     * Get dirCasa
     *
     * @return string
     */
    public function getDirCasa() {
        return $this->dirCasa;
    }

    /**
     * Set emailPersonal
     *
     * @param string $emailPersonal
     *
     * @return Hojadevida
     */
    public function setEmailPersonal($emailPersonal) {
        $this->emailPersonal = $emailPersonal;

        return $this;
    }

    /**
     * Get emailPersonal
     *
     * @return string
     */
    public function getEmailPersonal() {
        return $this->emailPersonal;
    }

    /**
     * Set estatura
     *
     * @param string $estatura
     *
     * @return Hojadevida
     */
    public function setEstatura($estatura) {
        $this->estatura = $estatura;

        return $this;
    }

    /**
     * Get estatura
     *
     * @return string
     */
    public function getEstatura() {
        return $this->estatura;
    }

    /**
     * Set piel
     *
     * @param string $piel
     *
     * @return Hojadevida
     */
    public function setPiel($piel) {
        $this->piel = $piel;

        return $this;
    }

    /**
     * Get piel
     *
     * @return string
     */
    public function getPiel() {
        return $this->piel;
    }

    /**
     * Set ojos
     *
     * @param string $ojos
     *
     * @return Hojadevida
     */
    public function setOjos($ojos) {
        $this->ojos = $ojos;

        return $this;
    }

    /**
     * Get ojos
     *
     * @return string
     */
    public function getOjos() {
        return $this->ojos;
    }

    /**
     * Set pelo
     *
     * @param string $pelo
     *
     * @return Hojadevida
     */
    public function setPelo($pelo) {
        $this->pelo = $pelo;

        return $this;
    }

    /**
     * Get pelo
     *
     * @return string
     */
    public function getPelo() {
        return $this->pelo;
    }

    /**
     * Set peso
     *
     * @param string $peso
     *
     * @return Hojadevida
     */
    public function setPeso($peso) {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return string
     */
    public function getPeso() {
        return $this->peso;
    }

    /**
     * Set experienciaTv
     *
     * @param string $experienciaTv
     *
     * @return Hojadevida
     */
    public function setExperienciaTv($experienciaTv) {
        $this->experienciaTv = $experienciaTv;

        return $this;
    }

    /**
     * Get experienciaTv
     *
     * @return string
     */
    public function getExperienciaTv() {
        return $this->experienciaTv;
    }

    /**
     * Set deportes
     *
     * @param string $deportes
     *
     * @return Hojadevida
     */
    public function setDeportes($deportes) {
        $this->deportes = $deportes;

        return $this;
    }

    /**
     * Get deportes
     *
     * @return string
     */
    public function getDeportes() {
        return $this->deportes;
    }

    /**
     * Set habilidades
     *
     * @param string $habilidades
     *
     * @return Hojadevida
     */
    public function setHabilidades($habilidades) {
        $this->habilidades = $habilidades;

        return $this;
    }

    /**
     * Get habilidades
     *
     * @return string
     */
    public function getHabilidades() {
        return $this->habilidades;
    }

    /**
     * Set idiomas
     *
     * @param string $idiomas
     *
     * @return Hojadevida
     */
    public function setIdiomas($idiomas) {
        $this->idiomas = $idiomas;

        return $this;
    }

    /**
     * Get idiomas
     *
     * @return string
     */
    public function getIdiomas() {
        return $this->idiomas;
    }

    /**
     * Set maneja
     *
     * @param string $maneja
     *
     * @return Hojadevida
     */
    public function setManeja($maneja) {
        $this->maneja = $maneja;

        return $this;
    }

    /**
     * Get maneja
     *
     * @return string
     */
    public function getManeja() {
        return $this->maneja;
    }

    /**
     * Set entidadSalud
     *
     * @param string $entidadSalud
     *
     * @return Hojadevida
     */
    public function setEntidadSalud($entidadSalud) {
        $this->entidadSalud = $entidadSalud;

        return $this;
    }

    /**
     * Get entidadSalud
     *
     * @return string
     */
    public function getEntidadSalud() {
        return $this->entidadSalud;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     *
     * @return Hojadevida
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * Set tallaCamisa
     *
     * @param string $tallaCamisa
     *
     * @return Hojadevida
     */
    public function setTallaCamisa($tallaCamisa) {
        $this->tallaCamisa = $tallaCamisa;

        return $this;
    }

    /**
     * Get tallaCamisa
     *
     * @return string
     */
    public function getTallaCamisa() {
        return $this->tallaCamisa;
    }

    /**
     * Set tallaChaqueta
     *
     * @param string $tallaChaqueta
     *
     * @return Hojadevida
     */
    public function setTallaChaqueta($tallaChaqueta) {
        $this->tallaChaqueta = $tallaChaqueta;

        return $this;
    }

    /**
     * Get tallaChaqueta
     *
     * @return string
     */
    public function getTallaChaqueta() {
        return $this->tallaChaqueta;
    }

    /**
     * Set tallaPantalon
     *
     * @param string $tallaPantalon
     *
     * @return Hojadevida
     */
    public function setTallaPantalon($tallaPantalon) {
        $this->tallaPantalon = $tallaPantalon;

        return $this;
    }

    /**
     * Get tallaPantalon
     *
     * @return string
     */
    public function getTallaPantalon() {
        return $this->tallaPantalon;
    }

    /**
     * Set tallaZapato
     *
     * @param string $tallaZapato
     *
     * @return Hojadevida
     */
    public function setTallaZapato($tallaZapato) {
        $this->tallaZapato = $tallaZapato;

        return $this;
    }

    /**
     * Get tallaZapato
     *
     * @return string
     */
    public function getTallaZapato() {
        return $this->tallaZapato;
    }

    /**
     * Set dv
     *
     * @param string $dv
     *
     * @return Hojadevida
     */
    public function setDv($dv) {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return string
     */
    public function getDv() {
        return $this->dv;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Hojadevida
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
     * @return Hojadevida
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

    /**
     * Set image2
     *
     * @param string $image2
     *
     * @return Hojadevida
     */
    public function setImage2($image2) {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return string
     */
    public function getImage2() {
        return $this->image2;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Hojadevida
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
     * Set image1
     *
     * @param string $image1
     *
     * @return Hojadevida
     */
    public function setImage1($image1) {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return string
     */
    public function getImage1() {
        return $this->image1;
    }

    public function __toString() {
        return $this->nombre;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Hojadevida
     */
    public function setEstado($estado) {
        $this->Estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado() {
        return $this->Estado;
    }
    /**
     * Set Tags
     *
     * @param string $Tags
     *
     * @return Hojadevida
     */
    public function setTags($Tags) {
        $this->Tags = $Tags;

        return $this;
    }

    /**
     * Get estado
     *
     * @return Tags
     */
    public function getTags() {
        return $this->Tags;
    
    }

}
