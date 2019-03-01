# Biblioteca-PHP

<b>Login: acesso  |  Senha: 123456</b>
  
Estrutura do Banco de Dados

categoria - id INT AUTO_INCREMENT PRIMARY KEY, nome_categoria VARCHAR(220) 
 |
  --> livro - id INT, nome VARCHAR(220), descricao VARCHAR(220), categoria_id INT , data DATETIME
       |
        --> imagens - id INT, nome VARCHAR(220), imagem VARCHAR(220) (Nome/Tipo do arquivo da imagem), livro_id INT
       |
        --> arquivos - id INT, nome VARCHAR(220), arquivo VARCHAR(220) (Nome/Tipo do arquivo do ebook), livro_id INT

privilegio - id INT, nome VARCHAR(220)
 |
  --> usuario - id INT, email VARCHAR(220), senha VARCHAR(220), nome_usuario VARCHAR(220), privilegio_id INT, datauser DATETIME

cadastro - id INT, nomeCad VARCHAR(220), emailCadVARCHAR(220), senCadVARCHAR(220), priv INT, chaveReg VARCHAR(220)

recuperacao - id INT, idRec INT, chaveRec VARCHAR(220)

categoria_id/livro_id/privilegio_id são chaves estrangeiras que apontar para as tabelas categoria/livro/privilegio respectivamente
Todos os id são AUTO_INCREMENT PRIMARY KEY
Todos os DATETIME sao DEFAULT CURRENT_TIMESTAMP
