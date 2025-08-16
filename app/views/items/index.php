<!DOCTYPE html>
<html>
<head>
    <title>Items</title>
</head>
<body>
<h1>Items</h1>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item->name); ?></td>
            <td><?php echo (int)$item->quantity; ?></td>
            <td><?php echo htmlspecialchars($item->price); ?></td>
            <td>
                <a href="/item/edit/<?php echo $item->id; ?>">Edit</a>
                <a href="/item/destroy/<?php echo $item->id; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p><a href="/item/create">Create Item</a></p>
</body>
</html>
