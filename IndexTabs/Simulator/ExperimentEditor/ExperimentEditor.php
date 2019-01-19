<!--
/*  Collector (Garcia, Kornell, Kerr, Blake & Haffey)
    A program for running experiments on the web
    Copyright 2012-2016 Mikey Garcia & Nate Kornell


    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 3 as published by
    the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
 		
		Kitten release (2019) author: Dr. Anthony Haffey (a.haffey@reading.ac.uk)		
*/
-->
<style>

.handsontable td{
    max-width:100px;
    text-align:left;
}


.handsontable tr > td.current {
    !background-color: rgb(0,0,360);
    !color:white;
}
.selected_cell{
    color:blue;
}
.exp_table_cells {
	padding: 10px;
}
</style>

<br><br><br>
<table id="exp_data_table">    
	<tr>
		<td align="left" class="exp_table_cells">
			<div id="Conditions" class="hide_show_elements"> 
				<h3>Conditions</h3>
				<div id="conditionsArea"></div>
			</div>
			<br><br>
		</td>
		<td></td>
	</tr>
	<tr>
		<td id="Procedure" class="hide_show_elements exp_table_cells" align="left"  valign="top">
			<h3>Procedure</h3>
			<select id="proc_select"></select>
			<button type="button" id="new_proc_button" class="btn btn-primary">New Sheet</button>
			<button type="button" id="rename_proc_button" class="btn btn-primary">Rename Sheet</button>
			<span id="procsArea">
				<div id="procSheetTable"></div>
			</span>
		</td>    
		<td id="resp_area">
			<select style="visibility: hidden"><option>Select</option></select>
			<div id="resp_data" class="custom_table"></div>
		</td>
	</tr>
	<tr>
		<td id="Stimuli" class="hide_show_elements exp_table_cells" align="left" valign="top">
			<h3>Stimuli</h3>
			<select id="stim_select"></select>
			<button type="button" id="new_stim_button" class="btn btn-primary">New Sheet</button>
			<button type="button" id="rename_stim_button" class="btn btn-primary">Rename Sheet</button>			
			<button type="button" id="stim_list_button" class="btn btn-primary">List Stimuli</button>
			<span id="stimsArea">
				<div id="stimsheetTable"></div> 
			</span>
		</td>
	</tr>
</table>

<script src="IndexTabs/Simulator/ExperimentEditor/ExpEditorFunctionsSql.js"></script>
<script src="IndexTabs/Simulator/ExperimentEditor/ExpEditorActionsSql.js"></script>

<script>

//handsontable_detected = false;  -- not sure what this was doing, but removing it seems to fix some problems
$(window).bind('keydown', function(event) {
    // hack to get keydown detected for handsontables
    //if(handsontable_detected == false){
        $(".handsontableInput").keyup(function(){
            $("#cell_content").val(this.value);
        });                
        $(".handsontableInput").keydown(function(){ 
            if(window.event.keyCode == "27"){                    
                $("#cell_content").val("");
            };
        });
    //}
    //handsontable_detected = true;    
});

$("#stim_list_button").on("click",function(){
	var web_url = "https://www.open-collector.org/<?= $_SESSION['version'] ?>/IndexTabs/Simulator/ExperimentEditor/stimList.php";
	window.open(web_url,"stimList",'height=800,width=800');
});



function cell_content_process(thisCellValue,coords,this_sheet,container){
	/*
	var experiment 		= dbx_mgmt.experiment;
	var this_exp     	= dbx_mgmt.experiments[experiment];
	
	if(container.parentElement.id == "conditionsArea"){
		this_exp['cond_array'] = handsOnTable_Conditions.getData();
	} else {
		if(container.parentElement.id == "stimsArea"){
			var sheet_type = "all_stims";
			this_exp[sheet_type][this_sheet] = handsOnTable_Stimuli.getData();
		}
		if(container.parentElement.id == "procsArea"){
			var sheet_type = "all_procs";
			this_exp[sheet_type][this_sheet] = handsOnTable_Procedure.getData();
		}		
	}
	
    $("#cell_content").val(thisCellValue);
    sheet_management.cell_backup = thisCellValue;
    if( sheet_management.current_sheet !== this_sheet |
        sheet_management.current_coords !== coords){            
            var div = $('#cell_content_border');
            div.css('border-color','blue');
        }
    sheet_management.current_sheet = this_sheet;
    sheet_management.current_coords = coords;
		*/
}

var cell_width = $(window).width()*0.99;
$("#cell_content").css("width",cell_width+"px");

var spreadsheets = {};
var alerts_ready = false;

var handsOnTable_Conditions = null;
var handsOnTable_Stimuli    = null;
var handsOnTable_Procedure  = null;

</script>