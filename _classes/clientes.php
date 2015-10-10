<?php

/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09/10/15
 * Time: 10:52
 */
require_once("tabelabase.php");

class clientes extends tabelabase
{

    private $cid;
    private $cnome;
    private $csobrenome;

    public function __construct($id = NULL, $nome = NULL, $sobrenome = NULL)
    {
        parent::__construct();
        $this->tabela = "clientes";

        $this->setCid($id);
        $this->setCid($nome);
        $this->setCid($sobrenome);
    }

    public function impStatement($ds)
    {
        $this->setCid($ds['id']);
        $this->setCnome($ds['nome']);
        $this->setCsobrenome($ds['sobrenome']);
    }

    public function inserirBanco()
    {
        if ($this->getCid() == NULL) {
            $this->gerarCid();
        }

        $sql = "INSERT INTO aulas.clientes (id, nome, sobrenome) values (:id, :nome, :sobrenome)";
        $st = $this->getConexao()->prepare($sql);
        $st->bindValue(':id', $this->getCid(), PDO::PARAM_INT);
        $st->bindValue(':nome', $this->getCnome(), PDO::PARAM_STR);
        $st->bindValue(':sobrenome', $this->getCsobrenome(), PDO::PARAM_STR);

        $st->execute();

    }

    public function atualizarBanco()
    {
        $sql = "UPDATE aulas.clientes SET nome=:nome, sobrenome=:sobrenome WHERE id=:id ;";
        $st = $this->getConexao()->prepare($sql);
        $st->bindValue(':id', $this->getCid(), PDO::PARAM_INT);
        $st->bindValue(':nome', $this->getCnome(), PDO::PARAM_STR);
        $st->bindValue(':sobrenome', $this->getCsobrenome(), PDO::PARAM_STR);

        $st->execute();

    }

    public function excluirBanco()
    {
        $sql = "DELETE FROM aulas.clientes WHERE id=:id";
        $st = $this->getConexao()->prepare($sql);
        $st->bindValue(':id', $this->getCid(), PDO::PARAM_INT);

        $st->execute();

    }

    public function buscarClientes($tratamento = "")
    {
        $sql = "SELECT * FROM aulas.clientes " . $tratamento;
        $st = $this->getConexao()->prepare($sql);
        $st->execute();
        return $st;
    }

    public function buscarCliente()
    {
        $sql = "SELECT * FROM aulas.clientes where id = :id";
        $st = $this->getConexao()->prepare($sql);
        $st->bindValue(':id', $this->getCid(), PDO::PARAM_INT);
        $st->execute();
        return $st;
    }


    public function gerarCid()
    {
        $sql = "SELECT coalesce(max(clientes.id),0)+1 as novoid from aulas.clientes";
        $novoCid = $this->executaConsultaUnica($sql);
        $this->setCid($novoCid);
    }

    //GETTERS & SETTERS
    /**
     * @return null
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @param null $cid
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
    }

    /**
     * @return null
     */
    public function getCnome()
    {
        return $this->cnome;
    }

    /**
     * @param null $cnome
     */
    public function setCnome($cnome)
    {
        $this->cnome = $cnome;
    }

    /**
     * @return null
     */
    public function getCsobrenome()
    {
        return $this->csobrenome;
    }

    /**
     * @param null $csobrenome
     */
    public function setCsobrenome($csobrenome)
    {
        $this->csobrenome = $csobrenome;
    }



}