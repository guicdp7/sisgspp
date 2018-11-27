(function () {
    "use strict";
    var uNome, uSnome, uTipo, uPid;

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

                var txMenuUName = document.getElementById("txMenuUName"),
                    formSolicita = document.getElementById("formSolicita");
                txMenuUName.innerHTML = uTipo == "J" ? uSnome : uNome + " " + uSnome;
                formSolicita.addEventListener("submit", formSolicitaSubmit, false);

                swipedetect(document.body, function (dir) {
                    if (dir == "d" || dir == "e") {
                        if (menuIsAtivo && dir == "e") {
                            closeSlideMenu();
                        }
                        else if (!menuIsAtivo && dir == "d") {
                            openSlideMenu();
                        }
                    }
                });

                _AoIniciar();
                getProjetos();
                getTipos();
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
        var api = new Api("projetos", { "pessoa_id": uPid }),
            seProjetos = document.getElementById("seProjetos");
        api.send(function (res) {
            if (res.error) {
                Erro(res);
                btSubmit.disabled = true;
            }
            else {
                limpaObj(seProjetos);
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        seProjetos.appendChild(CriaObj("option", {
                            conteudo: res[i].nome,
                            value: res[i].id
                        }));
                    }
                }
                else {
                    seProjetos.appendChild(CriaObj("option", {
                        conteudo: "Nenhum Projeto"
                    }));
                    btSubmit.disabled = true;
                }
            }
        });
    };
    function getTipos() {
        var api = new Api("tarefas/tipos"),
            seTipos = document.getElementById("seTipos");
        api.send(function (res) {
            if (res.error) {
                Erro(res);
                btSubmit.disabled = true;            }
            else {
                limpaObj(seTipos);
                if (res.length > 0) {
                    for (var i = 0; i < res.length; i++) {
                        seTipos.appendChild(CriaObj("option", {
                            conteudo: res[i].nome,
                            value: res[i].id
                        }));
                    }
                }
                else {
                    seProjetos.appendChild(CriaObj("option", {
                        conteudo: "Nenhum Tipo"
                    }));
                    btSubmit.disabled = true;
                }
            }
        });
    };
    //Eventos
    function formSolicitaSubmit(e) {
        e.preventDefault();
        var self = this;

        if (self.descricao.value == "") {
            var msg = new Mensagem("Por favor descreva sua solicitação.", true);
        }
        else {
            var btSubmit = document.getElementById("btSubmit");
            Loader.add(btSubmit);
            var api = new Api("tarefas/nova", {
                "tarefa": {
                    "pessoa_id": uPid,
                    "projeto_id": self.projeto.value,
                    "tipo_id": self.tipo.value,
                    "descricao": self.descricao.value
                }
            });
            api.send(function (res) {
                if (res.error) {
                    Erro(error);
                }
                else {
                    location.href = "minhas-solicitacoes.html";
                }
                Loader.remove(btSubmit);
            });
        }
    };
})();