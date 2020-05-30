<?php

class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "category";
 
    // object properties
    public $id;
    public $name;
    public $number;
    public $systemkey;
    public $note;
    public $priority;
    public $diabled;


 
    public function __construct($db){
        $this->conn = $db;
    }
 
    public function getadjacencylist(){

        $query = "
        SELECT categoryId as id ,catetory_relations.ParentcategoryId as parent
        FROM catetory_relations 
        
        ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
    
    public function getchild($id){

        $query = "
        SELECT categoryId as id
FROM catetory_relations
WHERE catetory_relations.ParentcategoryId=$id
        ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    public function getitemcount($id){

        $query = "
        SELECT  count(item_category_relations.ItemNumber) as item_count
FROM item_category_relations
WHERE item_category_relations.categoryId =$id
group BY item_category_relations.categoryId
        ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    public function getCategoryItems(){
 
        $query = "
        select cat.Name as catname, sum(total) as total
            from catetory_relations as t1 
            left join catetory_relations as t2 on t1.categoryId = t2.ParentcategoryId
            left join catetory_relations as t3 on t2.categoryId = t3.ParentcategoryId
            left join catetory_relations as t4 on t3.categoryId = t4.ParentcategoryId
            left join catetory_relations as t5 on t4.categoryId = t5.ParentcategoryId
            left join catetory_relations as t6 on t5.categoryId = t6.ParentcategoryId
            LEFT join (SELECT categoryId as cat, count(ItemNumber) as total 
            FROM Item_category_relations group by categoryId)
            as test
            on t6.categoryId = test.cat OR t5.categoryId = test.cat OR t4.categoryId = test.cat 
            OR t3.categoryId = test.cat OR t2.categoryId = test.cat OR t1.categoryId = test.cat
            OR t1.ParentcategoryId = test.cat 
            inner join (SELECT * FROM category where Id not in 
            (Select categoryId from catetory_relations)) as cat
            on t1.ParentcategoryId = cat.Id
            group by t1.ParentcategoryId ";

            
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;

    }
    public function getname($id){

$query = "
        select Name from category where category.Id = $id
        ";

            
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }

}

?>