"use strict";



//global var, storing previois background colors.
var last_colors={};

function Highlight_Element_By_ID(elementid,color=false)
{
    //Register_Time("Highlight_Element_By_ID: "+elementid);
                
    if (!color)
    {
        color=last_colors[ elementid ];
    }
    
    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        last_colors[ elementid ]=element.style.backgroundColor;
        element.style.backgroundColor=color;
    }
    else
    {
        console.log("No such element:",elementid);
    }
}

function Highlight_Element(element,color=false)
{
    if (color && !element.hasAttribute("oldcolor"))
    {
        element.setAttribute("oldcolor",element.style.backgroundColor );
        element.style.backgroundColor=color;
    }
    else if (element.hasAttribute("oldcolor"))
    {
        element.style.backgroundColor=element.getAttribute("oldcolor");
        element.removeAttribute("oldcolor");
    }
}

function Highlight_TR(element,color=false)
{
    //let element = Get_Element_By_ID(elementid);
    if (element)
    {
        Highlight_Element(element,color);
        
        let tds=element.querySelectorAll("td");
        for (let n=0;n<tds.length;n++)
        {
            Highlight_Element(tds[n],color);
        }
    }    
}
function Highlight_Elements_By_Class(element,classes,color=false)
{
    Register_Time("Highlight_Elements_By_Class: ");
    console.clear();
                    
    let elements=document.getElementsByClassName(classes);

    console.log(classes,elements.length,color);
    for (let n=0;n<elements.length;n++)
    {
        Highlight_Element(elements[n],color);
    }
}

