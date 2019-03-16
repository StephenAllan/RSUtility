<?php

namespace AppBundle\Model;

class Item
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var boolean */
    private $tradeable;

    /** @var int */
    private $value;

    /** @var double */
    private $profit;

    /** @var double */
    private $highestBuyPrice;

    /** @var double */
    private $flippingMargin;

    /** @var int */
    private $buying;

    /** @var int */
    private $buyingQuantity;

    /** @var int */
    private $selling;

    /** @var int */
    private $sellingQuantity;

    /** @var int */
    private $overall;



    // Define Functions

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function isTradeable()
    {
        return $this->tradeable;
    }

    /**
     * @param boolean $tradeable
     */
    public function setTradeable($tradeable)
    {
        $this->tradeable = $tradeable;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return double
     */
    public function getHighAlchemyValue()
    {
        return $this->value * 0.6;
    }

    /**
     * @return float
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @param float $profit
     */
    public function setProfit($profit)
    {
        $this->profit = $profit;
    }

    /**
     * @return float
     */
    public function getHighestBuyPrice()
    {
        return $this->highestBuyPrice;
    }

    /**
     * @param float $highestBuyPrice
     */
    public function setHighestBuyPrice($highestBuyPrice)
    {
        $this->highestBuyPrice = $highestBuyPrice;
    }

    /**
     * @return float
     */
    public function getFlippingMargin()
    {
        return $this->flippingMargin;
    }

    /**
     * @param float $flippingMargin
     */
    public function setFlippingMargin($flippingMargin)
    {
        $this->flippingMargin = $flippingMargin;
    }

    /**
     * @return int
     */
    public function getBuying()
    {
        return $this->buying;
    }

    /**
     * @param int $buying
     */
    public function setBuying($buying)
    {
        $this->buying = $buying;
    }

    /**
     * @return int
     */
    public function getBuyingQuantity()
    {
        return $this->buyingQuantity;
    }

    /**
     * @param int $buyingQuantity
     */
    public function setBuyingQuantity($buyingQuantity)
    {
        $this->buyingQuantity = $buyingQuantity;
    }

    /**
     * @return int
     */
    public function getSelling()
    {
        return $this->selling;
    }

    /**
     * @param int $selling
     */
    public function setSelling($selling)
    {
        $this->selling = $selling;
    }

    /**
     * @return int
     */
    public function getSellingQuantity()
    {
        return $this->sellingQuantity;
    }

    /**
     * @param int $sellingQuantity
     */
    public function setSellingQuantity($sellingQuantity)
    {
        $this->sellingQuantity = $sellingQuantity;
    }

    /**
     * @return int
     */
    public function getOverall()
    {
        return $this->overall;
    }

    /**
     * @param int $overall
     */
    public function setOverall($overall)
    {
        $this->overall = $overall;
    }
}
