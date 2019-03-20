-- Tout d'abord, il faut créer une nouvelle base de données:

create database dbLivre;
use dbLivre;

-- Maintenant, il faut créer les tables:



-- On créé maintenant la table des auteurs:

create table AUTEUR(
    ID  int primary key not null auto_increment,
    NOM varchar(50) not null   
);

-- Maintenant la table des catégories:
create table CATEGORIE(
    ID  int primary key  not null auto_increment,
    GENRE varchar(40) not null
);

-- La table des mots clefs:

create table MOTCLEF(
    ID int primary key not null auto_increment,
    MOTCLE varchar(40)
);

-- La table des adhérents:
create table ADHERENTS(
    ID  int primary key not null auto_increment,
    NOM varchar(40) not null,
    PRENOM varchar(40)
);

-- La table principale: les livres.

create table LIVRE(
    ID int  primary key not null auto_increment,
    TITRE varchar(60) not null,
    EDITEUR varchar(30) not null,
    RAYON int,
    foreign key(RAYON) references  CATEGORIE(ID)

);

-- Il est maintenant temps de passer aux tables intermédiaires qui vont relier les tables principales entre-elles:

-- On commence par celle reliant le livre à l'auteur:

create table ECRITPAR(
  ID_LIVRE int,
  ID_AUTEUR int,
    foreign key (ID_LIVRE) references livre(ID),
   foreign key (ID_AUTEUR) references auteur(ID)

);

-- On va maintenant créer la table reliant les livres avec les mots clefs:

create table MOTCLEFLIVRE(
    ID_LIVRE int,
    ID_MOTCLEF int,
    foreign key (ID_LIVRE) references livre(ID),
   foreign key (ID_MOTCLEF) references MOTCLEF(ID)
);



-- Il faut maintenant remplir les tables:



-- Maintenant les auteurs:
insert into AUTEUR(NOM)
VALUES
("J.K ROWLING"),
("J.R.R TOLKIEN"),
("G ORWELL"),
("H.P LOVECRAFT"),
("C de GAULLE"),
("A SAPKOWSKI"),
("D KARPYSTYN"),
("A HUXLEY")
;

-- Les catégories:
insert into CATEGORIE(GENRE)
VALUES
("FANTASY"),
("DYSTOPIE"),
("FANTASTIQUE"),
("AUTOBIOGRAPHIE"),
("SCIENCE FICTION")
;

--  Les livres:
insert into LIVRE (TITRE,EDITEUR,RAYON)
VALUES
("Harry Potter","GALLIMARD",1),
("Le Seigneur des anneaux",  "GALLIMARD",1),
("1984","GALLIMARD",2),
("L'appel de Chtulhu","POINTS",3),
("Mémoires de guerre","PLON",4),
("Le sorceleur","BRAGELONNE",5),
("La voie de la destruction","FLEUVE NOIR",5),
("Le meilleur des mondes","PLON",2)
;

-- Les mots clefs:

insert into MOTCLEF(MOTCLE)
VALUES
("Sorcier"),
("Magie"),
("Jeunesse"),
("Voyage"),
("Epopée"),
("Anticipation"),
("Politique"),
("Culte"),
("Mythe"),
("Rite"),
("Histoire"),
("France"),
("Politique"),
("Guerre"),
("Star Wars"),
("Univers Etendu"),
("Sith")
;


-- Les adhérents:



-- La table intermédiaire entre livres et auteurs:
insert into ECRITPAR(ID_LIVRE,ID_AUTEUR)
VALUES
(1,1),
(2,2),
(3,3),
(4,4),
(5,5),
(6,6), 
(7,7),
(8,8)
;

-- Le lien entre livre et mot clefs:

insert into MOTCLEFLIVRE(ID_LIVRE,ID_MOTCLEF)
VALUES
-- Le premier livre:
(1,1),
(1,2),
(1,3),
-- Le second livre:
(2,2),
(2,4),
(2,5),
-- Le troisième:
(3,6),
(3,7),

-- Le quatrième:
(4,8),
(4,9),
(4,10),

-- Le cinquième:
(5,11),
(5,12),
(5,13),

-- Le sixième:
(6,9),
(6,4),
(6,2),

-- Le septième:
(7,15),
(7,16),
(7,17),

-- Le huitième:
(8,6),
(8,7)
;

-- On créé une requête qui relie les auteurs à leur livre et à leur rayon:
-- nom est = au nom de l'auteur dans la table auteur.
-- titre est égal au titre du livre dans la table livre.
-- genre est égal au genre dans la table catégorie.

select nom,titre,genre
from 
livre join categorie 
on categorie.id= rayon
join ecritpar 
on id_livre = livre.id 
join auteur 
on id_auteur = auteur.id
;




-- Cette fonction met en relation toutes les tables qui concernent le livre pour une barre de recherche:
-- Titre vient de la table livre, nom vient de la table auteur, genre vient de la table categorie et
-- motcle vient de la table motclef
select titre,nom,genre,motcle 
from 
-- Pour commencer, on va join le livre à son ou ses auteurs:
ecritpar join livre 
on id_livre = livre.id
join auteur 
on id_auteur = auteur.id
-- Ensuite on join le livre à sa catégorie:
join categorie
on livre.rayon=categorie.id
-- Enfin, on relie les livres à leurs mots-clefs:
join motcleflivre 
on motcleflivre.id_livre=livre.id
join motclef
on ID_MOTCLEF=motclef.id
-- On trie par auteur pour avoir leurs différentes oeuvres:
order by nom
;


-- Il nous faut maintenant créer une table des employés:

create table employe (
    ID int primary key auto_increment,
    NOM varchar(50) not null,
    MDP varchar(50) not null
    );

    -- On va ajouter une liste d'employés:

    insert into employe (NOM,MDP)
    VALUES
    ("Robert","toto"),
    ("Maxence","abcd"),
    ("Cynthia","XXXX"),
    ("Anthony","12345"),
    -- On ajoute un admin qui aura des droits supplémentaires:
    ("admin","mdpadmin")
    ;


    -- La commande pour identifier le nom des employés:
    select nom,mdp 
    from 
    employe
    where nom ="$nomEmploye" and mdp = "$mdpEmploye"
    ;



-- On ajoute des adhérents:

insert into ADHERENTS (NOM,PRENOM)
VALUES
("Tendlah","Eva"),
("Mentord","Gérard"),
("Provist","Alain"),
("Tah","Véjai"),
("Marakantabamayélé","Aurélie")
;


-- On ajoute à la table livre une colonne qui permet à l'admin de définir si oui ou non un livre est archivé:
ALTER TABLE LIVRE 
ADD ARCHIVE BOOLEAN 
DEFAULT FALSE
;
-- Le zéro affiché signifie que la valeur est fausse (ce que l'on veut puisque les livres ne sont pas archivés).
-- On va également ajouter une colonne pour savoir si oui ou non le livre est emprunté:
ALTER TABLE LIVRE 
ADD SUR_PLACE BOOLEAN 
DEFAULT TRUE
;

-- On créé une table qui relie les adhérents aux livres qu'ils empruntent:

create table emprunt(
     ID_LIVRE int not null,
    foreign key (ID_LIVRE) references livre(ID),
    ID_ADHERENT int not null,
   foreign key (ID_ADHERENT) references ADHERENTS(ID),
   NbrEmprunts int DEFAULT 0,
   DATE_DEBUT date ,
   DATE_FIN date 
);

-- Il faut maintenant créer une formule qui relie les livres aux adhérents qui empruntent:

insert into emprunt(id_livre,id_adherent,NbrEmprunts)
VALUES
(1,2,1),
(2,5,1)
;

-- On créé une fonction qui connecte tout:

select nom,prenom,titre,date_debut,date_fin
from
livre join emprunt
on livre.id = id_livre
join ADHERENTS
on adherents.id = id_adherent
;

insert into emprunt (id_livre,id_adherent,date_debut,DATE_FIN)
VALUES



-- Un exemple d'update:
update emprunt
set 
date_debut = now(),
date_fin = date_add(now(),interval 14 day)
where
id_livre=1;


-- La commande pour ajouter un livre à la liste des emprunts:
insert into emprunt (id_livre,id_adherent,date_debut,date_fin)
VALUES
("$livre","$adherent","$date",date_add("$date",interval 14 day))
;


-- Afficher la liste des livres empruntés:

select id_livre,id_adherent,titre,nom,prenom,date_debut,date_fin
from emprunt join livre
on id_livre = livre.id
join adherents
on id_adherent = adherents.id
-- Ici, on met la colonne `date_fin` entre ces symboles pour éviter toute source de conflit dans la lecture de la
-- requête.
where datediff(`date_fin`,now()) <0 ;