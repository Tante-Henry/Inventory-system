<?php
require_once __DIR__ . '/User.php';

class Auth
{
    private static $secret = 'secretkey';

    private static function b64url($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function b64urlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }

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
        $header = self::b64url(json_encode(['alg'=>'HS256','typ'=>'JWT']));
        $body = self::b64url(json_encode($payload));
        $sig = self::b64url(hash_hmac('sha256', "$header.$body", self::$secret, true));
        return "$header.$body.$sig";
    }

    public static function jwtDecode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        list($header, $body, $signature) = $parts;
        $expected = self::b64url(hash_hmac('sha256', "$header.$body", self::$secret, true));
        if (!hash_equals($expected, $signature)) return null;
        return json_decode(self::b64urlDecode($body), true);
    }
}
