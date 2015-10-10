<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

<?php
$pdo = new PDO("pgsql:host=localhost port=5432 dbname=aulas user=postgres password=1234"); //or die("Erro");


//$sql = "INSERT INTO aulas.clientes (id, nome, sobrenome) values (:id, :nome, :sobrenome)";
//$sql = "UPDATE aulas.clientes SET nome=:nome, sobrenome=:sobrenome WHERE id=:id ;";
//$sql = "DELETE FROM aulas.clientes WHERE id=:id";
$sql = "SELECT * FROM aulas.clientes where id < :id";
$st = $pdo->prepare($sql);
$st->bindValue(':id', 5, PDO::PARAM_INT);
$st->bindValue(':nome', 'Felipe', PDO::PARAM_STR);
$st->bindValue(':sobrenome', 'Kappke', PDO::PARAM_STR);

$st->execute();

if ($st->rowCount() >= 1) {
    $resultado = $st->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i <= count($resultado); $i++) {
        echo "<p> {$resultado[$i]['nome']}</p>";
    }
}


echo "<pre>";
var_dump($st->errorInfo());
echo "</pre>";

echo "ok";
?>
</body>
</html>