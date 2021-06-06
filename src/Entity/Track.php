<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TrackRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 *
 * @ORM\Entity(repositoryClass=TrackRepository::class)
 *
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put"},
 *      normalizationContext={"groups"={"track:read"}}
 * )
 *
 */
class Track
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255)
     * @Groups({"track:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"track:read"})
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"track:read", "album:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"track:read"})
     * @SerializedName("album")
     */
    private $meta_album;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"track:read"})
     * @SerializedName("artist")
     */
    private $meta_artist;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"track:read", "album:read"})
     * @SerializedName("tracknumber")
     */
    private $meta_track_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"track:read"})
     * @SerializedName("date")
     */
    private $meta_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"track:read"})
     * @SerializedName("genre")
     */
    private $meta_genre;


    /**
     * @Groups({"track:read", "album:read"})
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="tracks")
     */
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="tracks")
     */
    private $album;

    /**
     * @ORM\Column(type="integer")
     */
    private $mtime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mimeType;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"track:read", "album:read"})
     * @SerializedName("playtime_string")
     */
    private $meta_playtime_string;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"track:read", "album:read"})
     * @SerializedName("playtime_seconds")
     */
    private $meta_playtime_seconds;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"track:read", "album:read"})
     */
    private $meta_filesize;


    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
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

    public function getMetaAlbum(): ?string
    {
        return $this->meta_album;
    }

    public function setMetaAlbum(?string $meta_album): self
    {
        $this->meta_album = $meta_album;

        return $this;
    }

    public function getMetaArtist(): ?string
    {
        return $this->meta_artist;
    }

    public function setMetaArtist(string $meta_artist): self
    {
        $this->meta_artist = $meta_artist;

        return $this;
    }

    public function getMetaTrackNumber(): ?int
    {
        return $this->meta_track_number;
    }

    public function setMetaTrackNumber(?int $meta_track_number): self
    {
        $this->meta_track_number = $meta_track_number;

        return $this;
    }

    public function getMetaDate(): ?string
    {
        return $this->meta_date;
    }

    public function setMetaDate(?string $meta_date): self
    {
        $this->meta_date = $meta_date;

        return $this;
    }

    public function getMetaGenre(): ?string
    {
        return $this->meta_genre;
    }

    public function setMetaGenre(?string $meta_genre): self
    {
        $this->meta_genre = $meta_genre;

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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getMtime(): ?int
    {
        return $this->mtime;
    }

    public function setMtime(int $mtime): self
    {
        $this->mtime = $mtime;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getMetaPlaytimeString(): ?string
    {
        return $this->meta_playtime_string;
    }

    public function setMetaPlaytimeString(?string $meta_playtime_string): self
    {
        $this->meta_playtime_string = $meta_playtime_string;

        return $this;
    }

    public function getMetaPlaytimeSeconds(): ?float
    {
        return $this->meta_playtime_seconds;
    }

    public function setMetaPlaytimeSeconds(?float $meta_playtime_seconds): self
    {
        $this->meta_playtime_seconds = $meta_playtime_seconds;

        return $this;
    }

    public function getMetaFilesize(): ?int
    {
        return $this->meta_filesize;
    }

    public function setMetaFilesize(?int $meta_filesize): self
    {
        $this->meta_filesize = $meta_filesize;

        return $this;
    }
}
