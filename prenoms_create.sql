BEGIN TRANSACTION;

CREATE TABLE prenom
    (
    id_prenom SERIAL PRIMARY KEY,
    sexe VARCHAR(1000),
    preusuel VARCHAR(1000),
    annais VARCHAR(1000),
    dpt VARCHAR(1000),
    nombre VARCHAR(1000)
    );

COMMIT;
