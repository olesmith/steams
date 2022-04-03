"use strict";

//gets element by query selecter, verifying uniqueness.
function Get_Element_By_ID(elementid)
{
    let elements = document.querySelectorAll("#"+elementid);
    if (elements.length!=1)
    {
        console.log("Get_Element_By_ID",elementid,elements.length,"elements");
    }

    if (elements.length>0) { return elements[0]; }
    
    return false;
}

function Get_Element_By_ID_Or_Class(elementid)
{
    let elements = document.querySelectorAll("#"+elementid);

    if (elements.length==0)
    {
        elements=document.getElementsByClassName(elementid);
    }
    
    if (elements.length!=1)
    {
        console.log("Get_Element_By_ID_Or_Class",elementid,elements.length,"elements");
    }

    if (elements.length>0) { return elements[0]; }
    
    return false;
}

function Locate_Element_Or_Log(element_id)
{
    let element  = Get_Element_By_ID(element_id);

    if (!element)
    {
        console.log("Element:",element_id,"not found");
        return false;
    }

    return element;
}


function Show_Element(element,display,newcolor="")
{
    element.style.display = display;
    if (newcolor)
    {
        Color_Element(element,newcolor);
        let i = element.childNodes;
        if (i.length>1)
        {
            Color_Element(i[1],newcolor);
        }
        
        //console.log("Color2: "+newcolor,element.innerHTML);
    }
}




function Hide_Element(element)
{
    element.style.display = 'none';
}
                          
function Show_Elements(elements,display,newcolor="")
{
    for (let n = 0; n < elements.length; n++)
    {
        Show_Element(elements[n],display,newcolor);
    }
}

function Hide_Elements(elements)
{
    Show_Elements(elements,'none');
}
function Show_Element_By_ID(elementid,display,newcolor="")
{
    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        Show_Element(element,display,newcolor);
    }
    else
    {
        console.log("Show_Element_By_ID: '"+elementid+"' not found");
        console.trace();
    }

    return element;
}

function Show_Elements_By_ID(elementids,display,newcolor="")
{
    for (let n = 0; n < elementids.length; n++)
    {
        //console.log("Show",elementids[n]);
        Show_Element_By_ID(elementids[n],display,newcolor);
    }
}

function Hide_Element_By_ID(elementid)
{
    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        Hide_Element(element);
    }
    else
    {
        console.log("Hide_Element_By_ID: '"+elementid+"' not found");
        console.trace();
    }
}

function Hide_Elements_By_ID(elementids)
{
    for (let n = 0; n < elementids.length; n++)
    {
        //console.log("Hide",elementids[n]);
        Hide_Element_By_ID(elementids[n]);
    }
}
function Hide_And_Show_By_ID(hideids,showids,display='inline')
{
    for (let n = 0; n < showids.length; n++)
    {
        Show_Element_By_ID(showids[n],display);
    }
    
    for (let n = 0; n < hideids.length; n++)
    {
        Hide_Element_By_ID(hideids[n]);
    }
    
}




function Show_Elements_By_Class(classid,display,newcolor="",tagname="")
{
    if (Array.isArray(classid))
    {
        classid=classid.join(" ");
    }
    
    let elements = document.getElementsByClassName(classid);
    
    //console.log("Show_Elements_By_Class: "+classid+", "+elements.length+": "+display,"Tag:",tagname);
    
    for (let n = 0; n < elements.length; n++)
    {
        if (tagname && elements[n].tagName!=tagname)
        {
            continue;
        }
        Show_Element(elements[n],display);
    }  
}

function Show_Elements_By_Classes(classids,display)
{
    for (let n=0;n<classids.length;n++)
    {
        Show_Elements_By_Class(classids[n],display);
    }
}

function Hide_Elements_By_Class(classid,display,tagname="")
{
    if (Array.isArray(classid))
    {
        classid=classid.join(" ");
    }
    
    display='none';
    let elements = document.getElementsByClassName(classid);
    for (let n = 0; n < elements.length; n++)
    {
        if (tagname && elements[n].tagName!=tagname)
        {
            //console.log(elements[n].tagName);
            continue;
        }
        Hide_Element(elements[n],display);
    }

    if (Debug>0)
    {
        //Console_Log("Hide_Elements_By_Class",classid,elements.length,display);
    }
    Show_Elements(elements,"none");
}




function Hide_Elements_By_Classes(classids,display)
{
    for (let n=0;n<classids.length;n++)
    {
        Hide_Elements_By_Class(classids[n],display);
    }
}

function Show_Hide_Elements_By_Classes(pres,shows,hiddens,display)
{    
    let pre=pres.join(" ");
    
    for (let n=0;n<hiddens.length;n++)
    {
        Hide_Elements_By_Class(pre+' '+hiddens[n],display);
    }
    
    for (let n=0;n<shows.length;n++)
    {
        Show_Elements_By_Class(pre+' '+shows[n],display);
    }
    
}

