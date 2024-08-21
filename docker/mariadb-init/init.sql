-- Create the questionnaire table
CREATE TABLE questionnaire (
                               id INT AUTO_INCREMENT PRIMARY KEY,
                               name VARCHAR(255) NOT NULL,
                               description TEXT,
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the question table
CREATE TABLE question (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          questionnaire_id INT,
                          text VARCHAR(255) NOT NULL,
                          parent_question_id INT DEFAULT NULL,
                          order_number INT NOT NULL,
                          FOREIGN KEY (questionnaire_id) REFERENCES questionnaire(id),
                          FOREIGN KEY (parent_question_id) REFERENCES question(id) ON DELETE CASCADE
);

-- Create the answer table
CREATE TABLE answer (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        question_id INT,
                        text VARCHAR(255) NOT NULL,
                        follow_up_question_id INT DEFAULT NULL,
                        restriction TEXT,
                        FOREIGN KEY (question_id) REFERENCES question(id),
                        FOREIGN KEY (follow_up_question_id) REFERENCES question(id) ON DELETE CASCADE
);

-- Create the question_answer_restriction table
CREATE TABLE question_answer_restriction (
                                             id INT AUTO_INCREMENT PRIMARY KEY,
                                             answer_id INT,
                                             exclusion_type VARCHAR(255),
                                             exclusion_details TEXT,
                                             FOREIGN KEY (answer_id) REFERENCES answer(id) ON DELETE CASCADE
);

-- Insert initial questionnaire data
INSERT INTO questionnaire (name, description)
VALUES ('Erectile Dysfunction Questionnaire', 'Questionnaire to assess ED treatments');

-- Insert initial questions
INSERT INTO question (questionnaire_id, text, order_number)
VALUES (1, 'Do you have difficulty getting or maintaining an erection?', 1);

INSERT INTO question (questionnaire_id, text, order_number)
VALUES (1, 'Have you tried any of the following treatments before?', 2);

INSERT INTO question (questionnaire_id, text, parent_question_id, order_number)
VALUES (1, 'Was the Viagra or Sildenafil product you tried before effective?', 2, 3);

-- Insert initial answers
INSERT INTO answer (question_id, text, restriction)
VALUES (1, 'Yes', NULL);

INSERT INTO answer (question_id, text, restriction)
VALUES (1, 'No', 'No products available');

INSERT INTO answer (question_id, text, follow_up_question_id)
VALUES (2, 'Viagra or Sildenafil', 3);

INSERT INTO answer (question_id, text, follow_up_question_id)
VALUES (2, 'None of the above', NULL);

-- Insert restrictions for answers
INSERT INTO question_answer_restriction (answer_id, exclusion_type, exclusion_details)
VALUES (2, 'exclude_all', 'No products available');
