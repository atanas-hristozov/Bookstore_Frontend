<?php
require_once 'header.php';

define('URLBASE7','http://test.local/final_project');

$product_id=array_column($_SESSION['cart'], 'product_id');
$query = "SELECT books.*, authors.name FROM books INNER JOIN authors ON books.author_id = authors.id";
$result = $conn->query($query);

$total = 0;

?>  

<section class="chekout">
        <div class="chekout-order">
            <h2>Вашата поръчка</h2>
            <table class="chekout-order-table">
                <thead>
                <tr>
                    <th scope="col">Име</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Цена</th>
                </tr>
                </thead>
                    <?php
                        if($result->num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                foreach($product_id as $id){
                                    if($row['id'] == $id){
                                        $total = $total + (int)$row['price'];?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['title']);?></td>
                                        <td><?php echo htmlspecialchars($row['name']);?></td>
                                        <td><?php echo htmlspecialchars($row['price']);?> лв</td>
                                    </tr>
                                <?php
                                    }
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="chekout-price">
            <h3>Обща сума: <?php echo $total?> лв</h3>
        </div>
        <div class="contacts-question">
            <h1>Вашите данни</h1>
            <?php
            if(isset($_SESSION['login_user'])){
                $customer_id2 = $_SESSION['login_user'];
                $query = "SELECT customers.* FROM customers where id = $customer_id2"; 
                $result = $conn->query($query);
            
                if(!$result) die("Fatal error");
                $rows = $result->num_rows;
                $row = $result -> fetch_assoc();
            }
            ?>
            <form class="contacts-question-form" action="chek_out.php" method="POST" enctype="multipart/form-data" novalidate>
            
                <div class="contacts-question-form-id">
                    <div>
                        <label for="name">Име *</label>
                        <input type="text" name="name" id="name" placeholder="name" autocomplete="off" required value="<?php echo($row != "") ? htmlspecialchars($row['name']) : "";?>">
                    </div>
                    <div>
                        <label for="email">Електронна поща *</label>
                        <input type="email" name="email" id="email" placeholder="email" autocomplete="off" required value="<?php echo($row != "") ? htmlspecialchars($row['email']) : "";?>">
                    </div>
                </div>
                <div class="contacts-question-form-id">
                    <div>
                        <label for="phone">Телефон *</label>
                        <input type="number" id="phone" name="phone" placeholder="Вашият телефон" required value="<?php echo($row != "") ? htmlspecialchars($row['phone']) : "";?>">
                    </div>
                    <div>
                        <label for="address">Адрес *</label>
                        <input type="text" id="address" name="address" placeholder="Вашият адрес" required value="<?php echo($row != "") ? htmlspecialchars($row['address']) : "";?>">
                    </div>
                </div>

                    <input id="total" name="total" type="hidden" value="<?php echo $total?>">
                    <input id="customer_id" name="customer_id" type="hidden" value="<?php echo htmlspecialchars($row['id']);?>">
                    <?php

                    $product_id=array_column($_SESSION['cart'], 'product_id');
                    $query = "SELECT books.*, authors.name FROM books INNER JOIN authors ON books.author_id = authors.id";
                    $result = $conn->query($query);

                        if($result->num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                $i=1;
                                
                                foreach($product_id as $id){
                                    if($row['id'] == $id){
                                        $added = "";

                                        

                                        ?>
                                    <input class="book_isbn" id="book_isbn_<?php echo $i;?>" name="book_isbn" type="hidden" value="<?php echo htmlspecialchars($row['isbn']);?>">
                                <?php
                                
                                    }
                                    $i++;
                                }
                            }
                        }
                    ?>
                <button class="contacts-question-form-button" type="submit" id="btn-sent" name="btn-sent" class="btn btn-custom btn-lg btn-block mt-3">Поръчване</button>
                <p id="success" style="display:none;color:green;"></p>
                <p id="error" style="display:none;color:red;"></p>
            </form>
        </div>
</section>


<script>
    
    $(document).ready(function () {
        $('#btn-sent').unbind().bind('click', function (e) {
            e.preventDefault();
            var customer_id = $('#customer_id').val();
            var total = $('#total').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var address = $('#address').val();

            var line_items = {};

                var i = 1;
            $('.contacts-question-form .book_isbn').each(function () {
                line_items['row_' + i] = {
                    booksid: $("#book_isbn_" + i).val(),
                }
                i++;
            });
            
            var form = $('form')[0];
            var formData = new FormData(form);
            if(name != ""){
                $.ajax({
                    type: 'POST',
                    data: {
                        customer_id: customer_id,
                        total: total,
                        name: name,
                        email: email,
                        phone: phone,
                        address: address,
                        line_items: JSON.stringify(line_items),

                    } ,
                    cache: false,
                    url: '../common/includes/customer/customer-order-01.php',
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        console.log(dataResult);
                        if(dataResult.statusCode == 200){
                            $('#warning').hide();
                            $('form').trigger('reset');
                            $('#success').show();
                            $('#success').html('Поръчката е направена успешно.');
                            window.location = './index.php?remove_cart=true';
                        } else if (dataResult.statusCode == 202){
                        $('#error').show();
                        $('#error').html('Невалидна електронна поща');
                        } else {
                            alert("Eroor");
                        }
                    }
                });
            } else {
                $('form').addClass('validate');
            }
        });
    });
    
</script>

<?php
require_once 'footer.php';
?>  