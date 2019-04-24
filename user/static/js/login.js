jQuery(function ($) {
    var ajax = $.ajax

    var login = {
        init: function () {
            var _this = this
            this.getGroups()
            $('#login-btn').click(function () {
                var group_id = $('#groups').val()
                var student_id = $('#students').val()
                if (!group_id || !student_id) {
                    return alert('请填写完整！')
                }
                _this.submit(group_id, student_id)
            })
        },
        getGroups: function () {
            ajax({
                method: 'get',
                url: BASE_URL + '/groups?getOptions=1',
                success: function (data) {
                    data = data.data
                    var html = '<option selected disabled>请选择您的班级</option>'
                    data.forEach(function (item) {
                        html += '<option value="' + item.value + '">' + item.label + '</option>'
                    })
                    $('#groups').html(html)

                    $('#groups').on('change', function () {
                        login.getStudents($(this).val())
                    })
                },
                error: function () {
                    alert('获取班级列表失败！')
                }
            })
        },
        getStudents: function (group_id) {
            ajax({
                method: 'get',
                url: BASE_URL + '/students?getOptions=1&groupId=' + group_id,
                success: function (data) {
                    data = data.data
                    var html = '<option selected disabled>请选择您的姓名</option>'
                    data.forEach(function (item) {
                        html += '<option value="' + item.value + '">' + item.label + '</option>'
                    })
                    $('#students').html(html)
                },
                error: function () {
                    alert('获取学生列表失败！')
                }
            })
        },
        submit: function (group_id, student_id) {
            ajax({
                method: 'post',
                url: BASE_URL + '/students/login',
                data: {
                    groupId: group_id,
                    studentId: student_id,
                },
                success: function (data) {
                    data = data.data
                    if (data.id) {
                        store.set('user', data)
                        location.href = './'
                    }
                },
                error: function (err) {
                    if (err.responseJSON.msg) {
                        return alert(err.responseJSON.msg)
                    }
                    alert('登陆失败！')
                }
            })
        }
    }

    login.init()

})