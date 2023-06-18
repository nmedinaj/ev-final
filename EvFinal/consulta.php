<?php
    echo "<link rel='stylesheet' href='style.css'>";

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

    $sql = "SELECT * FROM Usuarios";

    $result = $conn->query($sql);        

    if($result->num_rows > 0){
        echo "<h2>Listado de usuarios</h2>";
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Email</th><th>Login</th></tr>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Nombre'] . "</td>";
            echo "<td>" . $row['Apellido1'] . "</td>";
            echo "<td>" . $row['Apellido2'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['Login'] . "</td>";
            echo "</tr>";
        }
    
        echo "</table>";           
    }
        else {
        echo "No hay usuarios registrados";
    }      

    //Cerrar conexión
    $conn -> close();
?>