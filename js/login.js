let username = _("username");
let password = _("password");
let lForm = _("login-form");
let btnLogin = _("login-form");
let showStatus = _("show-status");

lForm.addEventListener("submit", function (e) {
  e.preventDefault();
  // CHECK FOR EMPTY FIELDS
  if (clean(username) > 0 && clean(password) > 0) {
    // SEND DATA BACK
    $.ajax({
      url: "./control/actions.php",
      method: "POST",
      data: {
        username: username.value,
        password: password.value,
        loginUser: true,
      },
      beforeSend: function () {
        // console.log(username.value, password.value)
      },
      success: function (data) {
        // console.log(data)
        showStatus.innerHTML = data;
        if (
          data.trim() == "<span class='text-success'>Login Successfully</span>"
        ) {
          window.location.reload();
        }
      },
    });
  } else {
    showStatus.innerHTML = error("All fields required");
  }
});
