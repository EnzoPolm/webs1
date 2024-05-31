<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alta_professorat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$codi_validacio = $_POST['codi_validacio'];
$dni = $_POST['dni'];
$nom = $_POST['nom'];
$primer_cognom = $_POST['primer_cognom'];
$segon_cognom = isset($_POST['segon_cognom']) ? $_POST['segon_cognom'] : '';
$data_naixement = $_POST['data_naixement'];
$email = $_POST['email'];
$telefon = $_POST['telefon'];
$tipus_estudis = $_POST['tipus_estudis'];
$nom_estudis = $_POST['nom_estudis'] == 'altres' ? $_POST['nom_estudis_altres'] : $_POST['nom_estudis'];
$tipus_estudis2 = isset($_POST['tipus_estudis2']) ? $_POST['tipus_estudis2'] : '';
$nom_estudis2 = isset($_POST['nom_estudis2']) && $_POST['nom_estudis2'] == 'altres' ? $_POST['nom_estudis2_altres'] : $_POST['nom_estudis2'];

if (!preg_match("/^[0-9]{8}[A-Za-z]$/", $dni)) {
    die("Error: Format de DNI incorrecte");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Format d'email incorrecte");
}

$foto = null;
if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
    $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
}

$sql = "SELECT * FROM dades_professors WHERE codi_validacio = '$codi_validacio'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sql_update = "UPDATE dades_professors SET DNI='$dni', nom='$nom', cognom1='$primer_cognom', cognom2='$segon_cognom', data_naixement='$data_naixement', email='$email', telefon='$telefon', tipus_estudi1='$tipus_estudis', nom_estudi1='$nom_estudis', tipus_estudi2='$tipus_estudis2', nom_estudi2='$nom_estudis2'";
    
    if ($foto !== null) {
        $sql_update .= ", foto='$foto'";
    }
    
    $sql_update .= " WHERE codi_validacio='$codi_validacio'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Registre actualitzat correctament";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
} else {
    $sql_insert = "INSERT INTO dades_professors (codi_validacio, DNI, nom, cognom1, cognom2, data_naixement, email, telefon, tipus_estudi1, nom_estudi1, tipus_estudi2, nom_estudi2, foto) VALUES ('$codi_validacio', '$dni', '$nom', '$primer_cognom', '$segon_cognom', '$data_naixement', '$email', '$telefon', '$tipus_estudis', '$nom_estudis', '$tipus_estudis2', '$nom_estudis2', '$foto')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Registre insertat correctament";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
