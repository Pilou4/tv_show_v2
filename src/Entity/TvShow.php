<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TvShowRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * @ORM\Entity(repositoryClass=TvShowRepository::class)
 */
class TvShow
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
    #[NotBlank()]
    #[Length(max: 255, maxMessage: "Cette valeur est trop longue {maximun {{ limit }} caractères}" )]
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $synopsis;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    #[Type("\DateTime")]
    private $releaseDate;

    /**
     * @ORM\OneToMany(targetEntity=Season::class, mappedBy="tvShow", orphanRemoval=true)
     */
    private $seasons;

    /**
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="tvShow", orphanRemoval=true)
     */
    private $characters;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="directedTvShows")
     */
    private $directedBy;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tvShows")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureFile;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
            $season->setTvShow($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getTvShow() === $this) {
                $season->setTvShow(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Character[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setTvShow($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getTvShow() === $this) {
                $character->setTvShow(null);
            }
        }

        return $this;
    }

    public function getDirectedBy(): ?Person
    {
        return $this->directedBy;
    }

    public function setDirectedBy(?Person $directedBy): self
    {
        $this->directedBy = $directedBy;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getPictureFile(): ?string
    {
        return $this->pictureFile;
    }

    public function setPictureFile(?string $pictureFile): self
    {
        $this->pictureFile = $pictureFile;

        return $this;
    }
}
