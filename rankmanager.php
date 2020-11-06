<?php

define("BAN", -1);
define("USER", 0);
define("MOD", 1);
define("ADMIN", 2);
define("reqqed", FALSE);

function getRank($username) {
    require("mysql.php");
    $statement = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
    $statement->bindParam(":user", $username, PDO::PARAM_STR);
    $statement->execute();

    $row = $statement->fetch();

    return $row["SERVERRANK"];
}

function isBanned($username) {
    
    if (getRank($username) == -1) {
        return true;
    } else {
        return false;
    }
}

?>