'use strict';

/* Signup page functions */
let signupForm = document.querySelector('#registerForm');
if (signupForm) {
    /* Handle signup submission trough AJAX */
    let loginAjaxContainer = document.querySelector('.form');
    let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = loginAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = loginAjaxContainer.querySelector('#ajax-form-success-fill');

    let usernameField = signupForm.querySelector('input[name="username"]');
    let realnameField = signupForm.querySelector('input[name="realName"]');
    let imgField = signupForm.querySelector('input[name="img"]');
    let emailField = signupForm.querySelector('input[name="email"]');
    let passwordField = signupForm.querySelector('input[name="password"]');
    let confirmPasswordField = signupForm.querySelector('input[name="passwordConfirm"]');

    imgField.onchange = function(e) { 
        setTimeout(processImage(), 50);
    };
    
    
    // Submit form handler.
    signupForm.onsubmit = (e) => {
        e.preventDefault();
        ajaxRequestBox.style.display = 'flex';

        /* setTimeout(processImage(), 50); */

        /* console.log(imgField.files); */

        // Ajax request
        makeHTTPRequest('../php/action_register.php', 
            'post', 
            {   username: usernameField.value, 
                realName: realnameField.value,
                img: JSON.stringify({name:imgField.files[0].name}),
                imgS: JSON.stringify({name:imgField.files[0].size}),
                email: emailField.value, 
                password: passwordField.value,
                passwordConfirm: confirmPasswordField.value
            }, 
            (response) => { /* callback */
                if(response === 'ok') { 
                    console.log('1');
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 1.1s.
                    setTimeout(function(){ window.location.replace('../php/frontpage'); }, 1100);
                }
                else if (response === '404'){
                    console.log('2');
                    window.location.replace("./error_404");
                }
                else { // Error.
                    console.log(response);
                    ajaxFailBox.style.display = 'flex';
                    ajaxFailBox.querySelector('#error').innerHTML = response;
                }
                ajaxRequestBox.style.display = 'none';
            }
        );
    }

    // Close failure ajax box button handler.
    ajaxFailBox.querySelector('button').onclick = () => {
        ajaxFailBox.style.display = 'none';
    } 
}

function processImage() {
    const files = document.querySelector('[type=file]').files;
    const formData = new FormData();

    for (let i = 0; i < files.length; i++) {
        let file = files[i];
    
        formData.append('files[]', file);
    }

    fetch('../php/action_process_image.php', {
        method: 'POST',
        body: formData
    }).then(response => {
        /* console.log(response); */
    });
}


/* Login page functions */
let loginForm = document.querySelector('#loginForm');
if (loginForm) {
    /* Handle login submission trough AJAX */
    let loginAjaxContainer = document.querySelector('.form');
    let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = loginAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = loginAjaxContainer.querySelector('#ajax-form-success-fill');

    let usernameField = loginForm.querySelector('input[name="username"]');
    let passwordField = loginForm.querySelector('input[name="password"]');

    let previousPageField = loginForm.querySelector('input[name="previousPage"]');
    let previousPage = previousPageField.value;

    // Submit form handler.
    loginForm.onsubmit = (e) => {
        e.preventDefault();
        /* ajaxRequestBox.style.display = 'flex'; */
        // Ajax request
        makeHTTPRequest('../php/action_login.php',
            'post', 
            {username: usernameField.value, password: passwordField.value},
            (response) => { 
                if(response === 'ok') { 
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 1.1s.
                    setTimeout(function(){ window.location.replace(previousPage); }, 1100);
                }
                else if(response === 'fail1') { 
                    ajaxFailBox.style.display = 'flex';
                }
                else if(response === 'fail2') { 
                    ajaxFailBox.style.display = 'flex';
                }
                /* ajaxRequestBox.style.display = 'none'; */
            }
        );
    }
    // Close failure ajax box button handler.
    ajaxFailBox.querySelector('button').onclick = () => {
        ajaxFailBox.style.display = 'none';
    }

}

/* Helper functions */
function makeHTTPRequest(url, type, params, callback) {
    let request = new XMLHttpRequest();
    request.open(type, url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener("load", function () {
        callback(this.responseText);
    })  
    request.send(encodeForAjax(params));
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

