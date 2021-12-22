<?php
require_once 'header.php';
define('URLBASE1','http://test.local/final_project');
$categoryid=$_GET['id'];
$query = "SELECT id, title, image FROM categories WHERE id=$categoryid";
$result = $conn->query($query);
?> 
        <section class="category">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result -> fetch_assoc()) {
                        ?>
                        <h1><?php echo htmlspecialchars($row['title']);?></h1>
                        <form class="category-table" action="add-book.php" method="POST">
                            <?php
                                $row_id = $row['id'];
                                $query_products = "SELECT id, title, image, price, author_id FROM books WHERE category_id=$row_id";
                                $result_products = $conn->query($query_products);
                                if ($result_products->num_rows > 0) {
                                    while ($row_product = $result_products->fetch_assoc()){
                                        ?>
                                        <a href="<?php echo URLBASE1; ?>/Frontend/book.php?id=<?php echo $row_product['id']; ?>" class="category-table-item">
                                            <img src="<?php echo URLBASE1 . '/common/uploads/' . $row_product['image']; ?>" alt="">
                                            <p class="category-table-item-name"><?php echo $row_product['title']; ?></p>
                                            <p class="category-table-item-author"><?php echo $row_product['author_id']; ?></p>
                                            <div class="category-table-item-price">
                                                <p>Цена: <?php echo $row_product['price']; ?></p>
                                                <input type="hidden" name="hidden_name" value="<?php echo $row_product['title']; ?>">
                                                <input type="hidden" name="hidden_price" value="<?php echo $row_product['price']; ?>">
                                                <button type="submit" name="add_to_cart" value="add to cart">
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </a>
                                <?php
                                    }
                                }
                                ?>
                        </form>
                <?php
                    }
                }
                ?>
        </section>
<?php
require_once 'footer.php';
?>  