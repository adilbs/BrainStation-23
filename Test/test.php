<?php
 include_once 'database.php';
 include_once 'item.php';
 include_once 'category.php';

 // get database connection
 $database = new Database();
 $db = $database->getConnection();
 $category = new Category($db);

$children = $category->getCategoryChildren(1);

$data =$children->fetchAll(PDO::FETCH_ASSOC);

// var_dump($data);

function mysql_query($db,$query){
    
    $stmt = $db->prepare( $query );
    $stmt->execute();

}
function getallchild($db,$catId){
    $category = new Category($db);
    $childrens = $category->getCategoryChildren($catId)->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($childrens);
    return $childrens;
}

 function nested($db,$catId, $left = 0)
 {
    // print_r($catId);
      $right = $left + 1;
      $children = getallchild($db,$catId);
      foreach($children as $child)
            // print_r($child['categoryId']);
            $right = nested($db,(int)$child['categoryId'], $right);
      
    mysql_query($db,"INSERT INTO nested_category VALUES($catId, $left, $right)");    
 
      return $right + 1;
 }
 
 nested($db,109);

 ?>
