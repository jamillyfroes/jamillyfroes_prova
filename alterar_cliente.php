<?php
session_start ();
require_once 'conexao.php';

//verifica se o usuario tem permissao de adm
if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=4){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//inicializa variaveis 
$cliente = null;
if($_SERVER["REQUEST_METHOD"]== "POST"){
    if(!empty($_POST['busca_cliente'])){
        $busca= trim($_POST['busca_cliente']);

        //verifica se a busca é um numero(id) ou um nome
        if(is_numeric($busca)){
            $sql= "SELECT * FROM cliente WHERE id_cliente= :busca";
            $stmt= $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        }else{
            $sql= "SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome";
            $stmt= $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
        }

        $stmt->execute();
        $cliente= $stmt->fetch(PDO::FETCH_ASSOC);
        
        //se o usuario nao for encontrado, exibe um alerta
        if(!$cliente){
            echo "<script>alert('Cliente não encontrado!');</script>";
        }
    }
}

//obtendo o noe do perfil do usuario logado
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
    <title>Alterar Cliente</title>
    <link rel="stylesheet" href="styles.css">
    <!--Verifique se o javascript esta funcionando corretamente-->
    <script src="scripts.js"></script>
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
    <h2>Alterar Cliente</h2>

    <form action="alterar_cliente.php" method="POST">
        <label for="busca_cliente">Digite o ID ou nome do cliente</label>
        <input type="text" id="busca_cliente" name="busca_cliente" required onkeyup="buscarSugestoes()">
        <!--div para exibir sugestoes de usuarios-->
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
    </form>

    <?php if($cliente): ?>
    <!--formulario para alterar usuario-->
    <form action="processa_alteracao_cliente.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($cliente['id_cliente'])?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($cliente['nome_cliente'])?>">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($cliente['endereco'])?>">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?=htmlspecialchars($cliente['telefone'])?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?=htmlspecialchars($cliente['email'])?>">

        <label for="id_funcionario_responsavel">Funcionário Responsável</label>
        <select id="id_funcionario_responsavel" name="id_funcionario_responsavel" required>
            <option value="1" <?=$cliente['id_funcionario_responsavel']== 1 ?'select':''?>>João Silva</option>
            <option value="2" <?=$cliente['id_funcionario_responsavel']== 2 ?'select':''?>>Mariana Oliveira</option>
            <option value="3" <?=$cliente['id_funcionario_responsavel']== 3 ?'select':''?>>Roberto Santos</option>
            <option value="4" <?=$cliente['id_funcionario_responsavel']== 4 ?'select':''?>>Camila Ferreira</option>
            <option value="5" <?=$cliente['id_funcionario_responsavel']== 5 ?'select':''?>>Jesse Pinkman</option>
        </select>

        <button type="submit">Alterar</button>
        <button type="reset">Cancelar</button>
    </form>
    <?php endif; ?> 
    <a href="principal.php">Voltar</a>
    <br><br>
    <address>
        <center>Jamilly Fróes- Estudante- Técnico de Desenvolvimento de Sistemas</center>
    </address>
    <script src="meujs/alterarCliente.js"></script>
</body>
</html>