<?php
    session_start();
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

            <h1 class="mainfont" > My Games </h1>

            <table>
                <tr>
                    <th> <iframe frameborder="0" src="https://itch.io/embed/797546?bg_color=121214&amp;fg_color=ffffff&amp;border_color=161616" width="552" height="167"><a href="https://steambats.itch.io/typing-hell">Typing Hell by Bats</a></iframe> </th>
                    <th> <iframe frameborder="0" src="https://itch.io/embed/809750?bg_color=121214&amp;fg_color=ffffff&amp;border_color=161616" width="552" height="167"><a href="https://steambats.itch.io/easy-terminal">Easy Terminal (Program Launcher) by Bats</a></iframe> </th>
                </tr>

                <tr>
                    <th> <iframe frameborder="0" src="https://itch.io/embed/808642?bg_color=121214&amp;fg_color=ffffff&amp;border_color=161616" width="552" height="167"><a href="https://steambats.itch.io/easy-math">Easy Math (for Kids) by Bats</a></iframe> </th>
                </tr>
            </table>

            

        </section>
    </body>
</html>