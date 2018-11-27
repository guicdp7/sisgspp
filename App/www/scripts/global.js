"use strict";
/*Variáveis Globais*/
var Servidor = "http://sisgspp.esy.es/", Pagina, AjaxErros = [], thisUser = false;
/*Atribuições Globais*/
AjaxErros[0] = "Sem conexão com o servidor (Erro 0).";
AjaxErros[404] = "Página não encontrada (Erro 404).";
AjaxErros[500] = "Erro interno do Servidor (Erro 500).";
AjaxErros['parsererror'] = "A análise da requisição JSON falhou.";
AjaxErros['timeout'] = "Tempo limite excedido.";
AjaxErros['abort'] = "A requisição foi abortada.";

$(document).ready(function () {
    thisUser = isLogado();
    $("form").keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
});
/*Funções*/
function _AoIniciar() {
    /*Bloqueia Drag Drop*/
    $('a, img').on('dragstart', function (event) { event.preventDefault(); });

    /*Remove Is Invalid*/
    $('input').on('blur', onInputBlur);
    $('select').on('blur', onInputBlur);
    $('input[type="radio"]').on('click', onInputBlur);
    $('input[type="checkbox"]').on('click', onInputBlur);

    Pagina = location.href.split('/');
    Pagina = Pagina[Pagina.length - 1];

    $('body').fadeIn('slow');
};
function N(num, dec, ponto) {
    var n = num, p = ponto;
    dec = dec ? dec : 0;
    if (n === null || n === false || n === undefined) { return false; }
    if (isNaN(n)) {
        n = n.replace(",", ".");
        if (isNaN(n)) { return false; }
    }
    var res = Number(n);
    if (dec > 0) { res = res.toFixed(dec); }
    else { res = res.toString(); }
    if (res.indexOf("-0") > -1) { res = res.replace("-", ""); }
    if (res.indexOf("e") > -1) { var ss = res.split("e"); res = ss[0]; }
    if (p && p !== ".") { res = res.replace(".", p); }
    else if (!isNaN(res)) { res = Number(res); }
    else { return false; }
    return res;
};
function C(num1, operacao, num2, decimais) {
    var ND = decimais ? decimais : 0, OP = operacao ? operacao : "+", res;
    var N1 = N(num1), N2 = N(num2);
    switch (OP) {
        case "+": res = N1 + N2; break;
        case "-": res = N1 - N2; break;
        case "*": res = N1 * N2; break;
        case "/": res = N1 / N2; break;
    }
    return N(res, ND);
};
function MD5(d) {
    function M(d) {
        for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++) _ = d.charCodeAt(r), f += m.charAt(_ >>> 4 & 15) + m.charAt(15 & _);
        return f
    }
    function X(d) {
        for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++) _[m] = 0;
        for (m = 0; m < 8 * d.length; m += 8) _[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32;
        return _
    }
    function V(d) {
        for (var _ = "", m = 0; m < 32 * d.length; m += 8) _ += String.fromCharCode(d[m >> 5] >>> m % 32 & 255);
        return _
    }
    function Y(d, _) {
        d[_ >> 5] |= 128 << _ % 32, d[14 + (_ + 64 >>> 9 << 4)] = _;
        for (var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16) {
            var h = m,
                t = f,
                g = r,
                e = i;
            f = md5_ii(f = md5_ii(f = md5_ii(f = md5_ii(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_ff(f = md5_ff(f = md5_ff(f = md5_ff(f, r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 0], 7, -680876936), f, r, d[n + 1], 12, -389564586), m, f, d[n + 2], 17, 606105819), i, m, d[n + 3], 22, -1044525330), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 4], 7, -176418897), f, r, d[n + 5], 12, 1200080426), m, f, d[n + 6], 17, -1473231341), i, m, d[n + 7], 22, -45705983), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 8], 7, 1770035416), f, r, d[n + 9], 12, -1958414417), m, f, d[n + 10], 17, -42063), i, m, d[n + 11], 22, -1990404162), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 12], 7, 1804603682), f, r, d[n + 13], 12, -40341101), m, f, d[n + 14], 17, -1502002290), i, m, d[n + 15], 22, 1236535329), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 1], 5, -165796510), f, r, d[n + 6], 9, -1069501632), m, f, d[n + 11], 14, 643717713), i, m, d[n + 0], 20, -373897302), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691), f, r, d[n + 10], 9, 38016083), m, f, d[n + 15], 14, -660478335), i, m, d[n + 4], 20, -405537848), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438), f, r, d[n + 14], 9, -1019803690), m, f, d[n + 3], 14, -187363961), i, m, d[n + 8], 20, 1163531501), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467), f, r, d[n + 2], 9, -51403784), m, f, d[n + 7], 14, 1735328473), i, m, d[n + 12], 20, -1926607734), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 5], 4, -378558), f, r, d[n + 8], 11, -2022574463), m, f, d[n + 11], 16, 1839030562), i, m, d[n + 14], 23, -35309556), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060), f, r, d[n + 4], 11, 1272893353), m, f, d[n + 7], 16, -155497632), i, m, d[n + 10], 23, -1094730640), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174), f, r, d[n + 0], 11, -358537222), m, f, d[n + 3], 16, -722521979), i, m, d[n + 6], 23, 76029189), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487), f, r, d[n + 12], 11, -421815835), m, f, d[n + 15], 16, 530742520), i, m, d[n + 2], 23, -995338651), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844), f, r, d[n + 7], 10, 1126891415), m, f, d[n + 14], 15, -1416354905), i, m, d[n + 5], 21, -57434055), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571), f, r, d[n + 3], 10, -1894986606), m, f, d[n + 10], 15, -1051523), i, m, d[n + 1], 21, -2054922799), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359), f, r, d[n + 15], 10, -30611744), m, f, d[n + 6], 15, -1560198380), i, m, d[n + 13], 21, 1309151649), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070), f, r, d[n + 11], 10, -1120210379), m, f, d[n + 2], 15, 718787259), i, m, d[n + 9], 21, -343485551), m = safe_add(m, h), f = safe_add(f, t), r = safe_add(r, g), i = safe_add(i, e)
        }
        return Array(m, f, r, i)
    }
    function md5_cmn(d, _, m, f, r, i) {
        return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m)
    }
    function md5_ff(d, _, m, f, r, i, n) {
        return md5_cmn(_ & m | ~_ & f, d, _, r, i, n)
    }
    function md5_gg(d, _, m, f, r, i, n) {
        return md5_cmn(_ & f | m & ~f, d, _, r, i, n)
    }
    function md5_hh(d, _, m, f, r, i, n) {
        return md5_cmn(_ ^ m ^ f, d, _, r, i, n)
    }
    function md5_ii(d, _, m, f, r, i, n) {
        return md5_cmn(m ^ (_ | ~f), d, _, r, i, n)
    }
    function safe_add(d, _) {
        var m = (65535 & d) + (65535 & _);
        return (d >> 16) + (_ >> 16) + (m >> 16) << 16 | 65535 & m
    }
    function bit_rol(d, _) {
        return d << _ | d >>> 32 - _
    }
    var result = M(V(Y(X(d), 8 * d.length)));
    return result.toLowerCase()
};
function CriaObj(tag, dd) {
    var dds = dd ? dd : {};
    var obj = document.createElement(tag);
    if (dds.classe) { obj.className = dds.classe; }
    if (dds.conteudo) { obj.innerHTML = dds.conteudo; }
    if (dds.value) { obj.value = dds.value; }
    if (dds.titulo) { obj.title = dds.titulo; }
    if (dds.id) { obj.id = dds.id; }
    if (dds.src) { obj.src = dds.src; }
    if (dds.tipo) { obj.type = dds.tipo; }
    if (dds.for) { obj.setAttribute("for", dds.for); }
    if (dds.fBorda) { obj.setAttribute("frameBorder", dds.fBorda); }
    if (dds.nome) { obj.name = dds.nome; }
    if (dds.inputComent) { obj.placeholder = dds.inputComent; }
    return obj;
};
function Erro(dados, msgBts, retorno) {
    var erro = dados.error;
    var msg = new Mensagem();
    msg.setTitulo("Algo deu errado!");
    if (erro == 'net') {
        msg.setTexto('Você precisa estar conectado à internet para continuar.');
    }
    else {
        msg.setTexto(erro);
    }
    if (msgBts) {
        if (msgBts.length > 1) {
            msg.setTipo('confirma');
        }
        msg.setBotoes(msgBts);
    }
    msg.mostrar(retorno);
};
function fechaApp() {
    if (isPlatform("windows")) {
        window.close();
    }
    else {
        navigator.app.exitApp();
    }
};
function formataData(data, isHoras) {
    var cNum = function (n) {
        if (n < 10) {
            return "0" + n;
        }
        return n;
    }, dt = new Date(data.replace(/\s/, 'T'));
    var dia = cNum(dt.getDate()),
        mes = cNum(dt.getMonth() + 1);

    if (isHoras) {
        var hora = cNum(dt.getHours()),
            minuto = cNum(dt.getMinutes());

        return dia + "/" + mes + '/' + dt.getFullYear() + " às " + hora + ":" + minuto;
    }
    return dia + "/" + mes + '/' + dt.getFullYear();
};
function getRadioChecked(formId, name) {
    var rads = $('#' + formId + ' input[name="' + name + '"]');
    for (var i = 0; i < rads.length; i++) {
        if (rads[i].checked) {
            return rads[i];
        }
    }
    return null;
}
function getUrlParameter(nome, link) {
    var res = null, tmp = [], url = location.href;
    if (link) { url = link; }
    url.substr(url.indexOf("?") + 1).split("&").forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === nome) { res = decodeURIComponent(tmp[1]); }
    });
    return res;
};
function includeHTML(retorno) {
    var z, i = 0, elmnt, file, xhttp;
    z = document.getElementsByTagName("*");

    var varrerTags = function (elmnt) {
        if (i < z.length) {
            file = elmnt.getAttribute("include-html");
            if (file) {
                lerArquivo(file, function (res) {
                    elmnt.innerHTML = res;
                    i++;
                    varrerTags(z[i]);
                });
                elmnt.removeAttribute("include-html");
            }
            else {
                i++;
                varrerTags(z[i]);
            }
        }
        else {
            retorno();
        }
    };
    varrerTags(z[i]);
};
function IsConectado() {
    var networkState = navigator.connection.type;
    var states = {};
    states[Connection.UNKNOWN] = 'Desconhecido';
    states[Connection.ETHERNET] = 'Ethernet';
    states[Connection.WIFI] = 'WiFi';
    states[Connection.CELL_2G] = 'Cell 2G';
    states[Connection.CELL_3G] = 'Cell 3G';
    states[Connection.CELL_4G] = 'Cell 4G';
    states[Connection.CELL] = 'Cell generic';
    states[Connection.NONE] = false;

    return states[networkState];
};
function isEmail(obj) {
    if (!/^[\w.]+@[\w.]+\.[\w.]+$/.test(obj.value)) {
        return false;
    }
    return true;
};
function isLogado() {
    var vg = new VarGlobal('thisUser');
    if (vg.obterLocal()) {
        return JSON.parse(vg.obterLocal());
    }
    else {
        return false;
    }
};
function logout() {
    var vg = new VarGlobal('thisUser');
    vg.salvarLocal(null);
    location.href = "index.html";
};
function lerArquivo(arquivo, retorno) {
    var res = "";
    if (arquivo) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) { res = this.responseText; }
                if (this.status == 404) { res = "Arquivo não encontrado"; }
                retorno(res);
            }
        }
        xhttp.open("GET", arquivo, true);
        xhttp.send();
        return;
    }
};
function setValByClass(classe, valor) {
    var objs = document.getElementsByClassName(classe);
    for (var i = 0; i < objs.length; i++) {
        objs[i].value = valor;
    }
};
function setLogin(data) {
    var vg = new VarGlobal('thisUser'), jsonLogin = data;
    vg.salvarLocal(JSON.stringify(jsonLogin));
    thisUser = jsonLogin;
};
function isMoile() {
    var a = navigator.userAgent.toLowerCase();
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) {
        return true;
    }
    else {
        return false;
    }
};
function isNum(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
};
function isPlatform(nome) {
    if (device.platform.toLowerCase() == nome.toLowerCase()) {
        return true;
    }
    return false;
};
function limpaObj(obj, exceto) {
    var filhos = obj.children.length;
    while (obj.lastChild) {
        if (exceto == filhos) {
            break;
        }
        obj.removeChild(obj.lastChild);
        filhos--;
    }
};

/*Classes*/
function Api(url, dados, isLoader, cache) {
    var self = this, IsLoader = true, vgCache;
    /*Variáveis Públicas*/
    self.url = url;
    self.dados = dados ? dados : {};
    self.isTemporario = true;
    self.cacheHash = null;

    self.dados.retorno = 'json';
    if (cache) {
        self.cacheHash = MD5(Servidor + self.url + JSON.stringify(self.dados));
        vgCache = new VarGlobal(self.cacheHash);
    }
    if (isLoader === false) {
        IsLoader = false;
    }
    /*Funções Externas*/
    self.send = function (retorno) {
        var isInCache = false;
        if (cache) {
            isInCache = vgCache.obterVar();
        }
        if (!isInCache) {
            if (IsConectado()) {
                if (IsLoader) {
                    Loader.mostrar();
                }
                var ajaxObj = $.ajax({
                    cache: false,
                    method: "POST",
                    url: Servidor + self.url,
                    data: self.dados,
                    dataType: "json",
                    success: function (res) {
                        if (cache) {
                            vgCache.salvarVar(JSON.stringify(res));
                        }
                        retorno(res);
                        if (IsLoader) {
                            Loader.remover();
                        }
                    },
                    error: function (Xhr, Exception) {
                        var msg = AjaxErros[Xhr.status];
                        if (!msg) { msg = AjaxErros[Exception]; }
                        if (!msg) { msg = Xhr.responseText; }
                        retorno({ 'error': msg + "Motivo " + Xhr.responseText + " url " + Servidor + self.url + " data " + JSON.stringify(self.dados) }); /* -- Remover detalhes do erro*/
                        if (IsLoader) {
                            Loader.remover();
                        }
                    }
                });
                if (IsLoader) {
                    Loader.onCancelar(function () {
                        ajaxObj.abort();
                    });
                }
            }
            else {
                retorno({ 'error': 'net' });
            }
        }
        else {
            isInCache = JSON.parse(isInCache);
            retorno(isInCache);
        }
    };
};
var loaders = {};
var Loader = {
    'add': function (obj) {
        if (!loaders[obj.id]) {
            loaders[obj.id] = obj.innerHTML;
            obj.innerHTML = "<img src='images/loader.gif'/>";
            obj.disabled = true;
        }
    },
    'remove': function (obj) {
        if (loaders[obj.id]) {
            obj.innerHTML = loaders[obj.id];
            obj.disabled = false;
            delete loaders[obj.id];
        }
    },
    'mostrar': function () {
        var divLoader = document.getElementById('divLoader');
        if (divLoader) {
            $(divLoader).fadeIn("fast");
        }
    },
    'remover': function () {
        var divLoader = document.getElementById('divLoader');
        if (divLoader) {
            $(divLoader).fadeOut("fast");
        }
    },
    'onCancelar': function (evento) {
        /*var btNovo = btLoaderCancelar.cloneNode(true);
        btLoaderCancelar.parentNode.replaceChild(btNovo, btLoaderCancelar);
        btLoaderCancelar.addEventListener('click', evento, false);*/
    }
};
function Mensagem(texto, auto) {
    var self = this, Tipo = "alerta", Titulo = "Atenção:", Texto = texto, Botoes = ["ok", "cancelar"];
    /*Funções externas*/
    self.setTipo = function (texto) { Tipo = texto; };
    self.setTexto = function (texto) { Texto = texto; };
    self.setTitulo = function (texto) { Titulo = texto; };
    self.setBotoes = function (array) { Botoes = array; };
    self.mostrar = function (Retorno) {
        switch (Tipo) {
            case "confirma": navigator.notification.confirm(Texto, Retorno, Titulo, Botoes);
                break;
            case "texto": navigator.notification.prompt(Texto, Retorno, Titulo, Botoes);
                break;
            case "alerta":
            default: navigator.notification.alert(Texto, Retorno, Titulo, Botoes);
                break;
        }
    };
    /*Construtor*/
    if (auto) { self.mostrar(); }
};
function VarGlobal(chave) {
    var self = this, Chave = chave;
    /*Funções externas*/
    self.setChave = function (valor) { Chave = valor; };
    self.getChave = function () { return Chave; };
    self.obterSessao = function () {
        return window.sessionStorage.getItem(Chave);
    };
    self.obterLocal = function () {
        return window.localStorage.getItem(Chave);
    };
    self.obterVar = function (todas) {
        var vg = new VarGlobal("$varGlobalVar");
        var dds = vg.obterSessao();
        if (dds) {
            dds = JSON.parse(dds);
        }
        else {
            dds = {};
            vg.salvarSessao(JSON.stringify(dds));
        }
        if (todas) {
            return dds;
        }
        return dds[Chave] ? dds[Chave] : null;
    };
    self.salvarSessao = function (valor) {
        if (valor) {
            window.sessionStorage.setItem(Chave, valor);
        }
        else {
            window.sessionStorage.removeItem(Chave);
        }
        return valor;
    };
    self.salvarLocal = function (valor) {
        if (valor) {
            window.localStorage.setItem(Chave, valor);
        }
        else {
            window.localStorage.removeItem(Chave);
        }
        return valor;
    };
    self.salvarVar = function (valor) {
        var vg = new VarGlobal("$varGlobalVar");
        var dds = vg.obterVar(true);
        if (valor) {
            dds[Chave] = valor;
        }
        else {
            delete dds[Chave];
        }
        vg.salvarSessao(JSON.stringify(dds));
        return valor;
    }
};
/*Eventos Globais*/
function onBackButtonClick() {
    var voltar = function () {
        if (Pagina == 'index.html' || Pagina == 'inicio.html') {
            var msg = new Mensagem("Fechar SISGSPP?");
            msg.setTitulo("Você deseja sair?");
            msg.setBotoes(["Sim", "Não"]);
            msg.setTipo("confirma");
            msg.mostrar(function (res) {
                if (res == 1) {
                    fechaApp();
                }
            });
        }
        else {
            window.history.go(-1);
        }
    };
    var sideMenu = document.getElementById("side-menu");
    if (sideMenu) {
        if (menuIsAtivo) {
            closeSlideMenu();
        }
        else {
            voltar();
        }
    }
    else {
        voltar();
    }

};
function onInputBlur() {
    if (this) {
        if ($(this).hasClass('is-invalid')) {
            $(this).removeClass('is-invalid');
        }
        else if ($(this.parentNode).hasClass('is-invalid')) {
            $(this.parentNode).removeClass('is-invalid');
        }
        else if ($(this.parentNode.parentNode).hasClass('is-invalid')) {
            $(this.parentNode.parentNode).removeClass('is-invalid');
        }
    }
};
function onLongClick(elemento, funcao) {
    var tempo = 500, timeObj = false;

    var tocou = function () {
        timeObj = setTimeout(function () {
            funcao(elemento);
            timeObj = false;
        }, tempo);
    };
    var soltou = function () {
        if (timeObj) {
            clearTimeout(timeObj);
            timeObj = false;
        }
    };

    elemento.addEventListener('touchstart', tocou);
    elemento.addEventListener('touchend', soltou);
    elemento.addEventListener('mousedown', tocou);
    elemento.addEventListener('mouseup', soltou);
};
function swipedetect(el, callback) {
    var touchsurface = el,
        swipedir, dist, startX, startY, distX, distY,
        threshold = 100, //required min distance traveled to be considered swipe
        restraint = 100, // maximum distance allowed at the same time in perpendicular direction
        allowedTime = 300, // maximum time allowed to travel that distance
        elapsedTime, startTime, handleswipe = callback || function (swipedir) { };
    touchsurface.addEventListener('touchstart', function (e) {
        var touchobj = e.changedTouches[0];
        swipedir = 'none';
        dist = 0;
        startX = touchobj.pageX;
        startY = touchobj.pageY;
        startTime = new Date().getTime();// record time when finger first makes contact with surface
    }, false);
    touchsurface.addEventListener('touchend', function (e) {
        var touchobj = e.changedTouches[0];
        distX = touchobj.pageX - startX; // get horizontal dist traveled by finger while in contact with surface
        distY = touchobj.pageY - startY; // get vertical dist traveled by finger while in contact with surface
        elapsedTime = new Date().getTime() - startTime; // get time elapsed
        if (elapsedTime <= allowedTime) { // first condition for awipe met
            if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint) { // 2nd condition for horizontal swipe met
                swipedir = (distX < 0) ? 'e' : 'd'; // if dist traveled is negative, it indicates left swipe
            }
            else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint) { // 2nd condition for vertical swipe met
                swipedir = (distY < 0) ? 'c' : 'b'; // if dist traveled is negative, it indicates up swipe
            }
        }
        handleswipe(swipedir);
    }, false);
};
