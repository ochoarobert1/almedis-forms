let passd = true,
    passwordShow = document.getElementsByClassName('almedis-show-password'),
    tabsBtns = document.getElementsByClassName('almedis-tab'),
    contentTab = document.getElementsByClassName('almedis-content-tab'),
    naturalSubmit = document.getElementById('naturalSubmit'),
    registroSubmit = document.getElementById('registroSubmit'),
    convenioSubmit = document.getElementById('convenioSubmit'),
    /* PASSWORD LOST */
    almedisLostSubmit = document.getElementById('almedisLostSubmit'),
    almedisNewPassSubmit = document.getElementById('almedisNewPassSubmit'),
    /* LOGIN VARIABLES */
    almedisLoginSubmit = document.getElementById('almedisLoginSubmit'),
    almedisUserTab = document.getElementsByClassName('almedis-user-dashboard-tab'),
    almedisPedidosLink = document.getElementsByClassName('btn-pedidos'),
    almedisUserTabLinks = document.getElementsByClassName('almedis-user-tab'),
    /* CONFIRMATION VARIABLES */
    confirmationSubmit = document.getElementById('confirmationSubmit'),
    /* PAYMENT VARIABLES */
    paymentSubmit = document.getElementById('paymentSubmit'),
    /* TRACKING VARIABLES */
    trackingSubmit = document.getElementById('trackingSubmit'),
    /* TESTIMONIAL VARIABLES */
    testimonialSubmit = document.getElementById('testSubmit'),
    /* SINGLE INSTITUCIONES */
    convenioSingleSubmit = document.getElementById('convenioSingleSubmit'),
    downloadXLS = document.getElementById('downloadXLS'),
    /* SINGLE INSTITUCIONES */
    clientSubmit = document.getElementById('clientSubmit'),
    institucionSubmit = document.getElementById('institucionSubmit'),
    docsSubmit = document.getElementById('docsSubmit');


// Class functions declaration
let almedisForms = new AlmedisPublicClass();

if (downloadXLS) {
    downloadXLS.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('asdasd');
        e.preventDefault();
        var modal = document.getElementById('modal');
        if (modal) {
            modal.classList.toggle('modal-hidden');
        }
        var newRequest = new XMLHttpRequest();
        var resultDiv = document.getElementById('modalContent');
        resultDiv.innerHTML = '<div class="loader-modal"><div class="loader"></div></div>';
        var formData = new FormData();
        formData.append('action', "almedis_download_modal");
        newRequest.open('POST', custom_admin_url.ajax_url, true);
        newRequest.onload = function() {
            var result = JSON.parse(newRequest.responseText);
            document.getElementById('modalHeader').innerHTML = result.data.title;
            resultDiv.innerHTML = result.data.content;
        }
        newRequest.send(formData);
    });
}

$(document).ready(function() {
    jQuery('.btn-custom-opener-logged').on('click', function(e) {
        e.preventDefault();
    });
    jQuery('#tablePedidos').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    jQuery('#tableUser').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});


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
        passd = almedisForms.validateInput(elem, 'select');

        // Getting Name
        elem = document.getElementById('natural_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('natural_rut');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting email
        elem = document.getElementById('natural_email');
        passd = almedisForms.validateInput(elem, 'email');

        // Getting phone
        elem = document.getElementById('natural_phone');
        passd = almedisForms.validateInput(elem, 'phone');

        // Getting medicine
        elem = document.getElementById('natural_medicine');
        passd = almedisForms.validateInput(elem, 'medicine');

        elem = document.getElementsByName('natural_recipe');
        passd = almedisForms.validateInput(elem[0], 'file');

        // Getting password
        elem = document.getElementsByName('natural_notification');
        passd = almedisForms.validateInput(elem, 'radio');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('naturalResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisNaturalForm'));
            formData.append('action', "almedis_register_natural");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text">' + result.data + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisNaturalForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

var elemNaturalInput = document.getElementById('natural_recipe_file');
if (elemNaturalInput) {
    elemNaturalInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('naturalRecetaSelected');
        var fileLabel = document.getElementsByClassName('natural-file-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
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
        passd = almedisForms.validateInput(elem, 'select');

        // Getting Instituto
        elem = document.getElementById('convenio_usuario');
        passd = almedisForms.validateInput(elem, 'select');

        // Getting Name
        elem = document.getElementById('convenio_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('convenio_rut');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting email
        elem = document.getElementById('convenio_email');
        passd = almedisForms.validateInput(elem, 'email');

        // Getting phone
        elem = document.getElementById('convenio_phone');
        passd = almedisForms.validateInput(elem, 'phone');

        // Getting medicine
        elem = document.getElementById('convenio_medicine');
        passd = almedisForms.validateInput(elem, 'medicine');

        elem = document.getElementsByName('convenio_recipe');
        passd = almedisForms.validateInput(elem[0], 'file');

        // Getting password
        elem = document.getElementsByName('convenio_notification');
        passd = almedisForms.validateInput(elem, 'radio');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('convenioResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisConveniosForm'));

            formData.append('action', "almedis_register_convenio");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text">' + result.data + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisConveniosForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

/* CONVENIOS SINGLE */
if (convenioSingleSubmit) {
    convenioSingleSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Name
        elem = document.getElementById('convenio_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting email
        elem = document.getElementById('convenio_email');
        passd = almedisForms.validateInput(elem, 'email');

        // Getting medicine
        elem = document.getElementById('convenio_medicine');
        passd = almedisForms.validateInput(elem, 'medicine');

        elem = document.getElementsByName('convenio_carnet');
        passd = almedisForms.validateInput(elem[0], 'file');

        elem = document.getElementsByName('convenio_cartapoder');
        passd = almedisForms.validateInput(elem[0], 'file');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('convenioResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisConveniosSingleForm'));

            formData.append('action', "almedis_register_institucion");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text">' + result.data + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisConveniosSingleForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

var elemConvenioInput = document.getElementById('convenio_recipe_file');
if (elemConvenioInput) {
    elemConvenioInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('convenioRecetaSelected');
        var fileLabel = document.getElementsByClassName('convenio-file-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

// registro 
if (registroSubmit) {
    registroSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Name
        elem = document.getElementById('client_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('client_rut');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting email
        elem = document.getElementById('client_email');
        passd = almedisForms.validateInput(elem, 'email');

        // Getting phone
        elem = document.getElementById('client_phone');
        passd = almedisForms.validateInput(elem, 'phone');

        // Getting contraseña
        elem = document.getElementById('client_password');
        passd = almedisForms.validateInput(elem, 'password');

        // Getting contraseña
        elem2 = document.getElementById('client_confirm_password');
        if (elem.value != elem2.value) {
            elem2.nextElementSibling.classList.remove('hidden');
            passd = false;
        } else {
            elem2.nextElementSibling.classList.add('hidden');
        }

        // Getting direccion
        elem = document.getElementById('client_address');
        passd = almedisForms.validateInput(elem, 'text');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('registroResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisRegistroForm'));

            formData.append('action', "almedis_register_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                console.table(newRequest);
                console.log(result);
                resultDiv.innerHTML = '<span class="response-text">' + result.data.message + '</span>';
                if (result.data.action == 'redirect') {
                    setTimeout(function() {
                        window.location.assign(custom_admin_url.micuenta_url);
                    }, 1500);
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisRegistroForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

// registro 
if (clientSubmit) {
    clientSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Name
        elem = document.getElementById('client_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting Name
        elem = document.getElementById('client_apellido');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('client_rut');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting phone
        elem = document.getElementById('client_phone');
        passd = almedisForms.validateInput(elem, 'phone');

        // Getting direccion
        elem = document.getElementById('client_address');
        passd = almedisForms.validateInput(elem, 'text');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('clientResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('updateClientData'));

            formData.append('action', "almedis_update_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('updateClientData').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}

if (institucionSubmit) {
    institucionSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Name
        elem = document.getElementById('institucion_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting RUT
        elem = document.getElementById('institucion_rut');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting phone
        elem = document.getElementById('institucion_phone');
        passd = almedisForms.validateInput(elem, 'phone');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('institucionResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('updateInstitucionData'));

            formData.append('action', "almedis_update_institucion");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('updateInstitucionData').scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
}


if (almedisLoginSubmit) {
    almedisLoginSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting UserName
        elem = document.getElementById('username');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting UserName
        elem = document.getElementById('password');
        passd = almedisForms.validateInput(elem, 'password');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('loginResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisLoginForm'));

            formData.append('action', "almedis_login_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                if (result.data.class != 'error') {
                    setTimeout(function() {
                        window.location.href = result.data.redirect;
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

if (almedisLostSubmit) {
    almedisLostSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting UserName
        elem = document.getElementById('username');
        passd = almedisForms.validateInput(elem, 'email');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('loginResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisLostForm'));

            formData.append('action', "almedis_lost_pass_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisLostForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}

if (almedisNewPassSubmit) {
    almedisNewPassSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting UserName
        elem = document.getElementById('password');
        passd = almedisForms.validateInput(elem, 'text');

        elem = document.getElementById('password-repeat');
        passd = almedisForms.validateInput(elem, 'text');


        if (document.getElementById('password').value != document.getElementById('password-repeat').value) {
            document.getElementById('password-repeat').nextElementSibling.classList.remove('hidden');
            passd = false;
        } else {
            document.getElementById('password-repeat').nextElementSibling.classList.add('hidden');
        }

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('loginResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisNewPass'));

            formData.append('action', "almedis_new_pass_user");

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                if (result.data.class != 'error') {
                    setTimeout(function() {
                        window.location.href = result.data.redirect;
                    }, 2000);
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisNewPass').scrollIntoView({
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




var elemRadio = document.getElementsByName('payment_cartapoder');
if (elemRadio) {
    for (let index = 0; index < elemRadio.length; index++) {
        elemRadio[index].addEventListener('click', enableFileInput, false);
    }
}

function enableFileInput() {
    if (this.value === 'si') {
        document.getElementById('filesHandler').classList.add('hidden');
    } else {
        document.getElementById('filesHandler').classList.remove('hidden');
    }
}

var elemInput = document.getElementById('payment_cartapoder_file');
if (elemInput) {
    elemInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('fileSelected');
        var fileLabel = document.getElementsByClassName('file-carta-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

var elemInput = document.getElementById('payment_carnet_file');
if (elemInput) {
    elemInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('fileCarnetSelected');
        var fileLabel = document.getElementsByClassName('file-carnet-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

/* ALTERNATE PAYMENT METHODS FILES AND INFO */
var elemPayment = document.getElementsByName('payment_method');
if (elemPayment) {
    for (let index = 0; index < elemPayment.length; index++) {
        elemPayment[index].addEventListener('click', function() {
            var paymentType = this.value;
            var paymentBoxes = document.getElementsByClassName('payment-info');
            if (paymentType == 'tarjeta') {
                document.getElementsByClassName('text-non-tarjeta')[0].classList.add('hidden');
                document.getElementsByClassName('text-tarjeta')[0].classList.remove('hidden');
            } else {
                document.getElementsByClassName('text-non-tarjeta')[0].classList.remove('hidden');
                document.getElementsByClassName('text-tarjeta')[0].classList.add('hidden');
            }
            for (let index2 = 0; index2 < paymentBoxes.length; index2++) {
                paymentBoxes[index2].classList.add('hidden');
                if (paymentBoxes[index2].getAttribute('data-type') == paymentType) {
                    paymentBoxes[index2].classList.remove('hidden');
                }
            }
        });
    }
}

var elemCoPagoInput = document.getElementById('copago_file');
if (elemCoPagoInput) {
    elemCoPagoInput.addEventListener('change', function() {
        var filename = this.value;
        if (filename.length > 0) {
            filename = filename.split("\\");
            document.getElementById('copago_name').classList.add('hidden');
            var fileSelected = document.getElementById('copago_file_selected');
            fileSelected.innerHTML = filename[2];
        } else {
            document.getElementById('copago_name').classList.remove('hidden');
        }
    });
}

var elemTransferenciaInput = document.getElementById('transferencia_file');
if (elemTransferenciaInput) {
    elemTransferenciaInput.addEventListener('change', function() {
        var filename = this.value;
        if (filename.length > 0) {
            filename = filename.split("\\");
            document.getElementById('transferencia_name').classList.add('hidden');
            var fileSelected = document.getElementById('transferencia_file_selected');
            fileSelected.innerHTML = filename[2];
        } else {
            document.getElementById('transferencia_name').classList.remove('hidden');
        }
    });
}

if (paymentSubmit) {
    paymentSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        var elemSelected = '';
        var paymentSelected = '';
        var docsSelected = '';
        passd = true;

        // Getting Pedido Code
        elem = document.getElementById('payment_pedido');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting Carta Poder
        elem = document.getElementsByName('payment_method');
        passd = almedisForms.validateInput(elem, 'radio');

        elemSelected = document.getElementsByName('payment_method');
        for (let index = 0; index < elemPayment.length; index++) {
            if (elemPayment[index].checked) {
                paymentSelected = elemPayment[index].value;
            }
        }

        // Getting Payment Type
        if (paymentSelected == 'copago') {
            elem = document.getElementsByName('copago_total');
            passd = almedisForms.validateInput(elem[0], 'text');

            elem = document.getElementsByName('copago_file');
            passd = almedisForms.validateInput(elem[0], 'file');
        }

        if (paymentSelected == 'transferencia') {
            elem = document.getElementsByName('transferencia_total');
            passd = almedisForms.validateInput(elem[0], 'text');

            elem = document.getElementsByName('transferencia_file');
            passd = almedisForms.validateInput(elem[0], 'file');
        }

        docsSelected = document.getElementsByName('payment_cartapoder');
        for (let index = 0; index < docsSelected.length; index++) {
            if (docsSelected[index].checked) {
                var documentSelected = docsSelected[index].value;
            }
        }

        if (documentSelected == 'no') {
            elem = document.getElementsByName('payment_cartapoder_file');
            passd = almedisForms.validateInput(elem[0], 'file');

            elem = document.getElementsByName('payment_carnet_file');
            passd = almedisForms.validateInput(elem[0], 'file');
        }

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var formData = new FormData(document.getElementById('almedisPaymentForm'));
            if (paymentSelected == 'copago') {
                var files = document.getElementById('copago_file').files;
                formData.append("file", files[0]);
            }
            if (paymentSelected == 'transferencia') {
                var files = document.getElementById('transferencia_file').files;
                formData.append("file", files[0]);
            }
            if (documentSelected == 'no') {
                var fileCarta = document.getElementById('payment_cartapoder_file').files;
                formData.append("carta", fileCarta[0]);
                var fileCarnet = document.getElementById('payment_carnet_file').files;
                formData.append("carnet", fileCarnet[0]);
            }

            formData.append('action', "almedis_payment_confirmation");
            var resultDiv = document.getElementById('paymentResult');
            resultDiv.innerHTML = '<div class="loader"></div>';

            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                document.getElementById('almedisPaymentForm').reset();
                if (paymentSelected == 'tarjeta') {
                    var flowUrl = document.getElementById('paymentSubmit').getAttribute('data-url');
                    window.location.assign(flowUrl);
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisPaymentForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}

if (trackingSubmit) {
    trackingSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Pedido Code
        elem = document.getElementById('payment_pedido');
        passd = almedisForms.validateInput(elem, 'text');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('trackingResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisTrackingForm'));
            formData.append('action', "almedis_tracking_pedido");
            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                if (result.data.class == 'error') {
                    resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                } else {
                    resultDiv.innerHTML = result.data.message;
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisTrackingForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}

if (testimonialSubmit) {
    testimonialSubmit.addEventListener('click', function(e) {
        e.preventDefault();
        var elem = '';
        passd = true;

        // Getting Testimonial Name
        elem = document.getElementById('test_nombre');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting Testimonial Text
        elem = document.getElementById('test_message');
        passd = almedisForms.validateInput(elem, 'text');

        // Getting Testimonial Picture
        elem = document.getElementsByName('test_picture');
        passd = almedisForms.validateInput(elem[0], 'file');

        if (passd == true) {
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('testResult');
            resultDiv.innerHTML = '<div class="loader"></div>';
            var formData = new FormData(document.getElementById('almedisTestForm'));
            formData.append('action', "almedis_testimonial_submit");
            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                if (result.data.class == 'error') {
                    resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                } else {
                    resultDiv.innerHTML = '<span class="response-text ' + result.data.class + '">' + result.data.message + '</span>';
                }
            }
            newRequest.send(formData);
        } else {
            document.getElementById('almedisTestForm').scrollIntoView({
                behavior: 'smooth'
            });
        }
    }, false);
}


var elemTestInput = document.getElementById('test_picture_file');
if (elemTestInput) {
    elemTestInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('testPictureSelected');
        var fileLabel = document.getElementsByClassName('test-file-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

/* ABRIR MODAL EN PEDIDOS */
/*
var abrirPedidosClass = document.getElementsByClassName('almedis-pedido-click');
if (abrirPedidosClass) {
    for (let index = 0; index < abrirPedidosClass.length; index++) {
        abrirPedidosClass[index].addEventListener('click', function(e) {
            e.preventDefault();
            var modal = document.getElementById('modal');
            if (modal) {
                modal.classList.toggle('modal-hidden');
            }

            var pedidoId = this.getAttribute('data-pedido');
            var newRequest = new XMLHttpRequest();
            var resultDiv = document.getElementById('modalContent');
            resultDiv.innerHTML = '<div class="loader-modal"><div class="loader"></div></div>';
            var formData = new FormData();
            formData.append('action', "almedis_edit_pedido");
            formData.append('pedido_id', pedidoId);
            newRequest.open('POST', custom_admin_url.ajax_url, true);
            newRequest.onload = function() {
                var result = JSON.parse(newRequest.responseText);
                document.getElementById('modalHeader').innerHTML = result.data.title;
                resultDiv.innerHTML = result.data.content;
            }
            newRequest.send(formData);
        });
    }
}
*/

jQuery(document).on('change', '#client_recipe_file', function() {
    var filename = this.value;
    console.log(filename);
    filename = filename.split("\\");
    jQuery('#recetaSelected').removeClass('missing');
    jQuery('#recetaSelected').addClass('submitted');
    activateModalSubmit();
});

jQuery(document).on('change', '#client_carta_file', function() {
    var filename = this.value;
    console.log(filename);
    filename = filename.split("\\");
    jQuery('#cartaSelected').removeClass('missing');
    jQuery('#cartaSelected').addClass('submitted');
    activateModalSubmit();
});

jQuery(document).on('change', '#client_carnet_file', function() {
    var filename = this.value;
    console.log(filename);
    filename = filename.split("\\");
    jQuery('#carnetSelected').removeClass('missing');
    jQuery('#carnetSelected').addClass('submitted');
    activateModalSubmit();
});

function activateModalSubmit() {
    jQuery('#modalSubmit').removeClass('hidden');
}

var modalClose = document.getElementById('closeModal');
if (modalClose) {
    modalClose.addEventListener('click', function() {
        document.getElementById('modalHeader').innerHTML = '';
        document.getElementById('modal').classList.toggle('modal-hidden');
    });
}

jQuery(document).on('click', '#docsSubmit', function(e) {
    e.preventDefault();
    passd = true;

    if (passd == true) {
        var pedidoId = document.getElementById('almedisModalForm').getAttribute('data-pedido');
        var newRequest = new XMLHttpRequest();
        var resultDiv = document.getElementById('docsResult');
        resultDiv.innerHTML = '<div class="loader-modal"><div class="loader"></div></div>';
        var formData = new FormData();
        formData.append('action', "almedis_load_docs");
        formData.append('pedido_id', pedidoId);
        formData.append('client_recipe', document.getElementById('client_recipe_file').files[0]);
        formData.append('client_carta', document.getElementById('client_carta_file').files[0]);
        formData.append('client_carnet', document.getElementById('client_carnet_file').files[0]);
        newRequest.open('POST', custom_admin_url.ajax_url, true);
        newRequest.onload = function() {
            var result = JSON.parse(newRequest.responseText);
            document.getElementById('docsResult').innerHTML = result.data;
            setTimeout(() => {
                var resultDiv = document.getElementById('archivesSingle');
                resultDiv.innerHTML = '<div class="loader-modal"><div class="loader"></div></div>';
                formData.append('action', "almedis_reload_docs");
                formData.append('pedido_id', pedidoId);
                newRequest.open('POST', custom_admin_url.ajax_url, true);
                newRequest.onload = function() {
                    var result = JSON.parse(newRequest.responseText);
                    resultDiv.innerHTML = result.data;
                }
                newRequest.send(formData);
            }, 2000);
        }
        newRequest.send(formData);
    } else {
        document.getElementById('almedisTestForm').scrollIntoView({
            behavior: 'smooth'
        });
    }

});



var elemCarnetInput = document.getElementById('convenio_carnet_file');
if (elemCarnetInput) {
    elemCarnetInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('convenioCarnetSelected');
        var fileLabel = document.getElementsByClassName('carnet-file-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

var elemCartaInput = document.getElementById('convenio_carta_file');
if (elemCartaInput) {
    elemCartaInput.addEventListener('change', function() {
        var filename = this.value;
        filename = filename.split("\\");
        var fileSelected = document.getElementById('convenioCartaSelected');
        var fileLabel = document.getElementsByClassName('carta-file-helper');
        fileLabel[0].classList.remove('hidden');
        fileSelected.innerHTML = filename[2];
    });
}

var repeatPedidoClicks = document.getElementsByClassName('almedis-repeat-pedido-click');
if (repeatPedidoClicks) {
    for (let index = 0; index < repeatPedidoClicks.length; index++) {
        repeatPedidoClicks[index].addEventListener('click', function() {
            var pedidoId = repeatPedidoClicks[index].getAttribute('data-pedido');
            Swal.fire({
                icon: 'question',
                title: 'Repetir Pedido',
                text: '¿Realmente desea repetir este mismo pedido?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Repetir',
                denyButtonText: 'Cancelar',
                confirmButtonColor: '#009df1'
            }).then((result) => {
                if (result.isConfirmed) {

                    var newRequest = new XMLHttpRequest();
                    var formData = new FormData();
                    formData.append('action', "almedis_repeat_pedido");
                    formData.append('pedido_id', pedidoId);
                    newRequest.open('POST', custom_admin_url.ajax_url, true);
                    newRequest.onload = function() {
                        Swal.fire('¡Pedido repetido con éxito!', '', 'success')
                    }
                    newRequest.send(formData);


                }
            });
        });
    }
}

jQuery(document).on('click', '.filter-file-btn', function(e) {
    e.preventDefault();
    jQuery.ajax({
        type: 'POST',
        url: custom_admin_url.ajax_url,
        data: {
            action: 'almedis_get_archhive',
            info: jQuery('.almedis-filter-form').serialize()
        },
        beforeSend: function() {
            jQuery('.filter-mini-loader').html('<div class="loader"></div>');
        },
        success: function(result) {
            jQuery('.filter-mini-loader').html('');
            var blob = new Blob([result], {
                type: 'application/vnd.ms-excel'
            });
            var downloadUrl = URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.href = downloadUrl;
            a.download = "data.xlsx";
            document.body.appendChild(a);
            a.click();
        }
    });
    console.log('clicked');
});