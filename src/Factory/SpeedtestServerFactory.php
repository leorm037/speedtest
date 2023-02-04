<?php

namespace App\Factory;

use App\Entity\SpeedtestServer;
use DateTimeImmutable;
use stdClass;

class SpeedtestServerFactory
{

    public static function build(stdClass $server): SpeedtestServer
    {
        $speedtestServer = new SpeedtestServer();

        return $speedtestServer
                        ->setDatetime(new DateTimeImmutable())
                        ->setId($server->id)
                        ->setHost($server->host)
                        ->setPort($server->port)
                        ->setName($server->name)
                        ->setSelected(false)
                        ->setLocation($server->location)
                        ->setCountry($server->country);
    }

}
