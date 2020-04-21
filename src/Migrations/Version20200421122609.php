<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421122609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events ADD state_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A5D83CC1 FOREIGN KEY (state_id) REFERENCES eventstates (id)');
        $this->addSql('CREATE INDEX IDX_5387574A5D83CC1 ON events (state_id)');
        $this->addSql('ALTER TABLE users CHANGE administrator administrator TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE eventstates DROP FOREIGN KEY FK_FAE12AFD71F7E88B');
        $this->addSql('DROP INDEX IDX_FAE12AFD71F7E88B ON eventstates');
        $this->addSql('ALTER TABLE eventstates DROP event_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A5D83CC1');
        $this->addSql('DROP INDEX IDX_5387574A5D83CC1 ON events');
        $this->addSql('ALTER TABLE events DROP state_id');
        $this->addSql('ALTER TABLE eventstates ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eventstates ADD CONSTRAINT FK_FAE12AFD71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('CREATE INDEX IDX_FAE12AFD71F7E88B ON eventstates (event_id)');
        $this->addSql('ALTER TABLE users CHANGE administrator administrator TINYINT(1) NOT NULL');
    }
}
