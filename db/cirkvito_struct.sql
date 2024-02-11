CREATE TABLE IF NOT EXISTS agency (
  agency_id varchar(255) NOT NULL,
  agency_name varchar(255) DEFAULT NULL,
  agency_url varchar(255) DEFAULT NULL,
  agency_timezone varchar(255) DEFAULT NULL,
  agency_lang varchar(255) DEFAULT NULL,
  agency_phone varchar(255) DEFAULT NULL,
  agency_fare_url varchar(255) DEFAULT NULL,
  agency_email varchar(255) DEFAULT NULL,
  PRIMARY KEY (agency_id)
);

CREATE TABLE IF NOT EXISTS distances (
  id_salle_depart int(10) NOT NULL,
  id_salle_arrivee int(10) NOT NULL,
  distance float DEFAULT NULL,
  temps float NOT NULL,
  PRIMARY KEY (id_salle_depart,id_salle_arrivee),
  FOREIGN KEY (id_salle_arrivee) REFERENCES salle(id_salle_arrivee)
);

CREATE TABLE IF NOT EXISTS film (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  titre varchar(50) NOT NULL,
  duree int(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS salle (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  nom varchar(32) NOT NULL,
  adresse varchar(32) NOT NULL,
  id_ville int(10) NOT NULL,
  latitude float DEFAULT NULL,
  longitude float DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS seance (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  heure_debut datetime NOT NULL,
  id_salle INTEGER NOT NULL,
  id_film INTEGER NOT NULL,
  id_section INTEGER DEFAULT NULL,
  FOREIGN KEY (id_salle) REFERENCES salle(id_salle),
  FOREIGN KEY (id_film) REFERENCES film(id_film),
  FOREIGN KEY (id_section) REFERENCES section(id_section)
);

CREATE TABLE IF NOT EXISTS section (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  nom varchar(255) NOT NULL,
  sigle varchar(8) NOT NULL,
  remarque varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS ville (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  nom varchar(50) NOT NULL,
  code_postal varchar(5) NOT NULL
);