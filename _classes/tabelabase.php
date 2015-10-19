<?php
/**
 * Classe base para as classes das Tabelas
 */

require_once("banco.php");

abstract class tabelabase extends banco
{
    /** @var string Nome da Tabela da Classe. */
    private $tabela = "";

    /** @var string Nome do Schema da Classe. */
    private $schema = "";

    /** @var PDOStatement Armazena o Statement da última constulta. */
    private $statement = null;

    /**
     * Insere nas Propriedades da Classe as informações do DataSet informado por parâmetro
     * @param FETCH_ASSOC $ds Vetor na estrutura PDO::FETCH_ASSOC. Pode ser obtido pela executção de $pdo->prepare($sql)->execute()->fetch(PDO::FETCH_ASSOC);
     * @return null
     */
    public abstract function importarDataset($ds);

    /**
     * Insere as informações no Banco de Dados
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public abstract function inserirBanco();

    /**
     * Atualiza o Banco com as informações da Classe
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public abstract function atualizarBanco();

    /**
     * Exclui o Registro atual do Banco
     * @return mixed Se bem sucedida, <b>TRUE</b>; Se mau sucedida, retorna uma <b>STRING</b> com a descrição do erro.
     */
    public abstract function excluirBanco();

    /**
     * @param string $sql Instrução SQL a ser executada
     * @param array $param Array com os dados para a substituição
     */
    public function carregarRegistroPorSql($sql, $param = array())
    {
        $this->setStatement(parent::executarSQL($sql, $param));
    }

    /**
     * Carrega a Classe com o próximo registro do Statement.
     * @return bool
     */
    public function proximo()
    {
        $ds = $this->getStatement()->fetch(PDO::FETCH_ASSOC);
        if ($ds != false) {
            $this->importarDataset($ds);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getTabela()
    {
        return $this->tabela;
    }

    /**
     * @param string $tabela
     */
    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return null
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param null $statement
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
    }
}