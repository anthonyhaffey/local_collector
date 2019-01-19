<?php
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
if($_SESSION['user_email'] == "guest"){
	echo "You cannot create a study unless you are logged in. Please log in or register.";
} else {
	$simulator_on = "true";
	require 'initiateTool.php';    
?>

<!-- Scripts needed for simulator -->
<link rel="stylesheet" type="text/css" href="IndexTabs/Simulator/SimulatorStyle.css" media="screen" />

<style>
.fixed-top-2 {
	margin-top: 50px;
  height: 42px;
}
#sim_navbar{
  padding: 0px;
}
#simulator_table{
	margin-top: 0px;
}
</style>


<script>
var User_Data = {
	Username:   "Admin:Simulator",
	ID:         "Admin:Simulator",
	Debug_Mode: true,
	Experiment_Data: {stimuli: {}, procedure: {}, globals: {}, responses: {}}
}

window.onbeforeunload = function() {
	if($("#save_status").html() !== "" & $("#save_status").html() !== "Up to date"){
		//bootbox.alert("If you haven't completed the experiment, please type CTRL-S to save your data and e-mail it to the researcher and explain why you didn't complete the study.");
		return "Please do not try to refresh - you will have to restart if you do so.";	
	}		
};
</script>

<nav class="navbar navbar-primary bg-white fixed-top fixed-top-2" id="sim_navbar">
	<?php require("ExperimentEditor/LoadSqlExperiment.php"); ?>
  <span class='not_survey_cell_view_td' align="right">
    <?php require("SupportBars/interfaces.php"); ?>
  </span>
</nav>


<script>
$(".collectorSwitch").on("click",function(){
	if(this.className.indexOf("btn-outline-primary") !== -1){
		this.className = this.className.replace("btn-outline-primary","btn-primary");
	} else {
		if(this.className.indexOf("btn-primary") !== -1){
			this.className = this.className.replace("btn-primary","btn-outline-primary");
		}
	}
});


$("#cell_content").on("blur",function(){
    $("#cell_content").hide();
});

block_save = true;
</script>
<br><br>
<table id="simulator_table">    
  <tr>
    <td id="Presentation">            
      <div id="ExperimentContainer" style="text-align:center; margin:auto">
        <?php 
          require(__DIR__ ."/../../sqlExperiment.php");
        ?>			
        <div id="preview_message">Select an experiment to be able to start a preview. Once you press start the experiment will buffer to the level of trials you've selected.</div>
      </div>
    </td>
  </tr>
  <tr>
    <td id="run_stop_buttons" align="centre">
      <button type="button" id="run_button" class="btn btn-primary">Run Simulation</button>
      <button type="button" id="stop_button" class="btn btn-primary">Stop Simulation</button>
      <button type="button" id="shuffle_off_button" class="btn btn-primary" title='Click to turn Shuffle OFF'>Shuffle</button>
      <button type="button" id="shuffle_on_button" class="btn btn-outline-primary" title='Click to turn Shuffle ON' style="display:none">Shuffle</button>
    </td>
  </tr> 
  <tr>
    <td>
      <div id="authorised_interface">
			  <?php require ("ExperimentEditor/ExperimentEditor.php"); ?>
				<?php require ("TrialTypeEditor/TrialTypeEditor.php"); ?>
			</div>
    </td>
  </tr>
</table>

<script src="IndexTabs/Simulator/simulatorFunctions.js"></script>
<script src="IndexTabs/Simulator/simulatorActions.js"></script>
<script>
presentation_style_default = $("#Presentation")[0].style;

$("#shuffle_off_button").on("click",function(){			// code for disabling shuffling	
	$("#shuffle_on_button").show();
	$("#shuffle_off_button").hide();
});
$("#shuffle_on_button").on("click",function(){			// code for enabling shuffling
	$("#shuffle_on_button").hide();
	$("#shuffle_off_button").show();
});
  
$("#stop_button").on("click",function(){
	$("#experiment_div").hide();
	$(".trial_iframe").remove();
	exp_json.trial_no = 0;
	exp_json.post_no  = 0;
	$("#stim_listing").css("width","0%");
	$("#stim_progress").show();
	$(".progress").hide();
	$("#experiment_progress").css("width","0%");
	delete(stim_interval);	
});

$(document).keyup(function(e) {
	if($("#ACE_editor").is(":focus")){
		alert("whoop");
	}
	switch(e.which){
		case 27:
			$("#survey_cell_view").hide();
			break;
		case 37:
		case 38:
		case 39:
		case 40:
			if(typeof(survey_hot) !== "undefined"){
				var thisCellValue = survey_hot.getValue();
				$("#survey_cell_view").val(thisCellValue);				
			};
			$("#survey_cell_view").show();
			break;
		default:
			if(typeof($(".handsontableInput")[0]) !== "undefined"){				
				var thisCellValue = $(".handsontableInput")[0].value; // bit of a hack
				$("#survey_cell_view").val(thisCellValue);
				$("#survey_cell_view").show();
			}
			break;			
	}
});
</script>

<?php 
}
?>