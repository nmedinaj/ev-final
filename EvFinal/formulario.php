<?php
    echo "<link rel='stylesheet' href='style.css'>";

    if($_POST){
        $nombre = $_POST["nombre"];
        $apellido1 = $_POST["apellido1"];
        $apellido2 = $_POST["apellido2"];
        $email = $_POST["email"];
        $login = $_POST["login"];
        $pass = $_POST["pass"];

        //Validar datos del formulario
        if(empty($nombre) || empty($apellido1) || empty($apellido2) || empty($email) || empty($login) || empty($pass)){
            die("No se pueden enviar campos vacíos");
            echo "<button onclick=\"window.location.href='/EvFinal\">Volver a formulario</button>";
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            die("El formato del campo email es incorrecto");
            echo "<button onclick=\"window.location.href='/EvFinal\">Volver a formulario</button>";
        } else if(strlen($pass) < 4 || strlen($pass) > 8) {
            die("La contraseña debe tener entre 4 y 8 caracteres");
            echo "<button onclick=\"window.location.href='/EvFinal\">Volver a formulario</button>";
        }

        try {       
        
            //Establecer conexión con BBDD
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "cursosql";

            $conn = new mysqli($servername, $username, $password, $dbname);

            //Comprobar conexión
            if($conn->connect_error){
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sql1 = "SELECT count(*) as num_emails FROM Usuarios WHERE email = '$email'";

            $result = $conn->query($sql1);        

            if($result->fetch_assoc()["num_emails"] == 0){
                $sql2 = "INSERT INTO Usuarios (nombre, apellido1, apellido2, email, login, password) VALUES ('$nombre', '$apellido1', '$apellido2', '$email', '$login', '$pass')";

                if($conn->query($sql2) === TRUE) {
                    echo "<p class='d-flex justify-content-end'>Registro completado con éxito</p>";
                    echo "<button class='btn' onclick=\"window.location.href='consulta.php'\">consulta</button>";
                } else {
                    echo "Error: " . $sql2 . " " . $conn->error;
                }
            }
            else {
                echo'<script type="text/javascript">
                    alert("Email ya ha sido registrado anteriormente");
                    window.location.href="/EvFinal";
                    </script>';
            }      

            //Cerrar conexión
            $conn -> close();

        } catch (Exception $e) {
            echo 'Se ha producido un error: ',  $e->getMessage(), "\n";
        }

    }
?>