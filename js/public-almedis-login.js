let passd = true,
    almedisLoginSubmit = document.getElementById('almedisLoginSubmit'),
    almedisUserTab = document.getElementsByClassName('almedis-user-dashboard-tab'),
    almedisPedidosLink = document.getElementsByClassName('btn-pedidos'),
    almedisUserTabLinks = document.getElementsByClassName('almedis-user-tab');


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
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisLoginForm'));

            formData.append("action", "almedis_login_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                if (result.data.class != 'error') {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisLoginForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}

if (almedisUserTabLinks) {
    for (let index = 0; index < almedisUserTabLinks.length; index++) {
        almedisUserTabLinks[index].addEventListener('click', function(e) {
            e.preventDefault();
            var tabSelected = this.getAttribute('data-tab');
            changeUserTab(tabSelected);
        }, false);
    }
}

if (almedisPedidosLink) {
    for (let index = 0; index < almedisPedidosLink.length; index++) {
        almedisPedidosLink[index].addEventListener('click', function(e) {
            e.preventDefault();
            changeUserTab('pedidos');
        }, false);
    }
}

function changeUserTab(id) {
    for (let index2 = 0; index2 < almedisUserTab.length; index2++) {
        almedisUserTab[index2].classList.add('hidden');
    }
    document.getElementById(id).classList.remove('hidden');
}