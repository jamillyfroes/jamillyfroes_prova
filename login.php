<?php
session_start();
require_once 'conexao.php';

if($_SERVER['REQUEST_METHOD']== "POST"){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE email = :email"
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($senha,$usuario['senha'])){
        //login bem sucedido define variaveis de sessao
        $_SESSION['usuario']= $usuario['nome'];
        $_SESSION['perfil']= $usuario['id_perfil'];
        $_SESSION['id_usuario']= $usuario['id_usuario'];

        ///verifica se a senha é temporaria
        
    }
}
?>