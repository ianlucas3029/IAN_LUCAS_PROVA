<?php 
session_start();
require_once 'conexao.php';
require 'navegacao.php';

//VERIFICA SE O USUÁRIO TEM PERMISSÃO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php'</script>";
    exit();
}

// EXCLUI FORNECEDOR SE ID FOR PASSADO
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_fornecedor = $_GET['id'];

    $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor deletado com sucesso!');window.location.href='excluir_fornecedor.php'</script>";
    } else {
        echo "<script>alert('Erro ao excluir fornecedor!');</script>";
    }
}

// BUSCA TODOS OS FORNECEDORES
$sql = "SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Fornecedor</title>
    <link rel="stylesheet" href="styles.css"/>

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
            background-color: rgb(35, 176, 201);
            color: white;
        }
        tr:nth-child(even) {
            background-color: rgb(172, 241, 243);
        }
        tr:hover {
            background-color: #ddd;
        }
        .excluir {
            border: 1px solid #ccc;
            border-radius: 10px; 
            overflow: hidden; 
            border-collapse: collapse;
        }
        .excluir th, .excluir td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        img {
            max-width: 30px;
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <h2 align="center">Excluir Fornecedor</h2>

    <?php if (!empty($fornecedores)): ?>
        <table class="excluir" border="1" align="center">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?= htmlspecialchars($fornecedor['id_fornecedor']) ?></td>
                    <td><?= htmlspecialchars($fornecedor['nome_fornecedor']) ?></td>
                    <td><?= htmlspecialchars($fornecedor['endereco']) ?></td>
                    <td><?= htmlspecialchars($fornecedor['telefone']) ?></td>
                    <td><?= htmlspecialchars($fornecedor['email']) ?></td>
                    <td><?= htmlspecialchars($fornecedor['contato']) ?></td>
                    <td>
                        <a href="excluir_fornecedor.php?id=<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                            <img src="imagem/excluir.png" alt="Excluir">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p align="center">Nenhum fornecedor encontrado.</p>
    <?php endif; ?>

    <br>
    <a href="principal.php">
        <img src="imagem/voltar.png" alt="Voltar">
    </a>
    <br>
    <center>
        <address>
            Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </address>
    </center>
</body>
</html>