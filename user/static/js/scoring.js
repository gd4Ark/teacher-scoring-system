jQuery(function ($) {
    var ajax = $.ajax

    var scoring = {
        user: null,
        init: function () {
            if (!store.has('user')) {
                return location.href = './login.html'
            }
            this.user = store.get('user')
            this.getTeachers()
            this.initUserInfo()
            this.initEvent()
        },
        initUserInfo() {
            $('.group_name').html(this.user.group_name)
            $('.user_name').html(this.user.name)
        },
        initTeachingInfo(data) {
            var html = ''
            data.forEach(function (item) {
                html += '<td class="teacher_info" data-teaching-id="' + item.id + '">' +
                    '<span>' + item.subject.label + '</span>' +
                    '<span>' + item.teacher.label + '</span>' +
                    '</td>'
            })
            $('table thead .head-info').append(html)
        },
        initEvent() {
            var _this = this
            $('#logout-btn').click(function () {
                _this.logout()
            })
        },
        getTeachers: function () {
            var _this = this
            var group_id = store.get('user').group_id
            ajax({
                method: 'get',
                url: BASE_URL + '/teachings?getOptions=1&groupId=' + group_id,
                success: function (data) {
                    _this.initTeachingInfo(data.data)
                },
                error: function () {
                    alert('获取任课列表失败！')
                }
            })
        },
        logout() {
            store.del('user')
            location.href = './login.html'
        },
    }

    scoring.init()

})