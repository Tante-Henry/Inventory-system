<?php
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/AuditLog.php';

class Pos
{
    public static function checkout($user, $client, $items)
    {
        $total = 0;
        $lines = [];
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['qty']) {
                throw new Exception('Insufficient stock for product ' . $item['id']);
            }
            $product->stock -= $item['qty'];
            $product->update([]);
            $lineTotal = $item['qty'] * $product->price;
            $total += $lineTotal;
            $lines[] = [
                'name' => $product->name,
                'qty' => $item['qty'],
                'price' => $product->price,
                'total' => $lineTotal,
            ];
            if ($product->stock < 5) {
                self::sendWhatsAppAlert("Low stock for {$product->name}");
            }
        }
        $receiptHtml = self::renderReceipt($client, $lines, $total);
        $receiptPdf = self::generatePdf($receiptHtml);
        AuditLog::log($user, 'checkout');
        return ['html' => $receiptHtml, 'pdf' => $receiptPdf];
    }

    private static function renderReceipt($client, $lines, $total)
    {
        $html = "<h1>Receipt for {$client}</h1><table><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr>";
        foreach ($lines as $l) {
            $html .= "<tr><td>{$l['name']}</td><td>{$l['qty']}</td><td>{$l['price']}</td><td>{$l['total']}</td></tr>";
        }
        $html .= "</table><p>Total: {$total}</p>";
        return $html;
    }

    private static function generatePdf($html)
    {
        // TODO: integrate real PDF library
        $tmp = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($tmp, $html);
        return $tmp;
    }

    private static function sendWhatsAppAlert($message)
    {
        // TODO: integrate with WhatsApp API
        file_put_contents(__DIR__ . '/../data/whatsapp.log', $message . "\n", FILE_APPEND);
    }
}
