<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210134226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_shop (article_id INT NOT NULL, shop_id INT NOT NULL, INDEX IDX_1C28CBA37294869C (article_id), INDEX IDX_1C28CBA34D16C4DD (shop_id), PRIMARY KEY(article_id, shop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_shop ADD CONSTRAINT FK_1C28CBA37294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_shop ADD CONSTRAINT FK_1C28CBA34D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_23A0E664D16C4DD ON article (shop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_shop');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664D16C4DD');
        $this->addSql('DROP INDEX IDX_23A0E664D16C4DD ON article');
        $this->addSql('ALTER TABLE article DROP shop_id');
    }
}
