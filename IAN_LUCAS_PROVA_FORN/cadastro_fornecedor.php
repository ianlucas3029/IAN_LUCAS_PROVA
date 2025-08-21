<?php
session_start();
require_once 'conexao.php';
require 'navegacao.php';

// Verifica se o usuário tem permissão (perfil 1 = admin)
if ($_SESSION['perfil'] != 1) {
    echo "Acesso negado!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_fornecedor = $_POST['nome_fornecedor'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];

    $sql = "INSERT INTO fornecedor (nome_fornecedor, endereco, telefone, email, contato)
            VALUES (:nome_fornecedor, :endereco, :telefone, :email, :contato)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nome_fornecedor", $nome_fornecedor);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":contato", $contato);

    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar fornecedor.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Cadastrar Fornecedor</title>
    <style>
        img {
            max-width: 45px;
        }
    </style>
</head>
<body>
    <h2>Cadastrar Fornecedor</h2>

    <form action="cadastro_fornecedor.php" method="POST" onsubmit="return validar()">
        <label for="nome_fornecedor">Nome do Fornecedor:</label>
        <input type="text" id="nome_fornecedor" name="nome_fornecedor" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email">

        <label for="contato">Contato:</label>
        <input type="text" id="contato" name="contato">


        <div class="button">
            <button type="submit">Salvar</button>
            <button type="reset">Cancelar</button>
        </div>
    </form>

    <a href="principal.php"><img src="imagem/voltar.png" alt="Voltar"></a>

    <script>
        function validar() {
            const nome = document.getElementById('nome_fornecedor').value.trim();
            const telefone = document.getElementById('telefone').value.trim();
            const email = document.getElementById('email').value.trim();

            const nomeRegex = /^[A-Za-zÀ-ú\s]+$/;
            const telefoneRegex = /^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!nomeRegex.test(nome)) {
                alert('Nome do fornecedor inválido! Use apenas letras e espaços.');
                return false;
            }

            if (telefone && !telefoneRegex.test(telefone)) {
                alert('Telefone inválido! Use o formato (00) 00000-0000.');
                return false;
            }

            if (email && !emailRegex.test(email)) {
                alert('E-mail inválido!');
                return false;
            }

            return true;
        }
    </script>

    <center>
        <address>
            Ian Lucas Borba - Técnico de Desenvolvimento de Sistemas
        </address>
    </center>
</body>
</html>
