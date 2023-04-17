<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'posts')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Post
{
    /**
     * @var UuidInterface
     */
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'message', type: 'string')]
    private $message;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'created', type: 'datetime')]
    private $created;

    /**
     * @var \DateTime|null
     */
    #[ORM\Column(name: 'updated', type: 'datetime', nullable: true)]
    private $updated;

    /**
     * @throws Exception;
     */
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->id = Uuid::uuid4();
        $this->created = new \DateTime('NOW');
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated = new \DateTime('NOW');
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }
}
