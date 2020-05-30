<?php
class Item{
  // database connection and table name
    private $conn;
    private $table_name = "item";
 
    // object properties
    public $id;
    public $customData;
    public $number;
    public $barcode;
    public $name1;
    public $name2;
    public $name3;
    public $note;
    public $discountGroup;
    public $priceGroup;
    public $statisticsGroup;
    public $price;
    public $priceCost;
    public $priceRecRetail;
    public $currency;
    public $vatRate;
    public $group;
    public $colli;
    public $allowOrderDiscount;
    public $stock;
    public $stockReserved;
    public $stockAvailable;
    public $stockOrdered;
    public $supplierName;
    public $supplierNumber;
    public $weight;
    public $volume;
    public $dimensions;
    public $unit;
    public $altltemNumber;
    public $image;
    public $sortPriority;
    public $stockStatus;

 
    public function __construct($db){
        $this->conn = $db;
    }
 
   
}
?>