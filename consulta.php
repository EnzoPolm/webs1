<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Consulta de dades dels professors</title>
    <style>
        body {
            margin: 0;
            background: url('https://i.ibb.co/ncPqFV6/logo-institut-sapalomera.png') repeat;
            background-size: auto;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 90%;
            margin: 20px auto;
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
        }
        @media only screen and (max-width: 600px) {
            .container {
                max-width: 100%;
            }
        }
        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            z-index: -1;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Consulta de dades dels professors</h2>
        <table>
            <thead>
                <tr>
                    <th>Codi de validació</th>
                    <th>DNI</th>
                    <th>Nom</th>
                    <th>Primer cognom</th>
                    <th>Segon cognom</th>
                    <th>Data de naixement</th>
                    <th>Correu electrònic</th>
                    <th>Telèfon</th>
                    <th>Tipus d'estudis</th>
                    <th>Nom d'estudis</th>
                    <th>Tipus d'estudis 2</th>
                    <th>Nom d'estudis 2</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost"; 
                $username = "root"; 
                $password = ""; 
                $database = "alta_professorat";
                
                $conn = new mysqli($servername, $username, $password, $database);
                
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                
                $sql = "SELECT * FROM dades_professors";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["codi_validacio"] . "</td>";
                        echo "<td>" . $row["DNI"] . "</td>";
                        echo "<td>" . $row["nom"] . "</td>";
                        echo "<td>" . $row["cognom1"] . "</td>";
                        echo "<td>" . $row["cognom2"] . "</td>";
                        echo "<td>" . $row["data_naixement"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["telefon"] . "</td>";
                        echo "<td>" . $row["tipus_estudi1"] . "</td>";
                        echo "<td>" . $row["nom_estudi1"] . "</td>";
                        echo "<td>" . $row["tipus_estudi2"] . "</td>";
                        echo "<td>" . $row["nom_estudi2"] . "</td>";
                        echo '<td><img src="data:image/jpeg;base64,'.base64_encode($row["foto"]).'" alt="Foto"/></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No hay datos disponibles</td></tr>";
                }
            
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
