<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venus";

//Conexão bd
$conn = new mysqli($servername, $username, $password, $dbname);

//Verificar conexão
if($conn->connect_error)
{
    die(!"Houve um erro na conexão com o banco de dados". $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    //Verificar se existe
    $query = "SELECT id FROM jogadores WHERE nome = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0)
    {
        echo"Nome de usúario já existente! Escolha um novo nome!";
    }

    else
    {
        //inserir novos dados do usúario

        $query = "INSERT INTO jogadores (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nome, $email, $senha); 

        if($stmt->execute())
        {
            header("Location: Venus");
        }
        else
        {
            echo "Erro nno cadastro =(! Tente novamente!";
        }
    }

    $stmt->close();
    $conn->close();
}
?>