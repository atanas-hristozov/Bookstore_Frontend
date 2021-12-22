<?php
require_once 'header.php';
define('URLBASE2','http://test.local/final_project');
$product_id = $_GET['id'];
$query = "SELECT books.*, authors.name, publishers.title  ,  books.title as booktitle  , categories.title as categorytitle FROM books INNER JOIN authors ON books.author_id=authors.id     JOIN categories ON category_id = categories.id     JOIN publishers ON publisher_id = publishers.id WHERE books.id=$product_id";
$result = $conn->query($query);


?> 
            <section class="book">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    $category[] = $row;
                ?>
                <div class="book-info">
                    <img src="<?php echo URLBASE2 . '/common/uploads/' . $row['image']; ?>" alt="">
                    <div class="book-info-desc">
                        <h2><?php echo htmlspecialchars($row['booktitle']);?></h2>
                        <h3><?php echo htmlspecialchars($row['name']);?></h3>
                        <table>
                            <tr>
                                <td>Издател</td>
                                <td><?php echo htmlspecialchars($row['title']);?></td>
                            </tr>
                            <tr>
                                <td>Брой страници</td>
                                <td><?php echo htmlspecialchars($row['pages']);?></td>
                            </tr>
                            <tr>
                                <td>Година на издаване</td>
                                <td><?php echo htmlspecialchars($row['year']);?></td>
                            </tr>
                            <tr>
                                <td>Език</td>
                                <td><?php echo htmlspecialchars($row['lang']);?></td>
                            </tr>
                            <tr>
                                <td>ISBN</td>
                                <td><?php echo htmlspecialchars($row['isbn']);?></td>
                            </tr>
                            <tr>
                                <td>Категория</td>
                                <td><?php echo htmlspecialchars($row['categorytitle']);?></td>
                            </tr>
                        </table>
                        <div class="book-info-desc-item">
                            <p class="book-info-desc-item-he">Анотация</p>
                            <p class="book-info-desc-item-pe">
                                <?php echo htmlspecialchars_decode($row['description']);?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <form class="book-price" method="post">
                <?php
                    $book_id=$_GET['id'];
                ?>
                    <input id="bookid" name="bookid" type="hidden" value=<?php echo $book_id;?>>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    
                    <div class="book-price-cost">
                        <p>Цена: </p>
                        <p><?php echo htmlspecialchars($row['price']);?> лв</p>
                    </div>
                    <button type="submit" name="add">
                        Купи
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </button>
                </form>


                    <?php
                }
            }
            ?>
            </section>

            <section class="simbook">
            
                <h3>Подобни книги</h3>
                <div class="simbook-table">
                <?php
                    $newcategory= $category[0]['category_id'];
                    $query_products = "SELECT books.*, authors.name FROM books INNER JOIN authors ON books.author_id = authors.id WHERE category_id=$newcategory LIMIT 6";
                    $result_products = $conn->query($query_products);
                    if ($result_products->num_rows > 0) {
                        while ($row_product = $result_products->fetch_assoc()){
                            ?>
                    <a href="<?php echo URLBASE2; ?>/Frontend/book.php?id=<?php echo $row_product['id']; ?>" class="simbook-table-item">
                        <img src="<?php echo URLBASE2 . '/common/uploads/' . $row_product['image']; ?>" alt="">
                        <p class="simbook-table-item-name"><?php echo $row_product['title']; ?></p>
                        <p class="simbook-table-item-author"><?php echo $row_product['name']; ?></p>
                        <form class="simbook-table-item-price" method="post">
                            <div class="simbook-table-item-price-value">
                                <p>Цена:</p>
                                <p><?php echo $row_product['price']; ?> лв</p>
                            </div>
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
            </section>
<?php
require_once 'footer.php';
?>  