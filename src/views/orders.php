<h4>Orders</h4>
<?php print(getAlert()); ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Besteldatum</th>
            <th scope="col">Bekijken</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $personID = $_SESSION['PersonID'];
        $stmt = $db->prepare("
                            SELECT O.OrderID, O.CustomerID, O.OrderDate
                            FROM orders O 
                            JOIN customers C 
                                ON O.CustomerID = C.CustomerID
                            WHERE C.PrimaryContactPersonID 
                                IN(SELECT PrimaryContactPersonID FROM customers WHERE PrimaryContactPersonID = :person_id)
                            ORDER BY O.OrderID DESC");
        $stmt->execute(['person_id' => $personID]);
        $results = $stmt->fetchAll();
        foreach ($results as $CustomerName) {
            print("<tr><th scope='row'>".$CustomerName['OrderID']."</th>");
            print("<td>".$CustomerName['OrderDate']."</td>");
            print("<td><a class='btn btn-primary' href='order.php?id=".$CustomerName['OrderID']."'>Bekijk</a></td>");
        }
    ?>
    </tbody>
</table>