use residencial;

CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(13) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    pass VARCHAR(200) NOT NULL,
    rol ENUM('s_admin', 'admin', 'resident') DEFAULT 'resident' NOT NULL,
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
    CONSTRAINT fk_user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
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