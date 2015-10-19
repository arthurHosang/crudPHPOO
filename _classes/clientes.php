<?php

require_once("tabelabase.php");

class pessoas extends tabelabase
{
    private $ci_clientes;
    private $cnome;
    private $csobrenome;


    public function __construct($id = NULL, $nome = NULL, $sobrenome = NULL, $cpf = NULL, $telefone = NULL, $email = NULL, $dataNasc = NULL, $endereco = NULL, $iplanos = NULL)
    {
        parent::__construct();
        $this->setSchema("aulas");
        $this->setTabela("pessoas");

        $this->ci_clientes = $id;
        $this->cnome = $nome;
        $this->csobrenome = $sobrenome;
    }

    /**
     * Insere nas Propriedades da Classe as informações do DataSet informado por parâmetro
     * @param FETCH_ASSOC $ds Vetor na estrutura PDO::FETCH_ASSOC. Pode ser obtido pela executção de $pdo->prepare($sql)->execute()->fetch(PDO::FETCH_ASSOC);
     * @return null
     */
    public function importarDataset($ds)
    {
        $this->ci_clientes = ($ds['i_clientes']);
        $this->cnome = $ds['nome'];
        $this->csobrenome = $ds['sobrenome'];

        /*
         * Busca de FKs
         * $b = new banco();
        $st = $b->executarSQL("SELECT planos.descricao, planos.valor
                                FROM aulas.clientes
                                  LEFT JOIN aulas.planos ON (pessoas.i_planos = planos.i_planos)
                                WHERE pessoas.i_clientes = :i_clientes", array(":i_clientes" => $this->getCiclientes()));
        $ds = $st->fetch(PDO::FETCH_ASSOC);

        $this->fdescricaoContratoVigente = $ds['descricao'];
        unset($b);*/
    }

    /**
     * Função complementar a inserirBanco() e atualizarBanco().
     * Esta função executa processos que são comuns as duas funções citadas anteriormente.
     * @param FETCH_ASSOC $ds Vetor na estrutura PDO::FETCH_ASSOC. Pode ser obtido pela executção de $pdo->prepare($sql)->execute()->fetch(PDO::FETCH_ASSOC);
     * @return mixed
     */
    private function gravarBanco($sql)
    {

        $params = array();
            $params = array(':i_clientes' => $this->getCiclientes(),
                ':nome' => $this->getCnome(),
                ':sobrenome' => $this->getCsobrenome());
        
        $st = $this->executarSQL($sql, $params);
        if ($st->rowCount() >= 1) {
            return true;
        } else {
            return $st;
        }
    }

    /**
     * Insere as informações no Banco de Dados
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public function inserirBanco()
    {
        if (($this->getCiclientes() == NULL) || !(is_numeric($this->getCiclientes()))) {
            $this->setCiclientes($this->gerarCi_clientes());
        }

        $sql = "INSERT INTO aulas.clientes (i_clientes, nome, sobrenome) VALUES (:i_clientes, :nome, :sobrenome)";
        
        return $this->gravarBanco($sql);
    }

    /**
     * Atualiza o Banco com as informações da Classe
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public function atualizarBanco()
    {
        $sql = "UPDATE aulas.clientes SET nome=:nome, sobrenome=:sobrenome WHERE pessoas.i_clientes=:i_clientes;";

        return $this->gravarBanco($sql);
    }

    /**
     * Exclui o Registro atual do Banco
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public function excluirBanco()
    {
        $sql = "DELETE FROM aulas.clientes WHERE pessoas.i_clientes = :i_clientes";
        $st = $this->getConexao()->prepare($sql);
        $st->execute(array(':i_clientes' => $this->getCiclientes()));

        if ($st->rowCount() >= 1) {
            return true;
        } else {
            return $st;
        }
    }

    /**
     * Retorna o valor do Maior pessoas,id no banco somado a 1. Se não houver nenhum pessoas.id no banco, a função retornará 1.
     * @return integer Código do maior ID mais 1
     */
    public function gerarCi_clientes()
    {
        $sql = "SELECT coalesce(max(pessoas.i_clientes),0)+1 AS novoid FROM aulas.clientes";
        $st = $this->getConexao()->prepare($sql);
        $st->execute();
        $res = $st->fetch(PDO::FETCH_ASSOC);

        $novoCid = $res['novoid'];
        return $novoCid;
    }

    /**
     * Carrega as informações da pessoa enviada por parâmtro.
     * @param integer $id Código da Pessoa
     */
    public function carregarRegistroPorPK($id)
    {
        $sql = "SELECT * FROM aulas.clientes WHERE pessoas.i_clientes = :i_clientes";
        $params = array(':i_clientes' => $id);
        $this->carregarRegistroPorSql($sql, $params);
    }

    /**
     * @return integer
     */
    public function getCiclientes()
    {
        return $this->ci_clientes;
    }

    /**
     * @param integer $ci_clientes
     */
    public function setCiclientes($ci_clientes)
    {
        $this->ci_clientes = $ci_clientes;
    }

    /**
     * @return string
     */
    public function getCnome()
    {
        return $this->cnome;
    }

    /**
     * @param string $cnome
     */
    public function setCnome($cnome)
    {
        $this->cnome = $cnome;
    }

    /**
     * @return string
     */
    public function getCsobrenome()
    {
        return $this->csobrenome;
    }

    /**
     * @param string $csobrenome
     */
    public function setCsobrenome($csobrenome)
    {
        $this->csobrenome = $csobrenome;
    }


}