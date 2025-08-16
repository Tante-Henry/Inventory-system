<?php
class AuditLog
{
    private static $file = __DIR__ . '/../data/audit.log';

    public static function log($user, $action)
    {
        $entry = date('c') . "|{$user}|{$action}\n";
        file_put_contents(self::$file, $entry, FILE_APPEND);
    }
}
