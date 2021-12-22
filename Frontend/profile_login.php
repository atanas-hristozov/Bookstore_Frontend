<?php
require_once 'header.php';
?> 
          <section class="contacts-question" style="background: none;">
            <h3>
              Влизане в профила
            </h3>
            <form class="contacts-question-form" action="profile-login.php" method="POST" enctype="multipart/form-data" novalidate>
              <div class="contacts-question-form-id">
                <div>
                  <label for="name">Име</label>
                  <input type="text" id="name" name="name" placeholder="Вашето име" required>
                </div>
                <div>
                  <label for="Password">Парола</label>
                  <input type="text" id="password" name="Password" placeholder="Парола" required>
                </div>
              </div>
              <button class="contacts-question-form-button" type="button" id="btn-login1">Вход</button>
              <p id="success" style="display:none;color:green;"></p>
              <p id="error" style="display:none;color:red;"></p>
            </form>
          </section>
          <section class="login-registration">
            <h3>
              Ако нямате профил, може да се регистрирате тук:
            </h3>
            <a href="profile_registration.php">Към регистрацията</a>
          </section>
<?php
require_once 'footer.php';
?>  

<script>
    $('#btn-login1').unbind().bind('click',function(e){
        e.preventDefault();
        var name = $('#name').val();
        var password = $('#password').val();


        if(name != "" && password != "") {
            $.ajax({
                type: 'POST',
                data: {
                    name: name,
                    password: password,
                },
                cache: false,
                url: '../common/includes/customer/customer-login.php',
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode == 200){
                        window.location = './profile.php';
                    } else if(dataResult.statusCode == 201){
                        $('error').show();
                        $('#error').html('Паролата не съвпада.');
                    } else if(dataResult.statusCode == 202){
                        $('error').show();
                        $('#error').html('Няма такъв потребител.');
                    }
                }
            });
        } else {
            alert('Моля попълнете задължителните полета!')
        }
    });
</script>