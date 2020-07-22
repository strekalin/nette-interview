<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200714215045 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE `job` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `location_id` int(10) unsigned NOT NULL,
          `company_id` int(10) unsigned NOT NULL,
          `title` varchar(200) NOT NULL,
          `ext_id` varchar(100) NOT NULL,
          `created_at` datetime NOT NULL DEFAULT current_timestamp(),
          `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`),
          UNIQUE KEY `ext_id_UNIQUE` (`ext_id`),
          KEY `fk_job_company_id_idx` (`company_id`),
          KEY `fk_job_location_id_idx` (`location_id`),
          CONSTRAINT `fk_job_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT `fk_job_location_id` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ');
    }
    
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()
            ->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $schema->dropTable('job');
    }
}
