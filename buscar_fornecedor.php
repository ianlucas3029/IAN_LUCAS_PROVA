<?php 
session_start();
require_once 'conexao.php';
require 'navegacao.php';

//VERIFICA SE O USUÁRIO TEM PERMISSÃO DE adm OU secretária
if($_SESSION['perfil'] !=1 && $_SESSION['perfil']!=2){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

$fornecedores = []; //INICIALIZA A VARIÁVEL PARA EVITAR ERROS

//SE O FORMULÁRIO FOR ENVIADO, BUSCA O FORNECEDOR POR ID OU NOME
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);
    
    //VERIFICA SE A BUSCA É UM número OU nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome',"$busca%",PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Fornecedores</title>
    <link rel="stylesheet" href="styles.css"/>
    
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
        max-width: 800px;
        margin-top: 20px;
        font-family: Arial, sans-serif;
        border-radius: 3px;
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
    img {
        max-width:30px;
        margin-left:20px;
    }
    .buscar {
        border: 1px solid #ccc;
        border-radius: 10px; 
        overflow: hidden; 
        border-collapse: collapse;
    }

    .buscar th, .buscar td {
        border: 1px solid #ccc;
        padding: 10px;
    }
    </style>
</head>
<body>
    <h2>Lista de Fornecedores</h2>
    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou NOME(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if(!empty($fornecedores)): ?>
        <table class="buscar" border="1" align="center">
            <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Contato</th>
                    <th>Ações</th>
            </tr>
            <?php foreach($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                    <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['contato'])?></td>
                    <td>
                        <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>"><img src="imagem/alterar.png"></a>
                        <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')"><img src="imagem/excluir.png"></a>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor encontrado.</p>
    <?php endif; ?>

    <br>
    <a href="principal.php"><img src="imagem/voltar.png" alt="Voltar"></a>
    <br>
    <center>
        <address>
            Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </address>
    </center>
</body>
</html>