<?php

namespace App;

use App\Abstract\AbstractProduct;
use App\Interfaces\StockableInterface;

class Electronic extends AbstractProduct implements StockableInterface
{
    private string $brand;

    public function __construct(int $id = 0, string $name = '', int $quantity = 0, string $brand = '')
    {
        parent::__construct($id, $name, $quantity);
        $this->brand = $brand;
    }

    public function addStocks(int $stock): self
    {
        $this->quantity += max(0, $stock);
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        $this->quantity -= max(0, $stock);
        if ($this->quantity < 0) $this->quantity = 0;
        return $this;
    }

    public function create(): bool
    {
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // insert parent product
            $stmt = $pdo->prepare("INSERT INTO product (name, quantity, createdAt, updatedAt) VALUES (:name, :quantity, :createdAt, :updatedAt)");
            $now = (new \DateTime())->format('Y-m-d H:i:s');
            $stmt->execute([
                ':name' => $this->name,
                ':quantity' => $this->quantity,
                ':createdAt' => $now,
                ':updatedAt' => $now,
            ]);

            $this->id = (int) $pdo->lastInsertId();

            // insert child electronic row using product_id as PK/FK
            $stmt2 = $pdo->prepare("INSERT INTO electronic (product_id, brand) VALUES (:product_id, :brand)");
            $stmt2->execute([
                ':product_id' => $this->id,
                ':brand' => $this->brand,
            ]);

            return true;
        } catch (\PDOException $e) {
            echo "Erreur (Electronic::create): " . $e->getMessage();
            return false;
        }
    }
    public function update(): bool
    {
        if ($this->id <= 0) {
            return false;
        }

        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            // update parent product
            $stmt = $pdo->prepare("UPDATE product SET name = :name, quantity = :quantity, updatedAt = :updatedAt WHERE id = :id");
            $stmt->execute([
                ':name' => $this->name,
                ':quantity' => $this->quantity,
                ':updatedAt' => (new \DateTime())->format('Y-m-d H:i:s'),
                ':id' => $this->id,
            ]);

            // update child electronic row (REPLACE to create if missing)
            $stmt2 = $pdo->prepare("REPLACE INTO electronic (product_id, brand) VALUES (:product_id, :brand)");
            $stmt2->execute([
                ':product_id' => $this->id,
                ':brand' => $this->brand,
            ]);

            return true;
        } catch (\PDOException $e) {
            echo "Erreur (Electronic::update): " . $e->getMessage();
            return false;
        }
    }
    public static function findOneById(int $id): self|false
    {
        return false;
    }
    public static function findAll(): array
    {
        return [];
    }
}
