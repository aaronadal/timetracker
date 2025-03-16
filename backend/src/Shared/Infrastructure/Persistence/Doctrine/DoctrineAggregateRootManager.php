<?php

namespace Core\Shared\Infrastructure\Persistence\Doctrine;

use Core\Shared\Domain\Entity\AggregateRoot;
use Core\Shared\Domain\Entity\UuidValueObject;
use Core\Shared\Domain\Persistence\AggregateRootManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template AR of AggregateRoot
 *
 * @template-implements AggregateRootManagerInterface<AR>
 */
final class DoctrineAggregateRootManager implements AggregateRootManagerInterface
{
    private readonly EntityManagerInterface $manager;

    /** @var EntityRepository<AR> */
    private readonly EntityRepository $repository;

    /** @param class-string<AR> $entityClass */
    public function __construct(
        string $entityClass,
        private readonly ManagerRegistry $registry,
    )
    {
        /** @var ObjectRepository<AR>|EntityRepository<AR> $repository */
        $repository = $this->registry->getRepository($entityClass);
        if (!($repository instanceof EntityRepository)) {
            throw new \RuntimeException("Repository for class <$entityClass> is not an EntityRepository");
        }

        $manager = $this->registry->getManagerForClass($entityClass);
        if (!($manager instanceof EntityManagerInterface)) {
            throw new \RuntimeException("Manager for class <$entityClass> is not an EntityManager");
        }

        /** @var EntityRepository<AR> $repository */
        $this->repository = $repository;
        $this->manager = $manager;
    }


    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->manager->persist($aggregateRoot);
        $this->flush();
    }

    public function exists(UuidValueObject $id): bool
    {
        return null !== $this->search($id);
    }

    public function search(UuidValueObject $id): ?AggregateRoot
    {
        return $this->repository->find($id);
    }

    public function matching(array $criteria): array
    {
        $qb = $this->repository->createQueryBuilder('ar');
        foreach ($criteria as $field => $value) {
            if($value === null) {
                $qb->andWhere($qb->expr()->isNull("ar.$field"));
            }
            else {
                $qb->andWhere(
                    $qb->expr()->eq("ar.$field", ":$field"),
                );
                $qb->setParameter($field, $value);
            }
        }

        $qb->orderBy('ar.createdAt', 'ASC');

        /** @var array<array-key, AR> $result */
        $result = $qb->getQuery()->getResult();

        return array_values($result);
    }

    private function flush(): void
    {
        $this->manager->flush();
    }
}
