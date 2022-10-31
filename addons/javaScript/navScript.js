var openMenu=document.querySelectorAll('.nav__logo--open');
var closeMenu=document.querySelectorAll('.nav__logo--close');
var listMenu=document.querySelectorAll('.nav__list');
var barMenu=document.querySelectorAll('.nav__bar');

window.addEventListener('load',loadEvents=_=>{
    openMenu.forEach(e=>e.addEventListener('click',showMenu));
    closeMenu.forEach(e=>e.addEventListener('click',hideMenu));
});

function showMenu(){ closeAllSidebar();
    openMenu.forEach(e=>e.style.display='none');
    closeMenu.forEach(e=>e.style.display='block');
    listMenu.forEach(e=>e.style.display='block');
    barMenu.forEach(e=>e.style.borderRadius="0px")
};

function hideMenu(){
    openMenu.forEach(e=>e.style.display='block');
    closeMenu.forEach(e=>e.style.display='none');
    listMenu.forEach(e=>e.style.display='none');
    barMenu.forEach(e=>e.style.borderRadius="15px 15px 0px 0px")
}

function hideAllMenu(){
    closeMenu.forEach(e=>{if(e.style.display=='block') hideMenu()})
};