<?php
require_once 'header.php';
?> 

          <section class="contacts">
            <h1>Контакти</h1>
            <div class="contacts-direction">
              <div class="contacts-direction-info">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <p>bookstore@gmail.com</p>
              </div>
              <div class="contacts-direction-info">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p>+359 888 88 88 88</p>
              </div>
              <div class="contacts-direction-info">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <p>София, България</p>
              </div>
            </div>
          </section>

          <section class="contacts-question">
            <h3>
              Задайте вашите въпроси
            </h3>
            <form class="contacts-question-form" action="contactform.php" method="post">
              <div class="contacts-question-form-id">
                <div>
                  <label for="name">Име</label>
                  <input type="text" id="name" name="name" placeholder="Вашето име">
                </div>
                <div>
                  <label for="mail">Електронна поща</label>
                  <input type="email" id="mail" name="mail" placeholder="Вашата електронна поща">
                </div>
              </div>
              <div class="contacts-question-form-text">
                <label for="question">Вашето запитване</label>
                <textarea id="question" name="question" placeholder="Вашето запитване"></textarea>
              </div>
              <button class="contacts-question-form-button" type="submit" name="submit">ИЗПРАЩАНЕ</button>
            </form>
          </section>

          
<?php
require_once 'footer.php';
?>  