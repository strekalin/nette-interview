<?php
declare(strict_types = 1);
namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714215026 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        /*
         * $table = $schema->createTable('job');
         *
         * $table->addColumn('id', Types::INTEGER, [
         * 'autoincrement' => true
         * ])
         * ->setLength(10)
         * ->setUnsigned(true)
         * ->setNotnull(true);
         *
         */
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `company` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(200) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `name_UNIQUE` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $schema->dropTable('company');
    }
}
