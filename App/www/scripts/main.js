var menuIsAtivo = false;
function openSlideMenu() {
    document.getElementById('side-menu').style.width = '250px';
    menuIsAtivo = true;
};

function closeSlideMenu() {
    document.getElementById('side-menu').style.width = '0';
    menuIsAtivo = false;
};