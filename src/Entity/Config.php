<?php

namespace App\Entity;

use App\Entity\Sygesca\Region;
use App\Repository\ConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConfigRepository::class)
 */
class Config
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apikey;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $siteId;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurRGB;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurTheme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApikey(): ?string
    {
        return $this->apikey;
    }

    public function setApikey(?string $apikey): self
    {
        $this->apikey = $apikey;

        return $this;
    }

    public function getSiteId(): ?int
    {
        return $this->siteId;
    }

    public function setSiteId(?int $siteId): self
    {
        $this->siteId = $siteId;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCouleurRGB(): ?string
    {
        return $this->couleurRGB;
    }

    public function setCouleurRGB(?string $couleurRGB): self
    {
        $this->couleurRGB = $couleurRGB;

        return $this;
    }

    public function getCouleurTheme(): ?string
    {
        return $this->couleurTheme;
    }

    public function setCouleurTheme(?string $couleurTheme): self
    {
        $this->couleurTheme = $couleurTheme;

        return $this;
    }

    public function getBg(): ?string
    {
        return $this->bg;
    }

    public function setBg(?string $bg): self
    {
        $this->bg = $bg;

        return $this;
    }
}
