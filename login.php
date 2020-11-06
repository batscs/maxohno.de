<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Databases</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

    <?php
        session_start();
        require("functions.php");
        drawTopbar();
    ?>

        

        <section style="margin-left: 50px;">

            <?php
                if(isset($_SESSION["username"])) {

                    ?>
                        <h1 class="mainfont"> You are already logged in.</h1>
                    <?php

                } else {

                    ?>
                        <h1 class="mainfont" > Login </h1>
                        <form action="login.php" method="post">

                            <div class="field mainfont"> Username </div>
                            <input type="text" class="input mainfont" name="username" placeholder="Username" required><br>

                            <div class="field mainfont"> Password </div>
                            <input type="password" class="input mainfont" name="pw" placeholder="Password" required><br>

                            <button type="submit" class="mainfont field button" id="login" name="submit"> Login </button>

                        </form>

                    <?php
                }

                if (isset($_POST["submit"])) {
                    require("mysql.php");
                    $statement = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user"); // Username überprüfen ob frei
                    $statement->bindParam(":user", $_POST["username"]);
                    $statement->execute();
                    $count = $statement->rowCount();
                    if ($count > 0) { 

                        $row = $statement->fetch();
                        //if(password_verify($_POST["pw"], $row["PASSWORD"])) {
                        if(md5($_POST["pw"]) == $row["PASSWORD"]) {
                            session_start();
                            $_SESSION["username"] = $row["USERNAME"];

                            header("Location: leaderboard.php");

                        } else {
                            ?>
                                <h1 class="mainfont" style="color: red"> Login failed: Password incorrect.</h1>
                            <?php
                        }

                    } else {
                        ?>
                            <h1 class="mainfont" style="color: red"> Login failed: User not found.</h1>
                        <?php
                    }
                }
            ?>

        </section>
    </body>
</html>