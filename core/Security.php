<?php
namespace Core;

class Security{
    private static string $key = "mskboss";
    private static string $cipher = "AES-128-CTR";
    private static string $iv = "1234567890123456"; // Must be 16 bytes for AES-128-CTR

    public static function encrypt(string $plaintext): string{
        return openssl_encrypt(
            $plaintext,
            self::$cipher,
            self::$key,
            0,
            self::$iv
        );
    }

    public static function decrypt(string $ciphertext): string{
        return openssl_decrypt(
            $ciphertext,
            self::$cipher,
            self::$key,
            0,
            self::$iv
        );
    }
}
