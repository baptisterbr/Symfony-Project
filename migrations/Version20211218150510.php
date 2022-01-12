<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211218150510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FDDD9CFE');
        $this->addSql('DROP INDEX IDX_B6BD307FDDD9CFE ON message');
        $this->addSql('ALTER TABLE message CHANGE id_seller_id shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F4D16C4DD ON message (shop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F4D16C4DD');
        $this->addSql('DROP INDEX IDX_B6BD307F4D16C4DD ON message');
        $this->addSql('ALTER TABLE message CHANGE shop_id id_seller_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FDDD9CFE FOREIGN KEY (id_seller_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FDDD9CFE ON message (id_seller_id)');
    }
}
