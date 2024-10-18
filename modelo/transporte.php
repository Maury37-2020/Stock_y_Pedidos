<?php

    class transporte {
        private $id;
        private $nombre;
        private $dni;
        private $telefono;

        public function __construct($id = 0, $nombre = "", $dni = "", $telefono = "") {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->dni = $dni;
            $this->telefono = $telefono;
        }

        public function insertar($nombre, $dni, $telefono) {
            include "conexion.php";

            $insTransporte = "INSERT INTO transporte (nombre, dni, telefono) 
                VALUES ($nombre, $dni, $telefono)";
            
            $response;
            if (mysqli_query($conexion,$insTransporte)){
                $response = "ok";
            } else {
                $response = "Error: No se inserto el trasponrte";
            }
            mysqli_close($conexion);
            return $response;
        }

    }
?>