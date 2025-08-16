<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
<h1>Edit Item</h1>
<form method="POST" action="/item/update/<?php echo $item->id; ?>">
    <?php include __DIR__ . '/form.php'; ?>
</form>
</body>
</html>
