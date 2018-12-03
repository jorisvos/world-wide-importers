<?php
    require('inc/config.php');

    // Define title variable
    $title = "Product";

    // lege StockItemID variabele die later ingevuld word (of niet)
    $StockItemID = "";
    // lege sql variabele die later ingevuld word
    $sql = '';
    // lege product variabele die later ingevuld word
    $product = '';

    // Controleer of 'id' is geset
    if (isset($_GET['id'])) {
        // Wijs 'id' toe aan StockItemID variabele
        $StockItemID = $_GET['id'];
        // Wijs sql toe
        $sql = 'SELECT * FROM stockitems s 
            LEFT JOIN colors c 
                ON s.ColorID = c.ColorID
            LEFT JOIN stockitemholdings h
                ON s.StockItemID = h.StockItemID
            WHERE s.StockItemID = :stockItemID';
        // Query wordt voorbereid
        $query = $db->prepare($sql);
        // Insert StockItemID from _GET in query
        $query->bindParam(':stockItemID', $StockItemID, PDO::PARAM_STR);
        // De query wordt uitgevoerd
        if ($query->execute()) {
            $product = $query->fetch();
        }
    }

    // Edit title variable to good title
    $title = $product['StockItemName'];

    // Defining view location
    $view = "product.php";

    // Including template
    include_once $template;
