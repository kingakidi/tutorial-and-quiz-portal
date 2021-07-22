let userTools = document.getElementsByName("user-tools");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let pLink = document.getElementsByName("p-link");
let show = _("show-item");

userTools.forEach(function (element) {
  element.addEventListener("change", function () {
    let value = this.value;
    let id = this.id;
    // SHOW THE MODAL FOR MORE ACTIONS
    let pPage = _("popup-page");
    let pContent = _("popup-content");
    let pSContent = _("show-popup-content");
    let btnPClose = _("popup-close");
    pPage.style.display = "block";
    // CLOSING BUTTON POPUPAGE
    btnPClose.onclick = function () {
      pPage.style.display = "none";
      location.reload();
    };

    if (value === "role") {
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          changeRoleForm: true,
          id: id,
        },
        beforeSend: function () {},
        success: function (data) {
          //   console.log(data);
          pSContent.innerHTML = data;
        },
        complete: function () {
          let roleForm = _("change-role");
          let role = _("role");
          let password = _("password");
          let showRoleStatus = _("show-role-status");
          let email = _("user-email");
          let btnRoleSubmit = _("btn-role-submit");
          roleForm.onsubmit = function (event) {
            event.preventDefault();
            // CHECK FOR EMPTY
            if (clean(role) > 0 && clean(password) > 0 && clean(email) > 0) {
              // SEND AJAX
              $.ajax({
                url: "./control/actions.php",
                method: "POST",
                data: {
                  changeUserRole: true,
                  email: email.value,
                  password: password.value,
                  role: role.value,
                },
                beforeSend: function () {
                  showRoleStatus.innerHTML = success("Loading...");
                },
                success: function (data) {
                  showRoleStatus.innerHTML = data;
                  //   console.log(data);
                  if (
                    data.trim() ===
                    "<span class='text-success'>Role change Succcessfully</span>"
                  ) {
                    role.disabled = true;
                    password.disabled = true;
                    btnRoleSubmit.disabled = true;
                  }
                },
              });
            } else {
              showRoleStatus.innerHTML = error("All fields required");
            }
          };
        },
      });
    } else if (value === "toggleActivation") {
      // SEND FOR TOOGLE FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          toggleActivation: true,
          id: id,
        },
        beforeSend: function () {
          pSContent.innerHTML = success("Loading....");
        },
        success: function (data) {
          //   console.log(data);
          pSContent.innerHTML = data;
        },
        complete: function () {
          let toggleForm = _("toggle-activation");
          let role = _("role");
          let password = _("password");
          let showRoleStatus = _("show-role-status");
          let email = _("user-email");
          let btnRoleSubmit = _("btn-role-submit");
          toggleForm.onsubmit = function (event) {
            event.preventDefault();
            // CHECK FOR EMPTY
            if (clean(role) > 0 && clean(password) > 0 && clean(email) > 0) {
              // SEND AJAX
              $.ajax({
                url: "./control/actions.php",
                method: "POST",
                data: {
                  changeUserActivation: true,
                  email: email.value,
                  password: password.value,
                  status: status.value,
                },
                beforeSend: function () {
                  showRoleStatus.innerHTML = success("Loading...");
                },
                success: function (data) {
                  showRoleStatus.innerHTML = data;
                  //   console.log(data);
                  if (
                    data.trim() ===
                    "<span class='text-success'>Role change Succcessfully</span>"
                  ) {
                    role.disabled = true;
                    password.disabled = true;
                    btnRoleSubmit.disabled = true;
                  }
                },
              });
            } else {
              showRoleStatus.innerHTML = error("All fields required");
            }
          };
        },
      });
    }
  });
});
