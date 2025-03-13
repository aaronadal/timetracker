<?php

namespace Core\Shared\Infrastructure\Symfony;

use Core\Shared\Infrastructure\Symfony\CompilerPass\DoctrineRepositoryInterfaceCompilerPass;
use Core\Shared\Infrastructure\Symfony\CompilerPass\DoctrineTypeCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new DoctrineRepositoryInterfaceCompilerPass());
        $container->addCompilerPass(new DoctrineTypeCompilerPass());
    }
}
