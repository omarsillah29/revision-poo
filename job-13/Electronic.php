<?php
require_once __DIR__ . '/AbstractProduct.php';

class Electronic extends AbstractProduct
{
    private string $brand;
    private int $warranty_fee;

    public function __construct(int $id = 0, string $name = '', array $photos = [], float $price = 0.0, string $description = '', int $quantity = 0, string $brand = '', int $warranty_fee = 0)
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }
    public function getWarrantyFee(): int
    {
        return $this->warranty_fee;
    }
    public function setBrand(string $b): void
    {
        $this->brand = $b;
    }
    public function setWarrantyFee(int $f): void
    {
        $this->warranty_fee = $f;
    }

    private static array $store = [];

    public function create(): bool
    {
        $this->id = count(self::$store) + 1;
        self::$store[$this->id] = $this;
        return true;
    }

    public function update(): bool
    {
        if ($this->id <= 0 || !isset(self::$store[$this->id])) return false;
        self::$store[$this->id] = $this;
        return true;
    }

    public static function findOneById(int $id): self|false
    {
        return self::$store[$id] ?? false;
    }

    public static function findAll(): array
    {
        return array_values(self::$store);
    }
}
