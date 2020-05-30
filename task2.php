<?php
 include_once 'database.php';
 include_once 'item.php';

 // get database connection
 $database = new Database();
 $db = $database->getConnection();


function getName($db,$Id){

 $query = "
 SELECT Name FROM `category` WHERE Id=$Id;
 ";

 $stmt = $db->prepare( $query );
$stmt->execute();

$name = $stmt->fetchAll(PDO::FETCH_ASSOC);

return $name[0]['Name'];

}

$query = "
select t1.ParentcategoryId as lev1, t1.categoryId as lev2, t2.categoryId as lev3,t3.categoryId as lev4, cat, total
            from catetory_relations as t1 
            left join catetory_relations as t2 on t1.categoryId = t2.ParentcategoryId
            left join catetory_relations as t3 on t2.categoryId = t3.ParentcategoryId
            left join catetory_relations as t4 on t3.categoryId = t4.ParentcategoryId
           
            
            LEFT join (SELECT categoryId as cat, count(ItemNumber) as total 
            FROM Item_category_relations group by categoryId)
            as test
            on t4.categoryId = test.cat 
            OR t3.categoryId = test.cat OR t2.categoryId = test.cat OR t1.categoryId = test.cat
            OR t1.ParentcategoryId = test.cat where t1.ParentcategoryId in 
            (SELECT Id FROM category where Id not in (Select categoryId from catetory_relations))
            order by lev1,lev2,lev3,lev4
";

$stmt = $db->prepare( $query );
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">

<?php foreach($data as $d): ?>

<ul class="list-inline"><?php print_r( getName($db, (int)$d['lev1']));?>
<li><?php print_r( getName($db, (int)$d['lev2']));?></li>
<li><?php print_r( getName($db, (int)$d['lev3']));?></li>

</ul>
    <?php endforeach; ?>
</div>
</body>
</html>