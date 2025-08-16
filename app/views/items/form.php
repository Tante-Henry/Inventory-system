<?php /* Shared form for create and edit */ ?>
<label>Name: <input type="text" name="name" value="<?php echo isset($item) ? htmlspecialchars($item->name) : ''; ?>"></label><br>
<label>Quantity: <input type="number" name="quantity" value="<?php echo isset($item) ? (int)$item->quantity : ''; ?>"></label><br>
<label>Price: <input type="number" step="0.01" name="price" value="<?php echo isset($item) ? htmlspecialchars($item->price) : ''; ?>"></label><br>
<button type="submit"><?php echo isset($item) ? 'Update' : 'Save'; ?></button>

