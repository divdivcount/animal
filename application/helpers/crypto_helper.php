<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 범용 암호화 함수
 * @param string $plaintext 암호화할 문자열
 * @return string 암호화된 문자열 (Base64)
 */
if (!function_exists('encrypt_string')) {
    function encrypt_string($plaintext)
    {
        $key = get_encryption_key();
        $cipher = 'aes-256-cbc';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

        $encrypted = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }
}

/**
 * 복호화 함수
 * @param string $encrypted 암호화된 Base64 문자열
 * @return string 복호화된 원문
 */
if (!function_exists('decrypt_string')) {
    function decrypt_string($encrypted)
    {
        $key = get_encryption_key();
        $cipher = 'aes-256-cbc';

        $data = base64_decode($encrypted);
        $iv_length = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $iv_length);
        $ciphertext = substr($data, $iv_length);

        return openssl_decrypt($ciphertext, $cipher, $key, 0, $iv);
    }
}

/**
 * 암호화 키 가져오기
 * @return string 32바이트 키
 */
if (!function_exists('get_encryption_key')) {
    function get_encryption_key()
    {
        // ※ 반드시 32바이트 문자열 사용!
        return 'my_super_secret_key_for_ci3_123456'; // 예시 키
    }
}