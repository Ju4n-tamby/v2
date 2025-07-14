CREATE DATABASE IF NOT EXISTS db_s2_ETU003922;
USE db_s2_ETU003922;

CREATE TABLE emp_membre(
  id_membre INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(60),
  datenaissance DATE,
  genre CHAR(1),
  email VARCHAR(60),
  ville VARCHAR(60),
  mdp VARCHAR(60),
  image VARCHAR(255)
);

CREATE TABLE emp_categorie_objet(
  id_categorie INT PRIMARY KEY AUTO_INCREMENT,
  nom_categorie VARCHAR(60)
);


CREATE TABLE emp_objet(
  id_objet INT PRIMARY KEY AUTO_INCREMENT,
  nom_objet VARCHAR(60),
  id_categorie INT,
  id_membre INT,
  FOREIGN KEY (id_categorie)
  REFERENCES emp_categorie_objet(id_categorie),
  FOREIGN KEY (id_membre)
  REFERENCES emp_membre(id_membre)
);


CREATE TABLE emp_images_objet(
  id_image INT PRIMARY KEY AUTO_INCREMENT,
  id_objet INT,
  nom_image VARCHAR(120),
  FOREIGN KEY (id_objet)
  REFERENCES emp_objet(id_objet)
);

CREATE TABLE emp_emprunt(
  id_emprunt INT PRIMARY KEY AUTO_INCREMENT,
  id_objet INT,
  id_membre INT,
  date_emprunt DATETIME,
  date_retour DATETIME,
  FOREIGN KEY (id_objet)
  REFERENCES emp_objet(id_objet),
  FOREIGN KEY (id_membre)
  REFERENCES emp_membre(id_membre)
);
-- Insertion des membres
ALTER TABLE emp_membre AUTO_INCREMENT = 1;
INSERT INTO emp_membre (nom, datenaissance, genre, email, ville, mdp, image) VALUES
('Alice Dupont', '1990-05-12', 'F', 'alice@example.com', 'Paris', 'pass123', 'alice.jpg'),
('Bob Martin', '1985-08-23', 'M', 'bob@example.com', 'Lyon', 'pass456', 'bob.jpg'),
('Claire Durand', '1992-11-30', 'F', 'claire@example.com', 'Marseille', 'pass789', 'claire.jpg'),
('David Petit', '1988-02-17', 'M', 'david@example.com', 'Toulouse', 'pass321', 'david.jpg');
ALTER TABLE emp_membre AUTO_INCREMENT = 1;

-- Insertion des catégories
INSERT INTO emp_categorie_objet (nom_categorie) VALUES
('esthétique'),
('bricolage'),
('mécanique'),
('cuisine');

-- Insertion des objets (10 par membre, répartis sur les catégories)
INSERT INTO emp_objet (nom_objet, id_categorie, id_membre) VALUES
('Sèche-cheveux', 1, 1),
('Trousse de maquillage', 1, 1),
('Perceuse', 2, 1),
('Tournevis', 2, 1),
('Clé à molette', 3, 1),
('Pompe à vélo', 3, 1),
('Mixeur', 4, 1),
('Poêle', 4, 1),
('Casserole', 4, 1),
('Fouet', 4, 1),

('Fer à lisser', 1, 2),
('Pinceau', 1, 2),
('Marteau', 2, 2),
('Scie', 2, 2),
('Cric', 3, 2),
('Tournevis électrique', 3, 2),
('Robot pâtissier', 4, 2),
('Grille-pain', 4, 2),
('Cafetière', 4, 2),
('Cuillère en bois', 4, 2),

('Brosse à cheveux', 1, 3),
('Palette de maquillage', 1, 3),
('Visseuse', 2, 3),
('Pince', 2, 3),
('Compresseur', 3, 3),
('Clé dynamométrique', 3, 3),
('Blender', 4, 3),
('Moule à gâteau', 4, 3),
('Saladier', 4, 3),
('Spatule', 4, 3),

('Lisseur', 1, 4),
('Crème visage', 1, 4),
('Perceuse sans fil', 2, 4),
('Scie sauteuse', 2, 4),
('Pistolet à graisse', 3, 4),
('Clé plate', 3, 4),
('Cocotte-minute', 4, 4),
('Batteur', 4, 4),
('Tamis', 4, 4),
('Planche à découper', 4, 4);

-- Insertion des emprunts
INSERT INTO emp_emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2024-06-01 10:00:00', '2024-06-05 18:00:00'),
(12, 1, '2024-06-02 09:30:00', '2024-06-06 17:00:00'),
(23, 4, '2024-06-03 14:00:00', '2024-06-07 16:00:00'),
(34, 3, '2024-06-04 11:00:00', '2024-06-08 15:00:00'),
(5, 3, '2024-06-05 13:00:00', '2024-06-09 19:00:00'),
(16, 4, '2024-06-06 08:00:00', '2024-06-10 20:00:00'),
(27, 2, '2024-06-07 12:00:00', '2024-06-11 18:00:00'),
(8, 1, '2024-06-08 15:00:00', '2024-06-12 17:00:00'),
(19, 4, '2024-06-09 10:30:00', '2024-06-13 16:30:00'),
(30, 2, '2024-06-10 09:00:00', '2024-06-14 18:00:00');


--Vues--
CREATE VIEW v_objet_categorie_membre AS
SELECT o.*, c.nom_categorie, m.nom
FROM emp_objet o
JOIN emp_categorie_objet c ON o.id_categorie = c.id_categorie
JOIN emp_membre m ON o.id_membre = m.id_membre;


INSERT INTO emp_images_objet (id_objet, nom_image) VALUES
(1, 'seche_cheveux.jpeg'),
(2, 'trousse_maquillage.jpeg'),
(3, 'perceuse.jpeg'),
(4, 'tournevis.jpeg'),
(5, 'cle_a_molette.jpeg'),
(6, 'pompe_a_velo.jpeg'),
(7, 'mixeur.jpeg'),
(8, 'poel.jpeg'),
(9, 'casserole.jpeg'),
(10, 'fouet.jpeg'),
(11, 'fer_a_lisser.jpeg'),
(12, 'pinceau.jpeg'),
(13, 'marteau.jpeg'),
(14, 'scie.jpeg'),
(15, 'cric.jpeg'),
(16, 'tournevis_electrique.jpeg'),
(17, 'robot_patissier.jpeg'),
(18, 'grille_pain.jpeg'),
(19, 'cafetiere.jpeg'),
(20, 'cuillere_en_bois.jpeg'),
(21, 'brosse_a_cheveux.jpeg'),
(22, 'palette_de_maquillage.jpeg'),
(23, 'visseuse.jpeg'),
(24, 'pince.jpeg'),
(25, 'compresseur.jpeg'),
(26, 'cle_dynamometrique.jpeg'),
(27, 'blender.jpeg'),
(28, 'moule_a_gateau.jpeg'),
(29, 'saladier.jpeg'),
(30, 'spatule.jpeg'),
(31, 'lisseur.jpeg'),
(32, 'creme_visage.jpeg'),
(33, 'perceuse_sans_fil.jpeg'),
(34, 'scie_sauteuse.jpeg'),
(35, 'pistolet_a_graisse.jpeg'),
(36, 'cle_plate.jpeg'),
(37, 'cocote_minute.jpeg'),
(38, 'batteur.jpeg'),
(39, 'tamis.jpeg'),
(40, 'planche_a_decouper.jpeg');
