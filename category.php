<?php
class Category{
 
    private $conn;
    private $table_name = "category";
 
    public $id;
    public $name;
    public $number;
    public $systemKey;
    public $note;
    public $priority;
    public $disabled;
 
    public function __construct($db){
        $this->conn = $db;
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

    public function getCategoryChildren($catId){

        $query = "
        select categoryId from catetory_relations where catetory_relations.ParentcategoryId=$catId;
        ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    
    }
 
   
}
?>

