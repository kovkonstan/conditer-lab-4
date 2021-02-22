<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Кондитерская</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/carousel/">

    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>

    <link href="carousel.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery-1.7.min.js" ></script>
    <script type="text/javascript" src="validate.min.js"></script>
    <script type="text/javascript" src="js/jquery.form.js" ></script>
</head>
<body>

<?php
include_once 'classes.php';
$Link=new Link('localhost','root','','sklad');
?>

<?php
session_start();
if($Link->LoginIsExist($_SESSION['user']) != "OK"){
    header("Location: form.php");
    exit;
}
?>

<header>
    <nav class="navbar navbar-expand-md ">

    </nav>


    <nav class="navbar navbar-expand-md ">


    </nav>

    <div class="container marketing">


        <div class="row featurette" style="background-color: white;">
            <div class="wrap-111">
                <img class="logo1" src="logo.jpg" width="100px" height="100px" />

                <ul class="ul_item">
                    <li>
                        <a class="li_item" aria-current="page" href="index.html"><h2>ГЛАВНАЯ </h2></a>
                    </li>
                    <li>
                        <a class="li_item" href="catalog.html"><h2>ПРОДУКЦИЯ </h2></a>
                    </li>
                    <li>
                        <a id="korzina" class="li_item" href="cart.html"><h2>КОРЗИНА</h2></a>
                    </li>

                </ul>

                <div class="text_wrapper">
		  <span id="tel_adr">
		  Телефон: 8 (800) 854-98-98 </br>
              Адрес: Москва, ул. Академика Королева, 12
		  </span>


                    <img src="z1.png" align="right"/>
                    <img src="z2.png" align="right"/>
                </div>


            </div>
        </div>


</header>

<main>


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

        <hr class="featurette-divider">

        <div class="row head_row_new"><span id="header_new"><h1>Склад продукции</h1></span></div>






        <div id="content">




            <?php

            $page = 1;
            $itemsByPage = 5;
            if(isset($_GET['page'])){

                $page = $_GET['page'];
            }
            if(isset($_GET['itemsByPage'])){

                $itemsByPage = $_GET['itemsByPage'];
            }

            $warehouse=$Link->GetItemsByPage($page, $itemsByPage);

            if ($warehouse==FALSE) :
                echo '<div id="table">Нет ни одного товара</div>';
            else:?>

            <p>
                <?php
                if($page != 1)
                {
                    $prev = $page-1;
                    echo "<a href=\"sklad.php?page=1\"> << </a>";
                    echo "<a href=\"sklad.php?page=$prev\"> Пред </a>";
                }
                echo " Страница $page ";
                if($page != $warehouse["countOfPages"])
                {
                    $next = $page+1;
                    $countOfPages = $warehouse["countOfPages"];
                    echo "<a href=\"sklad.php?page=$next\"> След </a>";
                    echo "<a href=\"sklad.php?page=$countOfPages\"> >> </a>";
                }

                ?>
            </p>

            <table id="item-tabl">
                <thead>
                    <th>Наименование товара</th>
                    <th>Тип</th>
                    <th>Дата добавления</th>
                    <th>Количество</th>
                </thead>
                <tbody>
                <?php

                foreach ($warehouse["array"] as $item): ?>
                <tr>
                    <td><?php echo $item->GetName();?></td>
                    <td><?php echo $item->GetType();?></td>
                    <td><?php echo $item->GetDate();?></td>
                    <td><?php echo $item->GetCount();?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>

            <div><h3 class="right">Всего: <?php echo $Link->GetAllCount();?> товар(-ов)</h3> </div>
            <?php endif;?>

            <hr class="featurette-divider">

            <div class="table">
                <form method="post" action="add.php" name="add_item" class="additem">
                    <h3>Новый товар</h3>
                    <label>Наименование:</label>
                    <input type="text" name="name" />

                    <label>Количество:</label>
                    <input type="text" name="count" />
                    <label>Тип:</label>

                    <?php $types=$Link->GetTypes();?>
                    <select name="type">
                        <?php foreach ( $types as $type ) : ?>
                            <option value="<?php echo $type['id']?>"><?php echo $type['type_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <p class="error" id="error"></p>
                    <input type="submit"  name="addgood" value="Добавить" />
                </form>

            </div>

            <hr class="featurette-divider">

            <form method="post" class="addtype" name="addtype" action="addtype.php" >
                <h3>Добавить тип товара</h3>
                <input name="type_name" id="type_name" type="text"/>
                <p class="error" id="error_type"></p>
                <input type="submit" value="Добавить" />
            </form>
            <?php
            ?>
        </div>

        <script type="text/javascript">
            var validator_type = new FormValidator('addtype', [{
                name: 'type_name',
                rules: 'required|callback_check_name'
            }], function(errors, event) {
                if (errors.length > 0) {
                    var errorString = '';

                    for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                        errorString += errors[i].message + '<br />';
                    }

                    var el = document.getElementById('error_type');

                    el.innerHTML = errorString;
                }
            });

            validator_type.registerCallback('check_name', function(value) {
                if (value.length > 2) {
                    return true;
                }

                return false;
            }).setMessage('check_name', 'Введите корректное имя');
            validator_type.setMessage('required', 'Заполните, пожалуйста, все поля');

            var validator = new FormValidator('add_item', [{
                name: 'name',
                rules: 'required|callback_check_name'
            }, {
                name: 'count',
                rules: 'required|numeric|callback_check_count'
            }, {
                name: 'type',
                rules: 'required'
            }], function(errors, event) {
                if (errors.length > 0) {
                    var errorString = '';

                    for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
                        errorString += errors[i].message + '<br />';
                    }

                    var el = document.getElementById('error');

                    el.innerHTML = errorString;
                }
            });

            validator.registerCallback('check_count', function(value) {
                if (value > 0) {
                    return true;
                }

                return false;
            }).setMessage('check_count', 'Введите корректное количество');

            validator.registerCallback('check_name', function(value) {
                if (value.length > 2) {
                    return true;
                }

                return false;
            }).setMessage('check_name', 'Введите корректное имя');

            validator.setMessage('required', 'Заполните, пожалуйста, все поля');
            validator.setMessage('numeric', 'Введите пожалуйста числовое значение в поле Количество');
        </script>

        <hr class="featurette-divider">
    </div>


    <!-- FOOTER -->
    <footer class="container">
        <a href="logout.php">Выход</a>
        <p class="float-end"><a href="#">Наверх</a></p>
        <p>&copy; 2021 Кондитерская &middot; <a href="#"> Политика конфиденциальности</a> &middot; <a href="#">Контакты</a></p>
    </footer>
</main>


<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
