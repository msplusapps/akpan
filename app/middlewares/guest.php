<?php

function guest(){
    if (isset($_SESSION['user'])) {
        header("Location: /dashboard");
        exit;
    }
}
