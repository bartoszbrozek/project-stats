<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    public function __construct()
    {
        $this->setCreatedAt((new \DateTime()));
        $this->dirStats = new ArrayCollection();
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
    private $directory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DirStats", mappedBy="projectid", orphanRemoval=true)
     */
    private $dirStats;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection|DirStats[]
     */
    public function getDirStats(): Collection
    {
        return $this->dirStats;
    }

    public function addDirStat(DirStats $dirStat): self
    {
        if (!$this->dirStats->contains($dirStat)) {
            $this->dirStats[] = $dirStat;
            $dirStat->setProjectid($this);
        }

        return $this;
    }

    public function removeDirStat(DirStats $dirStat): self
    {
        if ($this->dirStats->contains($dirStat)) {
            $this->dirStats->removeElement($dirStat);
            // set the owning side to null (unless already changed)
            if ($dirStat->getProjectid() === $this) {
                $dirStat->setProjectid(null);
            }
        }

        return $this;
    }
}
