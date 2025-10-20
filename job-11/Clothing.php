<?php
require_once __DIR__ . '/../job-01/Product.php';

class Clothing extends Product
{
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

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
        string $size = '',
        string $color = '',
        string $type = '',
        int $material_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $categoryId);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    // Getters
    public function getSize(): string
    {
        return $this->size;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMaterialFee(): int
    {
        return $this->material_fee;
    }

    // Setters
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setMaterialFee(int $fee): void
    {
        $this->material_fee = $fee;
    }

    // Persistence spécifiques pour Clothing (table clothing avec product_id PK/FK)
    // Note: parent Product::findOneById is an instance method returning Product|false
    // Keep compatible signature (bool|Product) and return a Clothing instance when found.
    public function findOneById(int $id, PDO $pdo): bool|Product
    {
        // Charger le product parent
        $product = new Product();
        $parent = $product->findOneById($id, $pdo);
        if ($parent === false) {
            return false;
        }

        $stmt = $pdo->prepare('SELECT * FROM clothing WHERE product_id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data === false) {
            return false;
        }

        return new Clothing(
            $parent->getId(),
            $parent->getName(),
            $parent->getPhotos(),
            $parent->getPrice(),
            $parent->getDescription(),
            $parent->getQuantity(),
            $parent->getCreatedAt(),
            $parent->getUpdatedAt(),
            $parent->getCategoryId(),
            $data['size'],
            $data['color'],
            $data['type'],
            (int)$data['material_fee']
        );
    }

    public static function findAll(PDO $pdo): array
    {
        $stmt = $pdo->query('SELECT p.*, c.size, c.color, c.type, c.material_fee FROM product p JOIN clothing c ON p.id = c.product_id');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $r) {
            $result[] = new Clothing(
                $r['id'],
                $r['name'],
                json_decode($r['photos'], true),
                $r['price'],
                $r['description'],
                $r['quantity'],
                new DateTime($r['createdAt']),
                new DateTime($r['updatedAt']),
                $r['category_id'],
                $r['size'],
                $r['color'],
                $r['type'],
                (int)$r['material_fee']
            );
        }
        return $result;
    }

    // Après création du product parent, appeler createChild pour insérer les données spécifiques
    public function createChild(PDO $pdo): bool
    {
        if ($this->getId() <= 0) {
            return false;
        }
        $stmt = $pdo->prepare('INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:product_id, :size, :color, :type, :material_fee)');
        return $stmt->execute([
            ':product_id' => $this->getId(),
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':material_fee' => $this->material_fee
        ]);
    }

    public function updateChild(PDO $pdo): bool
    {
        if ($this->getId() <= 0) {
            return false;
        }
        $stmt = $pdo->prepare('UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee WHERE product_id = :product_id');
        return $stmt->execute([
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':material_fee' => $this->material_fee,
            ':product_id' => $this->getId()
        ]);
    }
}
