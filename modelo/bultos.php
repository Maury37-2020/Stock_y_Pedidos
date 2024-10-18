<?php 

class bultos{
    private $id;
    private $id_pedido;
    private $id_peso;
    private $id_tamanio;

    public function __construct($id = null, $id_pedido = null, $id_peso = null,$id_tamanio = null){
        $this->id = $id;
        $this->id_pedido = $id_pedido;
        $this->id_peso = $id_peso;
        $this->id_tamanio = $id_tamanio;
        
    }

    public function getId_peso()
    {
        return $this->id_peso;
    }
    public function getId_pedido()
    {
        return $this->id_pedido;
    }
    public function getId_tamanio()
    {
        return $this->id_tamanio;
    }

    public function insertar($id_pedido, $id_peso, $id_tamanio) {
        include "conexion.php";

        $insBulto = "INSERT INTO bultos (id_pedido, id_peso, id_tamanio) 
            VALUES ($id_pedido, $id_peso, $id_tamanio)";

        if (mysqli_query($conexion, $insBulto)) {
            $response = "ok";
        } else {
            $response = "Error: No se inserto el bulto. " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
        return $response;
    }
}

?>