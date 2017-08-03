function tecla() 
{
    if (event.keyCode==123)
    {
        alert("CaterOT Security. Fuck You =)");
        event.keyCode=0;
        event.returnValue=false;
    }
} document.onkeydown=tecla;