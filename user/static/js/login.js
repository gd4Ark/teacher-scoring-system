jQuery(function($) {
  let ajax = $.ajax

  let login = {
    init: function() {
      this.initEvent()
    },
    initEvent: function() {
      let _this = this
      $('#groups').on('change', function() {
        location.href = './login?gid=' + BASE64.urlsafe_encode($(this).val())
      })

      $('#login-btn').click(function() {
        let gid = $('#groups').val()
        let stuid = $('#students').val()
        if (!gid || !stuid) {
          return alert('请填写完整！')
        }
        _this.submit(gid, stuid)
      })
    },
    submit: function(gid, stuid) {
      ajax({
        method: 'post',
        url: BASE_URL + 'students/login',
        data: {
          user_id: stuid,
        },
        success: function(result) {
          let data = result.data
          if (data.id) {
            gid = BASE64.urlsafe_encode(gid)
            stuid = BASE64.urlsafe_encode(stuid)
            location.href = './?gid=' + gid + '&stuid=' + stuid
          }
        },
        error: function(err) {
          if (err.responseJSON.message) {
            return alert(err.responseJSON.message)
          }
          alert('登陆失败！')
        },
      })
    },
  }

  login.init()
})
