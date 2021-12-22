<?php
require_once 'header.php';
$customer_id2 = $_SESSION['login_user'];
$query = "SELECT customers.* FROM customers where id = $customer_id2"; 
$result = $conn->query($query);

if(!$result) die("Fatal error");
$rows = $result->num_rows;
?> 

          <section class="profile">
              <h2>Моят профил</h2>
              <div class="profile-style">
                <div class="profile-style-person">
                    <img src="img/profile_picture.png">
                    <div class="profile-style-person-info">
                    <?php $row = $result -> fetch_assoc() ?>
                        <h3>Име:</h3>
                        <h3><?php echo htmlspecialchars($row['name']);?></h3>
                        <p>Телефон:</p>
                        <p><?php echo htmlspecialchars($row['phone']);?></p>
                        <p>E-mail:</p>
                        <p><?php echo htmlspecialchars($row['email']);?></p>
                        <p>Адрес:</p>
                        <p><?php echo htmlspecialchars($row['address']);?></p>
                    </div>
                </div>
                <div class="profile-style-orders">
                    <h3>Моите поръчки</h3>
                    <table>
                        <tr>
                            <td>Поръчка №</td>
                            <td>Дата</td>
                            <td>Книги</td>
                            <td>Стойност</td>
                        </tr>
                        <?php
                        $customer_id = $_SESSION['login_user'];
                        $query = "SELECT orders.* FROM orders where orders.customer_id='$customer_id'"; 
                        $result = $conn->query($query);
                        
                        if(!$result) die("Fatal error");
                        
                        $rows = $result->num_rows;
                        
                        if($result->num_rows > 0){
                            while($row = $result -> fetch_assoc()){ ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']);?></td>
                                        <td><?php echo date("d.m.Y", strtotime($row['purchase_date']));?></td>
                                        <td><?php 
                                        $line_items = json_decode($row['book_isbn']);
                                        $count_items = count((array)$line_items);
                                        $i=1;

                                        foreach($line_items as $item) {
                                            echo $item->booksid;
                                            if($count_items != $i){
                                                echo ", ";
                                            }
                                            
                                            $i++;
                                        }
                                        ?></td>
                                        <td><?php echo htmlspecialchars($row['total']);?></td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                    </table>
                </div>
              </div>
          </section>
          <form class="section-logout-btn" method="POST">
            <button type="button" id="btn-logout">Излизане от профила</button>
          </form>
          
<?php
require_once 'footer.php';
?>  

<script>
  $('#btn-logout').unbind().bind('click',function(e){
    e.preventDefault();
    $.ajax({
      type:'POST',
      cache:false,
      url: '../common/includes/customer/customer-logout.php',
      success:function(dataResult){
        var dataResult = JSON.parse(dataResult);
          if (dataResult.statusCode == 200) {
              window.location = "./index.php";
          } else if (dataResult.statusCode == 201) {
              alert('Error');
          }
      }
    });
  });
</script>