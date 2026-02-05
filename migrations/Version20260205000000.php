<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260205000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create order and order_product tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `order` (
            id INT AUTO_INCREMENT NOT NULL,
            order_number VARCHAR(255) NOT NULL,
            customer_code VARCHAR(255) NOT NULL,
            customer_name VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL,
            UNIQUE INDEX UNIQ_F52993988C26A5E8 (order_number),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE order_product (
            id INT AUTO_INCREMENT NOT NULL,
            order_id INT NOT NULL,
            product_code VARCHAR(255) NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            price NUMERIC(10, 2) NOT NULL,
            quantity INT NOT NULL,
            created_at DATETIME NOT NULL,
            INDEX IDX_2530ADE68D9F6D38 (order_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE68D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE68D9F6D38');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE `order`');
    }
}
