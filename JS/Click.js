"use strict";



function Click_Element_By_ID(elementid)
{
    Register_Time("Click_Element_By_ID");
                
    let element = Get_Element_By_ID(elementid);
    if (element)
    {
        element.click();
    }
    else
    {
        console.log("Click_Element_By_ID; No such element: "+elementid);
    }
}

function Click_Elements_By_ID(elementids,checkstub=false)
{    
    for (let n=0;n<elementids.length;n++)
    {
        if (checkstub)
        {
            let checkbox_id=checkstub
        }
        Click_Element_By_ID(elementids[ n ])
    }
}


function Click_Elements_By_Class(classid)
{
    if (Array.isArray(classid))
    {
        classid=classid.join(" ");
    }
    
    let elements = document.getElementsByClassName(classid);

    console.log(classid,elements.length,"elements");
    
    for (let n=0;n<elements.length;n++)
    {
        elements[n].click();
    }
}


function Click_Elements_By_Checked_IDs(element_ids,check_ids)
{
    for (let n=0;n<element_ids.length;n++)
    {
        let check_id=check_ids[n];

        let check_element=Get_Element_By_ID(check_id);

        if (check_element.checked)
        {
            console.log(n,check_element.checked);
            Click_Element_By_ID(element_ids[ n ]);
        }
    }
}

function Click_Parent_Element_By_Class(element_id,clss,ignore_first=0,debug=false)
{    
    let element=document.getElementById(element_id);
 
    if (debug) { console.log("START",element_id); }

    for (let level=0;level<ignore_first;level++)
    {
        if (element)
        {
            element=element.parentNode;
        }
    }
    
    let clicked=false;
    while (element && !clicked)
    {
        let elements=element.getElementsByClassName("Reload");
        
        let n=elements.length-1;
            
        if (elements.length>0)
        {
            if (debug) { console.log("FOUND!",element.tagName,elements[n]); }
            //found! Click it!
            elements[n].click();
            clicked=true;
        }
        else
        {
            element=element.parentNode;
            if (element)
            {
                if (debug) { console.log(element.tagName); }
            }
        }
    }

    if (!clicked)
    {
        console.log("Not found");
    }
}
//function criar() {
//let a = document.createElement('a')
//a.setAttribute('href', '#link')
//document.body.appendChild(a)
//a.click()
//a.innerHTML = 'aaaaa'


function Click_Above(element_id,dest_id,db_id)
{
    console.clear();
    
    let element=Get_Element_By_ID(element_id);
    let elements = document.getElementsByClassName("Reload_DIV");

    let str="Reload_DIV "+dest_id;
    

    let element_no=-1;
    for (let n=elements.length-1;n>=0;n--)
    {
        console.log(elements[n].className,str);
        if (elements[n].className==str)
        {
            element_no=n-1;

            break;
        }
    }

    if (element_no>=0)
    {
        element=elements[ element_no ];
        console.log("To click",element);

        elements=element.getElementsByClassName("Reload");
                    
        if (elements.length>0)
        {
            let reload_icon=elements[0];
            let reload=reload_icon.getAttribute('onclick');

            reload=reload.replace('?Include_ID=\d+&',"",reload);
            reload=reload.replace('?',"?Include_ID="+db_id+"&");
            reload_icon.setAttribute('onclick',reload);
            
            //reload_icon.click();
            console.log("onlcick: ",reload,reload_icon,elements);
            reload_icon.click();
        }
        
    }
}
