<?php
/**
 * Classe base para as classes das Tabelas
 */

require_once("banco.php");

abstract class tabelabase extends banco
{
    public $tabela = "";
    public $camposValores = array();
    public $camposPK = array();
    public $extrasSelect = "";

    public function addCampo($campo = NULL, $valor = NULL)
    {
        if ($campo != NULL) {
            $this->camposValores[$campo] = $valor;
        }
    }

    public function delCampo($campo)
    {
        if (array_key_exists($campo, $this->camposValores)) {
            unset($this->camposValores[$campo]);
        }
    }

    public function setValor($campo = NULL, $valor = NULL)
    {
        if ($campo != NULL && $valor != NULL) {
            $this->camposValores[$campo] = $valor;
        }
    }

    public function getValor($campo = NULL)
    {
        if ($campo != NULL && array_key_exists($campo, $this->camposValores)) {
            return $this->camposValores[$campo];
        } else {
            return false;
        }

    }

    public function inserir()
    {
        /*
        $campos = array_merge($this->camposPK, $this->camposValores);
        if ($campos==NULL){
            return false;
        }

        reset($campos);

        $sql = "INSERT INTO {$this->banco}.{$this->tabela} (";

        for ($i = 0; $i < count($campos); $i++) {
            $sql .= key($campos);
            if ($i < count($campos) - 1) {
                $sql .= ", ";
            }
            next($campos);
        }

        reset($campos);

        $sql .= ") VALUES (";



        $sql .= str_repeat("?, ", sizeof($campos)-1);
        $sql .= "?);";

        $con = pg_connect("host={$this->servidor} port={$this->porta} dbname={$this->banco} user={$this->usuario} password={$this->senha}"); //or die("Erro");
        $con->


        for ($i = 0; $i < count($this->camposValores); $i++) {
            if (is_numeric($this->camposValores[key($this->camposValores)])) {
                $sql .= $this->camposValores[key($this->camposValores)];
            } else {
                $sql .= "'" . $this->camposValores[key($this->camposValores)] . "'";
            }


            if ($i < count($this->camposValores) - 1) {
                $sql .= ", ";
            }
            next($this->camposValores);
        }

        $this->delCampo($this->campoPK);

        $sql .= ");";
        echo $sql;
        //return $this->executaSQL($sql);
        */
    }

    public function alterar()
    {
        $sql = "UPDATE {$this->banco}.{$this->tabela} SET ";
        reset($this->camposValores);
        for ($i = 0; $i < count($this->camposValores); $i++) {

            $sql .= key($this->camposValores) . " = ";

            if (is_numeric($this->camposValores[key($this->camposValores)])) {
                $sql .= $this->camposValores[key($this->camposValores)];
            } else {
                $sql .= "'" . $this->camposValores[key($this->camposValores)] . "'";
            }
            if ($i < count($this->camposValores) - 1) {
                $sql .= ", ";
            }
            next($this->camposValores);
        }

        $sql .= " WHERE " . $this->tabela . "." . $this->campoPK . " = " . $this->valorPK;

        /*if (is_numeric($objeto->campoPK[key($objeto->campoPK)])) {
            $sql .= $objeto->campoPK[key($objeto->campoPK)];
        } else {
            $sql .= "'".$objeto->campoPK[key($objeto->campoPK)]."'";
        }*/

        ////


        $sql .= ";";
        echo $sql;
        //return $this->executaSQL($sql);


    }

    public function deletar()
    {
        reset($this->camposValores);
        $sql = "DELETE FROM  {$this->banco}.{$this->tabela} ";


        $sql .= " WHERE " . $this->tabela . "." . $this->campoPK . " = " . $this->valorPK;

        /*if (is_numeric($objeto->campoPK[key($objeto->campoPK)])) {
            $sql .= $objeto->campoPK[key($objeto->campoPK)];
        } else {
            $sql .= "'".$objeto->campoPK[key($objeto->campoPK)]."'";
        }*/

        ////

        $sql .= ";";
        echo $sql;
        //return $this->executaSQL($sql);


    }

    public function executaSelect($sql = NULL)
    {
        $querry = $this->executaSQL($sql);
        $this->dataset = $querry;
        return $querry;
    }

    public function selecionarTudo($objeto)
    {
        $sql = "SELECT * FROM " . $objeto->banco . "." . $objeto->tabela . " ";
        if ($objeto->extrasSelect != NULL) {
            $sql .= $objeto->extrasSelect;
        }

        $sql .= ";";

        $this->executaSelect($sql);
    }

    public function selecionarCampos($objeto)
    {
        $sql = "SELECT ";

        for ($i = 0; $i < count($objeto->camposValores); $i++) {
            $sql .= key($objeto->camposValores);
            if ($i < count($objeto->camposValores) - 1) {
                $sql .= ", ";
            }
            next($objeto->camposValores);
        }


        $sql .= " FROM " . $objeto->banco . "." . $objeto->tabela . " ";
        if ($objeto->extrasSelect != NULL) {
            $sql .= $objeto->extrasSelect;
        }

        $sql .= ";";

        $o = $this->executaSelect($sql);
    }

}