"use strict";



function Table_Insert_Row_After(element,url)
{
    Register_Time("Table_Insert_Row_After");

    let parent=element.parentNode;
    let table_element=null;
    let tr_element=null;
    
    while (parent && !table_element)
    {
        //console.log(parent.id,parent.tagName);

        if (parent.tagName=="TR")
        {
            tr_element=parent;
        }
        
        if (parent.tagName=="TABLE")
        {
            table_element=parent;   
        }
        
        parent=parent.parentNode;
    }
    
    let tr_next_element=null;

    let rows=table_element.rows;
    for (let n=0;n<rows.length;n++)
    {
        if (rows[n].className==tr_element.className)
        {
            if (n+1<rows.length)
            {
                tr_next_element=rows[n+1];
                tr_next_element.style.display='table-row';

                let td_elements=tr_next_element.children;
                let td_element=td_elements[ td_elements.length-1 ];
                
                let inner=td_element.children[0];

                Load_URL_2_Element_Do(inner.id,url+"&Dest="+inner.id);
            }
        }
    }
    

    //let tr_element=element.parentNode;
    //let table_element=tr_element.parentNode;
    //console.log("Table_Insert_Row_After",table_element.id);
}


function Table_Append_Row(id,table_element,values)
{
    Register_Time("Table_Append_Row");
                
    //Create new row
    let tr_element=document.createElement("TR");
    table_element.append(tr_element);
    tr_element.id=id;

    for (let n=0;n<values.length;n++)
    {
        let td_element=document.createElement("TD");
        td_element.append(values[n]);
        
        tr_element.append(td_element);
    }

    return tr_element;
}

function Select_Option_Add_2_Table(form_element_id,table_element_id,select_element_id,noffset)
{
    Register_Time("Select_Option_Add_2_Table");
                
    //Find select element
    let select_element=Locate_Element_Or_Log(select_element_id);
    if (!select_element)
    {
        return false;
    }
    
    //Locate form element
    let form_element=Locate_Element_Or_Log(form_element_id);
    if (!form_element)
    {
        return false;
    }

    //Locate table element
    let table_element=Locate_Element_Or_Log(table_element_id);
    if (!table_element)
    {        
        return false;
    }

    
    //Locate table element parent
    let parent_element=table_element.parentElement;
    if (!parent_element)
    {
        console.log("No Table Parent Element:",table_element_id);
        return false;
    }



    //Identify option, value, id and title.
    let index=select_element.selectedIndex;
    
    let option_element=select_element.children[index];
    let id    = option_element.value;
    
    //let inner = option_element.innerHTML;
    let title = option_element.title;

    select_element.title=option_element.innerHTML;
    select_element.title=title;
    
    //Disable selected option
    option_element.disabled = true;


    //Gather row
    let nnodes=Number(table_element.childElementCount)+Number(noffset)-2;
    let values=title.split(",");

    let number_element=document.createElement("b");
    number_element.append(nnodes);
    
    values.unshift(number_element);    
    
    let hidden_element=document.createElement("input");

    hidden_element.type="hidden";
    hidden_element.name="Student_Hidden_"+id;
    hidden_element.id=id;
    hidden_element.value=1;

    let check_element=document.createElement("input");

    check_element.type="checkbox";
    check_element.name="Student_"+id;
    check_element.id=id;
    check_element.checked=true;

    check_element.append(hidden_element);
    
    values.push(check_element);

    let tr_element=Table_Append_Row(id,table_element,values);
    
    
    //Make sure FORM and TABLE elelements are visible.
    table_element.style.display='inline';
    form_element.style.display='initial';
}

function Table_Display_Previous(element,n_rows,clss,icon_class)
{
    let parent_element=element;
    
    let n=0;
    while (n<10 && parent_element.tagName!='TR')
    {
        console.log(n,parent_element.tagName);
        parent_element=parent_element.parentElement;
        n++;
    }
    
    
    let previous_row=parent_element.previousElementSibling;

    let n_displayed=0;
    while (previous_row)
    {
        previous_row=previous_row.previousElementSibling;

        if (previous_row)
        {
            if (previous_row.className==clss)
            {
                n_displayed++;
                previous_row.style.display='table-row';
            }
        }

        if (n_rows>0 && n_displayed>=n_rows)
        {
            break;
        }
    }
    
    if (previous_row)
    {
        let number_td=previous_row.getElementsByClassName('ROWN');
        if (number_td)
        {
            let number_cell=number_td[0];
            
            let new_icon = document.createElement("I");
            new_icon.className=icon_class;
            number_cell.addEventListener
            (
                "click",
                function(){ Table_Display_Previous( number_cell,n_rows,clss,icon_class); }
            );
            //new_icon.onclick=Table_Display_Previous(number_td,n_rows,clss,icon_class);
            
            number_cell.prepend(new_icon);
            console.log(number_cell,icon_class);
        }
    }
}
