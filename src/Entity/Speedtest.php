<?php

namespace App\Entity;

use App\Repository\SpeedtestRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeedtestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Speedtest extends AbstractEntity
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?DateTimeImmutable $datetime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 16, nullable: true)]
    private ?string $pingJitter = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 3, nullable: true)]
    private ?string $pingLatency = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadBandwidth = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadBytes = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadElapsed = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadBandwidth = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadBytes = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadElapsed = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $isp = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $interfaceInternalIp = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $interfaceName = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $interfaceMacAddr = null;

    #[ORM\Column(nullable: true)]
    private ?bool $interfaceIsVpn = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $interfaceExternalIp = null;

    #[ORM\Column(length: 64)]
    private ?string $serverIp = null;

    #[ORM\Column(length: 64)]
    private ?string $resultId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resultUrl = null;

    #[ORM\Column(nullable: true)]
    private ?bool $resultPersisted = null;

    #[ORM\ManyToOne(targetEntity: SpeedtestServer::class, inversedBy: 'speedtests', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'speedtest_server_id', referencedColumnName: 'id')]
    private ?SpeedtestServer $speedtestServer = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2, nullable: true)]
    private ?string $packetLoss = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPingJitter(): ?string
    {
        return $this->pingJitter;
    }

    public function setPingJitter(?string $pingJitter): self
    {
        $this->pingJitter = $pingJitter;

        return $this;
    }

    public function getPingLatency(): ?string
    {
        return $this->pingLatency;
    }

    public function setPingLatency(?string $pingLatency): self
    {
        $this->pingLatency = $pingLatency;

        return $this;
    }

    public function getDownloadBandwidth(): ?int
    {
        return $this->downloadBandwidth;
    }

    public function setDownloadBandwidth(?int $downloadBandwidth): self
    {
        $this->downloadBandwidth = $downloadBandwidth;

        return $this;
    }

    public function getDownloadBytes(): ?int
    {
        return $this->downloadBytes;
    }

    public function setDownloadBytes(?int $downloadBytes): self
    {
        $this->downloadBytes = $downloadBytes;

        return $this;
    }

    public function getDownloadElapsed(): ?int
    {
        return $this->downloadElapsed;
    }

    public function setDownloadElapsed(?int $downloadElapsed): self
    {
        $this->downloadElapsed = $downloadElapsed;

        return $this;
    }

    public function getUploadBandwidth(): ?int
    {
        return $this->uploadBandwidth;
    }

    public function setUploadBandwidth(?int $uploadBandwidth): self
    {
        $this->uploadBandwidth = $uploadBandwidth;

        return $this;
    }

    public function getUploadBytes(): ?int
    {
        return $this->uploadBytes;
    }

    public function setUploadBytes(?int $uploadBytes): self
    {
        $this->uploadBytes = $uploadBytes;

        return $this;
    }

    public function getUploadElapsed(): ?int
    {
        return $this->uploadElapsed;
    }

    public function setUploadElapsed(?int $uploadElapsed): self
    {
        $this->uploadElapsed = $uploadElapsed;

        return $this;
    }

    public function getIsp(): ?string
    {
        return $this->isp;
    }

    public function setIsp(?string $isp): self
    {
        $this->isp = $isp;

        return $this;
    }

    public function getInterfaceInternalIp(): ?string
    {
        return $this->interfaceInternalIp;
    }

    public function setInterfaceInternalIp(?string $interfaceInternalIp): self
    {
        $this->interfaceInternalIp = $interfaceInternalIp;

        return $this;
    }

    public function getInterfaceName(): ?string
    {
        return $this->interfaceName;
    }

    public function setInterfaceName(?string $interfaceName): self
    {
        $this->interfaceName = $interfaceName;

        return $this;
    }

    public function getInterfaceMacAddr(): ?string
    {
        return $this->interfaceMacAddr;
    }

    public function setInterfaceMacAddr(?string $interfaceMacAddr): self
    {
        $this->interfaceMacAddr = $interfaceMacAddr;

        return $this;
    }

    public function isInterfaceIsVpn(): ?bool
    {
        return $this->interfaceIsVpn;
    }

    public function setInterfaceIsVpn(?bool $interfaceIsVpn): self
    {
        $this->interfaceIsVpn = $interfaceIsVpn;

        return $this;
    }

    public function getInterfaceExternalIp(): ?string
    {
        return $this->interfaceExternalIp;
    }

    public function setInterfaceExternalIp(?string $interfaceExternalIp): self
    {
        $this->interfaceExternalIp = $interfaceExternalIp;

        return $this;
    }

    public function getServerIp(): ?string
    {
        return $this->serverIp;
    }

    public function setServerIp(string $serverIp): self
    {
        $this->serverIp = $serverIp;

        return $this;
    }

    public function getResultId(): ?string
    {
        return $this->resultId;
    }

    public function setResultId(string $resultId): self
    {
        $this->resultId = $resultId;

        return $this;
    }

    public function getResultUrl(): ?string
    {
        return $this->resultUrl;
    }

    public function setResultUrl(?string $resultUrl): self
    {
        $this->resultUrl = $resultUrl;

        return $this;
    }

    public function isResultPersisted(): ?bool
    {
        return $this->resultPersisted;
    }

    public function setResultPersisted(?bool $resultPersisted): self
    {
        $this->resultPersisted = $resultPersisted;

        return $this;
    }

    public function getSpeedtestServer(): ?SpeedtestServer
    {
        return $this->speedtestServer;
    }

    public function setSpeedtestServer(?SpeedtestServer $speedtestServer): self
    {
        $this->speedtestServer = $speedtestServer;

        return $this;
    }

    public function getPacketLoss(): ?string
    {
        return $this->packetLoss;
    }

    public function setPacketLoss(?string $packetLoss): self
    {
        $this->packetLoss = $packetLoss;

        return $this;
    }

    public function toArray(): array
    {
        return call_user_func('get_object_vars', $this);
    }
}
