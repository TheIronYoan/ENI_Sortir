<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421133259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE events ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('CREATE INDEX IDX_5387574A64D218E ON events (location_id)');
        $this->addSql('ALTER TABLE users ADD campus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9AF5D55E1 ON users (campus_id)');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16B64D218E');
        $this->addSql('DROP INDEX IDX_D95DB16B64D218E ON cities');
        $this->addSql('ALTER TABLE cities DROP location_id');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA71F7E88B');
        $this->addSql('DROP INDEX IDX_17E64ABA71F7E88B ON locations');
        $this->addSql('ALTER TABLE locations CHANGE event_id city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('CREATE INDEX IDX_17E64ABA8BAC62AF ON locations (city_id)');
        $this->addSql('ALTER TABLE campus DROP FOREIGN KEY FK_9D096811A76ED395');
        $this->addSql('DROP INDEX IDX_9D096811A76ED395 ON campus');
        $this->addSql('ALTER TABLE campus DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campus ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE campus ADD CONSTRAINT FK_9D096811A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_9D096811A76ED395 ON campus (user_id)');
        $this->addSql('ALTER TABLE cities ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16B64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('CREATE INDEX IDX_D95DB16B64D218E ON cities (location_id)');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A64D218E');
        $this->addSql('DROP INDEX IDX_5387574A64D218E ON events');
        $this->addSql('ALTER TABLE events DROP location_id');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA8BAC62AF');
        $this->addSql('DROP INDEX IDX_17E64ABA8BAC62AF ON locations');
        $this->addSql('ALTER TABLE locations CHANGE city_id event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('CREATE INDEX IDX_17E64ABA71F7E88B ON locations (event_id)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AF5D55E1');
        $this->addSql('DROP INDEX IDX_1483A5E9AF5D55E1 ON users');
        $this->addSql('ALTER TABLE users DROP campus_id');
    }
}
