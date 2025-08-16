<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($item->name); ?></title>
</head>
<body>
<h1><?php echo htmlspecialchars($item->name); ?></h1>
<ul>
    <li>ID: <?php echo (int)$item->id; ?></li>
    <li>Quantity: <?php echo (int)$item->quantity; ?></li>
    <li>Price: <?php echo htmlspecialchars($item->price); ?></li>
</ul>
<p>
    <a href="/item/edit/<?php echo $item->id; ?>">Edit</a>
    <a href="/item/index">Back to List</a>
</p>
</body>
</html>
