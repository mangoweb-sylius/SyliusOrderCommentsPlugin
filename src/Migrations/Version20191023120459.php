<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191023120459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_order_message (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, sendMail TINYINT(1) NOT NULL, sender_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, sendTime DATETIME NOT NULL, INDEX IDX_DABAA4988D9F6D38 (order_id), INDEX IDX_DABAA498F624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_order_message ADD CONSTRAINT FK_DABAA4988D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE app_order_message ADD CONSTRAINT FK_DABAA498F624B39D FOREIGN KEY (sender_id) REFERENCES sylius_admin_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_order_message');
    }
}
