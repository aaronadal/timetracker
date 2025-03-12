<?php

namespace Core\Shared\Infrastructure\Symfony\CompilerPass;

use Core\Shared\Infrastructure\Persistence\Doctrine\DoctrineAggregateRootManager;
use Core\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepositoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class DoctrineRepositoryInterfaceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('core.persistence.doctrine.repository');

        foreach ($ids as $id => $tags) {
            $repo = $container->findDefinition($id);

            /** @var class-string<DoctrineRepositoryInterface> $class */
            $class = $repo->getClass();

            /** @var DoctrineRepositoryInterface $instance */
            $instance = (new \ReflectionClass($class))->newInstanceWithoutConstructor();

            $entityClass = $instance->entityClass();

            $managerDefinition = new Definition(DoctrineAggregateRootManager::class);
            $managerDefinition->setArgument('$entityClass', $entityClass);
            $managerDefinition->setAutowired(true);

            $container->set('core.persistence.doctrine.manager.' . $class, $managerDefinition);

            $repo->setArgument('$manager', $managerDefinition);
        }
    }
}
