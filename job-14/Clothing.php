<?php
require_once __DIR__ . '/SockableInterface.php';

class Clothing implements SockableInterface
{
    private int $id;
    private string $name;
    private int $quantity;

    public function __construct(int $id = 0, string $name = '', int $quantity = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
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

    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
