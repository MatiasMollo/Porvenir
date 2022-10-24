var openLogin=document.querySelectorAll('.openSidebarLogin');
var closeLogin=document.querySelectorAll('.closeSidebarLogin');
var sidebarLogin=document.querySelector('.sidebar--login');
var barMenu=document.querySelectorAll('.nav__bar');
window.addEventListener('load',loadEvents=_=>{
    openLogin.forEach(e=>{e.addEventListener('click',printLogin)});
    closeLogin.forEach(e=>{e.addEventListener('click',printLogin)});
});

function printLogin() { 
    if(sidebarLogin.style.display=='flex') {sidebarLogin.style.display='none'; iconLogin(); if(screen.width<1023) barMenu.forEach(e=>e.style.borderRadius="15px 15px 0px 0px")}
    else {sidebarLogin.style.display='flex'; iconLogin(); }
};
function iconLogin() {
    openLogin.forEach(e=>{if(e.style.display=='none') e.style.display='flex'; else e.style.display='none'});
    closeLogin.forEach(e=>{if(e.style.display=='flex') e.style.display='none'; else e.style.display='flex'});
   if(screen.width<1023)  barMenu.forEach(e=>e.style.borderRadius="15px 0px 0px 0px")
};

function closeAllLogin() {
    if(sidebarLogin.style.display=='flex') printLogin()
    
};
function closeAllSidebar(){closeAllLogin()};