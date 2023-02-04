<?php

namespace App\Entity;

use App\Helper\DateTimeHelper;
use Doctrine\ORM\Mapping as ORM;


abstract class AbstractEntity
{

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt();
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

}
