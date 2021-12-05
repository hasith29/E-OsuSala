<?php
        session_start();
        unset($_SESSION["SUID"]);
        unset($_SESSION["Role_id"]);
        unset($_SESSION["Name"]);
        header("Location: ../login.php");
        exit();
?>