<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 *
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put"},
 *      normalizationContext={"groups"={"album:read"}, "swagger_definition_name"="Read"},
 *      denormalizationContext={"groups"={"album:write"}, "swagger_definition_name"="Write"}
 * )
 * @ApiFilter(SearchFilter::class, properties={"artist": "exact", "title": "partial", "id": "exact"})
 * @ApiFilter(BooleanFilter::class, properties={"active"})
 * @ApiFilter(PropertyFilter::class)
 *
 */
class Album
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"album:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Title of the Album
     * @Groups({"album:read", "album:write", "artists:read"})
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="albums")
     * @Groups({"album:write", "album:read"})
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity=Track::class, mappedBy="album")
     * @OrderBy({"meta_track_number"="ASC"})
     * @Groups({"album:read"})
     */
    private $tracks;

    /**
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="album", orphanRemoval=true)
     * @Groups({"album:write", "album:read"})
     */
    private $cover;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"album:write", "album:read"})
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"album:write", "album:read"})
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=ThumbnailObject::class, mappedBy="album", orphanRemoval=true)
     * @Groups({"album:write", "album:read"})
     */
    private $thumbnails;


    public function __construct()
    {
        $this->tracks = new ArrayCollection();
        $this->cover = new ArrayCollection();
        $this->thumbnails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

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
            $track->setAlbum($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getAlbum() === $this) {
                $track->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"album:read"})
     * @return string
     */
    /* public function getCoverPath(): ?string */
    /* { */
    /*     return 'uploads/covers/'.$this->getCover(); */
    /* } */
    
    /**
     * @Groups({"album:read"})
     * @SerializedName("created_date")
     */
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        // dd($this->createdAt);
        return $this->createdAt;
    }

    /**
     * @return Collection|MediaObject[]
     */
    public function getCover(): Collection
    {
        return $this->cover;
    }

    public function addCover(MediaObject $cover): self
    {
        if (!$this->cover->contains($cover)) {
            $this->cover[] = $cover;
            $cover->setAlbum($this);
        }

        return $this;
    }

    public function removeCover(MediaObject $cover): self
    {
        if ($this->cover->removeElement($cover)) {
            // set the owning side to null (unless already changed)
            if ($cover->getAlbum() === $this) {
                $cover->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @Groups({"album:read"})
     * @SerializedName("total_playtime_seconds")
     */
    public function getTotalTracksPlaytime()
    {
        $total = 0;
        foreach ($this->getTracks() as $track) {
            $total += $track->getMetaPlaytimeSeconds();
        }

        return $total;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|ThumbnailObject[]
     */
    public function getThumbnails(): Collection
    {
        return $this->thumbnails;
    }

    public function addThumbnail(ThumbnailObject $thumbnail): self
    {
        if (!$this->thumbnails->contains($thumbnail)) {
            $this->thumbnails[] = $thumbnail;
            $thumbnail->setAlbum($this);
        }

        return $this;
    }

    public function removeThumbnail(ThumbnailObject $thumbnail): self
    {
        if ($this->thumbnails->removeElement($thumbnail)) {
            // set the owning side to null (unless already changed)
            if ($thumbnail->getAlbum() === $this) {
                $thumbnail->setAlbum(null);
            }
        }

        return $this;
    }
}
