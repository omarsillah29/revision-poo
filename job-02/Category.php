<?php
class Category
{
    private int $id;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    public function __construct(int $id, string $name, string $description,)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
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
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getProducts(PDO $pdo): array
    {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE category_id = ?");
        $stmt->execute([$this->id]);
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

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
