<?php
session_start();
require_once 'conexao.php';
require 'navegacao.php';

//VERIFICA SE O USUÁRIO TEM PERMISSÃO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
    exit();
}

//INICIALIZA VARIÁVEL
$fornecedor = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_fornecedor'])) {
        $busca = trim($_POST['busca_fornecedor']);

        if (is_numeric($busca)) {
            $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fornecedor) {
            echo "<script>alert('Fornecedor não encontrado!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Fornecedor</title>
    <link rel="stylesheet" href="styles.css"/>
    <style>
        img {
            max-width: 45px;
        }
    </style>
</head>
<body>
    <h2>Alterar Fornecedor</h2>

    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o ID ou o nome do fornecedor:</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required>
        <button type="submit">Pesquisar</button>
    </form>

    <?php if ($fornecedor): ?>
        <form action="processa_alteracao_fornecedor.php" method="POST" onsubmit="return validarAlteracao()">
            <input type="hidden" name="id_fornecedor" value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">

            <label for="nome_fornecedor">Nome do Fornecedor:</label>
            <input type="text" name="nome_fornecedor" id="nome_fornecedor" value="<?= htmlspecialchars($fornecedor['nome_fornecedor']) ?>" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" value="<?= htmlspecialchars($fornecedor['endereco']) ?>">

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" value="<?= htmlspecialchars($fornecedor['telefone']) ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($fornecedor['email']) ?>">

            <label for="contato">Contato:</label>
            <input type="text" name="contato" id="contato" value="<?= htmlspecialchars($fornecedor['contato']) ?>">

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <br>
    <a href="principal.php">
        <img src="imagem/voltar.png" alt="Voltar">
    </a>
    <br>

    <script>
    function validarAlteracao() {
        const nome = document.getElementById('nome_fornecedor').value.trim();
        const nomeRegex = /^[A-Za-zÀ-ú\s]+$/;

        if (nome.length < 3) {
            alert('O nome deve ter pelo menos 3 caracteres.');
            return false;
        }

        if (!nomeRegex.test(nome)) {
            alert('Nome inválido! Use apenas letras e espaços.');
            return false;
        }

        return true;
    }
    </script>

    <center>
        <address>
            Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </address>
    </center>
</body>
</html>