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
	#trial_progress_span{
		margin:auto;
		width:300px;
	}
    .user_trialtype{
        background-color:PaleGreen ;        
    }
    .default_trialtype{
        background-color:LightSkyBlue ;
    }
	#default_user_trialtype_span{
		padding : 5px;
		border-radius : 5px;
	}
</style>
<br><br>
<div id="trial_progress_span"></div>	    

<div id="TrialTypes" class="hide_show_elements">
  
<div id="trial_type_selectors">
	<button class="btn btn-primary" id="community_trialtypes_btn">Community</button>
	<select id="trial_type_select">
		<option hidden disabled selected>Select a Trial Type</option>
	</select>	
	<span id="default_user_trialtype_span"></span>
	<button id="new_trial_type_button" 		class="btn btn-primary">New</button>
	<button id="rename_trial_type_button" class="btn btn-primary" style="display:none">Rename</button>
	<button id="delete_trial_type_button" class="btn btn-primary" style="display:none">Delete</button>
	<button id="save_trial_type_button" class="btn btn-primary">Save</button>
	<button id="view_trialtype_backups" class="btn btn-primary">Revert to backup</button>	
	<button class="btn btn-outline-primary" id="view_code_btn">Code</button>
	<button class="btn btn-outline-primary" id="view_graphic_btn">Graphic</button>	
</div>

<style type="text/css" media="screen">
	#ACE_editor { 
		/* height:50%; */
	}
</style>
<h6><em>ACE (https://ace.c9.io/)</em> is used for editing code</h6>  
<div id="ACE_editor" 			style="display:none;max-width:1000px"></div>
<div id="graphic_editor" 	style="display:none"><?php require("graphic.html") ?></div>


<script>
$("#community_trialtypes_btn").on("click",function(){
	var win = window.open('https://github.com/open-collector/open-collector/issues/2', '_blank');
});

$("#view_trialtype_backups").on("click",function(){
	alert("This will be implemented after backing up with dropbox is implemented");
});

var editor = ace.edit("ACE_editor");
editor.getSession().setUseWorker(false);
editor.setTheme("ace/theme/chrome");
editor.getSession().setMode("ace/mode/html");

editor.setOptions({
	enableBasicAutocompletion: true,
	enableSnippets: false,
	enableLiveAutocompletion: true,
	maxLines: 50,
	minLines: 30,
	tabSize:2,
	wrap:true,
});
editor.$blockScrolling = Infinity;

editor.on("focus",function(){
	helperActivate("Trialtype Code", "","trialtype_code");
});

langTools = ace.require('ace/ext/language_tools'); 

editor.completers.push({
	getCompletions: function(editor, session, pos, prefix, callback) {
		callback(null, [
			{value: "Trial.submit()", score: 1000, meta: "end trial - C"},
			{value: "Trial.elapsed()", score: 1000, meta: "since trial start - C"},
			{value: "Trial.set_timer()", score: 1000, meta: "at trial start - C"},
		]);
	}
});
</script>  

<script type="text/javascript" src="IndexTabs/Simulator/TrialTypeEditor/TrialTypeFunctions.js"></script>
<script type="text/javascript" src="IndexTabs/Simulator/TrialTypeEditor/TrialTypeActions.js"></script>

</div>