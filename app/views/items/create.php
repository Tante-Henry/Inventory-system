<!DOCTYPE html>
<html>
<head>
    <title>Create Item</title>
</head>
<body>
<h1>Create Item</h1>
<form method="POST" action="/item/store">
    <label>Name: <input type="text" name="name"></label><br>
    <label>Quantity: <input type="number" name="quantity"></label><br>
    <label>Price: <input type="number" step="0.01" name="price"></label><br>
    <button type="submit">Save</button>
</form>
</body>
</html>
