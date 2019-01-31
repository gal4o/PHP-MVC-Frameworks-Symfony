<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181201232645 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE part_car');
        $this->addSql('DROP TABLE parts');
        $this->addSql('DROP TABLE suppliers');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C62ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('DROP INDEX FK_sales_car ON sales');
        $this->addSql('ALTER TABLE sales CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('DROP INDEX fk_sales_customer ON sales');
        $this->addSql('CREATE INDEX IDX_6B8170449395C3F3 ON sales (customer_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customers (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, birth_date DATETIME NOT NULL, is_young_driver TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part_car (part_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_B519C3164CE34BEC (part_id), INDEX IDX_B519C316C3C6F69F (car_id), PRIMARY KEY(part_id, car_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parts (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, price DOUBLE PRECISION DEFAULT NULL, quantity BIGINT DEFAULT NULL, supplier_id BIGINT DEFAULT NULL, INDEX FK_part_supplier (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suppliers (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_importer TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C62ADD6D8C');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE sales DROP FOREIGN KEY FK_6B8170449395C3F3');
        $this->addSql('ALTER TABLE sales CHANGE id id BIGINT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE INDEX FK_sales_car ON sales (car_id)');
        $this->addSql('DROP INDEX idx_6b8170449395c3f3 ON sales');
        $this->addSql('CREATE INDEX FK_sales_customer ON sales (customer_id)');
        $this->addSql('ALTER TABLE sales ADD CONSTRAINT FK_6B8170449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }
}
