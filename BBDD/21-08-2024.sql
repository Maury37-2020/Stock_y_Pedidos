-- Crear tabla provincias
CREATE TABLE provincias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);
-- Insertar todas las provincias
INSERT INTO provincias (nombre) VALUES ('Buenos Aires');
INSERT INTO provincias (nombre) VALUES ('Catamarca');
INSERT INTO provincias (nombre) VALUES ('Chaco');
INSERT INTO provincias (nombre) VALUES ('Chubut');
INSERT INTO provincias (nombre) VALUES ('Córdoba');
INSERT INTO provincias (nombre) VALUES ('Corrientes');
INSERT INTO provincias (nombre) VALUES ('Entre Ríos');
INSERT INTO provincias (nombre) VALUES ('Formosa');
INSERT INTO provincias (nombre) VALUES ('Jujuy');
INSERT INTO provincias (nombre) VALUES ('La Pampa');
INSERT INTO provincias (nombre) VALUES ('La Rioja');
INSERT INTO provincias (nombre) VALUES ('Mendoza');
INSERT INTO provincias (nombre) VALUES ('Misiones');
INSERT INTO provincias (nombre) VALUES ('Neuquén');
INSERT INTO provincias (nombre) VALUES ('Río Negro');
INSERT INTO provincias (nombre) VALUES ('Salta');
INSERT INTO provincias (nombre) VALUES ('San Juan');
INSERT INTO provincias (nombre) VALUES ('San Luis');
INSERT INTO provincias (nombre) VALUES ('Santa Cruz');
INSERT INTO provincias (nombre) VALUES ('Santa Fe');
INSERT INTO provincias (nombre) VALUES ('Santiago del Estero');
INSERT INTO provincias (nombre) VALUES ('Tierra del Fuego');
INSERT INTO provincias (nombre) VALUES ('Tucumán');


-- Crear tabla localidad
CREATE TABLE localidad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cod_postal_corto VARCHAR (20) NOT NULL,
    cod_postal_largo VARCHAR (20) NULL,
    id_provincia INT,
    FOREIGN KEY (id_provincia) REFERENCES provincias(id)
);


-- INSERT INTO localidad(nombre,cod_postal_corto,cod_postal_largo,id_provincia) VALUES('Sunchales',2322,null,20);


-- Eliminar Cod_postal
ALTER TABLE direcciones_destinatarios
DROP COLUMN codigo_postal;
-- Eliminar Provincia
ALTER TABLE direcciones_destinatarios
DROP COLUMN provincia;
-- Eliminar Ciudad
ALTER TABLE direcciones_destinatarios
DROP COLUMN ciudad;


ALTER TABLE  direcciones_destinatarios
ADD COLUMN id_localidad INT;


ALTER TABLE direcciones_destinatarios
ADD CONSTRAINT id_localidad 
FOREIGN KEY (id_localidad) 
REFERENCES localidad(id);

