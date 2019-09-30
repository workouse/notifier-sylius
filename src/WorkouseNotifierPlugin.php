<?php

declare(strict_types=1);

namespace Workouse\NotifierPlugin;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Messenger\DependencyInjection\MessengerPass;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class WorkouseNotifierPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $builder)
    {
        $builder
            ->addCompilerPass(new MessengerPass())
            ->addCompilerPass(DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                ['Workouse\\NotifierPlugin'],
                [__DIR__]
            ));
    }
}
