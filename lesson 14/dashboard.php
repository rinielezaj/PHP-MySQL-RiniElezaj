<?php include_once("header.php");?>


    <?php

    include_once("config.php");

    $sql="SELECT * FROM products";

    $getProducts=$conn->prepare($sql);

    $getProducts->execute();

    $products=$getProducts->fetchAll();

    ?>
    <nav>
        <a href="logout.php" class="nav-link">Sign Out</a>
    </nav>
<table>
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Update</th>
    </thead>
    <tbody>
        <?php
        foreach($products as $product){
        ?>
        <tr>
            <td><?= $product['id']?></td>
            <td><?= $product['name']?></td>
            <td><?= $product['category_id']?></td>
            <td><?= "<a href='delete.php?id=$product[id]'>Delete</a> | <a href='edit.php?id=$product[id]'>Update</a> "?> </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<a href="add.php">Add</a>

<?php include_once("footer.php");?>
