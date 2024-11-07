<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class IsLocalIpExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function isLocalIp($clientIp)
    {
        // ...
    }
}
