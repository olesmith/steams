"use strict";






function Update_URL_2_Element(url,cell_id,form_id,group="Base",update_elements=true,debug=false)
{
    if (debug)
    {
        //console.clear();
        console.log("Update_URL_2_Element: Loading "+url,form_id,cell_id);
    }
    
    Register_Time("Update_URL_2_Element");
    console.log(form_id,cell_id,url);
    
    let element = Get_Element_By_ID(cell_id);
    if (!element)
    {
        console.log("No such destination element",cell_id);
        return false;
    }

    if (debug)
    {
        console.log("Found destination ",cell_id);
    }
     
    let form_elm = Get_Element_By_ID(form_id);
    if (!form_elm)
    {
        console.log("No such form element",form_id);
        return false;
    }

    if (debug)
    {
        console.log("Found form "+form_id);
    }
    
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (debug)
        {
            console.log("back",this.readyStat,this.status);
        }
     
        if (this.readyState == 4 && this.status == 200)
        {
            element.innerHTML=this.responseText;
            if (debug)
            {
                console.log("URL loaded");
            }

            Transfer_Loaded_Scripts(element);

        }

        //Form changed data - rewrite 
        if (group in Load_URLs)
        {
            console.log("Removing on group",group);
            Load_URLs[ group ]={};
        }

        if (update_elements)
        {
            let form_elm=Get_Element_By_ID(form_id);
            if (!form_elm)
            {
                console.log("Error!! Invalid form id:",form_id);
                return;
            }
            
            let inputs=form_elm.querySelectorAll("input");
            let areas=form_elm.querySelectorAll("textarea");
            let selects=form_elm.querySelectorAll("select");
            
            Update_CGI_2_Others(inputs);
            Update_CGI_2_Others(areas);
            Update_CGI_2_Others(selects);
        }
        
        //Transfer_Loaded_Scripts(element);
    };

    if (debug)
    {
        console.log("open post "+cell_id);
    }
    
    xhttp.open("POST",url,true);    
    
    let form_data=new FormData(form_elm);
    if (debug)
    {
        Form_Data_Console(form_data);
    }

    xhttp.send(form_data);
    
    if (debug)
    {
        console.log("datasend "+cell_id);
    }

    return false;
}


function Update_CGI_2_Others(inputs,debug=false)
{
    for (let n=0;n<inputs.length;n++)
    {
        let id=inputs[n].id;
        let value=inputs[n].value;
        let classes=id.split("_");

        let item_id=classes.pop();
        let module=classes.shift();
        let item_data=classes.join("_");

        classes=[module,item_data,item_id];
        classes=classes.join(" ");

        if (inputs[n].type=='select-one')
        {
            let options=inputs[n].querySelectorAll("option");
            if (debug)
            {
                console.log(value,options.length);
            }
            
            for (let m=0;m<options.length;m++)
            {
                if (options[m].value==value)
                {
                    value=options[m].innerHTML;
                    if (debug)
                    {
                        console.log("Value Found",options[m].innerHTML);
                    }
                }
            }
        }
        
        if (debug) { console.log(inputs[n].type,"Class",classes); }
        
        let others=document.getElementsByClassName(classes);

        if (others.length>0)
        {
            //console.log(id,classes,others.length,"elements");
            for (let m=0;m<others.length;m++)
            {
                //console.log(others[m].id,others[m].className,id);
                if (!others[m].className.match('editdata'))
                {
                    if (debug)
                    {
                        console.log(m,others[m],value);
                    }

                    //Protest against updating ourselve, (SELECTs)
                    if (others[m].id!=inputs[n].id)
                    {
                        others[m].innerHTML=value;
                        others[m].style.color='green';
                    }
                };
            }
        }
    }
}


function Form_Data_Console(form_data)
{
    for (let key of form_data.keys())
    {
        console.log(key,form_data.get(key));
    }
}
