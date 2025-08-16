<!DOCTYPE html>
<html>
<head>
    <title>Items</title>
</head>
<body>
<h1>Items</h1>
<ul>
    <?php foreach ($items as $item): ?>
        <li><?php echo htmlspecialchars($item->name); ?> (<?php echo (int)$item->quantity; ?>)</li>
    <?php endforeach; ?>
</ul>
</body>
</html>
