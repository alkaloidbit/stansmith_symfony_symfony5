<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 *
 * @ApiResource(
 *      iri="http://schema.org/MusicGroup",
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put"},
 *      normalizationContext={"groups"={"artist:read"}},
 *      denormalizationContext={"groups"={"artist:write"}},
 *      attributes={
 *          "pagination_items_per_page"=10
 *      }
 * )
* @ApiFilter(SearchFilter::class, properties={"name": "partial"})
 */
class Artist
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"artist:read"})
     */
    private $id;

    /**
     * The name of this artist
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({"artist:read", "album:read"})
     * @ApiProperty(iri="http://schema.org/name")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * The albums produced by this artist
     *
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="artist")
     * @Groups({"artist:read"})
     */
    private $albums;

    /**
     * @ORM\OneToMany(targetEntity=Track::class, mappedBy="artist")
     */
    private $tracks;


    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->tracks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getArtist() === $this) {
                $album->setArtist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Track[]
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
            $track->setArtist($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getArtist() === $this) {
                $track->setArtist(null);
            }
        }

        return $this;
    }
}
