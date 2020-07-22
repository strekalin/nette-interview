<?php
declare(strict_types = 1);
namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714215043 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `location` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `address` varchar(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `address_UNIQUE` (`address`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $schema->dropTable('location');
    }
}
