<?php
require_once __DIR__ . '/User.php';

class Auth
{
    private static $secret = 'secretkey';

    public static function login($name, $password)
    {
        $user = User::findByName($name);
        if ($user && password_verify($password, $user->password)) {
            return self::jwtEncode(['id'=>$user->id,'role'=>$user->role]);
        }
        return null;
    }

    public static function jwtEncode($payload)
    {
        $header = base64_encode(json_encode(['alg'=>'HS256','typ'=>'JWT']));
        $body = base64_encode(json_encode($payload));
        $sig = hash_hmac('sha256', "$header.$body", self::$secret, true);
        return "$header.$body." . base64_encode($sig);
    }

    public static function jwtDecode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        list($header, $body, $signature) = $parts;
        $expected = base64_encode(hash_hmac('sha256', "$header.$body", self::$secret, true));
        if (!hash_equals($expected, $signature)) return null;
        return json_decode(base64_decode($body), true);
    }
}
