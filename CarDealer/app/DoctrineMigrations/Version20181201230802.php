<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181201230802 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, travelledDistance BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts_cars (car_id INT NOT NULL, part_id INT NOT NULL, INDEX IDX_2BFFFFA1C3C6F69F (car_id), INDEX IDX_2BFFFFA14CE34BEC (part_id), PRIMARY KEY(car_id, part_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, birth_date DATETIME NOT NULL, is_young_driver TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, supplier_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, quantity BIGINT NOT NULL, INDEX IDX_490F70C62ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part_car (part_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_B519C3164CE34BEC (part_id), INDEX IDX_B519C316C3C6F69F (car_id), PRIMARY KEY(part_id, car_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_importer TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE parts_cars ADD CONSTRAINT FK_2BFFFFA1C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE parts_cars ADD CONSTRAINT FK_2BFFFFA14CE34BEC FOREIGN KEY (part_id) REFERENCES part (id)');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C62ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE part_car ADD CONSTRAINT FK_B519C3164CE34BEC FOREIGN KEY (part_id) REFERENCES part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE part_car ADD CONSTRAINT FK_B519C316C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE suppliers');
        $this->addSql('DROP INDEX FK_sales_car ON sales');
        $this->addSql('ALTER TABLE sales CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('DROP INDEX fk_sales_customer ON sales');
        $this->addSql('CREATE INDEX IDX_6B8170449395C3F3 ON sales (customer_id)');
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parts_cars DROP FOREIGN KEY FK_2BFFFFA1C3C6F69F');
        $this->addSql('ALTER TABLE part_car DROP FOREIGN KEY FK_B519C316C3C6F69F');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE parts_cars DROP FOREIGN KEY FK_2BFFFFA14CE34BEC');
        $this->addSql('ALTER TABLE part_car DROP FOREIGN KEY FK_B519C3164CE34BEC');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C62ADD6D8C');
        $this->addSql('CREATE TABLE cars (id BIGINT AUTO_INCREMENT NOT NULL, make VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, model VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, travelledDistance BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customers (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, birth_date DATETIME NOT NULL, is_young_driver TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, price DOUBLE PRECISION DEFAULT NULL, quantity BIGINT DEFAULT NULL, supplier_id BIGINT DEFAULT NULL, INDEX FK_part_supplier (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suppliers (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_importer TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE parts_cars');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE part_car');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE sales CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX FK_sales_car ON sales (car_id)');
        $this->addSql('DROP INDEX idx_6b8170449395c3f3 ON sales');
        $this->addSql('CREATE INDEX FK_sales_customer ON sales (customer_id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }
}
