<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240820105801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create initial schema for questionnaire, question, answer, and question_answer_restriction tables';
    }

    public function up(Schema $schema): void
    {

        // Create the category table
        $this->addSql('CREATE TABLE category (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,  
            name VARCHAR(255) NOT NULL
        )');

        // Create the product table
        $this->addSql('CREATE TABLE product (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            category_id INTEGER NOT NULL,  
            name VARCHAR(255) NOT NULL,
            CONSTRAINT FK_CATEGORY FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE
        )');

        // Create the product_dosage table
        $this->addSql('CREATE TABLE product_dosage (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            product_id INTEGER DEFAULT NULL,  
            dosage VARCHAR(255) DEFAULT NULL,
            description CLOB DEFAULT NULL,
            price DECIMAL(10, 2) NOT NULL,
            CONSTRAINT FK_PRODUCT FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE
        )');

        // Create the questionnaire table
        $this->addSql('CREATE TABLE questionnaire (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            name VARCHAR(255) NOT NULL, 
            description CLOB DEFAULT NULL, 
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
        )');

        // Create the question table
        $this->addSql('CREATE TABLE question (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            questionnaire_id INTEGER NOT NULL, 
            text VARCHAR(255) NOT NULL, 
            parent_question_id INTEGER DEFAULT NULL, 
            order_number INTEGER NOT NULL,
            question_number VARCHAR(4) NOT NULL,
            CONSTRAINT FK_QUESTIONNAIRE FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id) ON DELETE CASCADE,
            CONSTRAINT FK_PARENT_QUESTION FOREIGN KEY (parent_question_id) REFERENCES question (id) ON DELETE CASCADE
        )');

        // Create the answer table
        $this->addSql('CREATE TABLE answer (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            question_id INTEGER NOT NULL, 
            text VARCHAR(255) NOT NULL, 
            follow_up_question_id INTEGER DEFAULT NULL, 
            question_answer_restriction_id INTEGER DEFAULT NULL,
            CONSTRAINT FK_QUESTION FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE,
            CONSTRAINT FK_FOLLOW_UP_QUESTION FOREIGN KEY (follow_up_question_id) REFERENCES question (id) ON DELETE CASCADE,
            CONSTRAINT FK_QUESTION_ANWSER_RESTRICTION FOREIGN KEY (question_answer_restriction_id) REFERENCES question_answer_restriction (id) ON DELETE CASCADE
        )');

        // Create the product_dosage table
        $this->addSql('CREATE TABLE answer_to_product_dosage (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            answer_id INTEGER DEFAULT NULL,  
            product_dosage_id INTEGER DEFAULT NULL,
            CONSTRAINT FK_ANSWER FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE,
            CONSTRAINT FK_PRODUCT FOREIGN KEY (product_dosage_id) REFERENCES product_dosage (id) ON DELETE CASCADE
        )');

        // Create the question_answer_restriction table
        $this->addSql('CREATE TABLE question_answer_restriction (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            answer_id INTEGER NOT NULL, 
            exclusion_type VARCHAR(255) DEFAULT NULL, 
            exclusion_details CLOB DEFAULT NULL, 
            CONSTRAINT FK_ANSWER FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE
        )');
    }

    public function down(Schema $schema): void
    {
        // Drop the tables in reverse order
        $this->addSql('DROP TABLE question_answer_restriction');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product_dosage');
    }
}
