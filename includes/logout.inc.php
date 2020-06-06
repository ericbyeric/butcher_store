<?php
session_start();
session_unset();       // delete all the values of each session variable
session_destroy();
header("Location: ../index.php");