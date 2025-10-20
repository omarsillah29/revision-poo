<?php
require_once __DIR__ . '/../job-01/Product.php';

class Electronic extends Product
{
    private string $brand;
    private int $waranty_fee;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        float $price = 0.0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        int $categoryId = 0,
        string $brand = '',
        int $waranty_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $categoryId);
        $this->brand = $brand;
        $this->waranty_fee = $waranty_fee;
    }

    // Getters
    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getWarantyFee(): int
    {
        return $this->waranty_fee;
    }

    // Setters
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setWarantyFee(int $fee): void
    {
        $this->waranty_fee = $fee;
    }

    // Persistence spécifiques pour Electronic (table electronic avec product_id PK/FK)
    public function findOneById(int $id, PDO $pdo): bool|Product
    {
        $product = new Product();
        $parent = $product->findOneById($id, $pdo);
        if ($parent === false) {
            return false;
        }

        $stmt = $pdo->prepare('SELECT * FROM electronic WHERE product_id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            return false;
        }

        return new Electronic(
            $parent->getId(),
            $parent->getName(),
            $parent->getPhotos(),
            $parent->getPrice(),
            $parent->getDescription(),
            $parent->getQuantity(),
            $parent->getCreatedAt(),
            $parent->getUpdatedAt(),
            $parent->getCategoryId(),
            $data['brand'],
            (int)$data['waranty_fee']
        );
    }

    public static function findAll(PDO $pdo): array
    {
        $stmt = $pdo->query('SELECT p.*, e.brand, e.waranty_fee FROM product p JOIN electronic e ON p.id = e.product_id');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $r) {
            $result[] = new Electronic(
                $r['id'],
                $r['name'],
                json_decode($r['photos'], true),
                $r['price'],
                $r['description'],
                $r['quantity'],
                new DateTime($r['createdAt']),
                new DateTime($r['updatedAt']),
                $r['category_id'],
                $r['brand'],
                (int)$r['waranty_fee']
            );
        }
        return $result;
    }

    public function createChild(PDO $pdo): bool
    {
        if ($this->getId() <= 0) {
            return false;
        }
        $stmt = $pdo->prepare('INSERT INTO electronic (product_id, brand, waranty_fee) VALUES (:product_id, :brand, :waranty_fee)');
        return $stmt->execute([
            ':product_id' => $this->getId(),
            ':brand' => $this->brand,
            ':waranty_fee' => $this->waranty_fee
        ]);
    }

    public function updateChild(PDO $pdo): bool
    {
        if ($this->getId() <= 0) {
            return false;
        }
        $stmt = $pdo->prepare('UPDATE electronic SET brand = :brand, waranty_fee = :waranty_fee WHERE product_id = :product_id');
        return $stmt->execute([
            ':brand' => $this->brand,
            ':waranty_fee' => $this->waranty_fee,
            ':product_id' => $this->getId()
        ]);
    }
}
