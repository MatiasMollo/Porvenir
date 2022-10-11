var openLogin=document.querySelectorAll('.openSidebarLogin');
var closeLogin=document.querySelectorAll('.closeSidebarLogin');
var sidebarLogin=document.querySelector('.sidebar--login');

window.addEventListener('load',loadEvents=_=>{
    openLogin.forEach(e=>{e.addEventListener('click',printLogin)});
    closeLogin.forEach(e=>{e.addEventListener('click',printLogin)});
});

function printLogin() { 
    if(sidebarLogin.style.display=='flex') {sidebarLogin.style.display='none'; iconLogin();}
    else {sidebarLogin.style.display='flex'; iconLogin();}
};
function iconLogin() {
    openLogin.forEach(e=>{if(e.style.display=='none') e.style.display='flex'; else e.style.display='none'});
    closeLogin.forEach(e=>{if(e.style.display=='flex') e.style.display='none'; else e.style.display='flex'});
};

function closeAllLogin() {if(sidebarLogin.style.display=='flex') printLogin()};