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

    /** @var PDOObject Conexão com o banco */
    private $conexao = NULL;


    /** Realiza a conexão com o Banco de Dados */
    public function __construct()
    {
        $this->conectar();
    }

    /** Desconecta com o Banco de Dados */
    public function __destruct()
    {
        $this->desconectar();
    }

    /** Conecta no Banco de Dados */
    public function conectar()
    {
        $conn = new PDO("pgsql:host={$this->getServidor()} port={$this->getPorta()} dbname={$this->getBanco()} user={$this->getUsuario()} password={$this->getSenha()}"); //or die("Erro");
        $this->setConexao($conn);
    }

    /** Desconecta no Banco de Dados */
    public function desconectar()
    {
        if ($this->getConexao() != NULL) {
            $this->conexao = NULL;
        }
    }

    /**
     * Executa uma instrução SQL no Banco de Dados
     * @param null $sql Instrução SQL
     * @param array $param Parâmetro do SQL
     * @return mixed Retorna <b>PDOStatement</b> em caso de sucesso e <b>FALSE</b> em caso de falha.
     */
    public function executarSQL($sql = NULL, $param = array())
    {
        $st = $this->getConexao()->prepare($sql);
        $st->execute($param);
        return $st;
    }


    /**
     * @return string
     */
    public function getServidor()
    {
        return $this->servidor;
    }

    /**
     * @param string $servidor
     */
    public function setServidor($servidor)
    {
        $this->servidor = $servidor;
    }

    /**
     * @return string
     */
    public function getPorta()
    {
        return $this->porta;
    }

    /**
     * @param string $porta
     */
    public function setPorta($porta)
    {
        $this->porta = $porta;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param string $banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }

    /**
     * @return resource
     */
    public function getConexao()
    {
        return $this->conexao;
    }

    /**
     * @param resource $conexao
     */
    public function setConexao($conexao)
    {
        $this->conexao = $conexao;
    }
}