"use strict";





function Input_Field_Disable(element,disabled_color='grey',debug=false)
{
    let create_class="_CREATED_";
    
    let parent=element.parentElement;
    let elements=parent.children;
    
    if (debug)
    {
        console.log("Disable_Input_Field",element.value,elements.length);
    }

    let do_create=true;
    for (let m=0;m<elements.length;m++)
    {
        if (elements[m].className==create_class)
        {
            do_create=false;
            break;
        }
    }

    if (do_create)
    {
        let span_element=document.createElement("SPAN");
        span_element.className=create_class;
        span_element.innerHTML=element.value;
        
        parent.append(span_element);
        element.style.display='none';
        span_element.style.display='inline';
    }
}

function Input_Field_Enable(element,disabled_color='grey',debug=false)
{
    element.style.display='initial';
    element.innerHTML = '';

    let parent=element.parentElement;
    let elements=parent.children;
    
    if (debug)
    {
        console.log("Enable_Input_Field",element.value,elements.length);
    }
    
    for (let m=0;m<elements.length;m++)
    {
        if (elements[m].tagName=="SPAN")
        {
            elements[m].remove();
        }
    }        
}

function Input_Field_Toggle(element,disabled_color='grey',debug=false)
{
    let visible=false;
    if (element.style.display=='none')
    {
        visible=true;
        
        Input_Field_Enable(element,disabled_color,debug);
    }
    else
    {
        Input_Field_Disable(element,disabled_color,debug);
    }

    return visible;
}

function Toggle_Inputs_ByClass(classid,disabled_color='grey',debug=false)
{
    let elements = document.getElementsByClassName(classid);

    if (debug)
    {
        console.log(elements.length,classid);
    }
    
    for (let n=0;n<elements.length;n++)
    {
        Input_Field_Toggle(elements[n],disabled_color,debug);
    }
}

function Disable_Inputs_ByClass(classid,disabled_color='grey',debug=false)
{
    let elements = document.getElementsByClassName(classid);

    if (debug)
    {
        console.log(elements.length,classid);
    }
    
    for (let n=0;n<elements.length;n++)
    {
        Input_Field_Disable(elements[n],disabled_color,debug);
    }
}

function Enable_Inputs_ByClass(classid,disabled_color='grey',debug=false)
{
    let elements = document.getElementsByClassName(classid);

    if (debug)
    {
        console.log(elements.length,classid);
    }
    
    for (let n=0;n<elements.length;n++)
    {
        Input_Field_Enable(elements[n],disabled_color,debug);
    }
}

function Inputs_ByClasses_Enable_Disable(classid,classes,disabled_color='grey')
{
    let debug=false;
    for (let n=0;n<classes.length;n++)
    {
        Disable_Inputs_ByClass(classes[n],disabled_color,debug);
    }
    
    Enable_Inputs_ByClass(classid,disabled_color,debug);
}

function Element_Get_Inner_Number(element)
{
    let oldvalue=parseInt(element.innerHTML);
    if (isNaN(oldvalue))
    {
        console.log(oldvalue,"NAN!!");
        oldvalue=0;
    }

    return oldvalue;
}

function Sprint_Int(value,ndub=2)
{
    value = "000000000"+value;
    value=value.substr(value.length-ndub);
    return value;
}
function Sprint_Float(value,ndec=1)
{
    return value.toFixed(1);
}

function Input_Update_Sum_Class(element,rvalue,sumclass,change)
{
    //console.log(sumclass);
    let sumelements=document.getElementsByClassName(sumclass);
    if (sumelements.length>0)
    {
        Color_Elements(sumelements,"orange");

        for (let n=0;n<sumelements.length;n++)
        {
            let oldvalue=Element_Get_Inner_Number(sumelements[n]);
            let newvalue=oldvalue;

            
            newvalue+=change;
            sumelements[n].innerHTML=Sprint_Int(newvalue);
        }
    }
}

function Input_Update_Sum_Classes(element,rvalue,sumclasses)
{
    let change=rvalue-element.value;
    if (change!=0 && sumclasses)
    {
        for (let c=0;c<sumclasses.length;c++)
        {
            Input_Update_Sum_Class(element,rvalue,sumclasses[c],change);
        }
    }
}

function Input_Cyclic(element,maxvalue,sumclasses=false)
{
    let debug=false;
    
    let value=element.value;

    let rvalue="";
    if (value=="" || value==0) { rvalue=maxvalue; }
    else
    {
        rvalue=value-1;
        if (rvalue<=0) { rvalue=""; }
    }

    

    rvalue=Math.min(rvalue,maxvalue);

    
    if (rvalue<=0) { rvalue=""; }
    
    if (debug)
    {
        console.log(value,rvalue);
    }

    let change=rvalue-element.value;
    if (change!=0 && sumclasses)
    {
        Input_Update_Sum_Classes(element,rvalue,sumclasses);
    }
    
    element.value=rvalue;
    Mark_Form_On_Input_Change();
}


function Input_Cyclic_KeyBoard(element,maxvalue,sumclasses=false)
{
    let debug=false;
    
    let newvalue=event.keyCode-48;
    if (debug)
    {
        console.log(event.keyCode,element.value,newvalue);
    }
    
    newvalue=Math.min(newvalue,maxvalue);

    if (event.keyCode==32)
    {
        Input_Cyclic(element,maxvalue,sumclasses);
        newvalue=maxvalue;
    }
    else
    {
        let change=newvalue-element.value;
        if (change!=0 && sumclasses)
        {
            Input_Update_Sum_Classes(element,newvalue,sumclasses);
        }
    
        if (newvalue>=0 && newvalue<=maxvalue)
        {
            if (newvalue==0) { newvalue=""; }
            
            element.value=newvalue;
            if (debug) console.log("Update",element.value,newvalue);
        }
        else
        {
            //remove character
            element.value=maxvalue;
            if (debug) console.log("Ignore (resetting)",element.value);
        }
    }
      
    if (debug) console.log("Exiting: ",element.value,element);
}


function Inputs_Elements(clss,tagname='INPUT')
{
    let elements=document.getElementsByClassName(clss);

    let relements=[];
    for (let n=0;n<elements.length;n++)
    {
        if (elements[n].tagName==tagname)
        {
            relements.push(elements[n]);
        }
    }

    return relements;
}

function Elements_Sum(elements)
{
    let sum=0;
    for (let n=0;n<elements.length;n++)
    {
        let value=parseInt(elements[n].value);
        if (isNaN(value))
        {
            value=0;
        }
        
        sum+=value;
    }

    return sum;
}

function Elements_Set_Inner(elements,value)
{
    for (let n=0;n<elements.length;n++)
    {
        elements[n].innerHTML=value;
    }
}

function Element_Percentage_Set(dest_element_id,value_element_id,total_element_id,status_element_id=false,status_limit_id=false)
{
    let dest_element=Get_Element_By_ID_Or_Class(dest_element_id);
    if (!dest_element) { return; }
    
    let value_element=Get_Element_By_ID_Or_Class(value_element_id);
    if (!value_element) { return; }
    
    let total_element=Get_Element_By_ID_Or_Class(total_element_id);
    if (!total_element) { return; }

    let value=Element_Get_Inner_Number(value_element);
    let total=Element_Get_Inner_Number(total_element);

    if (total!=0)
    {
        let percent=100.0*value/(1.0*total);
        dest_element.innerHTML=Sprint_Float(percent);
        //dest_element.innerHTML="100.0*"+value+"/"+(1.0*total);
        
        Color_Element(dest_element,"orange");
    }
}

function Inputs_Sum_Row(element,clss,dest_clss,total_id=false,percent_clss=false)
{
    //Source INPUT elements
    let elements=Inputs_Elements(clss);

    //Sum source elements
    let sum=Elements_Sum(elements);

    //Destination elements
    let dest_elements=document.getElementsByClassName(dest_clss);

    //Update sum on destination elements
    Elements_Set_Inner
    (
        dest_elements,
        Sprint_Int(sum)
    );
    
    //Change color on destination elements
    Color_Elements(dest_elements,"orange");
    
    console.log
    (
        "Inputs_Sum_Row",
        clss,elements.length,
        dest_clss,dest_elements.length,
        "Sum:",sum,
        total_id
    );

    if (total_id && percent_clss)
    {
        let total_element=Get_Element_By_ID(total_id);
        let percent_elements=document.getElementsByClassName(percent_clss);
        
        if (total_element)
        {
            let total=Element_Get_Inner_Number(total_element);

            let percent='-';
            if (total>0)
            {
                percent=Sprint_Float(100.0*sum/(1.0*total));
            }
            
            //Update percent on destination elements
            Elements_Set_Inner
            (
                percent_elements,
                percent
            );
            
            //Change color on destination elements
            Color_Elements(percent_elements,"orange");
            
            console.log("Total",total_element,total,percent);
        }
    }
}

function Input_Cyclic_Increasing(element,maxvalue,inc=1)
{
    let debug=true;
    
    //Make sure we add numbers
    inc=parseInt(inc);
    
    let value=element.value;    
    
    let rvalue=0;
    if (value=="-") { rvalue=0; }
    else
    {
        value=parseInt(value);
        if (value==0) { rvalue=1; }
        else
        {
            rvalue=value+inc;
            if (rvalue>maxvalue) { rvalue=0; }
        }
    }
    
    if (rvalue>maxvalue) { rvalue=0; }
    
    if (debug)
    {
        console.log
        (
            "Input_Cyclic_Increasing",
            element.name,
            inc,maxvalue,
            value,rvalue
        );
    }
    
    element.value=rvalue;
    Mark_Form_On_Input_Change();
}
