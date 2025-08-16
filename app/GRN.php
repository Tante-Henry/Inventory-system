<?php
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/AuditLog.php';

class GRN
{
    public static function receive($user, $supplier, $items)
    {
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                $product = Product::create($item['name'], $item['cost'], $item['qty']);
            } else {
                $totalCost = $product->stock * $product->price + $item['qty'] * $item['cost'];
                $product->stock += $item['qty'];
                $product->price = $totalCost / $product->stock;
                $product->update([]);
            }
        }
        AuditLog::log($user, 'grn');
    }
}
