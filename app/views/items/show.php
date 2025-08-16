<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($item->name); ?></title>
</head>
<body>
<h1><?php echo htmlspecialchars($item->name); ?></h1>
<p>Quantity: <?php echo (int)$item->quantity; ?></p>
<p>Price: <?php echo htmlspecialchars($item->price); ?></p>
</body>
</html>
