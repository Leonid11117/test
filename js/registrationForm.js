$(document).ready(function() {
  var form = $('#registration-form');
  var name = $('#name');
  var surname = $('#surname');
  var email = $('#email');
  var password = $('#password');
  var password2 = $('#password2');

  form.submit(function(event) {
    event.preventDefault();

    var formData = {
      'name': name.val(),
      'surname': surname.val(),
      'email': email.val(),
      'password': password.val(),
      'password2': password2.val()
    };

    $.ajax({
      type: 'POST',
      url: 'process.php',
      data: formData,
      dataType: 'json',
      encode: true
    })
    .done(function(data) {
      console.log(data);

      if (data.success) {
        form.hide();
        $('#success-message').show();
      } else {
        $('#error-message').text(data.message);
        $('#error-message').show();
      }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.error('AJAX error: ' + textStatus + ' : ' + errorThrown);
    });
  });
});

