<?php

declare(strict_types=1);

namespace Workouse\NotifierPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class WorkouseNotifierPlugin extends Bundle
{
    use SyliusPluginTrait;
}
