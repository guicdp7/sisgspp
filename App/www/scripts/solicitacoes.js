(function () {
    "use strict";
    var uNome, uSnome, uTipo, uPid, pId, pNome, projetos = [];

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

                pId = getUrlParameter("projeto_id");
                pNome = getUrlParameter("projeto_nome");

                var txMenuUName = document.getElementById("txMenuUName");
                txMenuUName.innerHTML = uTipo == "J" ? uSnome : uNome + " " + uSnome;

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

                if (pId) {
                    getSolicitacoes(pId, pNome, function () { });
                }
                else {
                    getProjetos(function () {
                        var i = 0;
                        var gs = function () {
                            if (i < projetos.length) {
                                getSolicitacoes(projetos[i].id, projetos[i].nome, function () {
                                    i++;
                                    gs();
                                });
                            }
                        };
                        gs();
                    });
                }

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

    function getProjetos(retorno) {
        var api = new Api("projetos", { "pessoa_id": uPid }),
            divProjetos = document.getElementById("divProjetos");
        api.send(function (res) {
            if (res.error) {
                Erro(res);
            }
            else {
                limpaObj(divSolicitacoes);
                if (res.length > 0) {
                    projetos = res;
                    retorno();
                }
                else {
                    divSolicitacoes.appendChild(CriaObj("h3", { conteudo: "Você ainda não possui projetos..." }));
                }
            }
        });
    };
    function getSolicitacoes(pId, pNome, retorno) {
        var api = new Api("tarefas", { "pessoa_id": uPid, "projeto_id": pId }),
            divSolicitacoes = document.getElementById("divSolicitacoes");
        api.send(function (res) {
            if (res.error) {
                Erro(res);
            }
            else {
                divSolicitacoes.appendChild(CriaObj("h2", {
                    conteudo: pNome
                }));
                if (res.length > 0) {
                    res.reverse();
                    for (var i in res) {
                        divSolicitacoes.appendChild(geraSolicitacoes(res[i]));
                    }
                }
                else {
                    divSolicitacoes.appendChild(CriaObj("h4", {
                        classe: "box-down p-2 mb-2",
                        conteudo: "Esse projeto ainda não possui solicitações..."
                    }));
                }
                retorno();
            }
        });
    };
    function geraSolicitacoes(dds) {
        var arrayStatus = ["Cancelada", "Pendente", "Em Desenvolvimento", "Concluida"];
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
            conteudo: dds.tipo.nome + " (" + arrayStatus[dds.status] + ")"
        }), divSTit = CriaObj("div", {
            classe: "text-cinza-escuro d-block",
            conteudo: formataData(dds.dt_cadastro, true)
        }), divCont = CriaObj("div", {
            classe: "box-down-content bg-azul-escuro pl-3 pr-5 pt-3"
        }), pDescricao = CriaObj("p", {
            classe: "text-ice",
            conteudo: dds.descricao
        }), pEntrega = CriaObj("p", {
            classe: "text-cinza-claro",
            conteudo: "Prazo: " + dds.prazo + (dds.prazo > 1 ? " dias" : " dia")
        });
        divCont.appendChild(pDescricao);
        divCont.appendChild(pEntrega);
        divDesc.appendChild(divTit);
        divDesc.appendChild(divSTit);
        divHead.appendChild(divFlag);
        divHead.appendChild(divDesc);
        divBox.appendChild(divHead);
        divBox.appendChild(divCont);

        return divBox;
    };
    //Eventos

})();