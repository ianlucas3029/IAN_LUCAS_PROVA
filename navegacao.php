<?php
$id_perfil = $_SESSION['perfil'];

$permissoes = [
    1 => [
        "cadastrar" => [
            'cadastro_usuario.php',
            'cadastro_perfil.php',
            'cadastro_cliente.php',
            "cadastro_fornecedor.php",
            "cadastro_produto.php",
            "cadastro_funcionario.php"
        ],
        "buscar" => [
            'buscar_usuario.php',
            'buscar_perfil.php',
            'buscar_cliente.php',
            "buscar_fornecedor.php",
            "buscar_produto.php",
            "buscar_funcionario.php"
        ],
        "alterar" => [
            'alterar_usuario.php',
            'alterar_perfil.php',
            'alterar_cliente.php',
            "alterar_fornecedor.php",
            "alterar_produto.php",
            "alterar_funcionario.php"
        ],
        "excluir" => [
            'excluir_usuario.php',
            'excluir_perfil.php',
            'excluir_cliente.php',
            "excluir_fornecedor.php",
            "excluir_produto.php",
            "excluir_funcionario.php"
        ],
    ],
    2 => [
        "cadastrar" => ['cadastro_cliente.php'],
        "buscar" => [
            'buscar_cliente.php',
            "buscar_fornecedor.php",
            "buscar_produto.php"
        ],
        "alterar" => [
                "alterar_fornecedor.php",
                "alterar_produto.php"
        ],
        "excluir" => ["excluir_produto.php"]
    ],
    3 => [
        "cadastrar" => ['cadastro_fornecedor.php','cadastro_produto.php'],
        "buscar" => ['buscar_cliente.php',"buscar_fornecedor.php","buscar_produto.php"],
        "alterar" => ["alterar_fornecedor.php","alterar_produto.php"],
        "excluir" => ["excluir_produto.php"]
    ],
    4 => [
        "cadastrar" => ['cadastro_cliente.php'],
        "buscar" => ["buscar_produto.php"],
        "alterar" => ["alterar_cliente.php"]
    ]
];

$opcoes_menu = $permissoes[$id_perfil];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="styles.css">

  <style>
    :root{
      --verde-agua:rgb(54, 184, 177);      /* principal */
      --verde-agua-escuro:#178f86; /* hover */
    }

    /* Barra do menu (topo) */
    nav{
      background: var(--verde-agua) !important;
      width: 100%;
    }

    /* Lista principal */
    nav ul.cascata{
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    nav ul.cascata > li{
      position: relative;
    }

    nav ul.cascata > li > a{
      display: block;
      padding: 14px 20px;
      color: #fff !important;
      text-decoration: none;
      font-weight: 600;
    }

    nav ul.cascata > li > a:hover{
      background: var(--verde-agua-escuro) !important;
    }

    /* Submenu (dropdown) */
    nav ul.cascata li ul.cascata{
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      min-width: 200px;
      background: var(--verde-agua) !important;
      box-shadow: 0 4px 10px rgba(0,0,0,.15);
      z-index: 9999;
    }

    nav ul.cascata li:hover > ul.cascata{
      display: block;
    }

    nav ul.cascata li ul.cascata li a{
      display: block;
      padding: 12px 16px;
      color: #fff !important;
      text-decoration: none;
      white-space: nowrap;
    }

    nav ul.cascata li ul.cascata li a:hover{
      background: var(--verde-agua-escuro) !important;
    }
  </style>
</head>
<body>
  <nav>
    <ul class="cascata">
      <?php foreach($opcoes_menu as $categoria => $arquivos): ?>
        <li class="cascata">
          <a href="#"><?= ucfirst($categoria) ?></a>
          <ul class="cascata">
            <?php foreach($arquivos as $arquivo): ?>
              <li>
                <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_"," ",basename($arquivo,".php"))) ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
</body>
</html>
