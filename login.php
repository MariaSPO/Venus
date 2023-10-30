<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venus";

//conexão db
$conn = new mysqli($servername, $username, $password, $dbname);

//verificação de conexão
if ($conn->connect_error) {
    die("Falha na conexão!". $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) 
    {
        $stmt->bind_result($user_id, $user_email, $user_senha);
        $stmt->fetch();

        //Verificar senha
        if(password_verify($senha, $user_password))
        {
            session_start();
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_email"] = $user_email;
            header("Location: venus"); //Redireciona para a pagina do venus
        }

        else
        {
            echo"Senha incorreta =(! Tnte de novo!";
        }
        
    }

    else
    {
        echo "Nome de usuáario não encontrado. Registre-se agora =D!";
    }

    $stmt->close();
    $conn->close();
}
?>