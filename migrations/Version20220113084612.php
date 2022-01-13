<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113084612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398938B6DAD');
        $this->addSql('DROP INDEX IDX_F5299398938B6DAD ON `order`');
        $this->addSql('ALTER TABLE `order` DROP id_shop_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD id_shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398938B6DAD FOREIGN KEY (id_shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_F5299398938B6DAD ON `order` (id_shop_id)');
    }
}
