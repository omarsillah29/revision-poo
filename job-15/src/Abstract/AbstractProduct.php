<?php

namespace App\Abstract;

abstract class AbstractProduct
{
    protected int $id;
    protected string $name;
    protected int $quantity;

    public function __construct(int $id = 0, string $name = '', int $quantity = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    abstract public function create(): bool;
    abstract public function update(): bool;
    abstract public static function findOneById(int $id): self|false;
    abstract public static function findAll(): array;
}
