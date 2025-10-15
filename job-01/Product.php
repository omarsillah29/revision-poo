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

        return new Category($data['id'], $data['name'], $data['description'], $data['categoryId']);
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
}
