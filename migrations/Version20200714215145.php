<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714215145 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE `job_description` (
          `job_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `ad` text NOT NULL,
          PRIMARY KEY (`job_id`),
          CONSTRAINT `fk_job_description_job_id` FOREIGN KEY (`job_id`) REFERENCES `job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ');
    }
    
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $schema->dropTable('job_description');
    }
}
