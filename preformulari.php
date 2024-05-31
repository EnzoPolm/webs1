<?php
require 'vendor/autoload.php';

$smtpHost = 'smtp.gmail.com';
$smtpPort = 587; 
$smtpUser = 'e.polm@sapalomera.cat';
$smtpPassword = 'Y2801446Z';

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "alta_professorat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexió fallida: " . $conn->connect_error);
}

$nom = $_POST['nom'];
$cognom1 = $_POST['cognom1'];
$cognom2 = $_POST['cognom2'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];

$codigo = uniqid();

$sql = "INSERT INTO dades_professors (nom, cognom1, cognom2, telefon, email, codi_validacio) VALUES ('$nom', '$cognom1', '$cognom2', '$telefono', '$correo', '$codigo')";

if ($conn->query($sql) === TRUE) {
    $mensaje = "Hola $nom $cognom1 $cognom2,\n\nEl teu codi de validació és: $codigo \n\n Pots emplenar el formulari complet aquí: http://localhost/formulari.html \n\n Pots trobar la nostra Política de Privacitat aquí: http://localhost/privacitat.html";
    $asunto = "Codi de validacio";
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUser;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port = $smtpPort;

    $mail->setFrom($smtpUser);
    $mail->addAddress($correo);

    $mail->Subject = $asunto;
    $mail->Body = $mensaje;

    if ($mail->send()) {
        echo "Correu enviat amb èxit";
    } else {
        echo "Error en l'enviament del correu: " . $mail->ErrorInfo;
    }
} else {
    echo "Error en el registre: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
