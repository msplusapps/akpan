<?php
    $iv = 1234567890123456;
    $key = "mskboss";
    $cipher = "AES-128-CTR";
    $options = 0;

    function encrypt($word){
        global $iv, $key, $cipher;
        $options = 0;
        $encryption = openssl_encrypt(
            $word,
            $cipher,
            $key,
            $options,
            $iv
        );
        return $encryption;
    }


    function decrypt($encryption){
        global $iv, $key, $cipher;
        $options = 0;
        $decryption = openssl_decrypt(
            $encryption,
            $cipher,
            $key,
            $options,
            $iv
        );
        return $decryption;
    }
