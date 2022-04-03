"use strict";

var Loaded_URLs = {};

function Initialize(is_mobile)
{
    if (is_mobile)
    {
        //Initialize_Mobile();
    }
    
    //let element=document.createElement('div');
    //element.innerHTML=window.innerHeight+"x"+window.innerWidth;
    //document.body.prepend(element);
}

function Initialize_Mobile()
{
    let tables=document.getElementsByClassName('applicationtable');
    for (let n=0;n<tables.length;n++)
    {
        tables[n].style.width=window.innerWidth+"px";
    }
    
    console.log(window.innerWidth);
    let centers = document.getElementsByClassName('applicationcenter');
    for (let n=0;n<centers.length;n++)
    {
        centers[n].style.width="100%";
    }
    
    let lefts = document.getElementsByClassName('applicationleft');
    for (let n=0;n<lefts.length;n++)
    {
        lefts[n].style.width='0px';
        //lefts[n].style.display='none';
    }
    
    let rights = document.getElementsByClassName('applicationright');
    for (let n=0;n<rights.length;n++)
    {
        rights[n].style.width='0px';
        //rights[n].style.display='none';
    }

}

function Parse_URL(url)
{
    url=url.substr(1);

    let args=url.split("&");
    
    return args;
}

function Load_URL_2_Element_Do(cell_id,url)
{
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            let elment = document.getElementById(cell_id);

            if (elment)
            {            
                elment.innerHTML=this.responseText;

                Transfer_Loaded_Scripts(elment);
            }
            else
            {
                console.dir("Cell not found",cell_id);
            }
        }

    };

    xhttp.open("GET",url,true);
    xhttp.send();
}


 
function Load_URL_Once(url,dest_id,display,hideids,showids,rdisplay='inline')
{
    Hide_And_Show_By_ID(hideids,showids,rdisplay);
    if (url in Loaded_URLs)
    {
        Toggle_Element_By_ID(dest_id,display);
    }
    else
    {
        Show_Load_URL_2_Element(url,dest_id,dest_id,display);
        Loaded_URLs[ url ]=1;
    }    
}

function Load_URL_Once_NoHiding(url,dest_id,display='initial',debug=false)
{
    if (url in Loaded_URLs)
    {
        //Toggle_Element_By_ID(dest_id,display);
    }
    else
    {
        if (debug)
        {
            console.log("Loading: "+url);
        }
        
        Show_Load_URL_2_Element(url,dest_id,dest_id,display);
        Loaded_URLs[ url ]=1;
    }
}


function Load_URL(url,dest_id,display,hideids,showids,rdisplay='inline')
{
    Hide_And_Show_By_ID(hideids,showids,rdisplay);
    Show_Load_URL_2_Element(url,dest_id,dest_id,display);    
}


function Show_Load_URL_2_Element(url,insert_id,hide_id,display='initial')
{
    Register_Time("Show_Load_URL_2_Element");
    Register_URL(url);
    
    if (hide_id==undefined)
    {
        hide_id=display_id;
    }

    //console.clear();
    
    let element = Get_Element_By_ID(insert_id);

    if (element)
    {
        if (Load_URL_2_Element(insert_id,"Base",url,"Show_Load_URL_2_Element"))
        {
            element=Show_Element_By_ID(hide_id,display);
            element.focus();
        }
    }
    else
    {
        console.log("Element "+insert_id+" not found. Not loaded");
        console.log("URL:",url);
    }
}
 
 

var Load_URLs={};
var Grouping_Class="GroupingNodes";

function Reload_URL_2_Element(cell_id,group,url,debug=false)
{
    Register_Time("Reload_URL_2_Element");
    Register_URL(url);

    console.log("Reload_URL_2_Element",cell_id,group,url);
    
    let element = Get_Element_By_ID(cell_id);

    if (element)
    {
        let grouping_elements=element.getElementsByClassName(Grouping_Class);

        for (let n=0;n<grouping_elements.length;n++)
        {
            let group=grouping_elements[n].id;
            if (group in Load_URLs)
            {
                console.log("Removing Loading Group",group);
                delete Load_URLs[ group ];
            }
            else
            {
                console.log("Not in Load_URLs - OK!");
            }
        }
    }
    
    Load_URL_2_Element(cell_id,group,url,"Reload_URL_2_Element",debug);
}

function Load_URL_2_Element(cell_id,group,url,module11,debug=false)
{
    Register_Time("Load_URL_2_Element");
    Register_URL(url);

    let group_create=false;
    if (group && ! (group in Load_URLs) )
    {
        group_create=true;
        Load_URLs[ group ]={};
    }

    if (group && url in Load_URLs[ group ])
    {
        //Test if element has gone empty
        let element = Get_Element_By_ID(cell_id);
        let regexp = new RegExp("/\S/");

        //Determine if we can skip reloading element
        if (element.childElementCount>0)
        {
            if (true)
            {
                console.log("Load_URL_2_Element: Already Loaded,",url);
            }
            
            return false;
        }
    }

    if (debug)
    {
        //console.log("Load_URL_2_Element: Loading",url);
    }
    
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            let element = Get_Element_By_ID(cell_id);

            if (!element)
            {
                console.log("Creating element "+cell_id);
                let base_element=Get_Element_By_ID("ModuleCell");
                if (base_element)
                {
                    for (let k=0;k<base_element.children.length;k++)
                    {
                        if (base_element.children[k].id!="HorMenu")
                        {
                            base_element.children[k].style.display='none';
                        }
                    }
                    
                    element=document.createElement('div');
                    base_element.append(element);
                    console.log("Element",cell_id,"Inserted in ModuleCell");
                }
            }
            
            if (element)
            {
                element.innerHTML=this.responseText;
                /////element.focus();

                if (debug)
                {
                    console.log("Load_URL_2_Element, Loaded: ",url,cell_id,group);
                }

                if (group_create)
                {
                    if (debug>0)
                    {
                        console.log("Create group: ",group);
                    }

                    let textnode =
                        document.createElement('span');
                    
                    textnode.id=group;
                    textnode.classList.add(Grouping_Class);
                    element.prepend(textnode);
                }

                
                //Fetched document may include a SCRIPT sections
                if (debug>2)
                {
                    console.log(this.responseText);
                }

                element.tab='initial';
                element.tabIndex=0;
                element.focus();
                Transfer_Loaded_Scripts(element);

                if (group && ! (group in Load_URLs) )
                {
                    Load_URLs[ group ]={};
                }
                
                if
                    (group && ! (url in Load_URLs[ group ]) )
                {
                    if (debug)
                    {
                        //console.log("Lock:",group,url);
                    }
                    
                    Load_URLs[ group ][ url ]=true;
                }

                
            }
            else
            {
                console.log("Cell not found");
                console.log(cell_id);

                return false;
            }
        }

    };

    xhttp.open("GET",url,true);
    xhttp.send();
    
    return true;
}

function Transfer_Loaded_Scripts(element)
{
    //Fetched document may include a SCRIPT sections
    let scripts = element.getElementsByTagName("SCRIPT");

    for (let n=0;n<scripts.length;n++)
    {
        let script=scripts[n];
        let scr = document.createElement("SCRIPT");

        if (scr)
        {
            scr.innerHTML = script.innerHTML;
            document.body.appendChild(scr);
            //console.log(script.innerHTML);
        }
    }
}

function Load_URL_2_Window(url)
{
    Register_Time("Load_URL_2_Window");               
    Register_URL(url);
    
    let a = document.createElement('A');
    a.href = url;
    ////?a.download = url.substr(filePath.lastIndexOf('/') + 1);
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}


function Load_Select(url,destination_id,cginame,source_id,debug=false)
{
    Register_Time("Load_Select");
                
    let element  = Get_Element_By_ID(source_id);

    if (!element)
    {
        console.log("Element:",source_id,"not found");
        return;
    }
    
    let index    = element.selectedIndex;
    let cgivalue = element.children[index].value;
    
    url=url+"&"+cginame+"="+cgivalue;

    Load_URL_2_Element(destination_id,"",url,"Load_Select");
}



