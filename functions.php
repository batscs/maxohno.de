<?php

function drawTopbar() {
    ?>
        <section class="topsection">
            <a href="index.php" class="title toptext mainfont"> Website </a>

            <?php
                if(!isset($_SESSION["username"])) { 
                    ?>
                        <a href="register.php" class="toptext mainfont"> Register </a>
                        <a href="login.php" class="toptext mainfont"> Login </a>
                    <?php
                }
            ?>
            
            <a href="leaderboard.php" class="toptext mainfont"> Leaderboard </a>

            <?php
                if(isset($_SESSION["username"])) { 
                    ?>
                        <a href="me.php" class="toptext mainfont"> My Profile </a>
                        <a href="socials.php" class="toptext mainfont"> Socials </a>
                        <a href="logout.php" class="toptext mainfont"> Logout </a>
                        
                    <?php
                    require("rankmanager.php");

                    if (getRank($_SESSION["username"]) >= ADMIN) {
                        ?>
                            <a href="controlpanel.php" class="toptext mainfont"> Control Panel </a>
                        <?php
                    }
                }
            ?>
            
        </section>
    <?php
}

function drawTopbarNoCP() {
    ?>
        <section class="topsection">
            <a href="index.php" class="title toptext mainfont"> Website </a>

            <?php
                if(!isset($_SESSION["username"])) { 
                    ?>
                        <a href="register.php" class="toptext mainfont"> Register </a>
                        <a href="login.php" class="toptext mainfont"> Login </a>
                    <?php
                }
            ?>
            
            <a href="leaderboard.php" class="toptext mainfont"> Leaderboard </a>

            <?php
                if(isset($_SESSION["username"])) { 
                    ?>
                        <a href="me.php" class="toptext mainfont"> My Profile </a>
                        <a href="socials.php" class="toptext mainfont"> Socials </a>
                        <a href="logout.php" class="toptext mainfont"> Logout </a>
                    <?php
                }
            ?>
            
        </section>
    <?php
}

function getRandomChar() {
    $r = rand(1,37);

    if ($r == 1) {
        return "a";  
    } else if ($r == 2) {
        return "a";
    } else if ($r == 3) {
        return "b";
    } else if ($r == 4) {
        return "c";
    } else if ($r == 5) {
        return "d";
    } else if ($r == 6) {
        return "e";
    } else if ($r == 7) {
        return "f";
    } else if ($r == 8) {
        return "g";
    } else if ($r == 9) {
        return "h";
    } else if ($r == 10) {
        return "i";
    } else if ($r == 11) {
        return "j";
    } else if ($r == 12) {
        return "k";
    } else if ($r == 13) {
        return "l";
    } else if ($r == 14) {
        return "m";
    } else if ($r == 15) {
        return "n";
    } else if ($r == 16) {
        return "o";
    } else if ($r == 17) {
        return "p";
    } else if ($r == 18) {
        return "q";
    } else if ($r == 19) {
        return "r";
    } else if ($r == 20) {
        return "s";
    } else if ($r == 21) {
        return "t";
    } else if ($r == 22) {
        return "u";
    } else if ($r == 23) {
        return "v";
    } else if ($r == 24) {
        return "w";
    } else if ($r == 25) {
        return "x";
    } else if ($r == 26) {
        return "y";
    } else if ($r == 27) {
        return "z";
    } else if ($r == 28) {
        return "0";
    } else if ($r == 29) {
        return "1";
    } else if ($r == 30) {
        return "2";
    } else if ($r == 31) {
        return "3";
    } else if ($r == 32) {
        return "4";
    } else if ($r == 33) {
        return "5";
    } else if ($r == 34) {
        return "6";
    } else if ($r == 35) {
        return "7";
    } else if ($r == 36) {
        return "8";
    } else if ($r == 37) {
        return "9";
    }

    return "?";
}

?>