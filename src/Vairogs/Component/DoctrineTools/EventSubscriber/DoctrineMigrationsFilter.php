<?php declare(strict_types = 1);

namespace Vairogs\Component\DoctrineTools\EventSubscriber;

use Doctrine\DBAL\Schema\AbstractAsset;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vairogs\Component\Functions\Local\_Exists;

#[AutoconfigureTag('doctrine.dbal.schema_filter')]
class DoctrineMigrationsFilter implements EventSubscriberInterface
{
    private bool $enabled = true;

    public function __invoke(AbstractAsset|string $asset): bool
    {
        if (!$this->enabled) {
            return true;
        }

        if (!(new class {
            use _Exists;
        })->exists(TableMetadataStorageConfiguration::class)) {
            return true;
        }

        if ($asset instanceof AbstractAsset) {
            $asset = $asset->getName();
        }

        return $asset !== (new TableMetadataStorageConfiguration())->getTableName();
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();
        if (null === $command) {
            return;
        }

        /*
         * Any console commands from the Doctrine Migrations bundle may attempt
         * to initialize migrations information storage table. Because of this
         * they should not be affected by this filter because their logic may
         * get broken since they will not "see" the table, they may try to use
         */
        if ($command instanceof DoctrineCommand) {
            $this->enabled = false;
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
        ];
    }
}
