<?php

namespace App\Entity;

use App\Repository\StatusDevisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusDevisRepository::class)
 */
class StatusDevis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accept;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $accept_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    public function getAcceptAt(): ?\DateTimeInterface
    {
        return $this->accept_at;
    }

    public function setAcceptAt(\DateTimeInterface $accept_at): self
    {
        $this->accept_at = $accept_at;

        return $this;
    }
}
