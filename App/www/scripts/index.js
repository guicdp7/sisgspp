(function () {
    "use strict";

    document.addEventListener( 'deviceready', onDeviceReady.bind( this ), false );

    function onDeviceReady() {
        if (!thisUser) {
            // Manipular eventos de pausa e retomada do Cordova
            document.addEventListener('pause', onPause.bind(this), false);
            document.addEventListener('resume', onResume.bind(this), false);
            document.addEventListener("backbutton", onBackButtonClick, false);

            formLogin.addEventListener("submit", formLoginSubmit, false);

            _AoIniciar();
        }
        else {
            location.href = "inicio.html";
        }
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

        Loader.add(btSubmit);
        var api = new Api("login", {
            "username": this.username.value,
            "senha": this.senha.value
        }, false);
        api.send(function (res) {
            if (res.error) {
                var msg = new Mensagem("Verifique os dados informados e tente novamente.");
                msg.setTitulo("Não foi possível fazer login!");
                msg.mostrar();
            }
            else {
                setLogin(res);
                location.href = "inicio.html";
            }
            Loader.remove(btSubmit);
        });
    }
} )();