'use strict';

/* Signup page functions */
let signupForm = document.querySelector('#registerForm');
if (signupForm) {
    /* Handle signup submission trough AJAX */
    let signupAjaxContainer = document.querySelector('.form');
    let ajaxRequestBox = signupAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = signupAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = signupAjaxContainer.querySelector('#ajax-form-success-fill');

    let usernameField = signupForm.querySelector('input[name="username"]');
    let realnameField = signupForm.querySelector('input[name="realName"]');
    let imgField = signupForm.querySelector('input[name="img"]');
    let emailField = signupForm.querySelector('input[name="email"]');
    let passwordField = signupForm.querySelector('input[name="password"]');
    let confirmPasswordField = signupForm.querySelector('input[name="passwordConfirm"]');

    imgField.onchange = function (e) {
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
            {
                username: usernameField.value,
                realName: realnameField.value,
                img: JSON.stringify({ name: imgField.files[0].name }),
                imgS: JSON.stringify({ name: imgField.files[0].size }),
                email: emailField.value,
                password: passwordField.value,
                passwordConfirm: confirmPasswordField.value
            },
            (response) => { /* callback */
                if (response === 'ok') {
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 1.1s.
                    setTimeout(function () { window.location.replace('../php/frontpage.php'); }, 1100);
                }
                else if (response === '404') {
                    window.location.replace("./error_404.php");
                }
                else { // Error.
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

/* Create Post page functions */
let createPostForm = document.querySelector('#createPageForm');
if (createPostForm) {
    /* Handle signup submission trough AJAX */
    let loginAjaxContainer = document.querySelector('.form');
    let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill');
    let ajaxFailBox = loginAjaxContainer.querySelector('#ajax-form-failure-fill');
    let ajaxSuccessBox = loginAjaxContainer.querySelector('#ajax-form-success-fill');

    let titleField = createPostForm.querySelector('input[name="title"]');
    let textField = createPostForm.querySelector('textarea');
    let imgField = createPostForm.querySelector('input[name="img"]');
    let tagsField = createPostForm.querySelector('input[name="tags"]');

    imgField.onchange = function (e) {
        setTimeout(processImage(), 50);
    };

    // Submit form handler.
    createPostForm.onsubmit = (e) => {
        e.preventDefault();
        ajaxRequestBox.style.display = 'flex';

        /* console.log(imgField.files); */

        /* setTimeout(processImage(), 50); */

        // Ajax request
        makeHTTPRequest('../php/action_create_post.php',
            'post',
            {
                title: titleField.value,
                text: textField.value,
                img: JSON.stringify({ name: imgField.files[0].name }),
                imgS: JSON.stringify({ name: imgField.files[0].size }),
                tags: tagsField.value
            },
            (response) => { /* callback */
                if (response.substring(0, 2) == 'ok') {
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 1.1s.
                    setTimeout(function () { window.location.replace('../php/item.php?id=' + response.substring(2, response.length)); }, 1100);
                }
                else if (response === '404') {
                    window.location.replace("./error_404.php");
                }
                else { // Error
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

/* Process image */
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
    /* let ajaxRequestBox = loginAjaxContainer.querySelector('#ajax-form-request-fill'); */
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
            { username: usernameField.value, password: passwordField.value },
            (response) => {
                if (response === 'ok') {
                    ajaxSuccessBox.style.display = 'flex';
                    // Redirect user after 1.1s.
                    setTimeout(function () { window.location.replace(previousPage); }, 1100);
                }
                else {
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

/* replys */

let userLogged = document.querySelectorAll('#userInfo');
let replys = document.querySelectorAll('.fa-reply');
if(replys.length != 0 && userLogged.length != 0){

    let hiddenBox = document.querySelector('.hiddenBox');
    let handlerfunction = function (e) {
        hiddenBox.querySelector('a').href = '../php/profile.php?user=' + e.target.parentElement.querySelector('.user').innerHTML;
        hiddenBox.querySelector('a').innerHTML = e.target.parentElement.querySelector('.user').innerHTML;
        hiddenBox.querySelector('input').value = e.target.parentElement.querySelector('input[name="id"]').value;
        hiddenBox.style.display = 'flex';
    }
    for(let reply of replys){
        reply.classList.add('fa_active');
        reply.classList.add('fa_hover');
        reply.onclick = handlerfunction;
    }
    hiddenBox.querySelector('.fa-times').onclick = (e) => {
        hiddenBox.style.display = 'none';
        hiddenBox.querySelector('textarea').value = '';
    }  
}


/* profile */

let btnsChange = document.querySelectorAll('.btnChange');
if(btnsChange.length != 0){
    let ajaxRequestPasswordBox = document.querySelector('#passwordChange');   
    let ajaxRequestEmailBox = document.querySelector('#emailChange');   
    let ajaxRequestPicBox = document.querySelector('#picChange');   
    let ajaxRequestNameBox = document.querySelector('#realnameChange');   
    
    let handlerfunction = function (e) {
        if(e.target.parentElement.parentElement.id == 'name') {
            ajaxRequestEmailBox.style.display = 'none';
            ajaxRequestPasswordBox.style.display = 'none';
            ajaxRequestPicBox.style.display = 'none';
            ajaxRequestNameBox.style.display = 'flex';
        }               
        else if(e.target.parentElement.parentElement.id == 'email'){
            ajaxRequestNameBox.style.display = 'none';
            ajaxRequestEmailBox.style.display = 'flex';
            ajaxRequestPasswordBox.style.display = 'none';
            ajaxRequestPicBox.style.display = 'none';
        }
        else if(e.target.parentElement.parentElement.id == 'password'){
            ajaxRequestNameBox.style.display = 'none';
            ajaxRequestEmailBox.style.display = 'none';
            ajaxRequestPasswordBox.style.display = 'flex';
            ajaxRequestPicBox.style.display = 'none';
        }
        else if(e.target.parentElement.parentElement.id == 'pic'){
            ajaxRequestNameBox.style.display = 'none';
            ajaxRequestEmailBox.style.display = 'none';
            ajaxRequestPasswordBox.style.display = 'none';
            ajaxRequestPicBox.style.display = 'flex';
        }
    }

    for(let btn of btnsChange){
        btn.onclick = handlerfunction;
    }
    
    let xs = document.querySelectorAll('.fa-times');

    for(let x of xs){
        x.onclick = (e) => {
            ajaxRequestNameBox.style.display = 'none';
            ajaxRequestEmailBox.style.display = 'none';
            ajaxRequestPasswordBox.style.display = 'none';
            ajaxRequestPicBox.style.display = 'none';
        };
    }

    ajaxRequestPicBox.querySelector('input').onchange = function (e) {
        setTimeout(processImage(), 50);
    };
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
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}


let downvote = document.getElementsByClassName('fa-thumbs-down');
if(downvote.length != 0 && userLogged.length != 0){	
	likeEventHandler('newsLikeDiv', '../php/action_like_news.php');
	likeEventHandler('commLikeDiv', '../php/action_like_comments.php');
    likeEventHandler('replyLikeDiv', '../php/action_like_reply.php');
}

function likeEventHandler(className, action) {
    let likeDiv = document.getElementsByClassName(className);
    for (let likeD of likeDiv) {
        let inputField = likeD.querySelector('input');
        let thumbsUpField = likeD.querySelector('.fa-thumbs-up');
        let thumbsDownField = likeD.querySelector('.fa-thumbs-down');
        let likesField = likeD.querySelector('span');
        
        thumbsUpField.classList.add('fa_active');
        thumbsDownField.classList.add('fa_active');
        thumbsUpField.classList.add('fa_hover');
        thumbsDownField.classList.add('fa_hover');

        thumbsUpField.onclick = () => {
            /* alert(action); */
            if (thumbsUpField.style.color == '') {
                let downvotestmp = '0';
                thumbsUpField.style.color = "green";
                if (thumbsDownField.style.color == "red") {
                    likesField.textContent++;
                    thumbsDownField.style.color = "";
                    downvotestmp = '-1';
                }
                likesField.textContent++;
                makeHTTPRequest(action,
                    'post',
                    { id: inputField.value, upvotes: '1', downvotes: downvotestmp },
                    (response) => { /* console.log(response) */  });

            }
            else {
                thumbsUpField.style.color = "";
                likesField.textContent--;
                makeHTTPRequest(action,
                    'post',
                    { id: inputField.value, upvotes: '-1', downvotes: '0' },
                    (response) => {/* console.log(response) */ });
            }
        }
        thumbsDownField.onclick = () => {
            let upvotestmp = '0'
            if (thumbsDownField.style.color == '') {
                thumbsDownField.style.color = "red";
                if (thumbsUpField.style.color == "green") {
                    likesField.textContent--;
                    thumbsUpField.style.color = "";
                    upvotestmp = '-1';
                }
                likesField.textContent--;
                makeHTTPRequest(action,
                    'post',
                    { id: inputField.value, upvotes: upvotestmp, downvotes: '1' },
                    (response) => {/* console.log(response)  */ });

            }
            else {
                thumbsDownField.style.color = "";
                likesField.textContent++;
                makeHTTPRequest(action,
                    'post',
                    { id: inputField.value, upvotes: '0', downvotes: '-1' },
                    (response) => {/* console.log(response) */ });
            }
        }



    }
}
