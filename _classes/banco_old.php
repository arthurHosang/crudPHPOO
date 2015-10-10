<?php

/**
 * Classe genérica para conectar com o banco
 * Created by PhpStorm.
 * User: arthur
 * Date: 08/10/15
 * Time: 16:18
 */
class banco
{

    /** @var string Endereço do Servidor */
    public $servidor = "localhost";

    /** @var string Porta em que o banco está disparado */
    public $porta = "5432";

    /** @var string Usuário de acesso ao banco */
    public $usuario = "postgres";

    /** @var string Senha do banco */
    public $senha = "1234";

    /** @var string Nome do Banco de Dados */
    public $banco = "aulas";

    /** @var resource Conexão com o banco */
    public $conexao = NULL;

    /** @var null DataSet */
    public $dataset = NULL;

    /** @var int Quantidade de linhas afetadas pela ultima operação */
    private $linhasAfetadas = -1;


    public function __construct()
    {
        $this->conecta();
    }

    public function __destruct()
    {
        if ($this->conexao != NULL) {
            pg_close($this->conexao);
        }
    }

    public function conecta()
    {
        //$this->conexao = pg_connect("host={$this->servidor} port={$this->porta} dbname={$this->banco} user={$this->usuario} password={$this->senha}"); //or die("Erro");
        try {
            $this->conexao = new PDO("pgsql:host={$this->servidor} port={$this->porta} dbname={$this->banco} user={$this->usuario} password={$this->senha}"); //or die("Erro");
            echo '<script> console.log("Conectado ao Banco"); </script>'; //Debug
        } catch (PDOException $e) {
        }

    }

    public function executaSQL_old($sql = NULL)
    {
        if ($sql != NULL) {
            //alterar para pg_query_params()
            $querry = pg_query($this->conexao, $sql) or $this->trataErro(__FILE__, __FUNCTION__);
            $this->setLinhasAfetadas(pg_affected_rows($querry));
        } else {
            $this->trataErro(__FILE__, __FUNCTION__, NULL, 'Comando SQL não informado na rotina', FALSE);
        }
        return $querry;
    }

    public function executaSQL($sql = NULL)
    {
        if ($sql != NULL) {
            //alterar para pg_query_params()
            $querry = pg_query($this->conexao, $sql) or $this->trataErro(__FILE__, __FUNCTION__);
            $this->setLinhasAfetadas(pg_affected_rows($querry));
        } else {
            $this->trataErro(__FILE__, __FUNCTION__, NULL, 'Comando SQL não informado na rotina', FALSE);
        }
        return $querry;
    }

    public function retornaDados($tipo = NULL)
    {
        switch (strtolower($tipo)) {
            case "array":
                return pg_fetch_array($this->dataset);
            case "assoc":
                return pg_fetch_assoc($this->dataset);
            case "object":
                return pg_fetch_object($this->dataset);
            default:
                return pg_fetch_object($this->dataset);
        }
    }

    public function getLinhasAfetadas()
    {
        return $this->linhasAfetadas;
    }

    public function setLinhasAfetadas($linhasAfetadas)
    {
        $this->linhasAfetadas = $linhasAfetadas;
    }

    /**
     * @return null
     */
    public function getConexao()
    {
        return $this->conexao;
    }

    /**
     * @param null $conexao
     */
    public function setConexao($conexao)
    {
        $this->conexao = $conexao;
    }

}