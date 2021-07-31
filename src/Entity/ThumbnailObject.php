<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateThumbnailObjectAction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ApiResource(
 *      iri="http://schema.org/ThumbnailObject",
 *      normalizationContext={
 *          "groups"={"thumbnail_object_read"}
 *      },
 *      collectionOperations={
 *          "post"={
 *              "controller"=CreateThumnailObjectAction::class,
 *              "deserialize"=false,
 *              "validation_groups"={"Default", "thumbnail_object_create"},
 *              "openapi_context"={
 *                  "requestBody"={
 *                      "Content"={
 *                          "multipart/form-data"={
 *                              "schema"={
 *                                  "type"="object",
 *                                  "properties"={
 *                                      "file"={
 *                                          "type"="string",
 *                                          "format"="binary"
 *                                      }
 *                                  }
 *                              }
 *                          }
 *                      }
 *                  }
 *              }
 *          },
 *          "get"
 *      },
 *      itemOperations={
 *          "get",
 *          "delete"
 *      }
 * )
 *
 * The class contains uploadable fields
 * @Vich\Uploadable
 */
class ThumbnailObject
{
    use TimestampableEntity;
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"thumbnail_object_read"})
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"thumbnail_object_read", "album:read"})
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"thumbnail_object_create"})
     * @Vich\UploadableField(mapping="thumbnail_object", fileNameProperty="fileName")
     */
    public $file;


    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     * @Groups({"thumbnail_object_read", "album:read"})
     */
    public $fileName;

    /**
     * "One ThumbnailObject to Many Tracks"
     * @ORM\OneToMany(targetEntity=Track::class, mappedBy="thumbnail")
     */
    private $tracks;

    /**
     * "Many ThumbnailObject to One Album"
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="thumbnails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album;

    public function __construct()
    {
        $this->tracks = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"thumbnail_object_read"})
     * @SerializedName("created_date")
     */
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        // dd($this->createdAt);
        return $this->createdAt;
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
            $track->setThumbnail($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): self
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getThumbnail() === $this) {
                $track->setThumbnail(null);
            }
        }

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
}
