"use strict";

function CheckBox_Group_Toggle_All(classes,display='initial')
{
    Register_Time("CheckBox_Group_Toggle_All");
    let elements=document.getElementsByClassName(classes);
    for (let n=0;n<elements.length;n++)
    {
        if (!elements[n].disabled)
        {
            elements[n].checked=!elements[n].checked;
        }
    }   
}

function CheckBox_Group_Set_All(check_id,classes,display='initial')
{
    Register_Time("CheckBox_Group_Set_All");
                
    let check_element  = Get_Element_By_ID(check_id);

    if (!check_element)
    {
        console.log("CheckBox_Group_Set_All:",check_id,"not found");
        return false;
    }

    let check=false;
    if (check_element.checked)
    {
        check=true;
    }

    console.log(check,check_id);
    
    let elements=document.getElementsByClassName(classes);
    for (let n=0;n<elements.length;n++)
    {
        if (!elements[n].disabled)
        {
        console.log("Element "+n,check);
        
            elements[n].checked=check;

            let prev=elements[n].style.display;
            
            Show_Element(elements[n],display);
            //console.log(n,prev,"->",elements[n].style.display);
        }
    }
}
