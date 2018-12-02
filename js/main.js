'use strict';

/* Signup page functions */
let signupForm = document.querySelector('.register-page');
if (signupForm) {
    /* Handle signup submission trough AJAX */
    console.log(':D')
    /* let loginAjaxContainer = document.querySelector('#ajax-form-container');
    let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = loginAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = loginAjaxContainer.querySelector('#ajax-form-success-fill');

    let usernameField = signupForm.querySelector('input[name="username"]');
    let emailField = signupForm.querySelector('input[name="email"]');
    let passwordField = signupForm.querySelector('input[name="password"]');
    let confirmPasswordField = signupForm.querySelector('input[name="confirm_password"]');

    // Submit form handler.
    signupForm.onsubmit = (e) => {
        e.preventDefault();
        ajaxRequestBox.style.display = 'flex';
        // Ajax request
        makeHTTPRequest('../actions/action_signup.php', 
            'post', 
            {   username: usernameField.value, 
                email: emailField.value, 
                password: passwordField.value,
                confirm_password: confirmPasswordField.value
            }, 
            (response) => { /* callback */
                if(response === 'ok') { 
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 0.5s.
                    setTimeout(function(){ window.location.replace("./main"); }, 500);
                }
                else { // Error.
                    ajaxFailBox.style.display = 'flex';
                    ajaxFailBox.querySelector('#error-message').innerHTML = response;
                }
                ajaxRequestBox.style.display = 'none';
            }
        );
    }

    // Close failure ajax box button handler.
    ajaxFailBox.querySelector('button').onclick = () => {
        ajaxFailBox.style.display = 'none';
    } */
}

/* Login page functions */
let loginForm = document.querySelector('#login-form');
if (loginForm) {
    /* Handle login submission trough AJAX */
    let loginAjaxContainer = document.querySelector('#ajax-form-container');
    let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = loginAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = loginAjaxContainer.querySelector('#ajax-form-success-fill');

    let usernameField = loginForm.querySelector('input[name="username"]');
    let passwordField = loginForm.querySelector('input[name="password"]');

    // Submit form handler.
    loginForm.onsubmit = (e) => {
        e.preventDefault();
        ajaxRequestBox.style.display = 'flex';
        // Ajax request
        makeHTTPRequest('../actions/action_login.php', 
            'post', 
            {username: usernameField.value, password: passwordField.value}, 
            (response) => { /* callback */
                if(response === 'ok') { 
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 0.5s.
                    setTimeout(function(){ window.location.replace("./main"); }, 500);
                }
                else if(response === 'fail') { 
                    ajaxFailBox.style.display = 'flex';
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