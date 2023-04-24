<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Serializer\Filter\PropertyFilter;
/* use App\ApiPlatform\AlbumSearchSupportUnderscoreFilter; */
use App\Repository\AlbumRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    types: ['http://schema.org/MusicAlbum'],
    operations: [
        new Get(),
        new Put(security: 'is_granted(\'ROLE_USER\')'),
        new Delete(security: 'is_granted(\'ROLE_ADMIN\')'),
        new GetCollection(security: 'is_granted(\'ROLE_USER\')'),
        new Post(security: 'is_granted(\'ROLE_USER\')'),
    ],
    normalizationContext: [
        'groups' => ['album:read'],
        'swagger_definition_name' => 'Read',
    ],
    denormalizationContext: [
        'groups' => ['album:write'],
        'swagger_definition_name' => 'Write',
    ],
    extraProperties: [
        'standard_put' => true,
    ]
)]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['artist' => 'exact', 'title' => 'partial', 'id' => 'exact'])]
#[ApiFilter(filterClass: BooleanFilter::class, properties: ['active'])]
#[ApiFilter(filterClass: PropertyFilter::class)]
#[ApiFilter(filterClass: OrderFilter::class, properties: ['id' => 'ASC'])]
#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['album:read'])]
    private $id;

    #[ApiProperty(iris: ['http://schema.org/name'])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['album:read', 'album:write', 'artists:read'])]
    #[Assert\NotBlank]
    private $title;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'albums')]
    #[Groups(['album:write', 'album:read'])]
    #[Assert\NotNull]
    private $artist;

    #[ORM\OneToMany(targetEntity: Track::class, mappedBy: 'album')]
    #[OrderBy(['meta_track_number' => 'ASC'])]
    #[Groups(['album:read'])]
    private $tracks;

    #[ORM\OneToMany(targetEntity: MediaObject::class, mappedBy: 'album', orphanRemoval: true)]
    #[Groups(['album:write', 'album:read', 'track:read'])]
    private $covers;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['album:write', 'album:read'])]
    #[Assert\NotNull]
    private $date;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['album:write', 'album:read'])]
    private $active;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
        $this->covers = new ArrayCollection();
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
     *
     * @return string
     */
    /* public function getCoverPath(): ?string */
    /* { */
    /*     return 'uploads/covers/'.$this->getCover(); */
    /* } */
    #[Groups(['album:read'])]
    #[SerializedName('created_date')]
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        // dd($this->createdAt);
        return $this->createdAt;
    }

    /**
     * @return Collection|MediaObject[]
     */
    public function getCovers(): Collection
    {
        return $this->covers;
    }

    public function addCover(MediaObject $cover): self
    {
        if (!$this->covers->contains($cover)) {
            $this->covers[] = $cover;
            $cover->setAlbum($this);
        }

        return $this;
    }

    public function removeCover(MediaObject $cover): self
    {
        if ($this->covers->removeElement($cover)) {
            // set the owning side to null (unless already changed)
            if ($cover->getAlbum() === $this) {
                $cover->setAlbum(null);
            }
        }

        return $this;
    }

    #[Groups(['album:read'])]
    #[SerializedName('total_playtime_seconds')]
    public function getTotalTracksPlaytime(): int
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

    #[SerializedName('mainThumbnail')]
    public function getCoverMediaObject()
    {
        return $this->covers[0];
    }
}
