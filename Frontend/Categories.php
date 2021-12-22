<?php
require_once 'header.php';
define('URLBASE4','http://test.local/final_project');

$query = "SELECT id, title, image FROM categories";
$result = $conn->query($query);
?> 
      <section class="portfolio">
      <?php
          if ($result->num_rows > 0) {
            while ($row = $result -> fetch_assoc()) {
              ?>
                <div class="portfolio-section">
                  <div class="portfolio-section-name">
                  <a href="category.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']);?></a>
                  </div>
                  <a class="portfolio-section-cover" href="category.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo URLBASE4 . '/common/uploads/' . $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']);?>">
                    <div class="portfolio-section-cover-text">
                      <h2><?php echo htmlspecialchars($row['title']);?></h2>
                      <?php 
                        $newcategory= $row['id'];
                        $query_products = "SELECT books.title as btitle FROM books  WHERE category_id=$newcategory Limit 3";
                        $result_products = $conn->query($query_products);
                        if ($result_products->num_rows > 0) {
                          while ($row_products = $result_products -> fetch_assoc()) {
                      ?>
                      <p><?php echo $row_products['btitle']; ?></p>
                      <?php
                          }
                        }
                      ?>
                    </div>
                  </a>
                </div>
                <?php
              }
          }
        ?>
      </section>
<?php
require_once 'footer.php';
?>  