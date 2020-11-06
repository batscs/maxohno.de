<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title> Leaderboard </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    
        <?php
        require("functions.php");
        drawTopbar();
        ?>

        <section style="margin-left: 50px;">

        <h1 class="mainfont"> Leaderboard: </h1>
        <table>

            <?php
                require("mysql.php");
                $statement = $mysql->prepare("SELECT * FROM stats ORDER BY HIGHSCORE DESC");
                $statement->execute();

                $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                ?>

                    <tr>
                        <th class="tableHeader"> <b> Place </b> </th>
                        <th class="tableHeader"> <b> Username </b> </th>
                        <th class="tableHeader"> <b> Highscore </b> </th>
                        <th class="tableHeader"> <b> Duration </b> </th>
                    </tr>

                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
                        
                    <?php
                        $topx = 15;
                        for($i = 0; $i < $topx; $i++) {

                            if ($i >= count($results)) {
                                break;
                            }

                            ?>

                                </tr>
                                <tr>
                                    <td class="table"> <a> <?php echo ($i + 1) ?>. </a> </td> 
                                    <td class="table"> <a> <?php echo htmlspecialchars($results[$i]["DISPLAYNAME"], ENT_QUOTES, 'UTF-8') ?> </a> </td>
                                    <td class="table"> <a> <?php echo $results[$i]["HIGHSCORE"] ?> </a> </td>
                                    <td class="table"> <a> <?php echo $results[$i]["DURATION"] ?>s </a> </td>


                            <?php

                        }

                        if(isset($_SESSION["username"])) {
        
                                    $whereAmI;
                                    for ($i = 0; $i < count($results); $i++) {
                                        if ($results[$i]["USERNAME"] == $_SESSION["username"]) {
                                            $whereAmI = $i;
                                            $i = count($results) + 1;
                                        }
                                    }
        
                                    ?>       
        
                                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

                                    <tr>
                                        <td class="table"> <a> <?php echo ($whereAmI + 1) ?>.</a> </td> 
                                        <td class="table"> <a> <?php echo htmlspecialchars($results[$whereAmI]["DISPLAYNAME"], ENT_QUOTES, 'UTF-8') ?> </a> </td>
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["HIGHSCORE"] ?> </a> </td>
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["DURATION"] ?>s </a> </td>
                                    </tr>
        
        
                                    <?php
        
                            }
                        ?>

                    </table>         

        </section>
    </body>
</html>
