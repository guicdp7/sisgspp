(function () {
    "use strict";

    document.addEventListener('deviceready', onDeviceReady.bind(this), false);

    function onDeviceReady() {
        if (thisUser) {
            includeHTML(function () {
                // Manipular eventos de pausa e retomada do Cordova
                document.addEventListener('pause', onPause.bind(this), false);
                document.addEventListener('resume', onResume.bind(this), false);
                document.addEventListener("backbutton", onBackButtonClick, false);

                _AoIniciar();
            });
        }
        else {
            location.href = "index.html";
        }
    };

    function onPause() {
        // TODO: este aplicativo foi suspenso. Salve o estado do aplicativo aqui.
    };

    function onResume() {
        // TODO: este aplicativo foi reativado. Restaure o estado do aplicativo aqui.
    };

    //Eventos

})();