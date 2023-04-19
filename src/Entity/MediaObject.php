<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateMediaObjectAction;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
#[ApiResource(
    types: ['http://schema.org/MediaObject'],
    normalizationContext: [
        'groups' => ['media_object:read'],
    ],
    operations: [
        new Get(),
        new GetCollection(
            security: 'is_granted(\'ROLE_USER\')',
        ),
        new Post(
            security: 'is_granted(\'ROLE_USER\')',
            controller: CreateMediaObjectAction::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'media_object_create']],
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ),
        new Delete(
            security: 'is_granted(\'ROLE_ADMIN\')'
        ),
    ],
)]
#[ORM\Entity]
class MediaObject
{
    use TimestampableEntity;
    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    #[Groups(['media_object:read'])]
    #[ORM\Id]
    protected $id;
    /**
     * @var string|null
     */
    #[ApiProperty(iris: ['http://schema.org/contentUrl'])]
    #[Groups(['media_object:read', 'album:read'])]
    public $coverContentUrl;
    /**
     * @var string|null
     */
    #[ApiProperty(iris: ['http://schema.org/contentUrl'])]
    #[Groups(['media_object:read', 'album:read'])]
    public $thumbnailContentUrl;
    /**
     * @var string|null
     */
    #[ApiProperty(iris: ['http://schema.org/contentUrl'])]
    #[Groups(['media_object:read', 'album:read'])]
    public $placeholderContentUrl;
    /**
     * @var File|null
     *
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="fileName")
     */
    #[Assert\NotNull(groups: ['media_object_create'])]
    public $file;
    /**
     * @var File|null
     *
     * @Vich\UploadableField(mapping="thumbnail_object", fileNameProperty="thumbnailName")
     */
    #[Groups(['media_object_create'])]
    public $thumbnail;
    /**
     * @var File|null
     *
     * @Vich\UploadableField(mapping="placeholder_object", fileNameProperty="placeholderName")
     */
    #[Groups(['media_object_create'])]
    public $placeholder;
    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    #[Groups(['media_object:read', 'album:read'])]
    public $fileName;
    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    #[Groups(['media_object:read', 'album:read'])]
    public $thumbnailName;
    /**
     * @var string|null
     */
    #[ORM\Column(nullable: true)]
    #[Groups(['media_object:read', 'album:read'])]
    public $placeholderName;
    /**
     * "Many MediaObject to One Album".
     */
    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: 'covers')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['media_object:read'])]
    private $album;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['media_object:read', 'album:read'])]
    #[SerializedName('created_date')]
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

    public function setFile(?File $file)
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setThumbnail(?File $thumbnail)
    {
        $this->thumbnail = $thumbnail;
        if ($thumbnail) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getThumbnail(): ?File
    {
        return $this->thumbnail;
    }

    public function setThumbnailName($thumbnailName)
    {
        $this->thumbnailName = $thumbnailName;
    }

    public function getThumbnailName(): ?string
    {
        return $this->thumbnailName;
    }

    public function setPlaceholder(?File $placeholder)
    {
        $this->placeholder = $placeholder;
        if ($placeholder) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getPlaceholder(): ?File
    {
        return $this->placeholder;
    }

    public function setPlaceholderName($placeholderName)
    {
        $this->placeholderName = $placeholderName;
    }

    public function getPlaceholderName(): ?string
    {
        return $this->placeholderName;
    }
}
