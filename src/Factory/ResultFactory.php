<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\Factory;

use App\Entity\Result;
use App\Entity\Server;
use DateTime;
use DateTimeZone;

class ResultFactory
{
    public static function fromJson(string $json): Result
    {
        $obj = json_decode($json);

        $result = new Result();

        $timestamp = new DateTime($obj->timestamp);

        $dateTimeZone = new DateTimeZone('America/Sao_Paulo');

        $timestamp->setTimezone($dateTimeZone);

        $result
                ->setTimestamp($timestamp)
                ->setPingJitter($obj->ping->jitter ?? null)
                ->setPingLatency($obj->ping->latency ?? null)
                ->setPingLow($obj->ping->low ?? null)
                ->setPingHigh($obj->ping->high ?? null)
                ->setDownloadBandwidth($obj->download->bandwidth ?? null)
                ->setDownloadBytes($obj->download->bytes ?? null)
                ->setDownloadElapsed($obj->download->elapsed ?? null)
                ->setDownloadLatencyIqm($obj->download->latency->iqm ?? null)
                ->setDownloadLatencyLow($obj->download->latency->low ?? null)
                ->setDownloadLatencyHigh($obj->download->latency->high ?? null)
                ->setDownloadLatencyJitter($obj->download->latency->jitter ?? null)
                ->setUploadBandwidth($obj->upload->bandwidth ?? null)
                ->setUploadBytes($obj->upload->bytes ?? null)
                ->setUploadElapsed($obj->upload->elapsed ?? null)
                ->setUploadLatencyIqm($obj->upload->latency->iqm ?? null)
                ->setUploadLatencyLow($obj->upload->latency->low ?? null)
                ->setUploadLatencyHigh($obj->upload->latency->high ?? null)
                ->setUploadLatencyJitter($obj->upload->latency->jitter ?? null)
                ->setPacketLoss($obj->packetLoss ?? null)
                ->setIsp($obj->isp ?? null)
                ->setInterfaceInternalIp($obj->interface->internalIp ?? null)
                ->setInterfaceName($obj->interface->name ?? null)
                ->setInterfaceMacAddr($obj->interface->macAddr ?? null)
                ->setInterfaceIsVpn($obj->interface->isVpn ?? null)
                ->setInterfaceExternalIp($obj->interface->externalIp ?? null)
        ;

        $server = new Server();

        $server
                ->setId($obj->server->id ?? null)
                ->setHost($obj->server->host ?? null)
                ->setPort($obj->server->port ?? null)
                ->setName($obj->server->name ?? null)
                ->setLocation($obj->server->location ?? null)
                ->setCountry($obj->server->country ?? null)
                ->setIsSelected(false)
        ;

        $url = str_replace(
            'https://www.speedtest.net/result/',
            'https://www.speedtest.net/pt/result/',
            $obj->result->url
        );

        $result
                ->setServer($server)
                ->setServerIp($obj->server->ip ?? null)
                ->setResultId($obj->result->id ?? null)
                ->setResultUrl($url)
                ->setResultPersisted($obj->result->persisted ?? null)
        ;

        return $result;
    }
}
