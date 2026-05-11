<?php //Incluimos nuestro archivo de base de datos
    require_once("../../config/DataBase.php");

    class animalModel {
        public $PDO;

        public function __construct()
        {
            //Declaramos la variable para conexión a la Base de datos.
            //Instanciamos la clase DataBase.
            $conecction = new DataBase();
            //Llamamos al método connect y lo asignamos a nuestra
            //variable $PDO.
            $this->PDO = $conecction->connect();
        }

        //Método para hacer un INSERT en la Base de datos, en la tabla "animales".
        public function insert($nombre, $sexo, $raza, $edad, $peso, $vacunas, $dueno,
        $fechaNacimiento, $usuario, $contrasena){
            
            $statement = $this->PDO->prepare("INSERT INTO animales VALUES(null, :nombre,
            :sexo, :raza, :edad, :peso, :vacunas, :dueno, CURDATE(), :fechaNacimiento,
            :usuario, :contrasena)");
            //Asociamos los valores colocados como placeholder en el query mediante el bindParam().
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":sexo", $sexo);
            $statement->bindParam(":raza", $raza);
            $statement->bindParam(":edad", $edad);
            $statement->bindParam(":peso", $peso);
            $statement->bindParam(":vacunas", $vacunas);
            $statement->bindParam(":dueno", $dueno);
            $statement->bindParam(":fechaNacimiento", $fechaNacimiento);
            $statement->bindParam(":usuario", $usuario);
            $statement->bindParam(":contrasena", $contrasena);
            //Ejecutamos el statement (execute). Valoraremos mediante un shorthand lo que regresará este método.
            return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
        }

        //Método para obtener todos los registros de la tabla animales.
        public function read(){
            $statement = $this->PDO->prepare("SELECT * FROM animales");
            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return ($rows) ? $rows : false;
        }

        //Método para obtener un solo registro de la tabla animales por id.
        public function readOne($id){
            $statement = $this->PDO->prepare("SELECT * FROM animales WHERE id = :id");
            $statement->bindParam(":id", $id);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            return ($row) ? $row : false;
        }

        //Método para actualizar un registro de la tabla animales.
        public function update($id, $nombre, $sexo, $raza, $edad, $peso, $vacunas, $dueno,
        $fechaNacimiento){
            $statement = $this->PDO->prepare("UPDATE animales SET
            nombre = :nombre,
            sexo = :sexo,
            raza = :raza,
            edad = :edad,
            peso = :peso,
            vacunas = :vacunas,
            dueno = :dueno,
            fechaNacimiento = :fechaNacimiento
            WHERE id = :id");
            $statement->bindParam(":id", $id);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":sexo", $sexo);
            $statement->bindParam(":raza", $raza);
            $statement->bindParam(":edad", $edad);
            $statement->bindParam(":peso", $peso);
            $statement->bindParam(":vacunas", $vacunas);
            $statement->bindParam(":dueno", $dueno);
            $statement->bindParam(":fechaNacimiento", $fechaNacimiento);
            return ($statement->execute()) ? true : false;
        }

        //Método para eliminar un registro de la tabla animales por id.
        public function delete($id){
            $statement = $this->PDO->prepare("DELETE FROM animales WHERE id = :id");
            $statement->bindParam(":id", $id);
            return ($statement->execute()) ? true : false;
        }

        //Método para encriptar contraseña.
        public function passwordEncrypt($password){
            $passwordEncrypted = password_hash($password, PASSWORD_DEFAULT);
            return $passwordEncrypted;
        }

        //Método para verificar si la password introducida corresponde con la encriptada.
        public function passwordDencryted($passwordEncrypted, $passwordCandidate){
            return (password_verify($passwordCandidate, $passwordEncrypted)) ? true : false;
        }

    }

?>
