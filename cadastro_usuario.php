<?php
session_start();
require_once 'conexao.php';
require 'navegacao.php';

// Verifica se o usuário tem permissão supondo que o perfil 1 sejá o admin
if($_SESSION['perfil'] != 1){
    echo "Acesso negado!";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];  
    $email = $_POST['email'];  
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);  
    $id_perfil = $_POST['id_perfil'];  
    
    $sql = "INSERT INTO usuario(nome,email,senha,id_perfil)
            VALUES (:nome,:email,:senha,:id_perfil)";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":nome",$nome);
    $stmt -> bindParam(":email",$email);
    $stmt -> bindParam(":senha",$senha);
    $stmt -> bindParam(":id_perfil",$id_perfil);
    
    if($stmt -> execute()){
        echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    } else{
        echo "<script>alert('Erro ao cadastrar usuário');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Cadastrar usuário</title>
    <style>
          img{
            max-width:45px;
        }
    </style>
</head>
<body>
     
     <h2>Cadastrar usuário</h2>

     <form action="cadastro_usuario.php" method="POST" onsubmit="return validar()">
        <label for="nome">Nome: </label>
        <input type="text" id="nome" name="nome" required/>

        <label for="email">E-mail: </label>
        <input type="email" id="email" name="email" required/>

        <label for="senha">Senha: </label>
        <input type="password" id="senha" name="senha" required/>

        <label for="id_perfil">Perfil: </label>
        <select id="id_perfil" name="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretária</option>
            <option value="3">Almoxarife</option>
            <option value="4">Cliente</option>
        </select>

        <div class="button">
        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
       </div>
     </form>
     
     <a href="principal.php"><img src="imagem/voltar.png"></a>
     <script>
function validar() {
  const nome = document.getElementById('nome').value.trim();
  const senha = document.getElementById('senha').value.trim();
  

  const nomeRegex = /^[A-Za-zÀ-ú\s]+$/;
  if (!nomeRegex.test(nome)) {
    alert('Nome inválido! Use apenas letras e espaços.');
    return false;
  }

  if (senha.length < 8  ) {
    alert('Senha deve ter pelo menos 8 caracteres.');
    return false;
  }

  return true; // tudo ok, envia form
}
</script>
<center>
        <adress>
            Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </adress>
    </center>
</body>
</html>