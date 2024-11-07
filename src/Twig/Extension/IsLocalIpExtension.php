<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\IsLocalIpExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class IsLocalIpExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('isLocalIp', [IsLocalIpExtensionRuntime::class, 'isLocalIp']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('isLocalIp', [IsLocalIpExtensionRuntime::class, 'isLocalIp']),
        ];
    }
}
