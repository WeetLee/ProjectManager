use testYourCode;

CREATE TABLE Utilisateur(
	id int PRIMARY KEY auto_increment NOT NULL,
	nom varchar(255) NOT NULL,
	username varchar(255) NOT NULL,
	motDePasse text NOT NULL,
	image text
);

CREATE TABLE Projet(
	id int PRIMARY KEY auto_increment NOT NULL,
	nom text NOT NULL,
	image text

);

CREATE TABLE UtilisateurProjet(
	idUtilisateur int,
	idProjet int,
	CONSTRAINT
	PRIMARY KEY (idUtilisateur,idProjet),
	FOREIGN KEY (idUtilisateur) REFERENCES Utilisateur(id),
	FOREIGN KEY (idProjet) REFERENCES Projet(id)
);

CREATE TABLE Fonctionnalite(
	id int PRIMARY KEY auto_increment NOT NULL,
	type varchar(255) NOT NULL,
	nom text NOT NULL,
	statut varchar(255) NOT NULL,
	affectation int,
	priorite int,
	idFonctionnaliteParent int,
	idProjet int NOT NULL,
	commentaire LONGTEXT,
	CONSTRAINT
	FOREIGN KEY (idProjet) REFERENCES Projet(id)
);

CREATE TABLE Tache(
	id int PRIMARY KEY auto_increment NOT NULL,
	nom text NOT NULL,
	avancement varchar(255) NOT NULL,
	dureePrevisionnelle int,
	idFonctionnalite int,
	affectation int,
	statut varchar(255),
	CONSTRAINT
	FOREIGN KEY(idFonctionnalite) REFERENCES Fonctionnalite(id),
	FOREIGN KEY(affectation) REFERENCES Utilisateur(id)
);

CREATE TABLE Test(
	id int PRIMARY KEY auto_increment NOT NULL,
	nom text NOT NULL,
	statut varchar(255) NOT NULL,
	dateDerniereExecution date,
	idFonctionnalite int,
	CONSTRAINT
	FOREIGN KEY(idFonctionnalite) REFERENCES Fonctionnalite(id)
);

