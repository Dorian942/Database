CREATE TABLE Client(
        Nom            Varchar (25) ,
        Prenom         Varchar (25) ,
        Client_ID      int (11) Auto_increment  NOT NULL ,
        Adresse        Varchar (25) ,
        Login          Varchar (25) ,
        MotDePasse     Varchar (25) ,
        Piece_Identite Boolean,
        PRIMARY KEY (Client_ID ) ,
        UNIQUE (Login )
)ENGINE=InnoDB;




CREATE TABLE Vehicule(
        Vehicule_ID    int (11) Auto_increment  NOT NULL ,
        Marque         Varchar (25) ,
        Kilometrage    Int ,
        Emplacement_ID Int NOT NULL ,
        Adresse        Varchar (25) NOT NULL ,
        PRIMARY KEY (Vehicule_ID )
)ENGINE=InnoDB;




CREATE TABLE Voiture(
        Modele      Varchar (25) NOT NULL ,
        Vehicule_ID Int NOT NULL ,
        PRIMARY KEY (Modele ,Vehicule_ID )
)ENGINE=InnoDB;




CREATE TABLE Moto(
        Cylindree   Int NOT NULL ,
        Vehicule_ID Int NOT NULL ,
        PRIMARY KEY (Cylindree ,Vehicule_ID )
)ENGINE=InnoDB;



CREATE TABLE Devis(
        Devis_ID      int (11) Auto_increment  NOT NULL ,
        Duree         Int ,
        Type_Vehicule Boolean,
        Prix          Float ,
        Assurance     Boolean,
        Devis_Date    Date ,
        Client_ID     Int ,
        Facture_ID    Int ,
        Vehicule_ID   Int ,
        PRIMARY KEY (Devis_ID )
)ENGINE=InnoDB;




CREATE TABLE Facture(
        Facture_ID      int (11) Auto_increment  NOT NULL ,
        Duree_Effective Int ,
        Prix_Effectif   Float ,
        Consommation    Int ,
        Etat            Int ,
        Devis_ID        Int ,
        PRIMARY KEY (Facture_ID )
)ENGINE=InnoDB;




CREATE TABLE Emplacement(
        Emplacement_ID int (11) Auto_increment  NOT NULL ,
        Adresse        Varchar (25) NOT NULL ,
        Places_Dispo   Int ,
        Place_Max      Int ,
        PRIMARY KEY (Emplacement_ID ,Adresse )
)ENGINE=InnoDB;



CREATE TABLE Agent(
        Matricule      int (11) Auto_increment  NOT NULL ,
        Nom            Varchar (25) ,
        Prenom         Int ,
        Adresse        Varchar (25) ,
        Date_Naissance Varchar (25) ,
        Telephone      Int ,
        Login          Varchar (25) ,
        MotDePasse     Varchar (25) ,
        PRIMARY KEY (Matricule ) ,
        UNIQUE (Telephone ,Login )
)ENGINE=InnoDB;




CREATE TABLE gere(
        Matricule      Int NOT NULL ,
        Emplacement_ID Int NOT NULL ,
        Adresse        Varchar (25) NOT NULL ,
        PRIMARY KEY (Matricule ,Emplacement_ID ,Adresse )
)ENGINE=InnoDB;

ALTER TABLE Vehicule ADD CONSTRAINT FK_Vehicule_Emplacement_ID FOREIGN KEY (Emplacement_ID,Adresse) REFERENCES Emplacement(Emplacement_ID,Adresse);

ALTER TABLE Voiture ADD CONSTRAINT FK_Voiture_Vehicule_ID FOREIGN KEY (Vehicule_ID) REFERENCES Vehicule(Vehicule_ID);
ALTER TABLE Moto ADD CONSTRAINT FK_Moto_Vehicule_ID FOREIGN KEY (Vehicule_ID) REFERENCES Vehicule(Vehicule_ID);
ALTER TABLE Devis ADD CONSTRAINT FK_Devis_Client_ID FOREIGN KEY (Client_ID) REFERENCES Client(Client_ID);
ALTER TABLE Devis ADD CONSTRAINT FK_Devis_Facture_ID FOREIGN KEY (Facture_ID) REFERENCES Facture(Facture_ID);
ALTER TABLE Devis ADD CONSTRAINT FK_Devis_Vehicule_ID FOREIGN KEY (Vehicule_ID) REFERENCES Vehicule(Vehicule_ID);
ALTER TABLE Facture ADD CONSTRAINT FK_Facture_Devis_ID FOREIGN KEY (Devis_ID) REFERENCES Devis(Devis_ID);
ALTER TABLE gere ADD CONSTRAINT FK_gere_Matricule FOREIGN KEY (Matricule) REFERENCES Agent(Matricule);
ALTER TABLE gere ADD CONSTRAINT FK_gere_Emplacement_ID FOREIGN KEY (Emplacement_ID,Adresse) REFERENCES Emplacement(Emplacement_ID,Adresse);