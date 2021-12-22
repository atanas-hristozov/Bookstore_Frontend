<?php
require_once 'header.php';
?> 
          <section class="contacts-question" style="background: none;">
            <h3>
              Регистрация на нов профил
            </h3>
            <form class="contacts-question-form">
              <div class="contacts-question-form-id">
                <div>
                  <label for="name">Име *</label>
                  <input type="text" name="name" id="name" placeholder="Потребителско име" autocomplete="off" required>
                </div>
                <div>
                    <label for="email">Електронна поща *</label>
                    <input type="email" name="email" id="email" placeholder="Електронна поща" required>
                </div>
              </div>
              <div class="contacts-question-form-id">
                <div>
                    <label for="password">Парола *</label>
                    <input type="password" id="password" name="password" placeholder="Вашата парола" required>
                </div>
                <div>
                    <label for="newpassword">Повторете парола *</label>
                    <input type="password" name="newpassword" id="newpassword" placeholder="Вашата парола" autocomplete="off" required>
                </div>
              </div>
              <div class="contacts-question-form-id">
                <div>
                    <label for="phone">Телефон *</label>
                    <input type="number" id="phone" name="phone" placeholder="Вашият телефон" required>
                </div>
                <div>
                  <label for="address">Адрес *</label>
                  <input type="text" id="address" name="address" placeholder="Вашият адрес" required>
                </div>
              </div>
              <button class="contacts-question-form-button" type="submit" id="btn-register1" class="btn btn-custom btn-lg btn-block mt-3">Регистриране</button>
              <p id="success" style="display:none;color:green;"></p>
              <p id="error" style="display:none;color:red;"></p>
            </form>
          </section>
<?php
require_once 'footer.php';
?>  

<script>
    $('#btn-register1').unbind().bind('click', function(e){
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var newpassword = $('#newpassword').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        if (name != "" && email != "" && password != "") {
          if(password === newpassword) {
            $.ajax({
                url: "../common/includes/customer/create-customer.php",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    phone: phone,
                    address: address,
                },
                cache: false,
                success: function(dataResult){  
                   var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode == 200){
                        $('#success').show();
                        $('#success').html('Успешна регистрация!');
                        window.location = './profile_login.php';
                    } else if (dataResult.statusCode == 201){
                        $('#error').show();
                        $('#error').html('Имейлът или името, което ползвате вече съществува');
                    } else if (dataResult.statusCode == 202){
                        $('#error').show();
                        $('#error').html('Невалидна електронна поща');
                    }
                    
                }
            });
          } else {
            alert('Паролите не съвпадат!')
          }
        } else {
            alert('Попълнете задължителните полета!')
        }
    });
</script>