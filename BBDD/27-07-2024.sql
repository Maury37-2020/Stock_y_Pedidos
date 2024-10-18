USE compostela;

-- Cambios tabla bultos
DROP TABLE bultos;

CREATE TABLE bultos(
id INT AUTO_INCREMENT PRIMARY KEY,
id_pedido INT NOT NULL,
id_peso INT NOT NULL,
id_tamanio INT NOT NULL,
FOREIGN KEY (id_pedido) REFERENCES pedidoscab (id),
FOREIGN KEY (id_peso) REFERENCES pesos (id),
FOREIGN KEY (id_tamanio) REFERENCES tamanios (id)
);

-------------------------------

-- Modificacion en tabla destinatarios (se agrega mail);

ALTER TABLE destinatarios 
ADD COLUMN mail VARCHAR(100);

-- Modificacion en tabla direcciones_destinatarios (se agrega ciudad y horarios de recepcion)

ALTER TABLE direcciones_destinatarios
ADD COLUMN ciudad VARCHAR(80);

ALTER TABLE direcciones_destinatarios
ADD COLUMN horario_desde VARCHAR(40);

ALTER TABLE direcciones_destinatarios
ADD COLUMN horario_hasta VARCHAR(40);

