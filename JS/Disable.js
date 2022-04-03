"use strict";

function Disable_Options_By_Class(select,hideclass,showclass)
{
    Register_Time("Disable_Options_By_Class");
                
    let elm=Get_Element_By_ID(select);
    let index=elm.selectedIndex;
    let value=elm.children[index].value;

    let elements = document.getElementsByClassName(hideclass);
    for (let n = 0; n < elements.length; n++)
    {
        elements[n].disabled = true;
        elements[n].style.display  = 'none';
    }
    showclass=showclass+"_"+value;

    elements = document.getElementsByClassName(showclass);
    for (let n = 0; n < elements.length; n++)
    {
        elements[n].disabled = false;
        elements[n].style.display  = 'initial';
    }    
}

