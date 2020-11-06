<?php
    session_start();
    require("mysql.php");
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

        <?php

            if (isset($_SESSION["username"])) {

                $statement = $mysql->prepare("SELECT SOCIALS FROM accounts WHERE USERNAME = :user");
                $statement->bindParam(":user", $_SESSION["username"]);
                $statement->execute();

                $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($results[0]["SOCIALS"] == 0) {

                    ?>
                        <form action="socials.php" method="post">
                            <h1 class="mainfont" style="color: red"> You have not created a socials account yet.</h1>
                            <button type="createsocials" class="mainfont field button" id="purplebtn" name="createsocials"> Create Social Account </button>
                        </form>

                    <?php
                } else {

                    $statement = $mysql->prepare("SELECT * FROM socials WHERE USER = :user");
                    $statement->bindParam(":user", $_SESSION["username"]);
                    $statement->execute();

                    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                    ?>

                    <table>
                        <tr>
                            <td style="padding-left: 0px">
                                <form action="socials.php" method="post">
                                    <h1 class="mainfont" style="color: green"> Follow somebody:</h1>
                                    <input style="width: 350px; margin-bottom: 20px;" type="text" class="input mainfont" name="followinput" placeholder="Name" required><br>
                                    <button type="follow" class="mainfont field button" id="purplebtn" name="follow"> Follow </button>
                                </form>          
                            </td>


                            <td style="padding-left: 300px">
                                <form action="socials.php" method="post">
                                    <h1 class="mainfont" style="color: red"> Unfollow somebody:</h1>
                                    <input style="width: 350px; margin-bottom: 20px;" type="text" class="input mainfont" name="unfollowinput" placeholder="Name" required><br>
                                    <button type="unfollow" class="mainfont field button" id="purplebtn" name="unfollow"> Unfollow </button>
                                </form>
                                
                            </td>
                        </tr>

                    </table>

                    <?php

                        if(isset($_POST["follow"])) {
                            $statement = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :trget");
                            $statement->bindParam(":trget", $_POST["followinput"]);
                            $statement->execute();

                            $count = $statement->rowCount();
                            if ($count > 0) {
                                $statement = $mysql->prepare("SELECT * FROM socials WHERE USER = :user AND TARGET = :target");
                                $statement->bindParam(":user", $_SESSION["username"]);
                                $statement->bindParam(":target", $_POST["followinput"]);
                                $statement->execute();

                                $count = $statement->rowCount();

                                if ($count == 0) {
                                    $statement = $mysql->prepare("INSERT INTO socials (USER, TARGET) VALUES (:user, :target)");
                                    $statement->bindParam(":user", $_SESSION["username"]);
                                    $statement->bindParam(":target", $_POST["followinput"]);
                                    $statement->execute();
                                    header("Refresh:0");
                                } else {
                                    ?>
                                        <h1 class="mainfont" style="color: red"> You are following that person already.</h1>
                                    <?php
                                }
                            } else {
                                ?>
                                    <h1 class="mainfont" style="color: red"> Person not found.</h1>
                                <?php
                            }
                        }

                        if(isset($_POST["unfollow"])) {
                            $statement = $mysql->prepare("DELETE FROM socials WHERE USER = :user AND TARGET = :target");
                            $statement->bindParam(":user", $_SESSION["username"]);
                            $statement->bindParam(":target", $_POST["unfollowinput"]);
                            $statement->execute();
                            header("Refresh:0");
                        }

                    ?>

                    <br><br><br><br>
                    
                    <?php

                    for ($i = 0; $i < count($results); $i++) {

                        $stmt = $mysql->prepare("SELECT * FROM stats WHERE USERNAME = :target");
                        $stmt->bindParam(":target", $results[$i]["TARGET"]);
                        $stmt->execute();

                        $profile = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $abc = $i + 1;
                        $splitLength = 3;

                        if ($abc % $splitLength != 0) {

                            ?> <table style="float: left; margin-right: 40px;"> <?php
                            
                        } else {
                            ?> <table> <?php
                        }
                        
                        ?>
                            <tr>

                                    <th class="tableHeader" colspan="2" style="width: 400px"> <a> Profile </a> </th> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Name: </a> </td> 
                                        <td class="table"> <a> <?php echo htmlspecialchars($profile[0]["DISPLAYNAME"], ENT_QUOTES, 'UTF-8') ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Placement: </a> </td> 
                                        <td class="table"> <a> <?php 

                                            $whereAmI = -1;
                                            $stmt123 = $mysql->prepare("SELECT * FROM stats ORDER BY HIGHSCORE DESC");
                                            $stmt123->execute();
                    
                                            $res123 = $stmt123->fetchAll(PDO::FETCH_ASSOC);
                    
                                            for ($k = 0; $k < count($res123); $k++) {
                                                if ($res123[$k]["USERNAME"] == $profile[0]["USERNAME"]) {
                                                    $whereAmI = $k;
                                                    $k = count($res123) + 1;
                                                }
                                            }
                                            echo $whereAmI + 1;

                                        ?>.</a> </td> 
                                    </tr>

                                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

                                    <tr>
                                        <th class="tableHeader" colspan="2"> <a> Best Performance </a> </th> 
                                    </tr>
        
                                    <tr>
                                        <td class="table"> <a> Highscore: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["HIGHSCORE"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Duration: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["DURATION"] ?>s </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Accuracy: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["ACCURACY"] ?>% </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> WPM: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["WPM"] ?> </a> </td> 
                                    </tr>

                                    <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>

                                    <tr>
                                        <th class="tableHeader" colspan="2"> <a> Lifetime Stats </a> </th> 
                                    </tr>
        
                                    <tr>
                                        <td class="table"> <a> Typed Words: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["TYPEDWORDS"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Playtime: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["PLAYTIME"] ?> </a> </td> 
                                    </tr>

                                    <tr>
                                        <td class="table"> <a> Matches: </a> </td> 
                                        <td class="table"> <a> <?php echo $profile[0]["MATCHES"] ?> </a> </td> 
                                    </tr>

                            </table>

                            <?php
                                if ($abc % $splitLength == 0) {
                                    ?> <br><br><br><br> <?php
                                }
                            ?>

                        <?php

                    }

                }

            } else {

                ?>
                    <h1 class="mainfont" style="color: red"> You are not logged in.</h1>
                <?php   
            }

            if (isset($_POST["createsocials"])) {
                $statement = $mysql->prepare("UPDATE accounts SET SOCIALS=1 WHERE USERNAME = :user");
                $statement->bindParam(":user", $_SESSION["username"]);
                $statement->execute();
                header("Refresh:0");
            }
        
        ?>

        </section>
    </body>
</html>
