<?php
require_once 'header.php';

define('URLBASE1','http://test.local/final_project');

$query = "SELECT id, title, image FROM categories LIMIt 2";
$result = $conn->query($query);
?>  
            <section class="section-home-slideshow">
                <h2>Нашите най-актуални предложения</h2>
                <div>
                    <div class="slideshow-container">
                        <div class="mySlides fade">
                        <div class="numbertext">1 / 4</div>
                        <img src="img/Banner_05.jpg" style="width:100%">
                        <div class="text">Промоция 1</div>
                        </div>
                    
                        <div class="mySlides fade">
                        <div class="numbertext">2 / 4</div>
                        <img src="img/Banner_03.jpg" style="width:100%">
                        <div class="text">Промоция 2</div>
                        </div>
                    
                        <div class="mySlides fade">
                        <div class="numbertext">3 / 4</div>
                        <img src="img/Banner_04.jpg" style="width:100%">
                        <div class="text">Промоция 3</div>
                        </div>

                        <div class="mySlides fade">
                        <div class="numbertext">4 / 4</div>
                        <img src="img/Banner_01.jpg" style="width:100%">
                        <div class="text">Промоция 4</div>
                        </div>
                    
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br>
                    
                    <div style="text-align:center">
                        <span class="dot" onclick="currentSlide(1)"></span>
                        <span class="dot" onclick="currentSlide(2)"></span>
                        <span class="dot" onclick="currentSlide(3)"></span>
                        <span class="dot" onclick="currentSlide(4)"></span>
                    </div>
                </div>
            </section>
            <section class="home-categories">
                <h3>Категории</h3>
                <div class="home-categories-number">
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result -> fetch_assoc()) {
                                ?>
                                    <a href="category.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']);?></a>
                    <div class="home-categories-number-table">
                        <?php
                        $row_id = $row['id'];
                        $query_products = "SELECT books.*, authors.name FROM books INNER JOIN authors ON books.author_id = authors.id WHERE category_id=$row_id LIMIT 6";
                        $result_products = $conn->query($query_products);

                        if ($result_products->num_rows > 0) {
                            while ($row_product = $result_products->fetch_assoc()){
                                ?>
                                    <a href="<?php echo URLBASE1; ?>/Frontend/book.php?id=<?php echo $row_product['id']; ?>" class="home-categories-number-table-item">
                                        <img src="<?php echo URLBASE1 . '/common/uploads/' . $row_product['image']; ?>" alt="">
                                        <p class="home-categories-number-table-item-name"><?php echo $row_product['title']; ?></p>
                                        <p class="home-categories-number-table-item-author"><?php echo $row_product['name']; ?></p>
                                        <form class="home-categories-number-table-item-price" method="post">
                                            <p>Цена: <?php echo $row_product['price']; ?>лв</p>
                                            <button type="submit" name="add" >
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            </button>
                                            <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
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
                </div>
            </section>

<?php
require_once 'footer.php';
?>  

<script>
        var slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
    }
</script>