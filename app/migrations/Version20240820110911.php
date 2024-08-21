<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240820110911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert initial data tables';
    }

    public function up(Schema $schema): void
    {
        // Insert initial data into the category table
        $this->addSql("INSERT INTO category (name) VALUES ('Erectile Dysfunction')");

        // Insert initial data into the product table
        $this->addSql("INSERT INTO product (category_id, name) VALUES (1, 'Sildenafil')");
        $this->addSql("INSERT INTO product (category_id, name) VALUES (1, 'Tadalafil')");

        // Insert initial data into the product_dosage table
        $this->addSql("INSERT INTO product_dosage (product_id,dosage, description, price) VALUES (1, '50mg', 'Sildenafil 50mg tablets', 10.00)");
        $this->addSql("INSERT INTO product_dosage (product_id, dosage, description, price) VALUES (1, '100mg', 'Sildenafil 100mg tablets', 15.00)");
        $this->addSql("INSERT INTO product_dosage (product_id, dosage, description, price) VALUES (1, '10mg', 'Tadalafil 10mg tablets', 20.00)");
        $this->addSql("INSERT INTO product_dosage (product_id, dosage, description, price) VALUES (1, '20mg', 'Tadalafil 20mg tablets', 25.00)");

        // Insert initial data into the questionnaire table
        $this->addSql("INSERT INTO questionnaire (name, description) VALUES ('Erectile Dysfunction Questionnaire', 'Questionnaire to assess ED treatments')");

        // Insert initial data into the question table
        $this->addSql("INSERT INTO question (questionnaire_id, text, order_number, question_number) VALUES (1, 'Do you have difficulty getting or maintaining an erection?', 1, '1.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, order_number, question_number) VALUES (1, 'Have you tried any of the following treatments before?', 2, '2.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, parent_question_id, order_number, question_number) VALUES (1, 'Was the Viagra or Sildenafil product you tried before effective?', 2, 3, '2a.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, parent_question_id, order_number, question_number) VALUES (1, 'Was the Cialis or Tadalafil product you tried before effective?', 2, 3, '2b.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, parent_question_id, order_number, question_number) VALUES (1, 'Which is your preferred treatment?', 2, 3, '2c.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, order_number, question_number) VALUES (1, 'Do you have, or have you ever had, any heart or neurological conditions?', 4, '3.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, order_number, question_number) VALUES (1, 'Do any of the listed medical conditions apply to you?', 5, '4.')");
        $this->addSql("INSERT INTO question (questionnaire_id, text, order_number, question_number) VALUES (1, 'Are you taking any of the following drugs?', 6, '5.')");

        // Insert initial data into the answer table
        $this->addSql("INSERT INTO answer (question_id, text) VALUES (1, 'Yes')");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (1, 'No', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, follow_up_question_id) VALUES (2, 'Viagra or Sildenafil', 3)");
        $this->addSql("INSERT INTO answer (question_id, text, follow_up_question_id) VALUES (2, 'Cialis or Tadalafil', 4)");
        $this->addSql("INSERT INTO answer (question_id, text, follow_up_question_id) VALUES (2, 'Both', 5)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (2, 'None of the above', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (2, 'None of the above', 3)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (3, 'Yes', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (3, 'No', 4)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (4, 'Yes', 3)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (4, 'No', 2)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (5, 'Viagra or Sildenafil', 2)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (5, 'Cialis or Tadalafil', 3)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (5, 'None of the above', 2)");
        $this->addSql("INSERT INTO answer (question_id, text, product_dosage_id) VALUES (5, 'None of the above', 4)");
        $this->addSql("INSERT INTO answer (question_id, text) VALUES (6, 'Yes')");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (6, 'No', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (7, 'Significant liver problems (such as cirrhosis of the liver) or kidney problems', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (7, 'Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (7, 'Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (7, 'Condition affecting your penis (such as Peyronie''s Disease, previous injuries or an inability to retract your foreskin)', 1)");
        $this->addSql("INSERT INTO answer (question_id, text) VALUES (7, 'I don''t have any of these conditions')");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (8, 'Alpha-blocker medication such as Alfuzosin, Doxazosin, Tamsulosin, Prazosin, Terazosin or over-the-counter Flomax', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (8, 'Riociguat or other guanylate cyclase stimulators (for lung problems)', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (8, 'Saquinavir, Ritonavir or Indinavir (for HIV)', 1)");
        $this->addSql("INSERT INTO answer (question_id, text, question_answer_restriction_id) VALUES (8, 'Cimetidine (for heartburn)', 1)");
        $this->addSql("INSERT INTO answer (question_id, text) VALUES (8, 'I don''t take any of these drugs')");

        // Insert initial data into the question_answer_restriction table
        $this->addSql("INSERT INTO question_answer_restriction (answer_id, exclusion_type, exclusion_details) VALUES (2, 'exclude_all', 'No products available')");
        $this->addSql("INSERT INTO question_answer_restriction (answer_id, exclusion_type, exclusion_details) VALUES (2, 'exclude_tadalafil', 'Exclude Tadalafil')");
        $this->addSql("INSERT INTO question_answer_restriction (answer_id, exclusion_type, exclusion_details) VALUES (2, 'exclude_sildenafil', 'Exclude Sildenafil')");
    }

    public function down(Schema $schema): void
    {
        // Delete the initial data in reverse order
        $this->addSql('DELETE FROM question_answer_restriction');
        $this->addSql('DELETE FROM answer');
        $this->addSql('DELETE FROM question');
        $this->addSql('DELETE FROM questionnaire');
        $this->addSql('DELETE FROM product');
        $this->addSql('DELETE FROM category');
        $this->addSql('DELETE FROM product_dosage');
    }
}
