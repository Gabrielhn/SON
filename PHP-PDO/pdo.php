PDO
<?php
// -Configurar driver de conexão no php.ini
    ;extension=php_pdo_mysql.dll ->mysql
    ;extension=php_pdo_oci.dll ->oracle
    // [Client oracle já deve estar instalado, na variável de ambiente e com o TNSNAMES configurado.]



// -Display erros (php.ini):
    display_errors = On



// -Conexão:
    TNS OK -> $conn= new \PDO("oci:host=localhost;dbname=xe","%usuario%","senha");
    TNS OFF -> $conn= new \PDO("oci:host=localhost;dbname=//localhost:1521/mydb","%usuario%","senha");





// -DML (INSERT, UPDATE, DELETE) com EXEC():
    $query = "INSERT INTO USR (email, senha, nome) VALUES ('luana@ienh.com.br','12345','Luana Gassen'); COMMIT; ";
    $ret = $conn->exec($query);
    print_r($ret);
    // [o retorno do EXEC vai ser sempre o numero de linhas que foram afetadas pelo comando]





// -DQL (SELECT)
    // Especificando todos os dados do array retornando, numerico e associativo juntos:
    $query = "SELECT * FROM USR";
    $stmt = $conn->query($query);

    $lista = $stmt->fetchall();                                                                                                                         // <--
    print_r ($lista);

    // exemplo de retorno do comando acima:
    // Array
    // (
    //     [0] => Array
    //         (
    //             [EMAIL] => pcc_.gabriel@hotmail.com
    //             [0] => pcc_.gabriel@hotmail.com
    //             [SENHA] => 12345
    //             [1] => 12345
    //             [NOME] => Gabriel Hipolito
    //             [2] => Gabriel Hipolito
    //         )

// ---------------------------------------------------------------------------------------------------

    // Retornando todos os dados do array, somente os associativos:
    $lista = $stmt->fetchall(PDO::FETCH_ASSOC);                                                                                                         // <--
    print_r ($lista);

    // exemplo de retorno do comando acima:
    // Array
    // (
    //     [0] => Array
    //         (
    //             [EMAIL] => pcc_.gabriel@hotmail.com
    //             [SENHA] => 12345
    //             [NOME] => Gabriel Hipolito
    //         )

// ---------------------------------------------------------------------------------------------------

    // Retornando os dados de um array tratado, especificando linhas pelo index:
    $lista = $stmt->fetchall();
    echo "| Email: " . $lista[1]['EMAIL'] . " | " . "Senha: " . $lista[1]['SENHA'] . " | " . "Nome: " . $lista[1]['NOME'] . " |";                       // <--
    // [o display do array é da seguinte forma: $lista[0]-->linha, [EMAIL]-->campo]

    // exemplo de retorno tratado do comando acima:
    // | Email: luana@ienh.com.br | Senha: 12345 | Nome: Luana Gassen |

// ---------------------------------------------------------------------------------------------------

    // Retornando todos os dados array em forma de objeto tratado:
    $lista = $stmt->fetchall(PDO::FETCH_OBJ);                                                                                                           // <---
    echo "| Email: " . $lista[1]->EMAIL . " | " . "Senha: " . $lista[1]->SENHA . " | " . "Nome: " . $lista[1]->NOME . " |";                             // <---
    // [o display do array é da seguinte forma: $lista[0]-->linha ou index, [EMAIL]-->campo ou objeto]

    // exemplo de retorno tratado do comando acima:
    // | Email: luana@ienh.com.br | Senha: 12345 | Nome: Luana Gassen |

// ---------------------------------------------------------------------------------------------------

    // Retornando dados sem identificar a key com foreach:
    $query = "SELECT * FROM USR";
    $stmt = $conn->query($query);
    $lista = $stmt->fetchall(PDO::FETCH_OBJ);
    foreach($lista as $key => $value) {                                                                                                                 // <--
    echo "| Email: " . $lista[$key]->EMAIL . " | " . "Senha: " . $lista[$key]->SENHA . " | " . "Nome: " . $lista[$key]->NOME . " |" . "<br/>";
    }

    // exemplo de retorno tratado do comando acima:
    //  | Email: pcc_.gabriel@hotmail.com | Senha: 12345 | Nome: Gabriel Hipolito |
    //  | Email: luana@ienh.com.br | Senha: 12345 | Nome: Luana Gassen |

// ---------------------------------------------------------------------------------------------------

    // Retornando somente um registro com fetch()
    $query = "SELECT * FROM USR";
    $stmt = $conn->query($query);                                                                                                               
    $lista = $stmt->fetch(PDO::FETCH_OBJ);                                                                                                              // <--
    echo "| Email: " . $lista->EMAIL . " | " . "Senha: " . $lista->SENHA . " | " . "Nome: " . $lista->NOME . " |" . "<br/>";                            // <--

    // exemplo de retorno tratado do comando acima:
    //  | Email: pcc_.gabriel@hotmail.com | Senha: 12345 | Nome: Gabriel Hipolito |

// ---------------------------------------------------------------------------------------------------

    //Protegendo as querys contra SQL injection:
    $query = "SELECT * FROM USR WHERE EMAIL=:email;";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':email',$_GET['email']);
    $stmt->execute($query);

    print_r($stmt);
?>