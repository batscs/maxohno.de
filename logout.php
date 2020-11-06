<?php
    session_start();
    session_destroy();
    header("Location: leaderboard.php");
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
        drawTopbar();
    ?>

        <section style="margin-left: 50px;">

                        <h1 class="mainfont" style="color: red"> You have successfully logged out.</h1>       

        </section>
    </body>
</html>