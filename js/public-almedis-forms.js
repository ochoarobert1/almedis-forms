let passwordShow = document.getElementsByClassName('almedis-show-password'),
    tabsBtns = document.getElementsByClassName('almedis-tab'),
    contentTab = document.getElementsByClassName('almedis-content-tab'),
    naturalSubmit = document.getElementById('naturalSubmit'),
    convenioSubmit = document.getElementById('convenioSubmit');

// Add password button to show
if (passwordShow.length > 0) {
    for (var i = 0; i < passwordShow.length; i++) {
        passwordShow[i].addEventListener('click', function(e) {
            currentState = this.previousElementSibling.getAttribute('type');
            if (currentState == 'password') {
                currentState = this.previousElementSibling.setAttribute('type', 'text');
            } else {
                currentState = this.previousElementSibling.setAttribute('type', 'password');
            }
        }, false);
    }
}

// Form tabs function
if (tabsBtns.length > 0) {
    for (var i = 0; i < tabsBtns.length; i++) {
        tabsBtns[i].addEventListener('click', function(e) {
            e.preventDefault();
            var selectedTab = this.getAttribute('data-tab');
            for (var i = 0; i < contentTab.length; i++) {
                contentTab[i].classList.add('hidden');
            }
            for (var i = 0; i < tabsBtns.length; i++) {
                tabsBtns[i].classList.remove('almedis-tab-active');
            }
            this.classList.add('almedis-tab-active');
            document.getElementById(selectedTab).classList.remove('hidden');
        }, false);
    }
}

// Submit of Natural Form
if (naturalSubmit) {
    naturalSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Natural Type
        elem = document.getElementById('natural_type');
        passd = validateInput(elem, 'select');

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
        elem = document.getElementsByName('natural_notification');
        passd = validateInput(elem, 'radio');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('naturalResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisNaturalForm'));

            formData.append("action", "almedis_register_natural");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text">' +  result.data + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisNaturalForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

// Submit of Convenios Form
if (convenioSubmit) {
    convenioSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Convenio Type
        elem = document.getElementById('convenio_type');
        passd = validateInput(elem, 'select');

        // Getting Instituto
        elem = document.getElementById('convenio_institucion');
        passd = validateInput(elem, 'select');

        // Getting Name
        elem = document.getElementById('convenio_nombre');
        passd = validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('convenio_rut');
        passd = validateInput(elem, 'text');

        // Getting email
        elem = document.getElementById('convenio_email');
        passd = validateInput(elem, 'email');

        // Getting phone
        elem = document.getElementById('convenio_phone');
        passd = validateInput(elem, 'phone');

        // Getting medicine
        elem = document.getElementById('convenio_medicine');
        passd = validateInput(elem, 'medicine');

        // Getting password
        elem = document.getElementsByName('convenio_notification');
        passd = validateInput(elem, 'radio');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('convenioResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisConveniosForm'));

            formData.append("action", "almedis_register_convenio");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text">' +  result.data + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisConveniosForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}