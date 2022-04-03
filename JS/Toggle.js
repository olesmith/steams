"use strict";

function Toggle_Element_By_ID(elementid,display)
{
    console.log("Toggleid",elementid,display);
    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        Toggle_Element(element,display);
    }
}

function Toggle_Elements_By_Class(clss,display='initial',tagname="")
{
    let elements = document.getElementsByClassName(clss);
    console.log("ToggleClass",clss,display,elements.length,"elements",tagname);
    
    for (let n=0;n<elements.length;n++)
    {
        if (tagname && elements[n].tagName!=tagname)
        {
            //console.log(elements[n].tagName);
            continue;
        }
        Toggle_Element(elements[n],display);
    }
}

function Toggle_Element(element,display)
{
    //console.log("Toggle",element.style.display=="none");
        
    if (element.style.display=="none")
    {
        Show_Element(element,display);
    }
    else
    {
        Hide_Element(element);
    }
}


function Toggle_Colors(element,color1,color2)
{
    //console.log(element,color1,color2);
    if (element.style.color==color2)
    {
        Color_Element(element,color1);
    }
    else
    {
        Color_Element(element,color2);
    }
}
