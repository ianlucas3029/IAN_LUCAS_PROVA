<?php
session_start();
require_once 'conexao.php';

if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php'</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_fornecedor = $_POST['id_fornecedor'];
    $nome = $_POST['nome_fornecedor'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];

    $sql = "UPDATE fornecedor 
            SET nome_fornecedor = :nome,
                endereco = :endereco,
                telefone = :telefone,
                email = :email,
                contato = :contato
            WHERE id_fornecedor = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contato', $contato);
    $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);


    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor atualizado com sucesso!');window.location.href='buscar_fornecedor.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar fornecedor!');window.location.href='alterar_fornecedor.php?id=$id_fornecedor';</script>";
    }
}
?>
