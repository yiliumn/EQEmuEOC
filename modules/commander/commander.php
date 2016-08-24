<?php

	require_once('modules/commander/functions.php');

	echo '<link rel="stylesheet" type="text/css" href="modules/commander/commander.css">';

	// echo '<script src="assets/global/plugins/jquery.min.js"></script>';
	$FJS .= '
		<script src="assets/global/plugins/jquery.ba-throttle-debounce.min.js"></script>
		<script src="modules/commander/js/eqmap_ws_core_config.js"></script>
		<script src="modules/commander/js/eqmap_ws_core.js"></script>
		<script src="modules/commander/js/eqmap_ws_sidebar.js"></script>
		<script src="modules/commander/js/eqmap_ws_server_to_client.js"></script>
		<script src="modules/commander/js/eqmap_ws_client_to_server.js"></script>
		<script src="assets/admin/pages/scripts/components-jqueryui-sliders.js"></script>
		<script src="assets/global/plugins/jquery-knob/js/jquery.knob.js"></script>
		<script src="cust_assets/js/context/jquery.contextmenu.js"></script>
		<link rel="stylesheet" href="cust_assets/js/context/jquery.contextmenu.css">
		<script type="text/javascript" src="cust_assets/js/colpick/js/colpick.js"></script>
		<link href="cust_assets/js/colpick/css/colpick.css" rel="stylesheet" type="text/css"/>';

	if(isset($_GET['zone'])){
		echo Draw2DMap($_GET['zone'], 1);  
	}
	else if(isset($_GET['ace_test'])){
		echo '
			<title>ACE in Action</title>
			<style type="text/css" media="screen">
				#editor {
					position: absolute;
					top: 0;
					right: 0;
					bottom: 0;
					left: 0;
				}
			</style>
			<div id="editor">
				function foo(items) {
					var x = "All this is syntax highlighted";
					return x;
				}
			</div>';

		if(isset($_GET['lua'])){
			echo '
			<script src="modules/commander/ace/build/src/ace.js" type="text/javascript" charset="utf-8"></script>
			<script>
				var editor = ace.edit("editor");
				editor.setTheme("ace/theme/terminal");
				editor.getSession().setMode("ace/mode/lua");
				var ace_file_to_load = "quests/global/test.lua";
			</script>';
		}
		else {
			echo '
			<script src="modules/commander/ace/build/src/ace.js" type="text/javascript" charset="utf-8"></script>
			<script src="modules/commander/ace/build/src/ext-language_tools.js"></script>
			<script>
				var editor = ace.edit("editor");
				ace.require("ace/ext/language_tools");
				editor.setTheme("ace/theme/terminal");
				editor.getSession().setMode("ace/mode/perl");
				editor.setOptions({
					enableBasicAutocompletion: true,
					enableSnippets: true,
					enableLiveAutocompletion: true
				});
				editor.commands.on("afterExec", function(e){
					 if (e.command.name == "insertstring"&&/^[\w.]$/.test(e.args)) {
						 editor.execCommand("startAutocomplete")
					 }
				});
				var ace_file_to_load = "quests/global/global_npc.pl";
			</script>';
		}

		$FJS .= "
		<script type='text/javascript'>
			$(document).bind('keydown', function(e) {
				if(e.ctrlKey && (e.which == 83)) {
					e.preventDefault();
					socket.send(JSON.stringify({id: 'quest_save_script', method: 'World.SaveFileContents', params: ['' + ace_file_to_load + '', '' + editor.getSession().getValue() + '']}));
					// alert('Saved');
					$.notific8('Saved!', { heading: 'Commander', theme: 'ruby', life: 500 });
					return false;
				}
			});
		</script>";
	}
	else{
		/* Main */
		echo '
			<div style="text-align: center;">
				<h1 class="page-title slideDown anim_entrance"> <i class="fa fa-cloud" style="font-size:20px"></i> Zone Servers </h1><hr>
				<table id="zone_servers_list" class="table table-hover table-striped table-bordered slideUp" style="width:600px;margin-left: auto; margin-right: auto;">
					<tr>
						<td style="text-align:center">
							<span id="zone_server_count"></span>
							Players Online <span id="total_players"></span>
						</td>
						<td>Players</td>
						<td>Port</td>
						<td>Short Name</td>
						<td>Zone ID</td>
						<td>Instance ID</td>
					</tr>
				</table>
			</div>';
	}
	/*  The following doesn't seem to be doing anything, html code checkers complain about style being here anyway. */
	#::: Dark Style UI
	if(isset($_SESSION['UIStyle']) == 2){
	
	}
	else{
		/*echo '
		<style type="text/css">
			.btn-default {
				color: #333333; 
				border-color: #cccccc;
			}
			body {
				background-color: #fff !important;
			}
		</style>';*/
	}
?>