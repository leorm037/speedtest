<?php

namespace App\Factory;

use App\Entity\Speedtest;
use App\Helper\DateTimeHelper;
use stdClass;

class SpeedtestFactory
{

    public static function build(stdClass $json): Speedtest
    {
        $speedtest = new Speedtest();

        return $speedtest
                        ->setDateTime(DateTimeHelper::currentDateTimeImmutable())
                        ->setPingJitter($json->ping->jitter)
                        ->setPingLatency($json->ping->latency)
                        ->setDownloadBandwidth($json->download->bandwidth)
                        ->setDownloadBytes($json->download->bytes)
                        ->setDownloadElapsed($json->download->elapsed)
                        ->setUploadBandwidth($json->upload->bandwidth)
                        ->setUploadBytes($json->upload->bytes)
                        ->setUploadElapsed($json->upload->elapsed)
                        ->setPacketLoss((isset($json->packetLoss) ? $json->packetLoss : 0))
                        ->setIsp($json->isp)
                        ->setInterfaceInternalIp($json->interface->internalIp)
                        ->setInterfaceName($json->interface->name)
                        ->setInterfaceMacAddr($json->interface->macAddr)
                        ->setInterfaceIsVpn($json->interface->isVpn)
                        ->setInterfaceExternalIp($json->interface->externalIp)
                        ->setSpeedtestServer(SpeedtestServerFactory::build($json->server))
                        ->setServerIp($json->server->ip)
                        ->setResultId($json->result->id)
                        ->setResultUrl($json->result->url)
                        ->setResultPersisted($json->result->persisted)
        ;
    }

}
