<?php
require_once '../common/includes/dbconnect.php';

define('URLBASE','http://test.local/final_project');


$query = "SELECT id, title, image FROM categories";
$result = $conn->query($query);

if(!$result) die("Fatal error");


$page = basename($_SERVER['PHP_SELF']); 
switch ($page){
case 'Index.php':
    $title= 'Начална';
    break;

case 'book.php':
    $title= 'Книга';
    break;

case 'Categories.php':
    $title= 'Категории';
    break;

case 'category.php':
    $title= 'Категория';
    break;

case 'Contacts.php':
    $title= 'Контакти';
    break;

case 'profile_login.php':
    $title= 'Влизане в рофил';
    break;

case 'Profile_registration.php':
    $title= 'Регистрация';
    break;

case 'Profile.php':
    $title= 'Профил';
    break;

default: 
$title="bookstore";

}

session_start();

if(isset($_POST['add'])){
    if(isset($_SESSION['cart'])){
        $item_array_id=array_column($_SESSION['cart'], "product_id");
        if(in_array($_POST['product_id'],$item_array_id)){
            echo "<script> alert('Product is already added in the cart!')</script>";
            echo "<script> window.location='index.php'</script>";
        }else{
            $count=count($_SESSION['cart']);
            $item_array=array(
                'product_id'=>$_POST['product_id'],
                'product_qty'=>1
            );
            $_SESSION['cart'][$count]=$item_array;
        }
    }else{
        $item_array=array(
            'product_id'=>$_POST['product_id'],
            'product_qty'=>1
        );
        $_SESSION['cart'][0] = $item_array;
        //print_r($_SESSION['cart']);
    }
}


if(isset($_GET['remove_cart'])){
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/main.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/header.js"></script>
    <script src="js/dropdown.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" href="img/Tab.png">
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="container">
        <div class="main-field">
            <header class="header">
                <div class="header-content">
                    <a href="Index.php" class="logo"><img src="img/logo_01.png" alt=""></a>
                    <input class="menu-btn" type="checkbox" id="menu-btn" />
                    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
                    <ul class="menu">
                    <li><a href="Index.php">Начало</a></li>
                    <li class="dropdown">
                        <button onclick="myFunction()" class="dropbtn">Категории <i class="fa fa-caret-down" aria-hidden="true"></i>                        
                        </button>
                        <div id="myDropdown" class="dropdown-content">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result -> fetch_assoc()) {
                                    ?>
                                        <a href="category.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']);?></a>
                                    <?php
                                }
                            }
                            ?>
                            <a href="Categories.php">Всички категории</a>
                        </div>
                    </li>
                    <li><a href="Contacts.php">Контакти</a></li>
                    <li class="dropdown">
                        <button onclick="myFunction1()" class="dropbtn">Профил/Количка <i class="fa fa-caret-down" aria-hidden="true"></i>                        
                        </button>
                        <div id="myDropdown1" class="dropdown-content header-user">
                            <?php 
                                if(isset($_SESSION['login_user'])){
                                    ?>
                                    <a class="header-user-link" href="profile.php">
                                    <?php
                                } else {
                                    ?>
                                    <a class="header-user-link" href="profile_login.php">
                                    <?php
                                }?>
                                
                                
                                
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <p>Моят Профил</p>
                            </a>
                            <a class="header-user-link" href="shopping-cart.php">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <p>Количка
                                <?php 
                                    if(isset($_SESSION['cart'])){
                                        $count = count($_SESSION['cart']);
                                        echo"<span>$count</span>";
                                    } else{
                                        echo"<span>0</span>";
                                    }
                                ?></p>
                            </a>
                        </div>
                    </li>
                    </ul>
                </div> 
            </header>
            <section class="section-home-profile">
                <form class="section-home-profile-search" action="search.php" method="POST">
                    <input type="text" name="search" placeholder="Търсене на книга">
                    <button type="submit" name="submit-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
                <div class="section-home-profile-user">
                                <?php 
                                if(isset($_SESSION['login_user'])){
                                    ?>
                                    <a class="header-user-link" href="profile.php">
                                    <?php
                                } else {
                                    ?>
                                    <a class="header-user-link" href="profile_login.php">
                                    <?php
                                }?>
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <p>Моят Профил</p>
                    </a>
                    <a href="shopping-cart.php">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <p>Количка
                        <?php 
                            if(isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                                echo"<span>$count</span>";
                            } else{
                                echo"<span>0</span>";
                            }
                        ?></p>
                    </a>
                </div>
            </section>