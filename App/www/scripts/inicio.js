(function () {
    "use strict";
    var uNome, uSnome, uTipo, uPid, uEmail;

    document.addEventListener('deviceready', onDeviceReady.bind(this), false);

    function onDeviceReady() {
        if (thisUser) {
            includeHTML(function () {
                // Manipular eventos de pausa e retomada do Cordova
                document.addEventListener('pause', onPause.bind(this), false);
                document.addEventListener('resume', onResume.bind(this), false);
                document.addEventListener("backbutton", onBackButtonClick, false);

                uNome = thisUser[0].nome;
                uSnome = thisUser[0].sobrenome;
                uTipo = thisUser[0].tipo;
                uPid = thisUser[0].pessoa_id;
                uEmail = thisUser[0].email;

                var txUserName = document.getElementById("txUserName"),
                    txEmail = document.getElementById("txEmail"),
                    txMenuUName = document.getElementById("txMenuUName");
                txUserName.innerHTML = uTipo == "J" ? uSnome : uNome + " " + uSnome;
                txMenuUName.innerHTML = txUserName.innerHTML;
                txEmail.innerHTML = uEmail;

                getProjetos();

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

    function getProjetos() {
        var api = new Api("projetos", { "pessoa_id": uPid });
        api.send(function (res) {
            if (res.error) {
                Erro(res);
            }
            else {
                limpaObj(divProjetos);
                for (var i in res) {
                    divProjetos.appendChild(geraProjeto(res[i]));
                }
            }
        });
    };
    function geraProjeto(dds) {
        var divBox = CriaObj("div", {
            classe: "box-down p-2 mb-2"
        }), divHead = CriaObj("div", {
            classe: "box-down-header bg-verde py-3 px-3 d-flex justify-content-start"
        }), divFlag = CriaObj("div", {
            classe: "flag mr-2"
        }), divDesc = CriaObj("div", {
            classe: "d-flex flex-column"
        }), divTit = CriaObj("div", {
            classe: "text-cinza-escuro d-block",
            conteudo: dds.nome
        }), divSTit = CriaObj("div", {
            classe: "text-cinza-escuro d-block",
            conteudo: "Solicitações >"
        });

        divDesc.appendChild(divTit);
        divDesc.appendChild(divSTit);
        divHead.appendChild(divFlag);
        divHead.appendChild(divDesc);
        divBox.appendChild(divHead);

        return divBox;
    };
    //Eventos

})();