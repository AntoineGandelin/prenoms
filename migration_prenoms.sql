BEGIN TRANSACTION;

CREATE TABLE tempo
    (
    sexe VARCHAR(1000),
    preusuel VARCHAR(1000),
    annais VARCHAR(1000),
    dpt VARCHAR(1000),
    nombre VARCHAR(1000)    
    );

copy tempo from 'C:/wamp64/www/projets/prenoms/migration_base/fic/dpt2020.csv' with csv delimiter ';' NULL '' encoding 'utf8';

insert into prenom (sexe, preusuel, annais, dpt, nombre) 
select sexe, preusuel, annais, dpt, nombre
    from tempo;

drop table tempo;    
commit;
vacuum full; 