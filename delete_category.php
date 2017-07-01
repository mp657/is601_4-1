<?php
require_once('database.php');

$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$category_name = filter_input(INPUT_POST, 'category_name');

if ($category_id != false) {
    //check to see if the categoryID is used in the product table
    $queryProduct = 'SELECT COUNT(*) FROM products WHERE categoryID = :category_id';
    $stmProduct = $db->prepare($queryProduct);
    $stmProduct->bindValue(':category_id', $category_id);
    $stmProduct->execute();
    $productCount = $stmProduct->fetch();
    $stmProduct->closeCursor();

    if ($productCount[0] == 0) {
        $query = 'DELETE FROM categories WHERE categoryID = :category_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $success = $statement->execute();
        $statement->closeCursor();
    } else {
        $categoryDeleteMessage = 'Category can not be deleted with name as ' . $category_name;
    }
}

// Display the Category List page
include('category_list.php');