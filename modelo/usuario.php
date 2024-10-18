<?php 
    class Usuario {
        private $id;
        private $nombre;
        private $mail;
        private $password;
        private $rol;

        public function __construct($id=null, $nombre=null, $mail=null, $password=null, $rol=null) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->mail = $mail;
            $this->password = $password;
            $this->rol = $rol;
        }

        public function getID(){
            return $this->id;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getRol(){
            return $this->rol;
        }
        public function setID($id)  {
            $this->id = $id;
        }

        public function setNombre($nombre){
            $this->nombre=$nombre;
        }

        public function setMail($mail){
            $this->mail = $mail;
        }
        
        public function setPassword($password){
            $this->password = $password;
        }

        public function setRol($rol){
            $this->rol = $rol;
        }
    
        public function existeUsuario(){
            include 'conexion.php';

            $rsUsuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '" . $this->mail . 
                "' and password = '" . $this->password . "'") or
                die("Problemas en el select de login:" . mysqli_error($conexion));
            
            if($rsUsuario->num_rows==0){
                return false;
            }
            $dbUsuario = mysqli_fetch_array($rsUsuario);
            $this->id = $dbUsuario['id'];
            $this->nombre = $dbUsuario['nombre'];
            $this->rol = $dbUsuario['rol'];
            mysqli_close($conexion);
            return true;
        }
        
        public function cambiarPassword(){
            include 'conexion.php';

            $updPassword = "UPDATE usuarios SET password = '" . $this->password . "' WHERE id = " . $this->id;

            mysqli_query($conexion, $updPassword) or
             die("Problemas en el update de actualizacion de password:" . mysqli_error($conexion));
            mysqli_close($conexion);
            return true;
        }

        public function insertarUsurio() {

            include 'conexion.php';
            
            $insQuery = "INSERT INTO usuarios VALUES(default,'" . $this->mail . "','" . $this->nombre . "','" . 
                $this->password . "','" . $this->rol . "');";
            
            //echo $insQuery;
            
            mysqli_query($conexion, $insQuery);
            
            
        }

        public function modificarUsuario(){

            include 'conexion.php';

            $qryUpdate = "UPDATE usuarios SET nombre='" . $this->nombre . "', email='" . $this->mail . 
                        "', password='" . $this->password . "', rol='" . $this->rol . "' where id=" . $this->id ;
            
            //echo $qryUpdate; 

            mysqli_query($conexion, $qryUpdate);
        }

        public function seleccionarUsuario(){

            include 'conexion.php';

            $qrySelect = "SELECT * FROM usuarios WHERE id=" . $this->id;

            $rsUsuario = mysqli_query($conexion, $qrySelect);

            return $rsUsuario;

        }

    }
?>