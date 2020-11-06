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
        drawTopbar();
    ?>

        <section style="margin-left: 50px;">
            <?php
                session_start();
                if(isset($_SESSION["username"])) {

                    ?>
                        <h1 class="mainfont"> You are already registered.</h1>
                    <?php

                } else {

                    ?>
                      
                        <h1 class="mainfont" > Create Account </h1>
                        <form action="register.php" method="post">

                            <div class="field mainfont"> Username </div>
                            <input type="text" class="input mainfont" name="username" placeholder="Username" required><br>

                            <div class="field mainfont"> Password </div>
                            <input type="password" class="input mainfont" name="pw" placeholder="Password" required><br>

                            <div class="field mainfont"> Registration Key </div>
                            <input type="text" class="input mainfont" name="rkey" placeholder="Registration Key" required><br>

                            <button type="submit" class="mainfont field button" id="register" name="submit"> Register </button>

                        </form>         

                    <?php
                }

                if (isset($_POST["submit"])) {

                    if (preg_match("/^[A-Za-z]{1}[A-Za-z0-9]{3,12}$/", $_POST["username"])) {

                        require("mysql.php");
                        $statement = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user"); 
                        $statement->bindParam(":user", $_POST["username"]);
                        $statement->execute();
                        $count = $statement->rowCount();
                        if ($count == 0) { // Username überprüfen ob frei

                            $statement = $mysql->prepare("SELECT * FROM registrationkeys WHERE REGKEY = :ckey");
                            $statement->bindParam(":ckey", $_POST["rkey"]);
                            $statement->execute();
                            $count = $statement->rowCount();

                            if ($count == 1) { // Registriationkey auf existenz überprüfen

                                // TODO: Gucken ob Key bereits einen OWNER hat

                                $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                                if ($results[0]["OWNER"] == null) {

                                    $statement = $mysql->prepare("INSERT INTO accounts (USERNAME, PASSWORD, REGKEY, SERVERRANK, SOCIALS) VALUES (:user, :pw, :rkey, :srank, 0)");
                                    $statement->bindParam(":user", $_POST["username"]);
                                    //$hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
                                    $hash = md5($_POST["pw"]);
                                    $statement->bindParam(":pw", $hash);
                                    $statement->bindParam(":rkey", $_POST["rkey"]);
                                    $defaultRank = 0;
                                    $statement->bindParam(":srank", $defaultRank);
                                    $statement->execute();

                                    $statement = $mysql->prepare("UPDATE registrationkeys SET OWNER=:owner WHERE REGKEY = :ckey");
                                    $statement->bindParam(":owner", $_POST["username"]);
                                    $statement->bindParam(":ckey", $_POST["rkey"]);
                                    $statement->execute();

                                    $statement = $mysql->prepare("INSERT INTO stats (USERNAME, DISPLAYNAME) VALUES (:user, :display)");
                                    $statement->bindParam(":user", $_POST["username"]);
                                    $statement->bindParam(":display", $_POST["username"]);
                                    $statement->execute();

                                    ?>
                                        <h1 class="mainfont" style="color: green" href="login.php"> Registration successful. You can now log in.</h1>
                                    <?php

                                } else {
                                    ?>
                                        <h1 class="mainfont" style="color: red"> Registration Key already in use.</h1>
                                    <?php
                                }

                            } else {
                                ?>
                                    <h1 class="mainfont" style="color: red"> Registration Key doesn't exist.</h1>
                                <?php
                            }

                        } else {
                            
                            ?>
                                <h1 class="mainfont" style="color: red"> Username is already in use.</h1>
                            <?php

                        }
                    } else {
                        ?>
                                <h1 class="mainfont" style="color: red"> Username not allowed: <br> Username has to start with a letter and be between 3 and 12 characters long <br> Only following characters are allowed: <br> A-Z <br> a-z <br> 0-9 </h1>
                                
                            <?php
                    }
                }
            ?>
        </section>

    </body>
</html>