<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function postGenerateSchema(
        GenerateSchemaEventArgs $args,
    ): void {
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
