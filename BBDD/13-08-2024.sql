-- Crear columna transporte_id
ALTER TABLE pedidoscab
ADD COLUMN transporte_id INT;

-- Relaciones transporte_id a tabla transporte
ALTER TABLE pedidoscab
ADD CONSTRAINT transporte_id
FOREIGN KEY (transporte_id) REFERENCES transportes(id);