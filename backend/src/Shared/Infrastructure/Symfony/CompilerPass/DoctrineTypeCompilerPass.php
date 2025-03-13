<?php

namespace Core\Shared\Infrastructure\Symfony\CompilerPass;

use Core\Shared\Infrastructure\Persistence\Doctrine\Types\AbstractType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineTypeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $types = $container->findTaggedServiceIds('core.persistence.doctrine.type');

        $typesDefinition = [];
        foreach ($types as $id => $tags) {
            $definition = $container->findDefinition($id);

            $class = $definition->getClass();
            if (null === $class) {
                continue;
            }

            if (!is_subclass_of($class, AbstractType::class)) {
                throw new \RuntimeException('All services tagged with "core.persistence.doctrine.type" must extend ' . AbstractType::class);
            }

            $typesDefinition[$class::name()] = ['class' => $class];
        }

        $container->setParameter('doctrine.dbal.connection_factory.types', $typesDefinition);
    }
}
