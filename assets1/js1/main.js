/*=============== SHOW HIDE PASSWORD LOGIN ===============*/
const passwordAccess = (loginPass, loginEye) =>{
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye)

   iconEye.addEventListener('click', () =>{
      // Change password to text
      input.type === 'password' ? input.type = 'text'
						              : input.type = 'password'

      // Icon change
      iconEye.classList.toggle('ri-eye-fill')
      iconEye.classList.toggle('ri-eye-off-fill')
   })
}
passwordAccess('password','loginPassword')

/*=============== SHOW HIDE PASSWORD CREATE ACCOUNT ===============*/
const passwordRegister = (loginPass, loginEye) =>{
   const input = document.getElementById(loginPass),
         iconEye = document.getElementById(loginEye)

   iconEye.addEventListener('click', () =>{
      // Change password to text
      input.type === 'password' ? input.type = 'text'
						              : input.type = 'password'

      // Icon change
      iconEye.classList.toggle('ri-eye-fill')
      iconEye.classList.toggle('ri-eye-off-fill')
   })
}
passwordRegister('passwordCreate','loginPasswordCreate')

/*=============== SHOW HIDE LOGIN & CREATE ACCOUNT ===============*/
const loginAcessRegister = document.getElementById('loginAccessRegister'),
      buttonRegister = document.getElementById('loginButtonRegister'),
      buttonAccess = document.getElementById('loginButtonAccess')

buttonRegister.addEventListener('click', () => {
   loginAcessRegister.classList.add('active')
})

buttonAccess.addEventListener('click', () => {
   loginAcessRegister.classList.remove('active')
})

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.login__access .login__form');
    const registerForm = document.querySelector('.login__register .login__form');

    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = {
            action: 'login',
            email: this.querySelector('#email').value,
            password: this.querySelector('#password').value
        };

        fetch('process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.href = 'dashboard.php';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
            console.error('Error:', error);
        });
    });

    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = {
            action: 'register',
            names: this.querySelector('#names').value,
            surnames: this.querySelector('#surnames').value,
            emailCreate: this.querySelector('#emailCreate').value,
            passwordCreate: this.querySelector('#passwordCreate').value
        };

        fetch('process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Registration successful! Please login.');
                document.getElementById('loginButtonAccess').click();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
            console.error('Error:', error);
        });
    });

    const loginPassword = document.getElementById('loginPassword');
    const loginPasswordCreate = document.getElementById('loginPasswordCreate');
    const passwordInput = document.getElementById('password');
    const passwordCreateInput = document.getElementById('passwordCreate');

    loginPassword.addEventListener('click', () => {
        if(passwordInput.type === 'password') {
            passwordInput.type = 'text';
            loginPassword.classList.replace('ri-eye-off-fill', 'ri-eye-fill');
        } else {
            passwordInput.type = 'password';
            loginPassword.classList.replace('ri-eye-fill', 'ri-eye-off-fill');
        }
    });

    loginPasswordCreate.addEventListener('click', () => {
        if(passwordCreateInput.type === 'password') {
            passwordCreateInput.type = 'text';
            loginPasswordCreate.classList.replace('ri-eye-off-fill', 'ri-eye-fill');
        } else {
            passwordCreateInput.type = 'password';
            loginPasswordCreate.classList.replace('ri-eye-fill', 'ri-eye-off-fill');
        }
    });
});