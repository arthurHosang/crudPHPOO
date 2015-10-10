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
    private $servidor = "localhost";

    /** @var string Porta em que o banco está disparado */
    private $porta = "5432";

    /** @var string Usuário de acesso ao banco */
    private $usuario = "postgres";

    /** @var string Senha do banco */
    private $senha = "1234";

    /** @var string Nome do Banco de Dados */
    private $banco = "aulas";

    /** @var resource Conexão com o banco */
    private $conexao = NULL;

    /** @var int Quantidade de linhas afetadas pela ultima operação */
    private $linhasAfetadas = -1;


    public function __construct()
    {
        $this->conecta();
    }

    public function __destruct()
    {
        if ($this->getConexao() != NULL) {
            pg_close($this->getConexao());
        }
    }

    public function conecta()
    {
        //$this->conexao = pg_connect("host={$this->servidor} port={$this->porta} dbname={$this->banco} user={$this->usuario} password={$this->senha}"); //or die("Erro");
        try {
            $conn = new PDO("pgsql:host={$this->servidor} port={$this->porta} dbname={$this->banco} user={$this->usuario} password={$this->senha}"); //or die("Erro");
            $this->setConexao($conn);
            echo '<script> console.log("Conectado ao Banco"); </script>'; //Debug
        } catch (PDOException $e) {
        }

    }

    public function getConexao()
    {
        if ($this->conexao != NULL) {
            return $this->conexao;
        } else {
            $this->conecta();
            return $this->conexao;
        }
    }

    public function setConexao($conexao)
    {
        $this->conexao = $conexao;
    }

    public function executaSQL($sql = NULL)
    {
        $st = $this->getConexao()->prepare($sql);
        $st->execute();
        return $st;
    }

    /**
     * @return int
     */
    public function getLinhasAfetadas()
    {
        return $this->linhasAfetadas;
    }

    /**
     * @param int $linhasAfetadas
     */
    public function setLinhasAfetadas($linhasAfetadas)
    {
        $this->linhasAfetadas = $linhasAfetadas;
    }

}