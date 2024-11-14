create database residencial;

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

INSERT INTO contact (id_user, name, birth, dui, email, phone, address, occupation, income, family_members, reason_interest, personal_reference, application_date) VALUES
(3, 'Juan Resident', '1990-01-01', '01234567-8', 'u03@example.com', '12345678', 'Calle Ejemplo 1, Ciudad', 'Trabajador Social', 1000.00, 3, 'Apoyo a vivienda', 'Ana Ruiz', '2024-11-14'),
(6, 'Maria Resident', '1985-05-10', '87654321-9', 'u06@example.com', '23456789', 'Avenida Central 250, Ciudad', 'Enfermera', 1200.00, 2, 'Atención médica', 'Pedro Pérez', '2024-11-14'),
(9, 'Carlos Resident', '1975-07-20', '12345678-7', 'u09@example.com', '34567890', 'Calle Nueva 100, Ciudad', 'Ingeniero', 1500.00, 4, 'Mejorar ingresos', 'Luisa Gómez', '2024-11-14'),
(12, 'Sofía Resident', '2000-03-15', '98765432-1', 'u12@example.com', '45678901', 'Barrio Antiguo 50, Ciudad', 'Estudiante', 500.00, 1, 'Becas de estudio', 'Clara Torres', '2024-11-14'),
(15, 'José Resident', '1988-10-30', '65432108-7', 'u15@example.com', '56789012', 'Plaza Mayor 5, Ciudad', 'Comerciante', 1300.00, 5, 'Apoyo a negocio', 'José Silva', '2024-11-14'),
(18, 'Ana Resident', '1993-02-25', '23456780-3', 'u18@example.com', '67890123', 'Calle Salud 300, Ciudad', 'Docente', 1000.00, 3, 'Reconocimiento laboral', 'Mario Cordero', '2024-11-14'),
(21, 'Verónica Resident', '1980-12-05', '34567890-4', 'u21@example.com', '78901234', 'Calle de la Paz 400, Ciudad', 'Artista', 900.00, 2, 'Fondos para proyecto', 'Verónica López', '2024-11-14'),
(27, 'Daniela Resident', '1995-08-17', '56789012-3', 'u27@example.com', '89012345', 'Calle Libertad 150, Ciudad', 'Cocinero', 800.00, 1, 'Capacitación en cocina', 'Daniela Ríos', '2024-11-14'),
(30, 'Rafael Resident', '1982-11-22', '67890123-6', 'u30@example.com', '90123456', 'Avenida del Sol 600, Ciudad', 'Vendedor', 1100.00, 3, 'Gestión de ventas', 'Rafael Martínez', '2024-11-14'),
(33, 'Teresa Resident', '1975-06-30', '78901234-5', 'u33@example.com', '01234567', 'Calle Progreso 300, Ciudad', 'Ingeniero Civil', 1500.00, 4, 'Proyectos de construcción', 'Teresa Pérez', '2024-11-14');
