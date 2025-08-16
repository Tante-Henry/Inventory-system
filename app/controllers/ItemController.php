<?php

class ItemController
{
    /**
     * Display a listing of all items.
     */
    public function index()
    {
        $items = Item::all();
        require __DIR__ . '/../views/items/index.php';
    }

    /**
     * Display the specified item or show a 404 page if not found.
     */
    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
        }
        require __DIR__ . '/../views/items/show.php';
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        require __DIR__ . '/../views/items/create.php';
    }

    /**
     * Store a newly created item after validating the request data.
     */
    public function store()
    {
        $data = $this->validateRequest($_POST);
        if ($data === false) {
            http_response_code(400);
            echo 'Invalid input';
            return;
        }
        $item = Item::create($data);
        header('Location: /items/' . $item->id);
        exit;
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
        }
        require __DIR__ . '/../views/items/edit.php';
    }

    /**
     * Update the specified item after validating the request data.
     */
    public function update($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
        }
        $data = $this->validateRequest($_POST, true);
        if ($data === false) {
            http_response_code(400);
            echo 'Invalid input';
            return;
        }
        $item = Item::update($id, $data);
        header('Location: /items/' . $item->id);
        exit;
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
        }
        Item::delete($id);
        header('Location: /items');
        exit;
    }

    /**
     * Validate request data. When $partial is true fields are optional.
     */
    private function validateRequest($input, $partial = false)
    {
        $data = [];

        if (isset($input['name'])) {
            $name = trim($input['name']);
            if ($name === '') {
                return false;
            }
            $data['name'] = $name;
        } elseif (!$partial) {
            return false;
        }

        if (isset($input['quantity'])) {
            $quantity = filter_var($input['quantity'], FILTER_VALIDATE_INT);
            if ($quantity === false) {
                return false;
            }
            $data['quantity'] = $quantity;
        } elseif (!$partial) {
            return false;
        }

        if (isset($input['price'])) {
            $price = filter_var($input['price'], FILTER_VALIDATE_FLOAT);
            if ($price === false) {
                return false;
            }
            $data['price'] = $price;
        } elseif (!$partial) {
            return false;
        }

        return $data;
    }

    /**
     * Render the 404 error page and terminate execution.
     */
    private function notFound()
    {
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
        exit;
    }
}
