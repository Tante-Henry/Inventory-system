<?php

class Item
{
    public $id;
    public $name;
    public $quantity;
    public $price;

    protected static function db()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $db = $config['db'];
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $db['host'], $db['database']);
        return new PDO($dsn, $db['username'], $db['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function all()
    {
        $stmt = self::db()->query('SELECT id, name, quantity, price FROM items');
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function find($id)
    {
        $stmt = self::db()->prepare('SELECT id, name, quantity, price FROM items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public static function create($data)
    {
        $pdo = self::db();
        $stmt = $pdo->prepare('INSERT INTO items (name, quantity, price) VALUES (:name, :quantity, :price)');
        $stmt->execute([
            ':name' => $data['name'],
            ':quantity' => $data['quantity'],
            ':price' => $data['price'],
        ]);
        return self::find($pdo->lastInsertId());
    }

    public static function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];
        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params[':name'] = $data['name'];
        }
        if (isset($data['quantity'])) {
            $fields[] = 'quantity = :quantity';
            $params[':quantity'] = $data['quantity'];
        }
        if (isset($data['price'])) {
            $fields[] = 'price = :price';
            $params[':price'] = $data['price'];
        }
        if (!$fields) {
            return self::find($id);
        }
        $sql = 'UPDATE items SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $pdo = self::db();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return self::find($id);
    }

    public static function delete($id)
    {
        $pdo = self::db();
        $stmt = $pdo->prepare('DELETE FROM items WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}

