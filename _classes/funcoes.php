<?php

/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09/10/15
 * Time: 15:04
 */

public
function trataErro($arquivo = NULL, $rotina = NULL, $numErro = NULL, $mensagem = NULL, $geraExcept = false)
{
    if ($arquivo == NULL) $arquivo = "não informado";
    if ($rotina == NULL) $rotina = "não informado";
    if ($numErro == NULL) $numErro = pg_last_error($this->conexao);
    if ($mensagem == NULL) $mensagem = pg_errormessage($this->conexao);

    $res = "Ocorreu um erro com em {$arquivo} ao {$rotina}. <br>Erro número {$numErro} - {$mensagem}.";

    if ($geraExcept) {
        die($res);
    } else {
        echo $res;
    }
}

public
function erroConsole($mensagem)
{
    echo '<script> console.log("' . $mensagem . '"); </script>';
}