let passd = true,
    almedisLoginSubmit = document.getElementById('almedisLoginSubmit');

function isValidEmailAddress(emailAddress) {
    'use strict';
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function telephoneCheck(str) {
    var patt = new RegExp(/^(\+{0,})(\d{0,})([(]{1}\d{1,3}[)]{0,}){0,}(\s?\d+|\+\d{2,3}\s{1}\d+|\d+){1}[\s|-]?\d+([\s|-]?\d+){1,2}(\s){0,}$/gm);
    return patt.test(str);
}

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

        case 'select':
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                elem.nextElementSibling.classList.add('hidden');
            }
            break;

        case 'medicine':
            if (elem.value == '') {
                elem.nextElementSibling.classList.remove('hidden');
                passd = false;
            } else {
                elem.nextElementSibling.classList.add('hidden');
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

if (almedisLoginSubmit) {
    almedisLoginSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting UserName
        elem = document.getElementById('username');
        passd = validateInput(elem, 'text');

        // Getting UserName
        elem = document.getElementById('password');
        passd = validateInput(elem, 'password');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('loginResult');
            var formData = new FormData(document.getElementById('almedisLoginForm'));

            formData.append("action", "almedis_login_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = result.data;
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisLoginForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}