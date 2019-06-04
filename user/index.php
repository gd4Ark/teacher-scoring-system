<?php include_once "./data/config.php" ?>
<?php include_once "./data/projects.php" ?>
<?php include_once "./lib/functions.php" ?>
<?php
// 未登录
if (!isset($_GET['gid']) || !isset($_GET['stuid'])) {
    echo redirect('./login');
    exit;
}
$gid = base64_decode($_GET['gid']);
$stuid = base64_decode($_GET['stuid']);
$group = get($base_url . 'groups/' . $gid);
$student = get($base_url . 'students/' . $stuid);
if (!$group || !$student) {
    echo msg("获取信息失败！");
    echo redirect('./login');
    exit;
}
if (!$group['allow']) {
    echo msg("该班级禁止登陆");
    echo redirect('./login');
    exit;
}
$has_complete = $student['complete'];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta id="user_id" content="<?php echo $stuid ?>">
    <link rel="stylesheet" href="./static/css/bootstrap.min.css">
    <link rel="stylesheet" href="./static/css/style.css">
    <link rel="stylesheet" href="./static/css/index.css">
    <title>评教系统</title>
    <!-- 解决加载时单元格闪一下的BUG -->
    <style>
        th,
        td {
            border: 1px solid #ccc;
            height: 30px;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">评教系统</h1>
        <a href="./login">退出</a>
    </div>
    <div class="main flex">
        <table class="table-container table-hover ">
            <thead>
                <tr class="head-info">
                    <td class="user_info col-12" colspan="3">
                        <span class="group_name col-6">
                            <?php echo $group['name'] ?>
                        </span>
                        <span class="user_name col-6">
                            <?php echo $student['name'] ?>
                            ——
                            <?php echo $has_complete ? "已提交" : "未提交" ?>
                        </span>
                    </td>
                    <?php include_once "./components/teachings.php" ?>
                </tr>
            </thead>
            <tbody>
                <?php include_once "./components/project.php" ?>
            </tbody>
            <tfoot>
                <?php include_once "./components/totalScore.php" ?>
                <?php include_once "./components/suggest.php" ?>
            </tfoot>
        </table>
        <button type="button" class="submit-btn btn btn-info btn-lg btn-block" <?php echo $has_complete ? "disabled" : "" ?>>
            <?php echo $has_complete ? "已提交" : "提交" ?>
        </button>
    </div>
    <script src="./static/js/jquery-3.2.1.min.js"></script>
    <script src="./static/js/config.js"></script>
    <script src="./static/js/scoring.js"></script>
</body>

</html>