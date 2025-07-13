<?php

function auth(){
    if (!isset($_SESSION['user'])) {
        header("Location: ./auth");
        exit;
    }
}
