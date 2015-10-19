# CRUD de PHP Orientado a Objeto utilizando a biblioteca PDO
CRUD em PHPOO utilizando a PDO.

# Para executar #
``` sudo service apache2 start ```

# Preparando o ambiente de Desenvolvimento #

## Instalar Apache2
```
sudo apt-get update
sudo apt-get install apache2
```

## Instalar PostgreSQL
` sudo ./postgresql-9.4.4-3-linux-x64.run `

## Instalar PHP5 ##
```
sudo apt-get install php5
sudo apt-get install libapache2-mod-php5
sudo apt-get install php5-pgsql
```

Abrir o arquivo php.ini e ativar as bibliotecas PDO e PostgreSQL

## Reiniciando os servidores ##
` sudo service apache2 restart `