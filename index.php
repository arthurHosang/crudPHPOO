<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="_css/css.css">
</head>
<body>

<?php
require_once("_classes/clientes.php");
echo "<p class='sucesso'>Conectado com Sucesso!</p>";

$c = new clientes();

$c->setCid(6);
//$c->setCnome('Hellen');
//$c->setCsobrenome("Borba");

//$c->inserirBanco();
//$c->atualizarBanco();
$c->excluirBanco();

$st = $c->buscarClientes();
echo $st->rowCount() . " resultados encontrados.";
if ($st->rowCount() >= 1) {
    $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
    //$resultado[$i]['id']

    for ($i = 0; $i < count($resultado); $i++) {
//       echo "<p> {$c->getCid()} - {$c->getCnome()}<p>";
        $c->impStatement($resultado[$i]);
        echo "<p> {$c->getCid()} - {$c->getCnome()}<p>";
        //next($st);
    }
}

echo "<hr><pre>";
var_dump($st);
echo "</pre>";
?>
</body>
</html>
