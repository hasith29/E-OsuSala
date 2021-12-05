<?php
        session_start();
        unset($_SESSION["CUID"]);
        unset($_SESSION["Role_id"]);
        unset($_SESSION["Name"]);
        header("Location: ../view/login.php");
        exit();
?>