"use strict";




function Disable_Non_Unique(select_classes)
{
    let elements=document.getElementsByClassName(select_classes);

    let nelements=0;
    for (let n=0;n<elements.length;n++)
    {
        if (elements[n].tagName=="SELECT")
        {
            console.log(elements[n].value);
            nelements++;
        }
    }

    console.log(nelements); 
}
