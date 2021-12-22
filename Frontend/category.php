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
                        <div class="category-table">
                            <?php
                                $row_id = $row['id'];
                                $query_products = "SELECT books.*, authors.name FROM books INNER JOIN authors ON books.author_id = authors.id WHERE category_id=$row_id";
                                $result_products = $conn->query($query_products);
                                if ($result_products->num_rows > 0) {
                                    while ($row_product = $result_products->fetch_assoc()){
                                        ?>
                                        <a href="<?php echo URLBASE1; ?>/Frontend/book.php?id=<?php echo $row_product['id']; ?>" class="category-table-item">
                                            <img src="<?php echo URLBASE1 . '/common/uploads/' . $row_product['image']; ?>" alt="">
                                            <p class="category-table-item-name"><?php echo $row_product['title']; ?></p>
                                            <p class="category-table-item-author"><?php echo $row_product['name']; ?></p>
                                            <form class="category-table-item-price" method="post">
                                                <p>Цена: <?php echo $row_product['price']; ?> лв</p>
                                                <?php
                                                $category_id=$_GET['id'];
                                                ?>
                                                <input id="categoryid" name="categoryid" type="hidden" value=<?php echo $category_id;?>>
                                                <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                                                <button type="submit" name="add">
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </a>
                                <?php
                                    }
                                }
                                ?>
                                
                        </div>
                <?php
                    }
                }
                ?>
        </section>
<?php
require_once 'footer.php';
?>  