$(document).ready(function() {
    $('#logIn').click(() => {
        $.ajax({
            type  : 'post',
            url   : 'controllers/SessionController.php',
            data  : {
                      'username': $('#username').val(),
                      'password' : $('#password').val(),
                      'function' : 'L'
                    },
            success: function (res) {  
                let json = JSON.parse(res);
                
                let Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });
                if (json['err'] != undefined && json['err'].length >= 1){
                  Toast.fire({
                    icon: 'error',
                    title: (json['err']+'!')
                  });
                  return;
                } else {
                  Toast.fire({
                    icon: 'success',
                    title: ('Loggin Success!')
                  });
  
                  window.location.href = "http://localhost/work_log/";
                }
            }
          });
    });
});