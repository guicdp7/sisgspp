"use script";
/*Variáveis*/
var divSelecionaCliente = document.getElementById('divSelecionaCliente'), inFormulas;

$(document).ready(function () {
    /*Adicionando atributo label a inputs com label*/
    var labels = document.getElementsByTagName('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].htmlFor != '') {
            var elem = document.getElementById(labels[i].htmlFor);
            if (elem){
                elem.label = labels[i];
            }
        }
    }
    var inFormulas = document.getElementsByClassName('formula');
    for (var i = 0; i < inFormulas.length; i++){
        inFormulas[i].addEventListener('keyup', inFormulasChange, false);
    }    
    /*Tipos de Pessoa*/
    labsTipoF = document.getElementsByClassName('pessoa-tipo-f');
    labsTipoJ = document.getElementsByClassName('pessoa-tipo-j');

    for (var i = 0; i < labsTipoF.length; i++){
        (function (id) {
            labsTipoF[id].addEventListener('change', function () { labTipoChange(id, ['Nome *', 'Sobrenome','CPF','RG']); }, false);
        })(i);
    }
    for (var i = 0; i < labsTipoJ.length; i++){
        (function (id) {
        labsTipoJ[id].addEventListener('change', function () { labTipoChange(id, ['Raz&atilde;o Social', 'Nome Fantasia *','CNPJ','IE']); }, false);
        })(i);
    }
    
    /*Auto completar endereÃ§os*/
    forms = document.getElementsByTagName('form');
    for(var chave in forms){
        if (forms[chave]['end[cep]']){
            (function (form){
                $(form['end[cep]']).change(function () { formCepChange(this, form); });
            })(forms[chave]);
        }
    }
});
/*Funções*/
function ajax (url, retorno){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
       retorno(this.responseText);
      }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
};
function aSelecionar(div_id){
    var div = document.getElementById(div_id);
    div.style.display = "flex";
};
function aFxSelecionar(div_id){
    var div = document.getElementById(div_id);
    div.style.display = "none";
};
function aSeleciona(obj, array, div_id, formId, names, hiddenValue){
    var formulario = document.getElementById(formId);
    if (array){
        var getClienteById = function (id){
            for (var i = 0; i < array.length; i++){
                if (array[i].id == id){
                    return array[i];
                }
            }
            return null;
        };
        var dds = getClienteById(obj.getAttribute('data-id'));
        if (dds != false){
            for (var i = 0; i < names.length; i++){
                if (names[i].radio){
                    var rads = document.getElementsByName(names[i].name);
                    for(var j = 0; j < rads.length; j++){
                        if (rads[j].value == dds[names[i].value]){
                            rads[j].checked = true;
                            if (names[i].name == 'pessoa[tipo]'){
                                radioPessoaChange({value : rads[j].value}, formId);
                            }
                            break;
                        }
                    }
                }
                else{
                    formulario[names[i].name].value = dds[names[i].value];
                }
            }
            if (hiddenValue){
                document.getElementById(hiddenValue.id).value = dds[hiddenValue.value];
            }
        }
        else{
            alert('Erro: Cliente não encontrado!');
        }
    }
    else{
        alert('Erro: Variável clientes não defininda!');
    }
    aFxSelecionar(div_id);
};
function labTipoChange(id, valores){
    var labsN = document.getElementsByClassName('label-pessoa-nome'),
        labsS = document.getElementsByClassName('label-pessoa-snome'),
        labCpf = document.getElementsByClassName('label-pessoa-cpf'),
        labRg = document.getElementsByClassName('label-pessoa-rg');
    
    if (labsN[id]){
        labsN[id].innerHTML = valores[0];
    }
    if (labsS[id]){
        labsS[id].innerHTML = valores[1];
    }
    if (labCpf[id]){
        labCpf[id].innerHTML = valores[2];
    }
    if (labRg[id]){
        labRg[id].innerHTML = valores[3];
    }
};
function getCepDados(form){
    var cep = form['end[cep]'],
        endereco = form['end[logradouro]'],
        cidade = form['end[cidade]'],
        bairro = form['end[bairro]'],
        uf = form['end[uf]'],
        num = form['end[numero]'];
    var reseta = function (status) {
        if (status){
            $(cep).addClass('spinner');
            cep.disabled = true;
            endereco.disabled = true;
            cidade.disabled = true;
            bairro.disabled = true;
            uf.disabled = true;
        }
        else{
            $(cep).removeClass('spinner');
            cep.disabled = false;
            endereco.disabled = false;
            cidade.disabled = false;
            bairro.disabled = false;
            uf.disabled = false;
        }		 
    };
    reseta(true);
    $.ajax({
        url: "https://viacep.com.br/ws/"+cep.value+"/json/",
        data: null,
        success: function (data) {
            if (!data.erro){
                endereco.value = data.logradouro;
                cidade.value = data.localidade;
                bairro.value = data.bairro;
                uf.value = data.uf;
                num.focus();
            }
            reseta();
        },
        error: function () { reseta(); },
        dataType: "json"
    });
};
/*Classes*/
function CalcFormula(formula, variaveis) {
    /*Variáveis Locais*/
    var self = this, Formula = formula, resultado,
        ops = { '+': ['MAIS'], '-': ['MENOS'], '*': ['X', 'VEZES'], '/': ['DIVIDIDO'] };
    /*Funções Locais*/
    var subVars = function () {
        for (var chave in variaveis) {
            var reg = new RegExp(chave, "gi");
            Formula = Formula.replace(reg, variaveis[chave]);
        }
    };
    var subOps = function () {
        for (var chave in ops) {
            for (var i = 0; i < ops[chave].length; i++) {
                var reg = new RegExp(ops[chave][i], "gi");
                Formula = Formula.replace(reg, chave);
            }
        }
    };
    var checaFormula = function () {
        return !/^[^0-9.+*/-]+$/.test(Formula);
    };
    /*Funções Globais*/
    self.calcula = function () {
        subVars(); subOps();
        if (checaFormula()) {
            Formula = "resultado = " + Formula + ";";
            try{
                eval(Formula);
                return resultado;
            }
            catch (e){
                return false;
            }
        }
        else {
            return false;
        }
    };
};
/*Eventos*/
function radioPessoaChange(self, form_id){
    var thisForm = document.getElementById(form_id);

    if (self.value == "F"){
        thisForm['pessoa[nome]'].label.innerHTML = "Nome:";
        thisForm['pessoa[sobrenome]'].label.innerHTML = "Sobrenome:";
    }
    else if (self.value == "J"){
        thisForm['pessoa[nome]'].label.innerHTML = "Raz&atilde;o Social:";
        thisForm['pessoa[sobrenome]'].label.innerHTML = "Nome Fantasia:";
    }
};
function inFormulasChange(){
    var txt = this.value, btSubmit = document.getElementById(this.getAttribute('data-submit'));
    var hasErro = function (self, status) {
        if (status){
            $(self.parentNode).addClass('has-error');
            if (btSubmit) { btSubmit.disabled = true; }            
        }
        else{
            $(self.parentNode).removeClass('has-error');
            if (btSubmit) { btSubmit.disabled = false; }            
        }
    }
    if (/^(\s*(MAIS|\+|MENOS|\-|VEZES|X|\*|DIVIDIDO|\/)?[\s(]*(ATP|LGP|PTP|KM2|VLE|VLC|PM2|PKG|VL|([0-9](.[0-9])?)+)[)\s]*)+$/i.test(txt) || txt == ""){
        if (txt == ""){
            hasErro(this, false);
        }
        else{
            var cf = new CalcFormula(txt, { 'ATP': 1, 'LGP': 1, 'KM2': 1, 'VLC': 1, 'VLE': 1, 'PM2': 1, 'PKG': 1, 'PTP': 1, 'VL': 1 });
            var res = cf.calcula();
            if (!res === false){
                hasErro(this, false);
            }
            else{
                hasErro(this, true);
            }
        }
    }
    else{
        hasErro(this, true);
    }
};
function formCepChange(input, form){
    if (input.value.length == 9){
        getCepDados(form);
    }
};