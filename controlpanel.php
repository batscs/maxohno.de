<?php
    session_start();
    require("rankmanager.php");
    require("mysql.php");
    
    

    if (getRank($_SESSION["username"]) < ADMIN) {
        header("Location: leaderboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Databases</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <?php
        require("functions.php");
        drawTopbarNoCP();
    ?>

        <section style="margin-left: 50px;">

            <h1 class="mainfont" > Control Panel </h1>
            <form action="controlpanel.php" method="post">

                <div class="field mainfont"> Key Amount </div>
                <input type="text" class="input mainfont" name="keyqty" placeholder="amount" required><br>

                <button type="genkeys" class="mainfont field button" id="purplebtn" name="genkeys"> Generate Keys </button>

            </form>

            <br> <br><br> <br><br> <br>

            <form action="controlpanel.php" method="post">

                <div class="field mainfont"> Change name </div>
                <input type="text" class="input mainfont" name="oldname" placeholder="oldname" required><br>
                <input style="margin-top: 20px" type="text" class="input mainfont" name="newname" placeholder="new name" required><br>

                <button type="changename" class="mainfont field button" id="purplebtn" name="changename"> Change Name </button>

            </form>

            <?php

                if(isset($_POST["changename"])) {
                    $statement = $mysql->prepare("UPDATE registrationkeys SET OWNER=:new WHERE OWNER=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();

                    $statement = $mysql->prepare("UPDATE accounts SET USERNAME=:new WHERE USERNAME=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();

                    $statement = $mysql->prepare("UPDATE accounts SET DISPLAYNAME=:new WHERE DISPLAYNAME=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();

                    $statement = $mysql->prepare("UPDATE socials SET USER=:new WHERE USER=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();

                    $statement = $mysql->prepare("UPDATE stats SET USERNAME=:new WHERE USERNAME=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();

                    $statement = $mysql->prepare("UPDATE stats SET DISPLAYNAME=:new WHERE DISPLAYNAME=:old");
                    $statement->bindParam(":new", $_POST["newname"]);
                    $statement->bindParam(":old", $_POST["oldname"]);
                    $statement->execute();
                }

                if (isset($_POST["genkeys"])) {

                    require("mysql.php");
                    $keylength = 12;
                    $keyArray = array($_POST["keyqty"]);

                    for($i = 0; $i < $_POST["keyqty"]; $i++) {

                        $key = "";
                        $found = false;

                        while(!$found) {
                            $key = "";

                            for ($j = 0; $j < $keylength; $j++) {
                                $current = getRandomChar();
                                $key = $key . $current;
                                
                            }

                            $statement = $mysql->prepare("SELECT * FROM registrationkeys WHERE REGKEY = :key"); // Username überprüfen ob frei
                            $statement->bindParam(":key", $key);
                            $statement->execute();
                            $count = $statement->rowCount();

                            if ($count == 0) { // unique key found 
                                $found = true;

                                $statement = $mysql->prepare("INSERT INTO registrationkeys (REGKEY) VALUES (:key)");
                                $statement->bindParam(":key", $key);
                                $statement->execute();
                                
                            } else {
                                echo "duplicate key: " . $key;
                            }

                        }

                        $keyArray[$i] = $key;

                        ?>

                        <a class="mainfont"> <?php echo $keyArray[$i] ?> </a> <br>

                        <?php

                    }

                }
            ?>

        </section>
    </body>
</html>