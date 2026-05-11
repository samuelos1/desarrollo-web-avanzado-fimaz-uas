<?php
    //Clase para conectarnos a la base de datos con PDO.
    class DataBase{
        //Atributos
        private $host = "localhost";
        private $db = "ganadero";
        private $user = "root";
        private $password = "";

        public function __construct()
        {
            
        }
        //Método para conectar a la base de datos.
        public function connect(){
            try {
                $PDO = new PDO("mysql:host=".$this->host.";dbname=".$this->db,$this->user,
                $this->password);
                return $PDO;
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

    }

?>
