<?php

namespace App\Entity;

use App\Repository\UrlsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlsRepository::class)
 */
class Urls
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_corta;

    /**
     * @ORM\Column(type="integer")
     */
    private $clicks;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_click;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_creacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="urls")
     */

    private $user;

    /**
     * Urls constructor.
     */
    public function __construct()
    {
        $this->clicks = '';
        $this->url_corta = '';
        $this->fecha_creacion = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrlCorta(): ?string
    {
        return $this->url_corta;
    }

    public function setUrlCorta(string $url_corta): self
    {
        $this->url_corta = $url_corta;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateClick()
    {
        return $this->date_click;
    }

    /**
     * @param mixed $date_click
     */
    public function setDateClick($date_click): void
    {
        $this->date_click = $date_click;
    }

    public function getClicks(): ?string
    {
        return $this->clicks;
    }

    public function setClicks(string $clicks): self
    {
        $this->clicks = $clicks;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


}
