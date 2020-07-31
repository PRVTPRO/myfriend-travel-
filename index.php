
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Сколько мы уже собрали? - Давайте узнаем!</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/album/">
    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) { 
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="album.css" rel="stylesheet">
    <style type="text/css">
            ul.countdown {
                list-style: none;
                margin: 0px 0;
                padding: 0;
                display: block;
                text-align: center;
            }

            ul.countdown li {
                display: inline-block;
            }

            ul.countdown li span {
                font-size: 80px;
                font-weight: 300;
                line-height: 80px;
            }

            ul.countdown li.seperator {
                font-size: 80px;
                line-height: 70px;
                vertical-align: top;
            }

            ul.countdown li p {
                color: #a7abb1;
                font-size: 14px;
            }
    </style>
  </head>
  <body>
    <header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">Сбор средств для поездок большой компанией.</h4>
          <p class="text-muted">Привет мой юнный друг эта система специально была разработанна для помощи в сборе средст для путешестний большой компанией, а так же этот инструмент может быть не плохим мотиватором ведь с его помощью можно смотреть прогресс всех участников поездки в реальном времени. Надеюсь мои старания не пропадут даром, твой Dev. друг Vovia!</p>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
          <strong>
<?
// Скрипт проверки
// Соединямся с БД
$link=mysqli_connect("localhost", "", "", "");
// Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
$sum_now = $_POST['submitsum_upadte'];
if(isset($_POST['submitsum']))
{
  $query = mysqli_query($link, "UPDATE users  SET sum_now=$sum_now  WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
  print '[Сохранено]';
}

if(isset($_POST['submitdel']))
{
  print '1231231231';
  $query ="DELETE FROM users WHERE user_id = '".intval($_COOKIE['id'])."'";
// Переадресовываем браузер на страницу проверки нашего скрипта
header("Location: /"); exit;
  print '[Пока]';

}
if(isset($_POST['submitregister']))
{
    $err = [];
    // проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }
    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }
    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }
    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {
        $login = $_POST['login'];
        // Убераем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));
        mysqli_query($link,"INSERT INTO users SET user_login='".$login."',name='".$_POST['name']."', user_password='".$password."',say='".$_POST['say']."',sum_max='".$_POST['sum_max']."'");
        header("Location: /"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
if(isset($_POST['submitlogin']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);
    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        if(!empty($_POST['not_attach_ip']))
        {
            // Если пользователя выбрал привязку к IP
            // Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
        // Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!!
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: index.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        print "Хм, что-то не получилось";
    }
    else
    {
        print "Улыбнись, ".$userdata['name']."!";
        print '<a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#myModalinfo">Информация!</a> <a href="logout.php" class="btn btn-outline-danger my-2">Выйти</a>
        ';
    }
}
else
{
    print '
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModallogin"> Войти </button>
    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#myModalregister">Регистрация</button>';
}
?>
</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>
<main role="main">
  <?
// Скрипт проверки
// Соединямся с БД
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        print "Хм, что-то не получилось";
    }
    else
    {
        //print "Привет, ".$userdata['user_login'].". Всё работает!";
        print '<section class="jumbotron text-center"><div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Панель управления карточкой ('.$userdata['name'].')</h5>
        <p class="card-text">
        <form id="updateform" method="post">      
<div class="input-group mb-3">
<input type="text" class="form-control" id="num1" placeholder="Накопленная сумма" name="submitsum_upadte" value="'.$userdata['sum_now'].'" aria-describedby="button-addon2">
<div class="input-group-append">    
  <input class="btn btn-success" name="submitsum" type="submit" value="Сохранить">
  </form>
</div>
</div>
</p>';?>

<button class="btn btn-warning" onclick="$('#num1').val( +$('#num1').val() +500);$('#num1').keyup();">+500 руб.</button>
<button class="btn btn-warning" onclick="$('#num1').val( +$('#num1').val() +1000);$('#num1').keyup();">+1000 руб.</button>
<? print '
          <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModaldel">Я пасс! (отказаться от поездки)</a>
      </div>
    </div>
  </div> 
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Детали поездки</h5>
        <ul class="countdown">
        <li>
            <span class="days">00</span>
            <p class="days_ref">days</p>
        </li>
        <li class="seperator">.</li>
        <li>
            <span class="hours">00</span>
            <p class="hours_ref">hours</p>
        </li>
        <li class="seperator">:</li>
        <li>
            <span class="minutes">00</span>
            <p class="minutes_ref">minutes</p>
        </li>
        <li class="seperator">:</li>
        <li>
            <span class="seconds">00</span>
            <p class="seconds_ref">seconds</p>
        </li>
    </ul>
      </div>
    </div>
  </div>
</div>
</section>';
    }
}
else
{
    print '
    <section class="jumbotron text-center">
    <div class="container">
      <h1>Давайте собирать вместе!</h1>
      <p class="lead text-muted"> Войдите либо зарегистрируйтесь для начала работы. Если у вас возникнут вопросы по работе с сайтом , нажмите кнопку   <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#myModalinfo">Информация!</button>    там все рассказано и показано.</p>
      <p>
        <a href="#" class="btn btn-success my-2" data-toggle="modal" data-target="#myModallogin">Войти</a>
        <a href="#" class="btn btn-warning my-2" data-toggle="modal" data-target="#myModalregister">Регистрация</a>
      </p>
    </div>
  </section>
  ';
}
?>
<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModalinfo">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Информация</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        Сайт был разработан интуитивно понятным, если что пишите в ЛС. Всех обнял)
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
        </div>
        
      </div>
    </div>
  </div>
  <div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModaldel">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Удаление аккаунта</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        1. После подтверждения ваша карточка удалится.<br>
        2. После подтверждения ваша учётная запись удалится.<br>
        3. Вы ливаете из самой крутой тимы.<br>
        <div class="custom-control custom-checkbox mr-sm-2">
        <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
        <label class="custom-control-label" for="customControlAutosizing"><b>Я осознаю риски и принимаю их.</b></label>
      </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
        <form method="post">  
          <button  class="btn btn-danger" name="submitdel" type="submit">Удалить</button>
          </form>
        </div>
      </div>
    </div>
  </div> 
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.downCount.js"></script>

    <script class="source" type="text/javascript">
        $('.countdown').downCount({
            date: '12/10/2020 12:00:00',
            offset: +10
        }, function () {
            alert('WOOT WOOT, done!');
        });
    </script>
<div class="container">
  <!-- The Modal -->
  <div class="modal" id="myModalregister">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Регистрация</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
               <!-- Modal body -->
               <div class="modal-body">
        <form method="POST">
        <div class="form-group">
        <label for="email">Отображаемое имя:</label>
        <input name="name" type="name" class="form-control">
  </div>
        <div class="form-group">
        <label for="email">Логин:</label>
        <input name="login" type="login" class="form-control">
  </div>
  <div class="form-group">
    <label for="pwd">Пароль:</label>
    <input name="password" type="password" class="form-control">
  </div>
  <center><h2>Данные карточки</h2>
  <div class="form-group">
        <label for="say">Текс который будет отображаться в карточке:</label>
        <input name="say" type="login" class="form-control">
  </div>
  <div class="form-group">
        <label for="sum_max">Сумма которую необходимо накопить:</label>
        <input name="sum_max" type="sum_max" class="form-control">
  </div>
<div class="modal-footer">
          <input class="btn btn-success" name="submitregister" type="submit" value="Зарегистрироваться">
        </div>
</form>
</div>
      </div>
    </div>
  </div>
</div>

  <!-- The Modal login -->
  <div class="modal" id="myModallogin">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Вход</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form method="POST">
        <div class="form-group">
        <label for="email">Логин:</label>
        <input name="login" type="login" class="form-control">
  </div>
  <div class="form-group">
    <label for="pwd">Пароль:</label>
    <input name="password" type="password" class="form-control">
  </div>
  <div class="checkbox">
    <label><input type="checkbox" name="not_attach_ip" > <strike>Запомнить IP </strike></label>
  </div> 
<div class="modal-footer">
          <input class="btn btn-success" name="submitlogin" type="submit" value="Войти">
        </div>
</form>
</div>
      </div>
    </div>
  </div>
  
</div>

</body>
  <div class="album py-5 bg-light">
    <div class="container">
    <div class="row">
<?
$query1 = mysqli_query($link, "SELECT * FROM users");

while($row=mysqli_fetch_array($query1))
{
$percent_sum=(($row['sum_now']/$row['sum_max'])*100);
print '
<div class="col-md-4">
  <div class="card mb-4 shadow-sm">
    <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: K. VALIEV"><title>K. VALIEV</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">'.$row['name'].'</text></svg>
    <div class="card-body">
      <p class="card-text">Личное сообщение: "'.$row['say'].'"</p>
      <div class="d-flex justify-content-between align-items-center">
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline-secondary">Собрано: '.$row['sum_now'].' руб.</button>
        </div>
        <small class="text-muted">Цель: '.$row['sum_max'].' руб.</small>
      </div><br>
      <div class="progress">
<div class="progress-bar bg-warning active" role="progressbar"
aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:'.$percent_sum.'%">
Собрано: '.$percent_sum.'%
    </div>
    </div> 
    </div>
  </div>
</div>
';
 }
 ?>      
    </div>
  </div>

</main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Поднимаемся!</a>
    </p>
    <p>MAXIMOV and &copy; Bootstrap, customize it for yourself!</p>
    <a href="/edutvse.apk" ><p><img src="https://repastcafe.ru/wp-content/uploads/googleplay.jpg" width="150" alt="Скачать приложение"></p></a>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.js"></script></body>
</html>
