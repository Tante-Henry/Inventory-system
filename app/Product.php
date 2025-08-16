<?php

class Product
{
    public $id;
    public $name;
    public $price;
    public $stock;
    public $barcode;

    private static $dataFile = __DIR__ . '/../data/products.json';

    public function __construct($id, $name, $price, $stock, $barcode = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->barcode = $barcode ?: self::generateBarcode($id);
    }

    public static function generateBarcode($seed)
    {
        return str_pad($seed, 12, '0', STR_PAD_LEFT);
    }

    public static function all()
    {
        if (!file_exists(self::$dataFile)) {
            return [];
        }
        $json = file_get_contents(self::$dataFile);
        $data = json_decode($json, true) ?: [];
        return array_map(function ($item) {
            return new self($item['id'], $item['name'], $item['price'], $item['stock'], $item['barcode']);
        }, $data);
    }

    public static function find($id)
    {
        foreach (self::all() as $product) {
            if ($product->id == $id) {
                return $product;
            }
        }
        return null;
    }

    public static function saveAll($products)
    {
        $data = array_map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
                'stock' => $p->stock,
                'barcode' => $p->barcode,
            ];
        }, $products);
        file_put_contents(self::$dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function create($name, $price, $stock)
    {
        $products = self::all();
        $id = $products ? max(array_map(function($p){return $p->id;}, $products)) + 1 : 1;
        $product = new self($id, $name, $price, $stock);
        $products[] = $product;
        self::saveAll($products);
        return $product;
    }

    public function update($fields)
    {
        foreach ($fields as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        $products = self::all();
        foreach ($products as $index => $p) {
            if ($p->id == $this->id) {
                $products[$index] = $this;
                break;
            }
        }
        self::saveAll($products);
    }

    public function delete()
    {
        $products = array_filter(self::all(), function ($p) {
            return $p->id != $this->id;
        });
        self::saveAll(array_values($products));
    }

    public static function exportCSV()
    {
        $products = self::all();
        $fp = fopen('php://temp', 'r+');
        fputcsv($fp, ['id','name','price','stock','barcode']);
        foreach ($products as $p) {
            fputcsv($fp, [$p->id, $p->name, $p->price, $p->stock, $p->barcode]);
        }
        rewind($fp);
        return stream_get_contents($fp);
    }

    public static function importCSV($csv)
    {
        $fp = fopen('php://temp', 'r+');
        fwrite($fp, $csv);
        rewind($fp);
        $rows = [];
        while (($row = fgetcsv($fp)) !== false) {
            $rows[] = $row;
        }
        fclose($fp);
        $products = [];
        foreach (array_slice($rows, 1) as $row) {
            [$id, $name, $price, $stock, $barcode] = $row;
            $products[] = new self($id, $name, $price, $stock, $barcode);
        }
        self::saveAll($products);
        return $products;
    }
}
