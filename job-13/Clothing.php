<?php
require_once __DIR__ . '/AbstractProduct.php';

class Clothing extends AbstractProduct
{
    private string $size;
    private string $color;

    public function __construct(int $id = 0, string $name = '', array $photos = [], float $price = 0.0, string $description = '', int $quantity = 0, string $size = '', string $color = '')
    {
        parent::__construct($id, $name, $photos, $price, $description, $quantity);
        $this->size = $size;
        $this->color = $color;
    }

    public function getSize(): string
    {
        return $this->size;
    }
    public function getColor(): string
    {
        return $this->color;
    }
    public function setSize(string $s): void
    {
        $this->size = $s;
    }
    public function setColor(string $c): void
    {
        $this->color = $c;
    }

    // For demo: simple static storage
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
