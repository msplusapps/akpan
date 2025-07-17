<?php

function auth(){
    if (!isset($_SESSION['user'])) {
        redirect("./auth/login");
        exit;
    }
}
