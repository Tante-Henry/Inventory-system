<?php

class ItemController
{
    public function index()
    {
        $items = Item::all();
        require __DIR__ . '/../views/items/index.php';
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        require __DIR__ . '/../views/items/show.php';
    }

    public function create()
    {
        require __DIR__ . '/../views/items/create.php';
    }

    public function store()
    {
        $data = $this->validateRequest($_POST);
        if ($data === false) {
            http_response_code(400);
            echo 'Invalid input';
            return;
        }
        $item = Item::create($data);
        header('Location: /item/show/' . $item->id);
        exit;
    }

    public function edit($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        require __DIR__ . '/../views/items/edit.php';
    }

    public function update($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        $data = $this->validateRequest($_POST, true);
        if ($data === false) {
            http_response_code(400);
            echo 'Invalid input';
            return;
        }
        $item = Item::update($id, $data);
        header('Location: /item/show/' . $item->id);
        exit;
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        Item::delete($id);
        header('Location: /item/index');
        exit;
    }

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

    private function notFound()
    {
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
    }
}
