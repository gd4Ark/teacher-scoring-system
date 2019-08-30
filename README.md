## 介绍

评教系统是一款为提高教师的教学质量，反馈学生的心声，提高学校教务管理能力的系统。针对各专业所授课程及教师的评价结果，直观的统计出每位教师的综合能力。

## 演示

### 后台管理

#### 分数统计

![](https://i.loli.net/2019/06/04/5cf65d16a5fbd68682.gif)

#### 数据管理

![](https://i.loli.net/2019/06/04/5cf660cf6c73a69592.gif)

### 学生评分

#### 登陆界面 

![](https://i.loli.net/2019/06/04/5cf65ac8f318810324.png)

#### 评分界面

![](https://i.loli.net/2019/06/04/5cf65addb629f13916.png)

### 技术栈

本系统为前后端分离的 SPA 应用。

具体技术：

- 后台管理端使用 VUE 、ElementUI
- 学生端使用 Bootstrap 、 jQuery 、 PHP
- 服务端使用 Lumen 、MySQL。

## 实现功能

### 后台管理

- 分数统计（支持导出为 XLSX）
  - 数据概览
  - 分数查看
  - 历史归档
- 数据管理
  - 班级录入
    - 学生录入
    - 课程录入
  - 教师录入
  - 科目录入

### 教师查询

- 自定查询分数

### 学生评分

- 对本班的任课教师进行各项评分、填写建议

## 安装与使用

下载

```bash
git clone https://github.com/gd4Ark/teacher-scoring-system.git
```

前端

```bash
npm install
# 开发模式
npm run serve
# 构建模式
npm run build
```

后端

```bash
cd server
composer install
# 创建好数据库且填写 .env 文件后，进行数据迁移
php artisan migrate --seed
```

## 注意事项

### 1、MySQL 版本问题

答：由于本项目使用了一些 MariaDB 不支持的特性，所以请使用 MySQL 版本的数据库。

### 2、填写 .env 文件

答：创建好数据库后（注意是 InnoDB 引擎），复制 .env.example 为 .env，填写你的数据库连接信息。

### 3、服务端 API 地址

答：管理端的配置在`src/common/config/index.js`中，学生端的配置在`user/static/js/config.js`中。

### 4、账号密码

答：默认账号密码都是 admin。

## 5、其他问题

答：如有其他问题请提 issue 或发送邮件到我的邮箱。

## TODO LIST

- 后台管理自定义评分项

## 作者

**评教系统** © 4ark，根据许可证 [MIT](https://github.com/gd4Ark/learn-english/blob/master/LICENSE) 发布。

> [Blog](https://4ark.me/) · GitHub [@gd4Ark](https://github.com/gd4Ark)

## 最后

如果觉得我的项目还不错的话👏 ，就给个 star ⭐ 鼓励一下吧~

