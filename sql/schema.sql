
-- schema.sql

CREATE DATABASE IF NOT EXISTS gestions_emplois CHARACTER SET utf8mb4;
USE gestions_emplois;

CREATE TABLE filieres (
    id_filiere INT AUTO_INCREMENT PRIMARY KEY,
    nom_filiere VARCHAR(25),
    DESCRIPTION TEXT
);

CREATE TABLE classes (
    id_classe INT AUTO_INCREMENT PRIMARY KEY,
    id_filiere INT,
    niveau INT,
    FOREIGN KEY (id_filiere) REFERENCES filieres(id_filiere)
);

CREATE TABLE etudiants (
    num_inscription VARCHAR(25) PRIMARY KEY,
    nom VARCHAR(25),
    prenom VARCHAR(25),
    id_classe INT,
    FOREIGN KEY (id_classe) REFERENCES classes(id_classe)
);

CREATE TABLE enseignants (
    id_ens INT AUTO_INCREMENT PRIMARY KEY,
    nom_ens VARCHAR(25),
    prenom_ens VARCHAR(12)
);

CREATE TABLE modules (
    idModule INT AUTO_INCREMENT PRIMARY KEY,
    id_module VARCHAR(15),
    nomModule VARCHAR(25),
    DESCRIPTION TEXT
);

CREATE TABLE salles (
    id_salle INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(25),
    DESCRIPTION TEXT
);

CREATE TABLE seances (
    id_seance INT AUTO_INCREMENT PRIMARY KEY,
    id_classe INT,
    id_ens INT,
    id_salle INT,
    idModule VARCHAR(15),
    jour VARCHAR(12),
    debut TIME,
    fin TIME,
    FOREIGN KEY (id_classe) REFERENCES classes(id_classe),
    FOREIGN KEY (id_ens) REFERENCES enseignants(id_ens),
    FOREIGN KEY (id_salle) REFERENCES salles(id_salle),
    FOREIGN KEY (idModule) REFERENCES modules(idModule)
);

-- Données fictives
INSERT INTO filieres (nom_filiere, DESCRIPTION) VALUES
('SRS', 'Systèmes et Réseaux Sécurité'),
('AL', 'Architecture Logiciel');

INSERT INTO classes (id_filiere, niveau) VALUES
(1, 3),
(2, 3);

INSERT INTO etudiants (num_inscription, nom, prenom, id_classe) VALUES 
('ETU02032024', 'KONDO', 'Tete', '1'),
('ETU02032025', 'AGBEKPONOU', 'Ismael','1'); 

INSERT INTO enseignants (nom, prenom) VALUES
('KOLNANGBLE', 'Jean'),
('PASSABI', 'Damien');

INSERT INTO modules (idModule, nomModule, DESCRIPTION) VALUES
('1', 'Java', 'Programmation Java'),
('2', 'Réseaux', 'Architecture réseau');

INSERT INTO salles (nom, DESCRIPTION) VALUES
('Lab Info', 'Salle informatique'),
('BO-004', 'Salle de test physique');

INSERT INTO cours (id_classe, id_ens, id_salle, idModule, jour, debut, fin) VALUES
(1, 1, 1, 'M1', 'lundi', '08:30:00', '10:00:00'),
(1, 1, 2, 'M2', 'Jeudi', '10:10:00', '11:45:00');
