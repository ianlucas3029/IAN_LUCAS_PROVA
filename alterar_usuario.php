<?php
session_start();
require_once 'conexao.php';
require 'navegacao.php';
//VERIFICA SE O USUÁRIO TEM PERMISSÃO DE ADM
if($_SESSION['perfil'] !=1){
    echo "<script>alert('Acesso Negado!');window.location.href='principal.php';</script>";
exit();
}
//INICIALIZA VARIAVEIS
$usuario = null;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(!empty($_POST['busca_usuario'])){
        $busca = trim($_POST['busca_usuario']);

        //VERIFICA SE A BUSCA É UM NÚMERO (ID) OU UM NOME
        if(is_numeric($busca)){
            $sql = "SELECT * FROM usuario WHERE id_usuario =:busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        }else{
            $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
        }
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        //SE O USUARIO NÃO FOR ENCOTRADO, EXIBE UM ALERTA
        if(!$usuario){
            echo "<script>alert('Usuário não encontrado!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="styles.css"/>
    <!--CERTIFIQUE-SE DE QUE O JAVASCRIPT ESTÁ SENDO CARREGADO CORRETAMENTE-->
    <style>
        img{
            max-width:45px;
        }
        
    </style>
</head>
<body>
    <h2>Alterar Usuário</h2>

    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou o nome do usuário: </label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">

    <!--DIV PARA EXIBIR SUGESTÕES DE USUÁRIOS-->
    <div id="sugestoes"></div>
    <button type="submit">Pesquisar</button>

    </form>
    <?php if($usuario): ?>
        <!--FORMULÁRIO PARA ALTERAR USUÁRIO-->
        <form action="processa_alteracao_usuario.php" method="POST" onsubmit="return validarAlteracao()">
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">

            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" value="<?=htmlspecialchars($usuario['nome'])?>" required> 

            <label for="email">Email: </label>
            <input type="email" name="email" id="email" value="<?=htmlspecialchars($usuario['email'])?>" required>       
        
            <label for="id_perfil">Perfil: </label>
            <select id="id_perfil" name="id_perfil">
                <option value="1"<?=$usuario['id_perfil']== 1?'select':''?>>Admnistrador</option>
                <option value="2"<?=$usuario['id_perfil']== 2?'select':''?>>Secretaria</option>
                <option value="3"<?=$usuario['id_perfil']== 3?'select':''?>>Almoxarife</option>
                <option value="4"<?=$usuario['id_perfil']== 4?'select':''?>>Cliente</option>
            </select>
            <!--SE O USUARIO LOGADO FOR UM ADM, EXIBIR OPCAO DE ALTERAR SENHA-->
            <?php if($_SESSION['perfil']==1): ?>
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha">
            <?php endif;?>

                <button type="submit">Alterar</button>
                <button type="reset">Cancelar</button>
        </form>
    <?php endif;?>
    <br>
    <a href="principal.php">
    <img src="imagem/voltar.png">
    </a>
    </form>
    <br>
<script>
function validarAlteracao() {
    const nome = document.getElementById('nome').value.trim();
    const senhaInput = document.getElementById('nova_senha');
    const senha = senhaInput ? senhaInput.value.trim() : '';

    const nomeRegex = /^[A-Za-zÁ-ÉÍ-ÓÚá-éí-óúÂ-Ûâ-ûÃ-Õã-õÇç\s]+$/;

    if (nome.length < 3) {
        alert('O nome deve ter pelo menos 3 caracteres.');
        return false;
    }

    if (!nomeRegex.test(nome)) {
        alert('Nome inválido! Use apenas letras e espaços.');
        return false;
    }

    if (senha !== '' && senha.length < 6) {
        alert('A nova senha deve ter pelo menos 6 caracteres.');
        return false;
    }

    return true;
}
</script>


    <center>
        <adress>
            Ian Lucas Borba - Técnico de desenvolvimento de sistemas
        </adress>
    </center>
</body>
</html>