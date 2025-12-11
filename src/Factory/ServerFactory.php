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

use App\Entity\Server;

class ServerFactory
{
    public static function fromJson(string $json): Server
    {
        $jsonObj = json_decode($json);

        $server = new Server();

        $server
                ->setHost($jsonObj->id ?? null)
                ->setPort($jsonObj->port ?? null)
                ->setName($jsonObj->name ?? null)
                ->setLocation($jsonObj->location ?? null)
                ->setCountry($jsonObj->country ?? null)
        ;

        return $server;
    }
}
