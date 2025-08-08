<?php
session_start();
require_once 'conexao.php';

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit(); 
}

//OBTENDO O NOME DO PERFIL DO USUARIO LOGADO 
$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil= $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['nome_perfil'];

//DEFINICAO DAS PERMISSOES POR PERFIL

$permissoes = [
     1 => ["Cadastrar"=>["cadastro_usuario.php", "cadastro_perfil.php","cadastro_cliente.php","cadastro_fornecedor.php", "cadastro_produto.php","cadastro_funcionario.php"],
     "Buscar"=>["buscar_usuario.php", "buscar_perfil.php","buscar_cliente.php","buscar_fornecedor.php", "buscar_produto.php","buscar_funcionario.php"],
     "Alterar"=>["alterar_usuario.php", "alterar_perfil.php","alterar_cliente.php","alterar_fornecedor.php", "alterar_produto.php","alterar_funcionario.php"],
     "Excluir"=>["exluir_usuario.php", "exluir_perfil.php","exluir_cliente.php","exluir_fornecedor.php", "exluir_produto.php","exluir_funcionario.php"]],


     2 => ["Cadastrar"=>["cadastro_cliente.php"],
     "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php", "buscar_produto.php"],
     "Alterar"=>[,"alterar_fornecedor.php", "alterar_produto.php"],
     "Excluir"=>[ "exluir_produto.php"]],

]





?>