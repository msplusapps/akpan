<?php
    ob_start();
    header("Location: /admin/dashboard");
    exit;
    ob_end_flush();