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

```
// 下载
git clone https://github.com/gd4Ark/teacher-scoring-system.git
// 安装前端依赖
npm install
// 安装后端依赖
cd server
composer install
```

## 注意事项

### 1、MySQL 版本问题

答：由于本项目使用了一些 MariaDB 不支持的特性，所以请使用 MySQL 版本的数据库。

## 作者

**评教系统** © 4ark，根据许可证 [MIT](https://github.com/gd4Ark/learn-english/blob/master/LICENSE) 发布。

> [Blog](https://4ark.me/) · GitHub [@gd4Ark](https://github.com/gd4Ark)

## 最后

如果觉得我的项目还不错的话👏 ，就给个 star ⭐ 鼓励一下吧~

