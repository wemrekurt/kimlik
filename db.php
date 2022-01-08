<?php

try {$db = new PDO("mysql:host=localhost;dbname=kimlika;charset=utf8", "root", "");
} catch ( PDOException $e ){
    print $e->getMessage();
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

?>