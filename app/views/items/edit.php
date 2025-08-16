<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
<h1>Edit Item</h1>
<form method="POST" action="/item/update/<?php echo $item->id; ?>">
    <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($item->name); ?>"></label><br>
    <label>Quantity: <input type="number" name="quantity" value="<?php echo (int)$item->quantity; ?>"></label><br>
    <label>Price:
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($item->price); ?>">
    </label><br>
    <button type="submit">Update</button>
</form>
</body>
</html>
