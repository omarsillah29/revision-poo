<?php

namespace App\Interfaces;

interface StockableInterface
{
    public function addStocks(int $stock): self;
    public function removeStocks(int $stock): self;
}
