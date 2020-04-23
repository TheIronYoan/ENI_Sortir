<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200422165530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, organizer_id INT NOT NULL, campus_id INT DEFAULT NULL, state_id INT DEFAULT NULL, location_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, start DATETIME NOT NULL, duration INT NOT NULL, sign_in_limit DATETIME NOT NULL, max_users INT NOT NULL, description LONGTEXT NOT NULL, illustration VARCHAR(150) DEFAULT NULL, INDEX IDX_5387574A876C4DDA (organizer_id), INDEX IDX_5387574AAF5D55E1 (campus_id), INDEX IDX_5387574A5D83CC1 (state_id), INDEX IDX_5387574A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, campus_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(10) DEFAULT NULL, email VARCHAR(75) NOT NULL, administrator TINYINT(1) DEFAULT \'0\', illustration VARCHAR(150) DEFAULT NULL, INDEX IDX_1483A5E9AF5D55E1 (campus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eventstates (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) NOT NULL, postal_code NUMERIC(5, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, street VARCHAR(150) NOT NULL, addr_complement VARCHAR(150) DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, INDEX IDX_17E64ABA8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE campus (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_9D09681164D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A876C4DDA FOREIGN KEY (organizer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A5D83CC1 FOREIGN KEY (state_id) REFERENCES eventstates (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA8BAC62AF FOREIGN KEY (city_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE campus ADD CONSTRAINT FK_9D09681164D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A876C4DDA');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A5D83CC1');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA8BAC62AF');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A64D218E');
        $this->addSql('ALTER TABLE campus DROP FOREIGN KEY FK_9D09681164D218E');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AAF5D55E1');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9AF5D55E1');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE user_event');
        $this->addSql('DROP TABLE eventstates');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE campus');
    }
}
