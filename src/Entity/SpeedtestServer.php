<?php

namespace App\Entity;

use App\Repository\SpeedtestServerRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeedtestServerRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SpeedtestServer extends AbstractEntity
{
    public function __construct()
    {
        $this->speedtests = new ArrayCollection();
    }
    
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?DateTimeImmutable $datetime = null;

    #[ORM\Column(length: 60)]
    private ?string $host = null;

    #[ORM\Column]
    private ?int $port = null;

    #[ORM\Column(length: 60)]
    private ?string $location = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 60)]
    private ?string $country = null;

    #[ORM\Column]
    private ?bool $selected = null;

    #[ORM\Column]
    protected ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne]
    private ?User $updatedUser = null;
    
    #[ORM\OneToMany(targetEntity: Speedtest::class, mappedBy: 'speedtestServer')]
    private Collection $speedtests; 

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDatetime(): ?DateTimeImmutable
    {
        return $this->datetime;
    }

    public function setDatetime(DateTimeImmutable $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function isSelected(): ?bool
    {
        return $this->selected;
    }

    public function setSelected(bool $selected): self
    {
        $this->selected = $selected;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getUpdatedUser(): ?User
    {
        return $this->updatedUser;
    }

    public function setUpdatedUser(?User $updatedUser): self
    {
        $this->updatedUser = $updatedUser;

        return $this;
    }
}
