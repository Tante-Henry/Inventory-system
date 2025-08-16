-- Seed data for Inventory System
-- Passwords generated using PHP password_hash()

INSERT INTO users (username, password, role) VALUES
('admin', '$2y$12$oYBs4LNTDdp95CqhUQAENOdm8VNysCwwYZ8M74HEe66pjoBPaHYe2', 'admin'),
('jdoe', '$2y$12$RSQAOxq5yd99Me04QCZ.be.BJL16mpprLTpQ6SPiJfdn/oMFbFeZC', 'worker');

INSERT INTO categories (name) VALUES
('Electronics'),
('Furniture');

INSERT INTO suppliers (name, contact_info) VALUES
('Acme Corp', 'acme@example.com');

INSERT INTO products (category_id, supplier_id, name, price, stock) VALUES
(1, 1, 'Laptop', 999.99, 10),
(2, 1, 'Office Chair', 199.99, 20);

INSERT INTO items (name, quantity, price) VALUES
('Keyboard', 15, 49.99),
('Mouse', 30, 19.95),
('Monitor', 8, 129.50),
('USB Cable', 50, 5.99);

INSERT INTO workers (user_id, name, contact_info) VALUES
(2, 'John Doe', 'john@example.com');

INSERT INTO customers (name, contact_info) VALUES
('Jane Customer', 'jane@example.com');

INSERT INTO sales (product_id, customer_id, worker_id, quantity, total) VALUES
(1, 1, 1, 1, 999.99);

INSERT INTO audit_logs (user_id, action) VALUES
(1, 'Initial data seeding');
