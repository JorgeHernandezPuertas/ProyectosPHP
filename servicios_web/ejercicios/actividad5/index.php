<?php
session_name("actividad5-sw");
session_start();
require "utils.php";

if (isset($_SESSION["usuario"])) {
    require './vistas/logeado.php';
} else {
    require './vistas/login.php';
}
