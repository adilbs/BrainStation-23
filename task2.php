<?php
include_once 'database.php';
include_once 'category.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
$category = new Category($db);

$data  = $category->getadjacencylist();


$ddata = $data->fetchAll(PDO::FETCH_ASSOC);

// var_dump($ddata);


function makeList($category, $par_id = 0) {
    //your sql code here
    $dbch = $category->getchild($par_id);
    $pages = $dbch->fetchAll();

    // var_dump($pages);
    if (count($pages)) {
        echo '<ul>';
        foreach ($pages as $page) {

            $cnt = $category->getitemcount((int)$page['id'] )->fetchAll(PDO::FETCH_ASSOC);
            if (count($cnt)){
                // echo '<li>', $page['id'], '('. $cnt[0]['item_count'] . ')';
                echo '<li>', ($category->getname((int)$page['id'])->fetchAll(PDO::FETCH_ASSOC))[0]['Name'], '('. $cnt[0]['item_count'] . ')';
            }else{
                
                // echo '<li>', $page['id'];
                echo '<li>', ($category->getname((int)$page['id'])->fetchAll(PDO::FETCH_ASSOC))[0]['Name'];
            }

            makeList($category,$page['id']);
            echo '</li>';
        }
        echo '</ul>';
    }
}

echo '<ul>';
    echo '<li> '.($category->getname(1)->fetchAll(PDO::FETCH_ASSOC))[0]['Name']. '</li>';
makeList($category,1);
echo '</ul>';

echo '<ul>';
    echo '<li> '.($category->getname(2)->fetchAll(PDO::FETCH_ASSOC))[0]['Name']. '</li>';
makeList($category,2);
echo '</ul>';
echo '<ul>';
    echo '<li> '.($category->getname(3)->fetchAll(PDO::FETCH_ASSOC))[0]['Name']. '</li>';
makeList($category,3);
echo '</ul>';
echo '<ul>';
    echo '<li> '.($category->getname(4)->fetchAll(PDO::FETCH_ASSOC))[0]['Name']. '</li>';
makeList($category,4);
echo '</ul>';

?>