<?php
session_start();
require 'conexao.php';

if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 4){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id_cliente= $_POST['id_cliente'];
    $nome= $_POST['nome'];
    $endereco= $_POST['endereco'];
    $telefone= $_POST['telefone'];
    $email= $_POST['email'];
    $id_funcionario_responsavel= $_POST['id_funcionario_responsavel'];
   

    //atualiza os dados do cliente
    $sql= "UPDATE cliente SET nome_cliente=:nome,endereco=:endereco,telefone=:telefone,email=:email,id_funcionario_responsavel=:id_funcionario_responsavel WHERE id_cliente=:id";
    $stmt= $pdo->prepare($sql);

    $stmt->bindParam(':nome',$nome);
    $stmt->bindParam(':endereco',$endereco);
    $stmt->bindParam(':telefone',$telefone);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':id_funcionario_responsavel',$id_funcionario_responsavel);
    $stmt->bindParam(':id',$id_cliente);

    if($stmt->execute()){
        echo "<script>alert('Cliente atualizado com sucesso!');window.location.href='buscar_cliente.php';</script>";
    }else{
        echo "<script>alert('Erro ao alterar cliente!');window.location.href='alterar_cliente.php';</script>";
    }
}
/*
    <address>
        <center>Jamilly Fróes- Estudante- Técnico de Desenvolvimento de Sistemas</center>
    </address>
*/
?>