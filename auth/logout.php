<?php
session_start();
session_unset();
session_destroy();

setcookie("saved_username", "", time() -