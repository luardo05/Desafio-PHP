<?php
require_once 'config/database.php';

if (isset($pdo)) {
    echo "Sucesso! O PHP conseguiu falar com o Banco de Dados.";
}
?>