<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    #[
        Length(
            min:3,
            minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
            max:30,
            maxMessage: 'Le nom doit contenir au maximun {{ limit }} caractères',
        )
    ]
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity=TvShow::class, mappedBy="categories")
     */
    private $tvShows;

    public function __construct()
    {
        $this->tvShows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|TvShow[]
     */
    public function getTvShows(): Collection
    {
        return $this->tvShows;
    }

    public function addTvShow(TvShow $tvShow): self
    {
        if (!$this->tvShows->contains($tvShow)) {
            $this->tvShows[] = $tvShow;
            $tvShow->addCategory($this);
        }

        return $this;
    }

    public function removeTvShow(TvShow $tvShow): self
    {
        if ($this->tvShows->removeElement($tvShow)) {
            $tvShow->removeCategory($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->label;
    }
}
