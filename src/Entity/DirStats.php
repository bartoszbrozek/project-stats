<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DirStatsRepository")
 */
class DirStats
{
    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $relativeDirectory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="integer")
     */
    private $filesize;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfLines;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="dirStats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectid;

    /**
     * @ORM\Column(type="string", length=63)
     */
    private $scanid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelativeDirectory(): ?string
    {
        return $this->relativeDirectory;
    }

    public function setRelativeDirectory(string $relativeDirectory): self
    {
        $this->relativeDirectory = $relativeDirectory;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilesize(): ?int
    {
        return $this->filesize;
    }

    public function setFilesize(int $filesize): self
    {
        $this->filesize = $filesize;

        return $this;
    }

    public function getNumberOfLines(): ?int
    {
        return $this->numberOfLines;
    }

    public function setNumberOfLines(int $numberOfLines): self
    {
        $this->numberOfLines = $numberOfLines;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProjectid(): ?Project
    {
        return $this->projectid;
    }

    public function setProjectid(?Project $projectid): self
    {
        $this->projectid = $projectid;

        return $this;
    }

    public function getScanid(): ?string
    {
        return $this->scanid;
    }

    public function setScanid(string $scanid): self
    {
        $this->scanid = $scanid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
