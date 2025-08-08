
-- schema.sql

-- Schema corrigé pour gestion_emploi
CREATE DATABASE IF NOT EXISTS gestion_emploi CHARACTER SET utf8mb4;
USE gestion_emploi;

-- Table des filières
CREATE TABLE filieres (
    id_filiere INT AUTO_INCREMENT PRIMARY KEY,
    nom_filiere VARCHAR(50) NOT NULL,
    description TEXT
);

-- Table des classes
CREATE TABLE classes (
    id_classe INT AUTO_INCREMENT PRIMARY KEY,
    id_filiere INT NOT NULL,
    niveau INT NOT NULL,
    nom_classe VARCHAR(20) NOT NULL,
    FOREIGN KEY (id_filiere) REFERENCES filieres(id_filiere)
);

-- Table des étudiants
CREATE TABLE etudiants (
    num_inscription VARCHAR(25) PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    id_classe INT NOT NULL,
    FOREIGN KEY (id_classe) REFERENCES classes(id_classe)
);

-- Table des enseignants
CREATE TABLE enseignants (
    id_ens INT AUTO_INCREMENT PRIMARY KEY,
    nom_ens VARCHAR(50) NOT NULL,
    prenom_ens VARCHAR(50) NOT NULL
);

-- Table des modules
CREATE TABLE modules (
    idModule VARCHAR(15) PRIMARY KEY,
    nomModule VARCHAR(100) NOT NULL,
    description TEXT
);

-- Table des salles
CREATE TABLE salles (
    id_salle INT AUTO_INCREMENT PRIMARY KEY,
    nom_salle VARCHAR(50) NOT NULL,
    description TEXT
);

-- Table des séances
CREATE TABLE seances (
    id_seance INT AUTO_INCREMENT PRIMARY KEY,
    id_classe INT NOT NULL,
    id_ens INT NOT NULL,
    id_salle INT NOT NULL,
    idModule VARCHAR(15) NOT NULL,
    jour VARCHAR(20) NOT NULL,
    debut TIME NOT NULL,
    fin TIME NOT NULL,
    FOREIGN KEY (id_classe) REFERENCES classes(id_classe),
    FOREIGN KEY (id_ens) REFERENCES enseignants(id_ens),
    FOREIGN KEY (id_salle) REFERENCES salles(id_salle),
    FOREIGN KEY (idModule) REFERENCES modules(idModule)
);

-- Insertion des données de test
INSERT INTO filieres (nom_filiere, description) VALUES
('AL', 'Architecture Logicielle'),
('SRS', 'Systèmes et Réseaux Sécurisés'),
('IA-BD', 'Intelligence Artificielle et Big Data');

INSERT INTO classes (id_filiere, niveau, nom_classe) VALUES
(1, 3, 'AL3'),
(2, 3, 'SRS3'),
(3, 3, 'IA-BD3');

INSERT INTO etudiants (num_inscription, nom, prenom, id_classe) VALUES 
('ETU001', 'KONDO', 'Tete', 1),
('ETU002', 'AGBEKPONOU', 'Ismael', 1),
('ETU003', 'MARTIN', 'Paul', 2),
('ETU004', 'DUPONT', 'Marie', 2),
('ETU005', 'COHEN', 'Sarah', 3),
('ETU006', 'DIALLO', 'Amadou', 3);

INSERT INTO enseignants (nom_ens, prenom_ens) VALUES
('SEWAVI', 'Kofi'),
('DUSSEY', 'Amina');

INSERT INTO modules (idModule, nomModule, description) VALUES
('M1', 'JavaEE', 'Java Enterprise Edition'),
('M2', 'C#', 'Programmation C Sharp'),
('M3', 'POO', 'Programmation Orientée Objet'),
('M4', 'Python', 'Langage Python'),
('M5', 'Webmastering', 'Développement Web');

INSERT INTO salles (nom_salle, description) VALUES
('B-002', 'Salle informatique B-002'),
('B-004', 'Salle informatique B-004'),
('A-101', 'Amphithéâtre A-101');

INSERT INTO seances (id_classe, id_ens, id_salle, idModule, jour, debut, fin) VALUES
(1, 1, 1, 'M1', 'Lundi', '08:30:00', '10:00:00'),
(1, 2, 2, 'M2', 'Mardi', '10:30:00', '12:00:00'),
(1, 1, 1, 'M3', 'Mercredi', '14:00:00', '15:30:00'),
(2, 2, 2, 'M4', 'Jeudi', '08:30:00', '10:00:00'),
(2, 1, 1, 'M5', 'Vendredi', '10:30:00', '12:00:00'),
(3, 1, 3, 'M1', 'Lundi', '14:00:00', '15:30:00'),
(3, 2, 2, 'M4', 'Mardi', '08:30:00', '10:00:00');