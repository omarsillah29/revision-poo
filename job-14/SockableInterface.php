<?php
interface SockableInterface
{
    /**
     * Add stock units to the product and return $this for chaining
     */
    public function addStocks(int $stock): self;

    /**
     * Remove stock units from the product and return $this for chaining
     */
    public function removeStocks(int $stock): self;
}
