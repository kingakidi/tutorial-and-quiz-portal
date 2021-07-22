let email = _('email')
let phone = _('phone')
let fullname = _('fullname')
let password = _('password')
let rForm = _('register-form')
let showStatus = _('show-status')
let btnRegister = _('btn-register')

function disabledAll(x) {
    x.forEach(element => {
        element.disabled = true;
    });
}

rForm.addEventListener('submit', function (e) {
    e.preventDefault();
    if (clean(email) > 0 && clean(fullname) > 0 && clean(phone) > 0 && clean(password) > 0) {
        $.ajax({
            url: "./control/actions.php", 
            method: "POST", 
            data: {
                fullname: fullname.value, 
                email: email.value, 
                phone: phone.value, 
                password: password.value, 
                registerAccount: true
            }, 
            beforeSend: function () {
                showStatus.innerHTML = ""
                btnRegister.disabled = true; 
                btnRegister.innerHTML = "Loading...."
            }, 
            success: function (data) {
                
                btnRegister.innerHTML = "Register"
              
                if (data.trim() === "<span class='text-success'>Account Registered Successfully</span>") {
                    disabledAll([fullname, email, phone, password])
                    btnRegister.disabled = true 
                    showStatus.innerHTML = data 
                    showStatus.innerHTML += "<a href='./login.php'> Click here to login <a>"
                }else{
                    btnRegister.disabled = false
                    showStatus.innerHTML = data
                }
                
            }
        })
    }else{
        showStatus.innerHTML = error("All fields required")
    }
})