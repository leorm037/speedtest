<?php

namespace App\Entity;

use App\Helper\DateTimeHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Factory\UuidFactory;


abstract class AbstractEntity
{

    private UuidFactory $uuidFactory;
    
    public function __construct(UuidFactory $uuidFactory)
    {
        $this->uuidFactory = $uuidFactory;
    }
    
    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt();
        $this->generateUuid();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updateddAt();
    }

    private function createdAt(): void
    {
        if (property_exists(get_class($this), "createdAt") && null === $this->createdAt) {
            $this->createdAt = DateTimeHelper::currentDateTimeImmutableUTC();
        }
    }

    private function updateddAt(): void
    {
        if (property_exists(get_class($this), "createdAt") && null === $this->updatedAt) {
            $this->updatedAt = DateTimeHelper::currentDateTimeUTC();
        }
    }
    
    private function generateUuid(): void
    {
        if (property_exists(get_class($this), "uuid") && null === $this->uuid) {
            $this->uuid = $this->uuidFactory->create();
        }
    }

}
