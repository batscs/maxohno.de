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
                                        <th class="tableHeader" colspan="2"> <a> Profile </a> </th> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Name: </a> </td> 
                                        <td class="table"> <a> <?php echo htmlspecialchars($results[$whereAmI]["DISPLAYNAME"], ENT_QUOTES, 'UTF-8') ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Placement: </a> </td> 
                                        <td class="table"> <a> <?php echo ($whereAmI + 1) ?>.</a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Followers: </a> </td> 
                                        <td class="table"> <a> <?php 

                                            $ff = $mysql->prepare("SELECT * FROM socials WHERE TARGET = :trgt");
                                            $ff->bindParam(":trgt", $_SESSION["username"]);
                                            $ff->execute();
                                            $count = $ff->rowCount();

                                            echo $count;

                                        ?> </a> </td> 
                                    </tr>

                                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

                                    <tr>
                                        <th class="tableHeader" colspan="2"> <a> Best Performance </a> </th> 
                                    </tr>
        
                                    <tr>
                                        <td class="table"> <a> Highscore: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["HIGHSCORE"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Duration: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["DURATION"] ?>s </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Accuracy: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["ACCURACY"] ?>% </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> WPM: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["WPM"] ?> </a> </td> 
                                    </tr>

                                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

                                    <tr>
                                        <th class="tableHeader" colspan="2"> <a> Lifetime Stats </a> </th> 
                                    </tr>
        
                                    <tr>
                                        <td class="table"> <a> Typed Words: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["TYPEDWORDS"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Playtime: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["PLAYTIME"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Matches: </a> </td> 
                                        <td class="table"> <a> <?php echo $results[$whereAmI]["MATCHES"] ?> </a> </td> 
                                    </tr>
        
                                    <?php
        
                            } else {
                                ?>
                                    <h1 class="mainfont" style="color: red"> You are not logged in.</h1>
                                <?php
                            }
                        ?>

                    </table>         

        </section>
    </body>
</html>
