(function () {
    "use strict";

    document.addEventListener( 'deviceready', onDeviceReady.bind( this ), false );

    function onDeviceReady() {
        // Manipular eventos de pausa e retomada do Cordova
        document.addEventListener( 'pause', onPause.bind( this ), false );
        document.addEventListener( 'resume', onResume.bind( this ), false );

        formLogin.addEventListener("submit", formLoginSubmit, false);
    };

    function onPause() {
        // TODO: este aplicativo foi suspenso. Salve o estado do aplicativo aqui.
    };

    function onResume() {
        // TODO: este aplicativo foi reativado. Restaure o estado do aplicativo aqui.
    };

    //Eventos
    function formLoginSubmit(e) {
        e.preventDefault();

        var api = new Api("login", {
            "username": this.username.value,
            "senha": this.senha.value
        });
        api.send(function (res) {
            if (res.error) {
                Erro(res);
            }
            else {
                var msg = new Mensagem(JSON.stringify(res), true);
            }
        });
    }
} )();