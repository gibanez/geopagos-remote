<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="codigoUsuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoUsuario;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="usuario", type="string", length=255)
     */
    private $usuario;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="clave", type="string", length=255)
     */
    private $clave;

    /**
     * @var int
     * @Assert\NotNull()
     *
     * @Assert\Range(
     *      min = 18,
     *      minMessage = "La edad no puede ser menor a 18 años"
     * )
     * @ORM\Column(name="edad", type="integer")
     */
    private $edad;

    /**
     * @ORM\ManyToMany(targetEntity="Pago", inversedBy="usuarios")
     * @ORM\JoinTable(
     *  name="usuario_pago",
     *  joinColumns={
     *      @ORM\JoinColumn(name="usuario", referencedColumnName="codigoUsuario")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="pago", referencedColumnName="codigoPago")
     *  }
     * )
     */
    private $pagos;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="Usuario", cascade={"all"})
     * @ORM\JoinTable(
     *  name="usuario_favorito",
     *  joinColumns={
     *      @ORM\JoinColumn(name="usuario", referencedColumnName="codigoUsuario")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="favorito", referencedColumnName="codigoUsuario")
     *  }
     * )
     */
    private $favoritos;



    public function __construct()
    {
        $this->pagos        = new ArrayCollection();
        $this->favoritos    = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getCodigoUsuario()
    {
        return $this->codigoUsuario;
    }

    /**
     * @param int $codigoUsuario
     */
    public function setCodigoUsuario($codigoUsuario)
    {
        $this->codigoUsuario = $codigoUsuario;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param string $clave
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    /**
     * @return int
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * @param int $edad
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    /**
     * @return mixed
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * @param mixed $pagos
     */
    public function setPagos($pagos)
    {
        $this->pagos = $pagos;
    }

    /**
     * @return mixed
     */
    public function getFavoritos()
    {
        return $this->favoritos;
    }

    /**
     * @param mixed $favoritos
     */
    public function setFavoritos($favoritos)
    {
        $this->favoritos = $favoritos;
    }

    public function __toString()
    {
        return $this->getUsuario();
    }

    public function addPago(Pago $pago)
    {
        if ($this->pagos->contains($pago)) {
            return;
        }
        $this->pagos[] = $pago;
        $pago->addUsuario($this);
    }
    public function removePago(Pago $pago)
    {
        $this->pagos->removeElement($pago);
        $pago->removeUsuario($this);
    }

    public function addFavorito(Usuario $usuario)
    {
        $this->favoritos[] = $usuario;
        //$usuario->addFavorito($this);
    }

    public function removeFavorito(Usuario $usuario)
    {
        $this->favoritos->removeElement($usuario);
    }



}

