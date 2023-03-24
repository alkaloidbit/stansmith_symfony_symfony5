<?php

namespace App\Entity;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity (repositoryClass=ArtistRepository::class)
 */
#[ApiResource(operations: [new Get(), new Put(), new GetCollection(security: 'is_granted(\'ROLE_USER\')'), new Post(security: 'is_granted(\'ROLE_USER\')')], types: ['http://schema.org/MusicGroup'], paginationItemsPerPage: 10, normalizationContext: ['groups' => ['artist:read']], denormalizationContext: ['groups' => ['artist:write']])]
#[ApiFilter(filterClass: SearchFilter::class, properties: ['name' => 'partial'])]
#[ApiFilter(filterClass: OrderFilter::class, properties: ['id' => 'ASC', 'name' => 'ASC'])]
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
     * @ORM\Column (type="string", length=255)
     * @Groups ({"artist:read", "artist:write", "album:read"})
     * @Assert\NotBlank
     */
    #[ApiProperty(iris: ['http://schema.org/name'])]
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
    public function getId() : ?int
    {
        return $this->id;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return Collection|Album[]
     */
    public function getAlbums() : Collection
    {
        return $this->albums;
    }
    public function addAlbum(Album $album) : self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setArtist($this);
        }
        return $this;
    }
    public function removeAlbum(Album $album) : self
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
    public function getTracks() : Collection
    {
        return $this->tracks;
    }
    public function addTrack(Track $track) : self
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
            $track->setArtist($this);
        }
        return $this;
    }
    public function removeTrack(Track $track) : self
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
