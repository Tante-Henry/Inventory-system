<?php
class User
{
    public $id;
    public $name;
    public $password;
    public $role;

    private static $dataFile = __DIR__ . '/../data/users.json';

    public function __construct($id, $name, $password, $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    public static function all()
    {
        if (!file_exists(self::$dataFile)) {return [];}    
        $json = file_get_contents(self::$dataFile);
        $data = json_decode($json, true) ?: [];
        return array_map(function($u){return new self($u['id'],$u['name'],$u['password'],$u['role']);}, $data);
    }

    public static function findByName($name)
    {
        foreach (self::all() as $u) {
            if ($u->name === $name) return $u;
        }
        return null;
    }

    public static function create($name, $password, $role)
    {
        $users = self::all();
        $id = count($users) + 1;
        $user = new self($id, $name, password_hash($password, PASSWORD_DEFAULT), $role);
        $users[] = $user;
        self::saveAll($users);
        return $user;
    }

    public static function saveAll($users)
    {
        $data = array_map(function($u){
            return ['id'=>$u->id,'name'=>$u->name,'password'=>$u->password,'role'=>$u->role];
        }, $users);
        file_put_contents(self::$dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}
