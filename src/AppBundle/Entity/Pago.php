<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pago
 *
 * @ORM\Table(name="pago")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PagoRepository")
 */
class Pago
{

    /**
     * @var int
     *
     * @ORM\Column(name="codigoPago", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoPago;

    /**
     * @var string
     * @Assert\Range(min = 1)
     * @Assert\NotNull()
     * @ORM\Column(name="importe", type="decimal", precision=10, scale=2)
     */
    private $importe;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @Assert\Range(min = "now")
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|Usuario[]
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="pagos", cascade={"all"})
     */
    private $usuarios;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getCodigoPago()
    {
        return $this->codigoPago;
    }

    /**
     * @param int $codigoPago
     */
    public function setCodigoPago($codigoPago)
    {
        $this->codigoPago = $codigoPago;
    }

    /**
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * @param string $importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return Usuario[]|\Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }

    /**
     * @param Usuario[]|\Doctrine\Common\Collections\ArrayCollection $usuarios
     */
    public function setUsuarios($usuarios)
    {
        $this->usuarios = $usuarios;
    }

    public function __toString()
    {
        return sprintf("%s (%s)", $this->getImporte(), $this->getFecha()->format("Y-m-d"));
    }


    public function addUsuario(Usuario $usuario)
    {

        $this->usuarios[] = $usuario;
        $usuario->addPago($this);
    }
    public function removeUsuario(Usuario $usuario)
    {
        $this->usuarios->removeElement($usuario);
        $usuario->removePago($this);
    }


}

