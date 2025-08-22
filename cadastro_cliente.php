<?php
session_start();
require_once 'conexao.php';

//verifica se o usuario tem permissao 
if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=4){
    echo "Acesso Negado!";
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome= $_POST['nome'];
    $endereco= $_POST['endereco'];
    $telefone= $_POST['telefone'];
    $email= $_POST['email'];
    $id_funconario_responsavel=  $_POST['id_funcionario_responsavel'];

    $sql= "INSERT INTO cliente(nome_cliente,endereco,telefone,email,id_funcionario_responsavel) VALUES (:nome,:endereco,:telefone,:email,:id_funcionario_responsavel)";
    $stmt= $pdo->prepare($sql);
    $stmt->bindParam(':nome',$nome);
    $stmt->bindParam(':endereco',$endereco);
    $stmt->bindParam(':telefone',$telefone);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':id_funcionario_responsavel',$id_funcionario_responsavel);

    if($stmt->execute()){
        echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
    }else{
        echo "<script>alert('Erro ao cadastrar Cliente!');</script>";
    }
}

//obtendo o nome do perfil do usuario logado
$id_perfil= $_SESSION['perfil'];
$sqlPerfil= "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil= $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil= $perfil['nome_perfil'];

//definição das permissoes por perfil

$permissoes=[
    1 =>["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente.php","cadastro_fornecedor.php","cadastro_produto.php","cadastro_funcionario.php"],
    "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php","buscar_funcionario.php"],
    "Alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente.php","alterar_fornecedor.php","alterar_produto.php","alterar_funcionario.php"],
    "Excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente.php","excluir_fornecedor.php","excluir_produto.php","excluir_funcionario.php"]],

    2 =>["Cadastrar"=>["cadastro_cliente.php"],
    "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
    "Alterar"=>["alterar_fornecedor.php","alterar_produto.php"],
    "Excluir"=>["excluir_produto.php"]],

    3 =>["Cadastrar"=>["cadastro_fornecedor.php","cadastro_produto.php"],
    "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
    "Alterar"=>["alterar_fornecedor.php","alterar_produto.php"],
    "Excluir"=>["excluir_produto.php"]],

    4 =>["Cadastrar"=>["cadastro_cliente.php"],
    "Buscar"=>["buscar_produto.php"],
    "Alterar"=>["alterar_cliente.php"]],
];

    //obtendo as opcoes disponiveis para o perfil logao
    $opcoes_menu= $permissoes[$id_perfil];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
        $('#telefone').mask('(00) 00000-0000');
        });
    </script>
</head>
<body>
<nav>
    <ul class="menu">
        <?php foreach($opcoes_menu as $categoria =>$arquivos):?>
            <li class="dropdown">
                <a href="#"><?=$categoria ?></a>
                <ul class="dropdown-menu">
                    <?php foreach($arquivos as $arquivo):?>
                        <li>
                            <a href="<?=$arquivo ?>"><?=ucfirst(str_replace("_"," ",basename($arquivo,".php")))?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
    <h2>Cadastrar Cliente</h2>
    <form action="cadastro_cliente.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="id_funcionario_responsavel">Funcionário Responsável</label>
        <select id="id_funcionario_responsavel" name="id_funcionario_responsavel">
            <option value="1">João Silva</option>
            <option value="2">Mariana Oliveira</option>
            <option value="3">Roberto Santos</option>
            <option value="4">Camila Ferreira</option>
            <option value="5">Jesse Pinkman</option>
        </select>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">Voltar</a>
    <br><br>
    <address>
        <center>Jamilly Fróes- Estudante- Técnico de Desenvolvimento de Sistemas</center>
    </address>
    <script src="meujs/cadCliente.js"></script>
</body>
</html>