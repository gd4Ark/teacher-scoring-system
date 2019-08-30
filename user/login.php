<?php include_once "./data/config.php" ?>
<?php include_once "./lib/functions.php" ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./static/css/bootstrap.min.css">
  <link rel="stylesheet" href="./static/css/style.css">
  <link rel="stylesheet" href="./static/css/login.css">
  <title>用户登录</title>
</head>

<body>
  <div class="container">
    <div class="row row-centered">
      <div class="well col-md-6 col-centered">
        <h2>评教系统 - 学生登录</h2>
        <div class="input-group input-group-md">
          <span class="input-group-addon">班级</span>
          <select id="groups" class="form-control">
            <option selected disabled>请选择您的班级</option>
            <?php include_once "./components/groups.php" ?>
          </select>
        </div>
        <div class="input-group">
          <span class="input-group-addon">姓名</span>
          <select id="students" class="form-control">
            <option selected disabled>请选择您的姓名</option>
            <?php include_once "./components/students.php" ?>
          </select>
        </div>
        <div class="form-group text-right">
          <input type="button" id="login-btn" class="btn btn-default" value="登录">
        </div>
      </div>
    </div>
  </div>
  <div class="footer flex">
    &copy 4ark. 2019
  </div>

  <script src="./static/js/jquery-3.2.1.min.js"></script>
  <script src="./static/js/config.js"></script>
  <script src="./static/js/base64.js"></script>
  <script src="./static/js/login.js"></script>
</body>

</html>
