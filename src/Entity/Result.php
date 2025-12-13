<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Entity;

use App\Repository\ResultRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
#[ORM\Cache(usage: 'READ_WRITE', region: 'read_write')]
#[ORM\HasLifecycleCallbacks]
class Result extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $timestamp = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $pingJitter = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $pingLatency = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $pingLow = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $pingHigh = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadBandwidth = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadBytes = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadElapsed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $downloadLatencyIqm = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $downloadLatencyLow = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $downloadLatencyHigh = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $downloadLatencyJitter = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadBandwidth = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadBytes = null;

    #[ORM\Column(nullable: true)]
    private ?int $uploadElapsed = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $uploadLatencyIqm = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $uploadLatencyLow = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $uploadLatencyHigh = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 3, nullable: true)]
    private ?string $uploadLatencyJitter = null;

    #[ORM\Column(nullable: true)]
    private ?int $packetLoss = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $isp = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $interfaceInternalIp = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $interfaceName = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $interfaceMacAddr = null;

    #[ORM\Column(nullable: true)]
    private ?bool $interfaceIsVpn = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $interfaceExternalIp = null;

    #[ORM\ManyToOne(inversedBy: 'results')]
    #[ORM\JoinColumn(nullable: false)]
    private Server $server;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $resultId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resultUrl = null;

    #[ORM\Column(nullable: true)]
    private ?bool $resultPersisted = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'], nullable: true)]
    protected ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    protected ?DateTime $updatedAt = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $serverIp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(?DateTime $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getPingJitter(): ?string
    {
        return $this->pingJitter;
    }

    public function setPingJitter(?string $pingJitter): static
    {
        $this->pingJitter = $pingJitter;

        return $this;
    }

    public function getPingLatency(): ?string
    {
        return $this->pingLatency;
    }

    public function setPingLatency(?string $pingLatency): static
    {
        $this->pingLatency = $pingLatency;

        return $this;
    }

    public function getPingLow(): ?string
    {
        return $this->pingLow;
    }

    public function setPingLow(?string $pingLow): static
    {
        $this->pingLow = $pingLow;

        return $this;
    }

    public function getPingHigh(): ?string
    {
        return $this->pingHigh;
    }

    public function setPingHigh(?string $pingHigh): static
    {
        $this->pingHigh = $pingHigh;

        return $this;
    }

    public function getDownloadBandwidth(): ?int
    {
        return $this->downloadBandwidth;
    }

    public function setDownloadBandwidth(?int $downloadBandwidth): static
    {
        $this->downloadBandwidth = $downloadBandwidth;

        return $this;
    }

    public function getDownloadBytes(): ?int
    {
        return $this->downloadBytes;
    }

    public function setDownloadBytes(?int $downloadBytes): static
    {
        $this->downloadBytes = $downloadBytes;

        return $this;
    }

    public function getDownloadElapsed(): ?int
    {
        return $this->downloadElapsed;
    }

    public function setDownloadElapsed(?int $downloadElapsed): static
    {
        $this->downloadElapsed = $downloadElapsed;

        return $this;
    }

    public function getDownloadLatencyIqm(): ?string
    {
        return $this->downloadLatencyIqm;
    }

    public function setDownloadLatencyIqm(?string $downloadLatencyIqm): static
    {
        $this->downloadLatencyIqm = $downloadLatencyIqm;

        return $this;
    }

    public function getDownloadLatencyLow(): ?string
    {
        return $this->downloadLatencyLow;
    }

    public function setDownloadLatencyLow(?string $downloadLatencyLow): static
    {
        $this->downloadLatencyLow = $downloadLatencyLow;

        return $this;
    }

    public function getDownloadLatencyHigh(): ?string
    {
        return $this->downloadLatencyHigh;
    }

    public function setDownloadLatencyHigh(?string $downloadLatencyHigh): static
    {
        $this->downloadLatencyHigh = $downloadLatencyHigh;

        return $this;
    }

    public function getDownloadLatencyJitter(): ?string
    {
        return $this->downloadLatencyJitter;
    }

    public function setDownloadLatencyJitter(?string $downloadLatencyJitter): static
    {
        $this->downloadLatencyJitter = $downloadLatencyJitter;

        return $this;
    }

    public function getUploadBandwidth(): ?int
    {
        return $this->uploadBandwidth;
    }

    public function setUploadBandwidth(?int $uploadBandwidth): static
    {
        $this->uploadBandwidth = $uploadBandwidth;

        return $this;
    }

    public function getUploadBytes(): ?int
    {
        return $this->uploadBytes;
    }

    public function setUploadBytes(?int $uploadBytes): static
    {
        $this->uploadBytes = $uploadBytes;

        return $this;
    }

    public function getUploadElapsed(): ?int
    {
        return $this->uploadElapsed;
    }

    public function setUploadElapsed(?int $uploadElapsed): static
    {
        $this->uploadElapsed = $uploadElapsed;

        return $this;
    }

    public function getUploadLatencyIqm(): ?string
    {
        return $this->uploadLatencyIqm;
    }

    public function setUploadLatencyIqm(?string $uploadLatencyIqm): static
    {
        $this->uploadLatencyIqm = $uploadLatencyIqm;

        return $this;
    }

    public function getUploadLatencyLow(): ?string
    {
        return $this->uploadLatencyLow;
    }

    public function setUploadLatencyLow(?string $uploadLatencyLow): static
    {
        $this->uploadLatencyLow = $uploadLatencyLow;

        return $this;
    }

    public function getUploadLatencyHigh(): ?string
    {
        return $this->uploadLatencyHigh;
    }

    public function setUploadLatencyHigh(?string $uploadLatencyHigh): static
    {
        $this->uploadLatencyHigh = $uploadLatencyHigh;

        return $this;
    }

    public function getUploadLatencyJitter(): ?string
    {
        return $this->uploadLatencyJitter;
    }

    public function setUploadLatencyJitter(?string $uploadLatencyJitter): static
    {
        $this->uploadLatencyJitter = $uploadLatencyJitter;

        return $this;
    }

    public function getPacketLoss(): ?int
    {
        return $this->packetLoss;
    }

    public function setPacketLoss(?int $packetLoss): static
    {
        $this->packetLoss = $packetLoss;

        return $this;
    }

    public function getIsp(): ?string
    {
        return $this->isp;
    }

    public function setIsp(?string $isp): static
    {
        $this->isp = $isp;

        return $this;
    }

    public function getInterfaceInternalIp(): ?string
    {
        return $this->interfaceInternalIp;
    }

    public function setInterfaceInternalIp(?string $interfaceInternalIp): static
    {
        $this->interfaceInternalIp = $interfaceInternalIp;

        return $this;
    }

    public function getInterfaceName(): ?string
    {
        return $this->interfaceName;
    }

    public function setInterfaceName(?string $interfaceName): static
    {
        $this->interfaceName = $interfaceName;

        return $this;
    }

    public function getInterfaceMacAddr(): ?string
    {
        return $this->interfaceMacAddr;
    }

    public function setInterfaceMacAddr(?string $interfaceMacAddr): static
    {
        $this->interfaceMacAddr = $interfaceMacAddr;

        return $this;
    }

    public function isInterfaceIsVpn(): ?bool
    {
        return $this->interfaceIsVpn;
    }

    public function setInterfaceIsVpn(?bool $interfaceIsVpn): static
    {
        $this->interfaceIsVpn = $interfaceIsVpn;

        return $this;
    }

    public function getInterfaceExternalIp(): ?string
    {
        return $this->interfaceExternalIp;
    }

    public function setInterfaceExternalIp(?string $interfaceExternalIp): static
    {
        $this->interfaceExternalIp = $interfaceExternalIp;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): static
    {
        $this->server = $server;

        return $this;
    }

    public function getResultId(): ?string
    {
        return $this->resultId;
    }

    public function setResultId(?string $resultId): static
    {
        $this->resultId = $resultId;

        return $this;
    }

    public function getResultUrl(): ?string
    {
        return $this->resultUrl;
    }

    public function setResultUrl(?string $resultUrl): static
    {
        $this->resultUrl = $resultUrl;

        return $this;
    }

    public function isResultPersisted(): ?bool
    {
        return $this->resultPersisted;
    }

    public function setResultPersisted(?bool $resultPersisted): static
    {
        $this->resultPersisted = $resultPersisted;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getServerIp(): ?string
    {
        return $this->serverIp;
    }

    public function setServerIp(?string $serverIp): static
    {
        $this->serverIp = $serverIp;

        return $this;
    }
}
