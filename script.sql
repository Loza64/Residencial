use residencial;

CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(13) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    pass VARCHAR(200) NOT NULL,
    rol ENUM('s_admin', 'admin', 'resident') DEFAULT 'resident' NOT NULL,
    state ENUM('approved', 'denied', 'waiting') DEFAULT 'waiting' NOT NULL,
    CONSTRAINT check_username CHECK (username REGEXP '^[a-zA-ZÁ-ÿ0-9]{4,13}$'),
    CONSTRAINT check_email CHECK (email REGEXP '^[\\w._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,10}$'),
    CONSTRAINT check_pass CHECK (pass REGEXP '^\\$2y\\$[0-9]{2}\\$[./0-9A-Za-z]{22}[./0-9A-Za-z]{31}$')
);

CREATE TABLE contact (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    id_user BIGINT NULL,
    name VARCHAR(150) NOT NULL,
    birth DATE NOT NULL,
    dui VARCHAR(10) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(8) NOT NULL,
    address VARCHAR(400) NOT NULL,
    occupation VARCHAR(120) NOT NULL,
    income DECIMAL(10, 2) NOT NULL, 
    family_members INT NOT NULL CHECK (family_members >= 0),
    reason_interest VARCHAR(350) NOT NULL,
    personal_reference VARCHAR(200) NOT NULL,
    application_date DATE NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT check_name CHECK (name REGEXP '^[a-zA-ZÁ-ÿ ]{3,40}$'), 
    CONSTRAINT check_dui CHECK (dui REGEXP '^[0-9]{8}-[0-9]{1}$'),
    CONSTRAINT check_email_contact CHECK (email REGEXP '^[\\w._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,10}$'),
    CONSTRAINT check_phone CHECK (phone REGEXP '^[0-9]{8}$'),
    CONSTRAINT check_address CHECK (address REGEXP '^[a-zA-Z0-9Á-ÿ ,.-]{1,400}$'),
    CONSTRAINT check_income CHECK (income REGEXP '^[0-9]+(,[0-9]{3})*(\\.[0-9]{2})?$'),  
    CONSTRAINT check_occupation CHECK (occupation REGEXP '^[a-zA-Z0-9Á-ÿ ]{1,120}$'),
    CONSTRAINT check_reason_interest CHECK (reason_interest REGEXP '^[a-zA-Z0-9Á-ÿ ,.-]{1,350}$'),
    CONSTRAINT check_personal_reference CHECK (personal_reference REGEXP '^[a-zA-Z0-9Á-ÿ ,.-]{1,200}$')
);

DELIMITER //
CREATE TRIGGER check_age_before_insert
BEFORE INSERT ON contact
FOR EACH ROW
BEGIN
    IF NEW.birth > DATE_SUB(CURDATE(), INTERVAL 18 YEAR) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El contacto debe ser mayor de 18 años.';
    END IF;
END;
//
DELIMITER ;

INSERT INTO users (username, email, pass, rol) VALUES ('User01', 'u01@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User02', 'u02@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User03', 'u03@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User04', 'u04@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User05', 'u05@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User06', 'u06@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User07', 'u07@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User08', 'u08@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User09', 'u09@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User10', 'u10@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User11', 'u11@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User12', 'u12@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User13', 'u13@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User14', 'u14@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User15', 'u15@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User16', 'u16@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User17', 'u17@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User18', 'u18@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User19', 'u19@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User20', 'u20@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User21', 'u21@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User22', 'u22@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User23', 'u23@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User24', 'u24@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User25', 'u25@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User26', 'u26@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User27', 'u27@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User28', 'u28@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User29', 'u29@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User30', 'u30@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User31', 'u31@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User32', 'u32@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User33', 'u33@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User34', 'u34@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User35', 'u35@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User36', 'u36@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');  
INSERT INTO users (username, email, pass, rol) VALUES ('User37', 'u37@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User38', 'u38@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 's_admin');  
INSERT INTO users (username, email, pass, rol) VALUES ('User39', 'u39@example.com', '$2y$10$lacHcLoU8wq0I1lXU6TesesUHkJ6DZxad9F7.6XPvRiO4Wc6.bhqa', 'resident');