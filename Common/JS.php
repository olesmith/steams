<?php

include_once("JS/Quote.php");
include_once("JS/Indent.php");
include_once("JS/Array.php");
include_once("JS/Functions.php");
include_once("JS/Shows.php");
include_once("JS/Hides.php");
include_once("JS/Show_Hide.php");
include_once("JS/Toggles.php");
include_once("JS/Clicks.php");
include_once("JS/Loads.php");
include_once("JS/Sends.php");
include_once("JS/Reloads.php");
include_once("JS/Check_Boxes.php");
include_once("JS/Inputs.php");
include_once("JS/Enables.php");
include_once("JS/Disables.php");
include_once("JS/Highlights.php");
include_once("JS/Table.php");
include_once("JS/Elements.php");
include_once("JS/Clip.php");
include_once("JS/Select.php");

trait JS
{
    use
        JS_Quote,
        JS_Indent,
        JS_Array,
        JS_Functions,
        JS_Shows,
        JS_Hides,
        JS_Show_Hide,
        JS_Toggles,
        JS_Clicks,
        JS_Loads,
        JS_Sends,
        JS_Reloads,
        JS_Check_Boxes,
        JS_Inputs,
        JS_Enables,
        JS_Disables,
        JS_Highlights,
        JS_Table,
        JS_Elements,
        JS_Clip,
        JS_Select;

    
    var
        $JS_Show_By_ID="Show_Elements_By_ID",
        $JS_Hide_By_ID="Hide_Elements_By_ID",
        
        $JS_Click_Element_By_ID ="Click_Element_By_ID",
        $JS_Click_Elements_By_ID="Click_Elements_By_ID",
        $JS_Click_Elements_By_Checked_IDs="Click_Elements_By_Checked_IDs",
        $JS_Click_Parent_Element_By_Class="Click_Parent_Element_By_Class",
        
        $JS_Click_Elements_By_Class ="Click_Elements_By_Class",
        
        $JS_Show_By_Class="Show_Elements_By_Class",
        $JS_Hide_By_Class="Hide_Elements_By_Class",
        
        $JS_Show_By_Classes="Show_Elements_By_Classes",
        $JS_Hide_By_Classes="Hide_Elements_By_Classes",
        $JS_Show_Hide_By_Classes="Show_Hide_Elements_By_Classes",
        
        
        $JS_Toggle_Element_By_ID="Toggle_Element_By_ID",        
        $JS_Toggle_Elements_By_Class="Toggle_Elements_By_Class",
        $JS_Toggle_Colors="Toggle_Colors",
        
        $JS_Display="inline", //try initial
        $JS_Field_Display="block", //try initial
        
        $JS_CSS_Visible="Visible",
        $JS_CSS_Visible_Color="orange",
        
        $JS_CSS_Hidden="Hidden",
        $JS_CSS_Hidden_Color="gray",
        
        $JS_CSS_Field="Field",
        $JS_Show_Load="Show_Load_URL_2_Element",
        $JS_Load_Once="Load_URL_Once_NoHiding",
        $JS_Load_URL_2_Element="Load_URL_2_Element",
        $JS_Select_Send="Select_Send",
        $JS_Load_URL_2_Window="Load_URL_2_Window",
        $JS_Send_Form_URL="Send_Form_URL",
        $JS_Reload_URL_2_Element="Reload_URL_2_Element",
        $JS_Load_Select="Load_Select",
        $JS_CheckBox_Group_Set_All="CheckBox_Group_Set_All",
        $JS_CheckBox_Group_Toggle_All="CheckBox_Group_Toggle_All",
        $JS_Enable_Inputs_ByClass="Enable_Inputs_ByClass",
        $JS_Disable_Inputs_ByClass="Disable_Inputs_ByClass",
        $JS_Toggle_Inputs_ByClass="Toggle_Inputs_ByClass",
        $JS_Inputs_ByClasses_Enable_Disable="Inputs_ByClasses_Enable_Disable",
        $JS_Input_Cyclic="Input_Cyclic",
        $JS_Input_Cyclic_KeyBoard="Input_Cyclic_KeyBoard",
        $JS_Inputs_Sum_Row="Inputs_Sum_Row",
        $JS_Element_Percentage_Set="Element_Percentage_Set",
        $JS_Highlight_ByClass="Highlight_Elements_By_Class",
        $JS_Table_Display_Previous="Table_Display_Previous",
        $JS_Clip_Board_Copy_URL="Clip_Board_Copy_URL";

}
?>