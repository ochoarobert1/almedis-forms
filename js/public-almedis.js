let passd = true,
    passwordShow = document.getElementsByClassName('almedis-show-password'),
    uploadFilesField = document.getElementsByClassName('almedis-file-upload-file'),
    uploadFilesBtn = document.getElementsByClassName('almedis-file-upload-btn'),
    naturalSubmit = document.getElementById('naturalSubmit');

function isValidEmailAddress(emailAddress) {
    'use strict';
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function telephoneCheck(str) {
    var patt = new RegExp(/^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm);
    return patt.test(str);
}

if (passwordShow.length > 0) {
    for (var i = 0; i < passwordShow.length; i++) {
        passwordShow[i].addEventListener('click', showPasswordFunction, false);
    }
}

function showPasswordFunction() {
    currentState = this.previousElementSibling.getAttribute('type');
    if (currentState == 'password') {
        currentState = this.previousElementSibling.setAttribute('type', 'text');
    } else {
        currentState = this.previousElementSibling.setAttribute('type', 'password');
    }
}

if (uploadFilesBtn.length > 0) {
    for (let index = 0; index < uploadFilesBtn.length; index++) {
        uploadFilesBtn[index].addEventListener('click', function(e) {
            e.preventDefault();
            var currentID = this.getAttribute('id').slice(0, -3);
            document.getElementById(currentID + 'File').click();
        }, false);
    }

    for (let index = 0; index < uploadFilesField.length; index++) {
        uploadFilesField[index].addEventListener('change', function(e) {
            var currentID = this.getAttribute('id').slice(0, -4);
            document.getElementById(currentID + 'Helper').innerHTML = '<span class="almedis-file-icon"></span>' + this.value.split("\\").pop();
        }, false);
    }
}

naturalSubmit.addEventListener('click', function(e) {
    e.preventDefault();
    var elem = '';
    passd = true;

    // Getting Name
    elem = document.getElementById('natural_nombre');
    passd = validateInput(elem, 'text');

    // Getting RUT
    elem = document.getElementById('natural_rut');
    passd = validateInput(elem, 'text');

    // Getting email
    elem = document.getElementById('natural_email');
    passd = validateInput(elem, 'email');

    // Getting phone
    elem = document.getElementById('natural_phone');
    passd = validateInput(elem, 'phone');

    // Getting medicine
    elem = document.getElementById('natural_medicine');
    passd = validateInput(elem, 'medicine');

    // Getting password
    elem = document.getElementById('natural_password');
    passd = validateInput(elem, 'password');

    // Getting password
    elem = document.getElementsByName('natural_notification');
    passd = validateInput(elem, 'radio');

    if (passd == true) {
        var elements = document.getElementsByClassName('almedis-form-control');
        dataString = 'action=almedis_register_natural';
        for (let index = 0; index < elements.length; index++) {
            dataString += '&' + elements[index].getAttribute('name') + '=' + elements[index].value;
        }
        console.log(dataString);
        /* SEND AJAX */
        /*
        var newRequest = new XMLHttpRequest();
        newRequest.open('POST', custom_admin_url.ajax_url, true);
        newRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        newRequest.onload = function() {
            var result = JSON.parse(newRequest.responseText);
            resultDiv.innerHTML = result.data;
            if (result.success == true) {
                setTimeout(function() {
                    resultDiv.classList.add('d-none');
                    grecaptcha.reset(grecaptchaWidget);
                    window.location.href = custom_admin_url.thanks_widget_url;
                }, 700);
            }
        }
        newRequest.send(dataString);
        */

    } else {
        document.getElementById('almedisNaturalForm').scrollIntoView({
            behavior: 'smooth'
        });
    }
});


function validateInput(elem, type) {
    switch (type) {
        case 'text':
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                if (elem.value.length <= 2) {
                    elem.nextElementSibling.classList.remove('hidden');
                    passd = false;
                } else {
                    elem.nextElementSibling.classList.add('hidden');
                }
            }
            break;

        case 'email':
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                if (isValidEmailAddress(elem.value) == false) {
                    elem.nextElementSibling.classList.remove('hidden');
                    passd = false;
                } else {
                    elem.nextElementSibling.classList.add('hidden');
                }
            }
            break;

        case 'phone':
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                if (telephoneCheck(elem.value) == false) {
                    elem.nextElementSibling.classList.remove('hidden');
                    passd = false;
                } else {
                    elem.nextElementSibling.classList.add('hidden');
                }
            }
            break;

        case 'medicine':
            if (elem.value == '') {
                elem.nextElementSibling.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                elem.nextElementSibling.nextElementSibling.classList.add('hidden');
            }
            break;

        case 'password':
            if (elem.value == '') {
                elem.parentElement.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                elem.parentElement.nextElementSibling.classList.add('hidden');
            }
            break;

        case 'radio':
            var formValid = false;
            for (let index = 0; index < elem.length; index++) {
                if (elem[index].checked) {
                    formValid = true;
                    break;
                }
            }

            if (formValid == false) {
                elem[0].parentElement.parentElement.parentElement.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                elem[0].parentElement.parentElement.parentElement.nextElementSibling.classList.add('hidden');
            }
            break;

        default:
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                if (elem.value.length <= 2) {
                    elem.nextElementSibling.classList.remove('hidden');
                    passd = false;
                } else {
                    elem.nextElementSibling.classList.add('hidden');
                }
            }
            break;
    }

    return passd;
}