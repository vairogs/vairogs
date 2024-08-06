<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

#[AsDoctrineListener(event: ToolEvents::postGenerateSchema)]
class FixDefaultSchemaListener
{
    /**
     * @throws Exception
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        foreach ($schemaManager->listSchemaNames() as $namespace) {
            if (!$args->getSchema()->hasNamespace($namespace)) {
                $args->getSchema()->createNamespace($namespace);
            }
        }
    }
}
