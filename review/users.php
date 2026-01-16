<?php

// Page incluse dans un contexte plus global (App)
include("../connection.php"); // Inclusion de la connection à la BD + classe d'appel
include("../classes.php"); // Inclusion du loader de classe

$message = "Bad request";
if (isset($_REQUEST["action"])) {
    if ($_REQUEST["action"] === "login") {
        $objUser = new User();
        $id = $objUser->signIn($_REQUEST["userName"], $_REQUEST["userPassword"]);
        if ($id != null) {
            $message = "";
            $objUser->load($id);
        } else {
            $message = "Connection error";
        }
    } elseif ($_REQUEST["action"] === "signup") {
        $objUser = new User();
        if ($objUser->register($_REQUEST)) {
            $message = "Register success";
        } else {
            $message = "Register error";
        }
    }
}