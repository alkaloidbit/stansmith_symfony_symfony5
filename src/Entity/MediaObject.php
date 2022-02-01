<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
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
 *      iri="http://schema.org/MediaObject",
 *      normalizationContext={
 *          "groups"={"media_object_read"}
 *      },
 *      collectionOperations={
 *          "post"={
 *              "controller"=CreateMediaObjectAction::class,
 *              "deserialize"=false,
 *              "validation_groups"={"Default", "media_object_create"},
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
 *      },
 *      attributes={
 *          "pagination_items_per_page"=10
 *      }
 * )
 *
 * The class contains uploadable fields
 * @Vich\Uploadable
 */
class MediaObject
{
    use TimestampableEntity;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"media_object_read"})
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"media_object_read", "album:read"})
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="fileName")
     */
    public $file;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="thumbnailName")
     */
    public $thumbnail;


    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     * @Groups({"media_object_read", "album:read"})
     */
    public $fileName;

    /**
     * @var string|null
     * @ORM\Column(nullable=true)
     * @Groups({"media_object_read", "album:read"})
     */
    public $thumbnailName;

    /**
     * "Many MediaObject to One Album"
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="cover")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"media_object_read"})
     */
    private $album;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"media_object_read"})
     * @SerializedName("created_date")
     */
    public function getCreatedAtTimestampable(): ?\DateTimeInterface
    {
        // dd($this->createdAt);
        return $this->createdAt;
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
