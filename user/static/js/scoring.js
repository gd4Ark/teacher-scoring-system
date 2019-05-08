jQuery(function ($) {

    var teaching_attr = 'data-teaching-id'

    var scoring = {
        init: function () {
            this.initEvent()
        },
        initEvent() {
            var _this = this
            // 登出
            $('#logout-btn').click(function () {
                _this.logout()
            })
            // 选择
            $('.radio').on('change', function () {
                _this.select(this)
            })
            // 提交
            $('.submit-btn').on('click', function () {
                _this.submit()
            })
        },
        select(self) {
            var id = $(self).attr(teaching_attr)
            var count = 0

            $('.radio[' + teaching_attr + '=' + id + ']:checked').each(function () {
                count += parseFloat($(this).val())
            })

            $('.assess-score-count[' + teaching_attr + '=' + id + ']').text(count)
        },
        isCompleted() {
            var status = true

            $('td[data-sub-project]').each(function () {
                var project = $(this).attr('data-sub-project')
                $('.teacher_info').each(function () {
                    var teaching_id = $(this).attr(teaching_attr)
                    var name = project + '-' + teaching_id
                    var select = '.radio[name=' + name + ']'

                    // 无选中
                    if (!$(select + ':checked').length) {
                        status = false
                        $(select).parent().addClass('err')
                        setTimeout(function () {
                            $(select).parent().removeClass('err')
                        }, 500)
                    }
                })
            })

            return status
        },
        getScore() {
            var data = {};

            var teaching_ids = $('.teacher_info').map(function () {
                return $(this).attr('data-teaching-id');
            }).get();

            var teacher_ids = $('.teacher_info').map(function () {
                return $(this).attr('data-teacher-id');
            }).get();

            var subject_ids = $('.teacher_info').map(function () {
                return $(this).attr('data-subject-id');
            }).get();


            for (var i = 0; i < teaching_ids.length; i++) {
                var id = teaching_ids[i];
                var suggest = $('.suggest').eq(i).val();
                $('td.title').each(function () {
                    var project = $(this).text();
                    var score = 0;
                    var radios = $('.radio[name^=' + project + '][' + teaching_attr + '=' + id + ']:checked');
                    $(radios).each(function () {
                        score += parseFloat($(this).val());
                    });
                    if (score) {
                        if (!data[id]) {
                            data[id] = {
                                projects: {},
                                suggest: suggest,
                                subject_id : subject_ids[i],
                                teacher_id : teacher_ids[i],
                            };
                        }
                        data[id].projects[project] = score;
                    }
                });
            }

            return data
        },
        submit() {
            
            var _this = this

            // 是否完成所有选项
            if (!this.isCompleted()) return

            var scores = this.getScore()

            $.ajax({
                method: "POST",
                url:  BASE_URL + 'students/submit',
                data: {
                    scores : scores,
                    user_id : $('#user_id').attr('content')
                },
                success: function (data) {
                    alert('提交成功！');
                    _this.logout()
                },
                error: function (err) {
                    if (err.responseJSON.msg) {
                        return alert(err.responseJSON.msg)
                    }
                    alert('提交失败！')
                }
            })

        },
        logout() {
            location.href = './login'
        },
    }

    scoring.init()

})