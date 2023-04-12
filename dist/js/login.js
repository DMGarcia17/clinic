let logIn = () => {
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
            title: ('Inicio de Sesi&oacute;n Exitoso!')
          });

          setTimeout(() => {
            window.location.href = "http://localhost/clinic/pages/calendar.php";
          }, 1000)
          
        }
    }
  });
};


$(document).ready(function() {
  let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
    switch($('#error').val()){
      case '1':
        Toast.fire({
          icon: 'error',
          title: ('Por favor inicie sesi&oacute;n!')
        });
      break;
      case '0':
        Toast.fire({
          icon: 'success',
          title: ('Sesi&oacute;n cerrada de forma exitosa!')
        });
      break;
    }

    $('#logInForm').validate({
      onfocusout: false,
      rules: {
        username: {
          required: true
        },
        password: {
          required: true
        }
      },
      messages: {
        username: "Por favor ingrese un nombre de usuario",
        password: "Por favor ingrese una contrase&ntilde;a"
      },
      submitHandler: function(e){
        logIn();
      }
    });

});