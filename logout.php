<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['isnewuser']);
unset($_SESSION['userid']);

header('Location: login.php');
