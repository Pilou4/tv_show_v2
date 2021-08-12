<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=TvShow::class, mappedBy="directedBy")
     */
    private $directedTvShows;

    public function __construct()
    {
        $this->directedTvShows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|TvShow[]
     */
    public function getDirectedTvShows(): Collection
    {
        return $this->directedTvShows;
    }

    public function addDirectedTvShow(TvShow $directedTvShow): self
    {
        if (!$this->directedTvShows->contains($directedTvShow)) {
            $this->directedTvShows[] = $directedTvShow;
            $directedTvShow->setDirectedBy($this);
        }

        return $this;
    }

    public function removeDirectedTvShow(TvShow $directedTvShow): self
    {
        if ($this->directedTvShows->removeElement($directedTvShow)) {
            // set the owning side to null (unless already changed)
            if ($directedTvShow->getDirectedBy() === $this) {
                $directedTvShow->setDirectedBy(null);
            }
        }

        return $this;
    }
}
