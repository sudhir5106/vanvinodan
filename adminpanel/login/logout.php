<?php
session_start(); # NOTE THE SESSION START
unset($_SESSION['admin']);
echo "true";
?>