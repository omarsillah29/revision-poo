<?php
class Product
{
    private int $id;
    private string $name;
    private array $photos;
    private float $price;
    private string $description;
    private int $quantity;
    private int $categoryId;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        float $price = 0.0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        int $categoryId = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
        $this->categoryId = $categoryId;
    }



    // Getters 
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getPhotos(): array
    {
        return $this->photos;
    }
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getCategory(PDO $pdo): Category
    {
        $stmt = $pdo->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$this->categoryId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si aucune catégorie trouvée, lever une exception claire
        if ($data === false) {
            throw new RuntimeException('Catégorie introuvable (id=' . intval($this->categoryId) . ')');
        }

        // Le constructeur de Category attend id, name, description
        return new Category($data['id'], $data['name'], $data['description']);
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
        $this->updatedAt = new DateTime();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
        $this->updatedAt = new DateTime();
    }
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
        $this->updatedAt = new DateTime();
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
        $this->updatedAt = new DateTime();
    }
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->updatedAt = new DateTime();
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->updatedAt = new DateTime();
    }
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
        $this->updatedAt = new DateTime();
    }
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    public function findOneById(int $id, PDO $pdo): bool|Product
    {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }

        $this->setId($data['id']);
        $this->setName($data['name']);
        $this->setPhotos(json_decode($data['photos']));
        $this->setPrice($data['price']);
        $this->setDescription($data['description']);
        $this->setQuantity($data['quantity']);
        $this->setCreatedAt(new DateTime($data['createdAt']));
        $this->setUpdatedAt(new DateTime($data['updatedAt']));
        $this->setCategoryId($data['category_id']);

        return $this;
    }

    public static function findAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM product");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($rows as $data) {
            $product = new Product();
            $product->setId($data['id']);
            $product->setName($data['name']);
            $product->setPhotos(json_decode($data['photos']));
            $product->setPrice($data['price']);
            $product->setDescription($data['description']);
            $product->setQuantity($data['quantity']);
            $product->setCreatedAt(new DateTime($data['createdAt']));
            $product->setUpdatedAt(new DateTime($data['updatedAt']));
            $product->setCategoryId($data['category_id']);

            $products[] = $product;
        }

        return $products;
    }

    public function create(): Product|false
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
            INSERT INTO product (name, photos, price, description, quantity, createdAt, updatedAt, category_id)
            VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :updatedAt, :category_id)
        ");

            $stmt->execute([
                ':name' => $this->name,
                ':photos' => json_encode($this->photos),
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
                ':category_id' => $this->categoryId
            ]);

            $this->id = $pdo->lastInsertId();
            return $this;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
    public function update(): Product|false
    {
        if ($this->id === null) {
            return false; // Impossible de mettre à jour sans ID
        }

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=draft-shop', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
            UPDATE product SET
                name = :name,
                photos = :photos,
                price = :price,
                description = :description,
                quantity = :quantity,
                createdAt = :createdAt,
                updatedAt = :updatedAt,
                category_id = :category_id
            WHERE id = :id
        ");

            $stmt->execute([
                ':name' => $this->name,
                ':photos' => json_encode($this->photos),
                ':price' => $this->price,
                ':description' => $this->description,
                ':quantity' => $this->quantity,
                ':createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
                ':updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
                ':category_id' => $this->categoryId,
                ':id' => $this->id
            ]);

            return $this;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
