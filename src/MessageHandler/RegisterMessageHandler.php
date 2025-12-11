<?php

/*
 *     This file is part of Speedtest.
 *
 *     (c) Leonardo Rodrigues Marques <leonardo@rodriguesmarques.com.br>
 *
 *     This source file is subject to the MIT license that is bundled
 *     with this source code in the file LICENSE.
 */

namespace App\MessageHandler;

use App\Message\RegisterMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RegisterMessageHandler
{
    public function __construct(
        private \App\Service\SpeedtestService $speedtestService,
    ) {
    }

    public function __invoke(RegisterMessage $message): void
    {
        $this->speedtestService->testSpeed();
    }
}
