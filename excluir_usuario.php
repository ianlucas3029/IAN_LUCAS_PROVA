<?php 
session_start();
require_once 'conexao.php';
require 'navegacao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
If($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php'</script>";
    exit();
}

//INICIALIZA A VARIAVEL PARA ARMAZENAR USUARIOS
$usuarios = [];

//BUSCA TODOS OS USUARIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM ID FOR PASSADO VIA GET EXCLUIR O USUARIO
if(isset($_GET['id'])&& is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    //EXCLUI O USUARIO DO BANCO DE DADOS
    $sql = "DELETE FROM usuario WHERE id_usuario=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id',$id_usuario,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script>alert('Usuário deletado com sucesso!');window.location.href='excluir_usuario.php'</script>";
    }else{
        echo "<script>alert('Erro ao excluir usuário!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuário</title>

    <style>
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        
    }
    th, td {
        border: 1px solid #333;
        padding: 8px 12px;
        text-align: left;
    }
    th {
        background-color:rgb(35, 176, 201);
        color: white;
    }
    tr:nth-child(even) {
        background-color:rgb(172, 241, 243);
    }
    tr:hover {
        background-color: #ddd;
    }
        img{
            max-width:45px;
            margin-left:-20px;
        }
        .excluir{
  border: 1px solid #ccc;
  border-radius: 10px; 
  overflow: hidden; 
  border-collapse: collapse;
}

.excluir th,
.excluir td {
  border: 1px solid #ccc;
  padding: 10px;
}

img{
    max-width:30px;
    margin-left:20px;
}



</style>
</head>
<body>
    <h2 align="center">Excluir Usuário</h2>
    <?php if(!empty($usuarios)):?>
        <table  class="excluir" border ="1" align="center">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
        <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                <td><?=htmlspecialchars($usuario['nome'])?></td>
                <td><?=htmlspecialchars($usuario['email'])?></td>
                <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                <td>    
                    <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"onclick="return confirm('Tem certeza que deseja excluir este usuário?')">    <img src="imagem/excluir.png"></a>
                </td>
            </tr>
        <?php endforeach;?>
        </table>
    <?php else:?>
        <p>Nenhum usuário encontrado</p>
        <?php endif;?>
<br>
        <a href="principal.php">
    <img src="imagem/voltar.png">
    </a>
    <br>
    <center>
        <adress>
          Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </adress>
    </center>
</body>
</html>