<?php

Class Projects{

	function getUserId(){ // get the logged in user's user id
		$userDetails = mysql_query("SELECT * FROM tbl_users WHERE username = '".$_SESSION['intrnt_usr']."' AND user_status = 1");
		$getUserDetails = mysql_fetch_array($userDetails);		
		$userId = $getUserDetails['user_id'];		
		return $userId;
	}
	
	//////////////////////////////// for project list page ////////////////////////////////
	
	function searchProjects($userId){ ?>
		<div class="search_project_wrap">
			<input type="text" name="search_project" id="search_project" value="" placeholder="Search project">
			<input type="hidden" id="logged_in_user_id" value="<?php $this->getUserId(); ?>">
		</div>
		
		<script type="text/javascript">
			$('#search_project').keyup(function() {
				var user_id = $('#logged_in_user_id').val();
				var searchstring = $('#search_project').val();
				var searchstring = escape(searchstring);
				
				$('#project_list').text('searching...');
				$('#project_list').load( 'plugins/project_space/controller2.php?action=search&searchstring=' + searchstring + '&user_id=<?php echo $userId; ?>' );
			});
		</script>
	<?php
	}
	
	function addNewProject(){ ?>
		<div class="add_project" id="add_project"><button class="blue_01">Add Project</button></div>
	<?php
	}
	
	function checkIfUserIsModerator($userId){
		/// get user access ///
		$checkUserAccess = mysql_query("SELECT user_level_id, group_id FROM tbl_users WHERE user_id = ".$userId );
		$getUserAccess = mysql_fetch_array($checkUserAccess);
		
		$checkAccessedPrivilege = mysql_query("SELECT role_id FROM tbl_user_group_role WHERE group_id = ".$getUserAccess['group_id']." OR user_id = ".$userId);
		
		$access = '';
		while($getAccessedPrivilege = mysql_fetch_array($checkAccessedPrivilege)){
			$access = $access.",".$getAccessedPrivilege['role_id'];
		}
		$access = substr($access, 1);
		$accessArr = explode(',', $access);
		
		if(in_array('4', $accessArr)){
			return 1;
		}else{
			return 0;
		}
		/*$checkAccessedPlugins = mysql_query("SELECT plugin_id FROM tbl_user_level_plugins WHERE user_level_id = ".$getUserAccess['user_level_id']." OR user_id = ".$userId);
		while($getAccessedPlugins = mysql_fetch_array($checkAccessedPlugins)){
			echo $getAccessedPlugins['plugin_id'];
			echo "<br/>";
		}*/
	}
	
	function addNewProjectForm($userId){ ?>
		<div id="add_project_form_bg"></div>
		<div class="add_project_form" id="add_project_form">
			<div id="back"><div class="add_project_close"></div></div>
            <div class="clear"></div>
            <div class="form_title">Add Project</div>
			<?php //echo $this->checkIfUserIsModerator($userId); ?>
            <hr />
            <div class="mart20"></div>
			<input type="hidden" name="add_project_user_id" id="add_project_user_id" value="<?php echo $userId; ?>" />
			<div class="userinput">
				<div class="add_project_title">Project Name: <span style="color:RED">*</span></div>
                <div class="add_project_input"><input type="text" name="add_project_title" id="add_project_title" value="" maxlength="250" /><br/>Maximum of 250 characters only.</div> <!--<span id="add_project_title_err" class="errmsg" >*</span>-->
			</div>
			<div class="userinput">
				<div class="add_project_title">Project Description: <span style="color:RED">*</span></div>
                <textarea name="add_project_desc" id="add_project_desc" rows="2" cols="20" ></textarea> <!--<span id="add_project_desc_err" class="errmsg">*</span>-->
			</div>
			<div class="userinput">
				<div class="add_project_title">Date Start: <span style="color:RED">*</span></div>
                <div class="add_project_input"><input type="text" style="width: 155px !important;" id="add_project_date_start" name="add_project_date_start" value="" readonly /></div> <!--<span id="add_project_date_start_err" class="errmsg">*</span>-->
			</div>
			<div class="userinput">
				<div class="add_project_title">Date End: <span style="color:RED">*</span></div>
                <div class="add_project_input"><input type="text" style="width: 155px !important;" id="add_project_date_end" name="add_project_date_end" value="" readonly /></div> <!--<span id="add_project_date_end_err" class="errmsg">*</span>-->
			</div>
            <div class="clear"></div>
			<div class="userinput">
				<div id="add_new_project_submit"><button class="orange_02">Add</button></div>
			</div>
			<!--<div id="add_project_msg_err" class="errmsg txt_red01">Please fill up all required fields</div>
            <div id="add_new_project_msg" class="txt_green01">&nbsp;</div>-->
			<div id="add_new_project_msg"></div>
            <link href="templates/blue/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
			<script type="text/javascript">
			$(function() {
				var dates = $( "#add_project_date_start, #add_project_date_end" ).datepicker({
					defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
					changeMonth: true,
					numberOfMonths: 1,
					onSelect: function( selectedDate ) {
						var option = this.id == "add_project_date_start" ? "minDate" : "maxDate",
							instance = $( this ).data( "datepicker" ),
							date = $.datepicker.parseDate(
								instance.settings.dateFormat ||
								$.datepicker._defaults.dateFormat,
								selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			});
			
			$('#add_new_project_submit').click(function() {
				
				var user_id = $('#add_project_user_id').val();
				
				var project_title = $('#add_project_title').val();
				var project_title = $.trim(project_title);
				var project_title = project_title.replace(/\\/g,'\\\\');
				var project_title = project_title.replace(/\'/g,'\\\'');
				var project_title = project_title.replace(/\"/g,'\\"');
				var project_title = project_title.replace(/\0/g,'\\0');
				
				var project_desc = $('#add_project_desc').val();
				var project_desc = $.trim(project_desc);
				var project_desc = project_desc.replace(/\\/g,'\\\\');
				var project_desc = project_desc.replace(/\'/g,'\\\'');
				var project_desc = project_desc.replace(/\"/g,'\\"');
				var project_desc = project_desc.replace(/\0/g,'\\0');
				
				var date_start = $('#add_project_date_start').val();
				var date_start = escape(date_start);
				
				var date_end = $('#add_project_date_end').val();
				var date_end = escape(date_end);
				
				if(project_title == ''){
					$('#add_project_title_err').show();
					var error = "y";
				}else{
					//$('#add_project_title_err').hide();
					var regexp = new RegExp("^[a-zA-Z0-9. &()?!;:,_'\"\-]+$");
					if( !regexp.test( project_title ) ){
						$('#add_new_project_msg').text('Invalid Input').addClass('txt_red01');
						return false;
					}
				}
				
				if(project_desc == ''){
					$('#add_project_desc_err').show();
					var error = "y";
				}else{
					$('#add_project_desc_err').hide();
				}
				
				if(date_start == ''){
				$('#add_project_date_start_err').show();
					var error = "y";
				}else{
					$('#add_project_date_start_err').hide();
				}
				
				if(date_end == ''){
				$('#add_project_date_end_err').show();
					var error = "y";
				}else{
					$('#add_project_date_end_err').hide();
				}
				
				if(error == "y"){
					$('#add_new_project_msg').text('Please fill up all required fields').addClass('txt_red01');
				}else{
					var project_title = escape(project_title);
					var project_desc = escape(project_desc);
					
					var project_desc = project_desc.replace(/\%0A/g,'<br/>')
					
					$('#add_project_msg_err').hide();
					$('#result').load( 'plugins/project_space/controller2.php?action=addnewproject&project_title=' + project_title + '&project_desc=' + project_desc + '&date_start=' + date_start + '&date_end=' + date_end + '&user_id=' + user_id );
					$('#project_list').text( 'loading...' );
					$('#project_list').load( 'plugins/project_space/controller2.php?action=updateprojectlist&user_id=' + user_id );
				}
			});
		</script>
		</div>
	<?php
	}
	
	/*function addNewMilestoneAttachment($projectId){ ?>
		<script type="text/javascript">
			//$('#add_milestone_attachment<?php echo $projectId; ?>').load('plugins/project_space/upload_form.php?project_id=<?php echo $projectId; ?>');
		</script>
	<?php
	}*/

	function addNewProjectQuery($project_title, $project_desc, $date_start, $date_end, $user_id){
	
		$assignProjectId = mysql_query("SELECT project_id FROM tbl_projects ORDER BY project_id DESC limit 1");
		$getNewProjectId = mysql_fetch_array($assignProjectId);
		
		if($getNewProjectId['project_id'] == ''){
			$newProjectId = 1;
		}else{
			$newProjectId = $getNewProjectId['project_id'] + 1;
		}

		//if(!in_array('4', $ifModeratorArr)){
			//echo "<script>alert('".$this->checkIfUserIsModerator($user_id)."');</script>";
			/// get publish roles ///
			$moderatorsGroup = '';
			$getProjectModeratorsGroup = mysql_query("SELECT tbl_users.user_id, tbl_user_group_role.role_id FROM tbl_users, tbl_user_group_role WHERE tbl_users.group_id = tbl_user_group_role.group_id AND tbl_user_group_role.role_id = 4") or die(mysql_error());
			while($moderatorsGroupRow = mysql_fetch_array($getProjectModeratorsGroup)){
				$moderatorsGroup = $moderatorsGroup.",".$moderatorsGroupRow['user_id'];
			}
			$moderatorsGroup = substr($moderatorsGroup, 1);
			
			$moderatorsUser = '';
			$getProjectModeratorsUser = mysql_query("SELECT tbl_users.user_id, tbl_user_group_role.role_id FROM tbl_users, tbl_user_group_role WHERE tbl_users.user_id = tbl_user_group_role.user_id AND tbl_user_group_role.role_id = 4");
			while($moderatorsUserRow = mysql_fetch_array($getProjectModeratorsGroup)){
				$moderatorsUser = $moderatorsUser.",".$moderatorsUserRow['user_id'];
			}
			$moderatorsUser = substr($moderatorsUser, 1);
			if($moderatorsGroup == ''){ $UsersThatPublish = $moderatorsUser; }
			else if($moderatorsUser == ''){ $UsersThatPublish = $moderatorsGroup; }
			else{ $UsersThatPublish = $moderatorsGroup.",".$moderatorsUser; }
			/// get publish roles ///

			/// get plugin access ///
			$moderatorsPluginLevel = '';
			$getPluginModeratorsLevel = mysql_query("SELECT tbl_users.user_id, tbl_user_level_plugins.plugin_id FROM tbl_users, tbl_user_level_plugins WHERE tbl_users.user_level_id = tbl_user_level_plugins.user_level_id AND tbl_user_level_plugins.plugin_id = 51");
			while($moderatorsPluginLevelRow = mysql_fetch_array($getPluginModeratorsLevel)){
				$moderatorsPluginLevel = $moderatorsPluginLevel.",".$moderatorsPluginLevelRow['user_id'];
			}
			$moderatorsPluginLevel = substr($moderatorsPluginLevel, 1);
			
			$moderatorsPluginUser = '';
			$getPluginModeratorUser = mysql_query("SELECT tbl_users.user_id, tbl_user_level_plugins.plugin_id FROM tbl_users, tbl_user_level_plugins WHERE tbl_users.user_id = tbl_user_level_plugins.user_id AND tbl_user_level_plugins.plugin_id = 51");
			while($moderatorsPluginUserRow = mysql_fetch_array($getPluginModeratorUser)){
				$moderatorsPluginUser = $moderatorsPluginUser.",".$moderatorsPluginUserRow['user_id'];
			}
			$moderatorsPluginUser = substr($moderatorsPluginUser, 1);
			$pluginsToAccess = $moderatorsPluginLevel.",".$moderatorsPluginUser;
			/// get plugin access ///
			
			$UsersThatPublishArr = explode(",", $UsersThatPublish);
			$pluginsToAccessArr = explode(",", $pluginsToAccess);
		
			$notifyModerators = '';
			foreach($UsersThatPublishArr as $UserThatPublish){
				if (in_array($UserThatPublish, $pluginsToAccessArr)) {
					$notifyModerators = $notifyModerators.",".$UserThatPublish;
				}
			}
			$notifyModerators = substr($notifyModerators, 1);
		
		//}
	
		if($this->checkIfUserIsModerator($user_id) == 1){
			$isModerator = 1;
			$addTextForRegUser = "";
			$notifyModerators = 1;
		}else{
			$isModerator = 0;
			$addTextForRegUser = " Awaiting for approval.";
		}
		
		/// query to add project to database ///
		$addNewProject = mysql_query("INSERT INTO tbl_projects SET project_id = ".$newProjectId.", project_title = '".addslashes($project_title)."', project_description = '".addslashes($project_desc)."', project_img = '', date_start = '".$date_start."', date_end = '".$date_end."', project_status = 'On Going', confirmation = '".$isModerator."', user_id = ".$user_id.", updated = '".$isModerator."', notification = '".$notifyModerators."'");
		
		$addCreatorToMembers = mysql_query("INSERT INTO tbl_project_members SET project_id = ".$newProjectId.", user_id = ".$user_id.", confirmation = 1, notification = 1");
		
		if($addNewProject){
            if ($this->checkIfUserIsModerator($user_id) == 1 && $isModerator == 1) {
                /*Whats Going on*/
                $mysql = mysql_query("SELECT project_img FROM tbl_projects WHERE project_id = '$newProjectId'");
                $result = mysql_fetch_array($mysql);
                
                if ($result['project_img'] == '') {
                    $img_src = 'plugins/project_space/project_img/default.jpg';
                } else {
                    $img_src = 'plugins/project_space/project_img/'.$newProjectId.'/'.$result['project_img'];
                }

                $dateRec = date('Y-m-d H:i:s', time());
                
                $reqServer = $_SERVER['REQUEST_URI'];
                $exServer = explode("/", $reqServer);
                
                if ($exServer[1] == 's3') {
                    $url = "http://".$_SERVER['SERVER_NAME']."/s3/intranet/";
                } elseif ($exServer[1] == 'intranet') {
                    $url = "http://".$_SERVER['SERVER_NAME']."/intranet/";
                } else {
                    $url = "http://".$_SERVER['SERVER_NAME']."/";
                }
                
                $text = '<div class="whatsProfContent">
                            <div class="urlThumbnails"><a href="'.$url.'?module=project_space&details='.$newProjectId.'"><img src="'.$img_src.'" width="90" /></a></div>
                            <div class="forceURLDate">
                                <div><a href="'.$url.'?module=project_space&details='.$newProjectId.'">'.stripslashes($project_title).'</a></div>
                                <div style="margin-top: 5px">'.$this->__shortenString(strip_tags($project_desc), 300).'</div>
                            </div>
                            <div class="clear"></div>
                        </div>';

                $msg = 'has created a new project on';
                
                $plugdir = 'project_space';
                
                $this->__whatsGoinOn($text, $dateRec, $user_id, $plugdir, $msg);
            }
            /*end*/
            
			echo "<script type='text/javascript'>
					
					$('#add_new_project_msg').text('New Project was successfully added.".$addTextForRegUser."').addClass('txt_green01');
					$('#add_project_title').val('');
					$('#add_project_desc').val('');
					$('#add_project_date_start').val('');
					$('#add_project_date_end').val('');
				</script>";
		}
		/*$('#add_project_form').delay(2000).fadeOut();
		$('#add_project_form_bg').delay(2000).fadeOut();*/
	}
	
	function viewAllProjects($searchString, $userId, $limit){ // show list of all projects (only projects confirmed by admin)
		//echo "<script>alert('".$limit."');</script>";
		if($limit == ''){ $limit = 5; }
		
		if($searchString == ''){
			$projectList = mysql_query("SELECT * FROM tbl_projects WHERE confirmation = 1 ORDER BY project_id DESC LIMIT ".$limit."");
			$totalProjects = mysql_query("SELECT * FROM tbl_projects WHERE confirmation = 1 ORDER BY project_id");
		}
		else{
			$projectList = mysql_query("SELECT * FROM tbl_projects WHERE project_title LIKE '%".$searchString."%' AND confirmation = 1 ORDER BY project_id DESC LIMIT ".$limit."");
			$totalProjects = mysql_query("SELECT * FROM tbl_projects WHERE project_title LIKE '%".$searchString."%' AND confirmation = 1 ORDER BY project_id");
		}
		?>
		<input type="hidden" id="view_more_limit" value="<?php echo $limit; ?>" />
		<?php
		//echo $userId;
		
		$char_limit = 100; // text limit of the project description
		
		if(mysql_num_rows($projectList) == 0){
			echo "<span class='txt_red01'>No projects found</span>";
		}
		
		else{
			while($row = mysql_fetch_array($projectList)){ ?>
				<div id="project<?php echo $row['project_id']; ?>" class="project">
                	<div class="title_header">
                        <span class="project_status">
                            <div id="project_status_result<?php echo $row['project_id']; ?>"></div>
                            <!--<?php if($row['user_id'] == $userId){ ?>
                                <div id="edit_project_status_input_bg<?php echo $row['project_id']; ?>"></div>
                                <select id="edit_project_status_input<?php echo $row['project_id']; ?>">
                                    <option value="On Going" <?php if($row['project_status']=='On Going'){ echo "selected"; } ?> >On Going</option>
                                    <option value="On Hold" <?php if($row['project_status']=='On Hold'){ echo "selected"; } ?> >On Hold</option>
                                    <option value="Cancelled" <?php if($row['project_status']=='Canceled'){ echo "selected"; } ?> >Canceled</option>
                                    <option value="Completed" <?php if($row['project_status']=='Completed'){ echo "selected"; } ?> >Completed</option>
                                </select>
                                <span id="edit_project_status<?php echo $row['project_id']; ?>"><?php $this->getProjectStatus($row['project_id']); ?></span>
                            <?php }  else { echo $this->getProjectStatus($row['project_id']); } ?>-->
                            <div style="float: left">Start <?php echo $row['date_start']; ?>&nbsp; | &nbsp;End <?php echo $row['date_end']; ?></div>
                            <div style="float: right;"><span id="edit_project_status2<?php echo $row['project_id']; ?>"><span class="status_indicator"><?php $this->getProjectStatus($row['project_id']); ?></span></span></div>
                            <div class="clear"></div>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <br />
                    <span class="project_title"><?php echo stripslashes($row['project_title']); ?></span></span>
                    <br/> 
					<span class="project_creator"><?php echo $this->getProjectCreator($row['project_id'], $row['user_id']); ?></span> 
					<?php
					$project_description = substr($row['project_description'], 0, $char_limit); 
					?>
					<div class="project_description"><?php echo stripslashes($project_description); ?>...<div class="clear"></div>
						<a href="#top"><div id="view_project<?php echo $row['project_id']; ?>" class="view_project"><button class="silver_01">View Project</button></div></a>
					</div> 
				</div>
                <div class="clear"></div>
			<?php
			$this->showProjectDetails($row['project_id'], $userId);
			$this->viewCss($row['project_id']);
			$this->viewJquery($row['project_id'], $userId);
			}
			$this->viewMoreProjects($limit, mysql_num_rows($totalProjects),$userId, $searchString);
		}
	}
	
	function getProjectStatus($projectId){
		$getProjectStatus = mysql_query("SELECT project_status FROM tbl_projects WHERE project_id = ".$projectId."");
		$getProjectStatusDetail = mysql_fetch_array($getProjectStatus);		
		$project_status = $getProjectStatusDetail['project_status'];		
		echo $project_status;
	}
	
	function getProjectDescription($projectId){
		$getProjectDescription = mysql_query("SELECT project_description FROM tbl_projects WHERE project_id = ".$projectId."");
		$getProjectDescriptionDetail = mysql_fetch_array($getProjectDescription);		
		$project_description = $getProjectDescriptionDetail['project_description'];	
		//$project_description = str_replace("<br/>", " ", $project_description);
		echo stripslashes($project_description);
	}

	function getProjectCreator($projectId, $userId){ /////// can be displayed in project page ///////
		$getProjectCreator = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.user_id FROM tbl_users, tbl_projects WHERE tbl_users.user_id = tbl_projects.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_projects.user_id = ".$userId);
		
		$projectCreator = mysql_fetch_array($getProjectCreator);
		$projectCreatorName = $projectCreator['firstname']." ".$projectCreator['lastname'];
		
		return "Project Creator: <a href='?module=myprofile&id=".$userId."'>".$projectCreatorName."</a>";
	}
	
	function getProjectCreatorID($projectId, $userId){ /////// can be displayed in project page ///////
		$getProjectCreator = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.user_id FROM tbl_users, tbl_projects WHERE tbl_users.user_id = tbl_projects.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_projects.user_id = ".$userId);
		
		$projectCreator = mysql_fetch_array($getProjectCreator);
		$userId = $projectCreator['user_id'];
		
		return $userId;
	}
	
	function viewMoreProjects($limit, $numOfProjects, $userId, $searchString){
		if($numOfProjects <= $limit){ ?>
			<div id="no_more_projects" class="noMoreRecords">No more projects to show</div>
		<?php
		}
		else{
			?>
			<div id="view_more_projects" class="loadMoreRecords"><span><img src="plugins/project_space/css/images/load_icon.gif" class="valignb marr6 null_efx" />Load More</span></div>
			<script type="text/javascript">
				$('#view_more_projects').live('click', function() {
					var oldlimit = $('#view_more_limit').val();
					var newlimit = parseInt(oldlimit) + 5;
					
					$('#view_more_projects').text('loading...');
					$('#project_list').load( 'plugins/project_space/controller2.php?action=updateprojectlist&limit=' + newlimit + '&user_id=<?php echo $userId; ?>&searchstring=<?php echo $searchString; ?>');
				});
			</script>
		<?php
		}
	}
	
	// css in a loop //
	function viewCss($projectId){ ?> 
		<style type="text/css">
			.project_notification{
				/*position: relative;
				float: left;*/
			}
		
			#projectDetails<?php echo $projectId; ?>{
				float: left;
				display: none;
				width: inherit;
				background-color: #EDEDED;
				padding: 20px;
				z-index: 20;
				/*border: 1px solid WHITE;*/
				min-height: 720px;
			}
			#projectDetailsbg<?php echo $projectId; ?>{
				position: absolute;
				float: left;
				display: none;
				width: inherit;
				height: 100%;
				top: -142px;
				left: -20px;
				bottom: 0;
				background-color: #EDEDED;
				padding: 20px;
				z-index: 15;
				margin-bottom:10px;
			}
			
			#whatAmIWorkingOn<?php echo $projectId; ?>{
				width: 77%;
				
				margin-top: 10px;
			}
			
			#view_project_description<?php echo $projectId; ?>{
				position: relative;
				float: left;
				cursor: pointer;
			}
			
			#project_description_popup<?php echo $projectId; ?>{
				position: absolute;
				border: 1px solid #bbb;
				min-width: 200px;
				min-height: 200px;
				z-index: 100;
				display: none;
				left: -52px;
				top: 0px;
				width: 322px;
				
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			
			#project_description_popup_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#close_project_description_popup<?php echo $projectId; ?>{
				position: relative;
				float: right;
			}
			
			#update_project_description_popup<?php echo $projectId; ?>{
				position: relative;
				float: right;
				display: none;
			}
			
			#close<?php echo $projectId; ?>{
				position: relative;
				float: right;
				cursor: pointer;
			}
			
			#add_project_members<?php echo $projectId; ?>{
				position: absolute;
				margin-left: 90px;
				width: 300px;
				display: none;
				z-index: 100;

				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			#add_project_members_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#add_project_memberslist<?php echo $projectId; ?>{
				width: 100%;
				height: 400px;
				overflow-y: auto;
				overflow-x: hidden;
				margin-top: 20px;
			}
			
			#close_add_members<?php echo $projectId; ?>, #add_members<?php echo $projectId; ?>{
				position: relative;
				float: right;
			}
			
			#add_project_members_btn<?php echo $projectId; ?>, #close_add_members<?php echo $projectId; ?>, #add_members<?php echo $projectId; ?>{
				cursor: pointer;
			}
			
			#bgdisabler<?php echo $projectId; ?>{
				position: absolute;
				width: 100%;
				height: 100%;
				background: none;
				top: 0;
				left: 0;
				display: none;
				z-index: 10;
				opacity: 0.4;
				filter: alpha(opacity=40);
			}
			
			#whatAmIWorkingOn_btn<?php echo $projectId; ?>{
				position: relative;
				float: right;
				cursor: pointer;
				z-index: 0;
				margin-top: 10px;
			}
			
			#whatAmIWorkingOn_btn<?php echo $projectId; ?>:hover{
				text-decoration: none !important;
			}
			
			#view_more_project_posts<?php echo $projectId; ?>{
				position: relative;
				float: left;
				cursor: pointer;
				text-shadow: 1px 1px white;
				background-color: #D5ECF9;
				border: 1px solid #B3DDF3;
				margin-top: 10px;
				padding: 6px;
				text-align: center;
				-moz-box-shadow: inset 0px 0px 0px 1px #eff5f9;
				-webkit-box-shadow: inset 0px 0px 0px 1px #EFF5F9;
				box-shadow: inner 0px 0px 0px 1px #EFF5F9;
				color: #1977AD;
				width: 96%;
			}
			
			#view_more_project_posts<?php echo $projectId; ?>:hover{
				text-decoration: underline;
			}
			
			#no_more_project_posts<?php echo $projectId; ?>{
				position: relative;
				float: left;
				width: 96%;
				color: #686868;
				text-shadow: 1px 1px 	white;
				background-color: #E6E6E8;
				border: 1px solid #CBCBCD;
				margin-top: 10px;
				padding: 6px;
				text-align: center;
				-moz-box-shadow: inset 0px 0px 0px 1px #eff5f9;
				-webkit-box-shadow: inset 0px 0px 0px 1px #EFF5F9;
				box-shadow: inner 0px 0px 0px 1px #EFF5F9;
			}
			
			#upload_project_image<?php echo $projectId; ?>{
			}
			
			#add_project_milestones_btn<?php echo $projectId; ?>{
				cursor: pointer;
			}
			
			#add_project_milestones<?php echo $projectId; ?>{
				position: fixed;
				top: 316px;
				left: 436px;
				z-index: 100;
				display: none;
				width: 354px;
				
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			#add_project_milestones_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#add_milestone_btn<?php echo $projectId; ?>{
				position: relative;
				float: left;
				cursor: pointer;
				font-family: 'CicleGordita';
				font-size: 1.25em;
				letter-spacing: 0.035em;
				cursor: pointer;
				margin: 0;
				color: white;
				background-color: #e68a1b;
				text-shadow: 1px 1px #ac6614;
				height: 30px;
				border: #fff 1px solid;
				padding: 0 15px 0 15px;
				background: -moz-linear-gradient( 
					top,
					#ff991e,
					#cf7c18);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#ff991e),
					to(#cf7c18));
				-moz-box-shadow: 1px 2px 3px 0px #acacac;    /*** Box Shadow ***/
				-webkit-box-shadow: 1px 2px 3px 0px #acacac;
				box-shadow: 1px 2px 3px 0px #acacac;
				border-radius: 2px;  /*** Rounded Corner ***/
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
				line-height: 30px;
			}
			
			#add_milestone_btn<?php echo $projectId; ?>:hover{
				background: -moz-linear-gradient(
				top,
				#f2911c,
				#b96500);
			background: -webkit-gradient(
				linear, left top, left bottom, 
				from(#f2911c),
				to(#b96500));
			text-decoration: none !important;
			}
			
			#close_add_milestone<?php echo $projectId; ?>{
				position: relative;
				float: right;
				cursor: pointer;
				margin: 0 0 0 20px;
			}
			
			#upload_project_img_btn<?php echo $projectId; ?>, #close_project_img_upload_form<?php echo $projectId; ?>{
				position: relative;
				float: left;
				cursor: pointer;
			}
			
			#project_img_upload_form<?php echo $projectId; ?>{
				position: absolute;
				float: left;
				top: 20%;
				width: 300px;
				margin-left: 130px;
				z-index: 1000;
				display: none;
				line-height: 11px;
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			
			#done_project_img_upload_form<?php echo $projectId; ?>, #close_project_img_upload_form<?php echo $projectId; ?>, #upload_project_img<?php echo $projectId; ?>{
				position: relative;
				float: left;
			}
			
			#view_all_project_milestones<?php echo $projectId; ?>{
				position: fixed;
				float: left;
				z-index: 1000;
				top: 150px;
				left: 410px;
				display: none;
				z-index: 20;
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
				width: 400px;
			}
			#view_all_project_milestones_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#edit_project_status<?php echo $projectId; ?>{
				color: #598E30;
			}
			
			#edit_project_status<?php echo $projectId; ?>:hover{
				cursor: pointer;
			}
			
			#edit_project_status_input<?php echo $projectId; ?>{
				display: none;
				position: absolute;
				font-family: 'CicleGordita';
				background-color: whiteSmoke;
				color: #069;
				padding: 5px 5px 5px 5px;
				letter-spacing: 1px;
				text-shadow: 1px 1px #fff;  /*** TEXT SHADOW ***/
				border: 1px solid #dedede;
				-moz-box-shadow: 0px 0px 0px 1px #fff,		/* BOX SHADOW */
							inset 1px 1px 1px #e1e1e1;			/* INNER SHADOW */
				-webkit-box-shadow: 0px 0px 0px 1px #fff,	/* BOX SHADOW */
							inset 1px 1px 1px #e1e1e1;			/* INNER SHADOW */
				box-shadow: 0px 0px 0px 1px #fff,			/* BOX SHADOW */
							inner 1px 1px 1px #e1e1e1;			/* INNER SHADOW */
				letter-spacing: 1px;
				margin: 0;
				font-size: 1.000em;/* Resize Font*/
				text-shadow: none;
				vertical-align: middle;
				width: 112px;
			}
			#edit_project_status_input_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: none;
				opacity: 0.7;
				filter: alpha(opacity=70);
				z-index: 0;
			}
			
			#project_img_upload_form_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				height: 100%; 
				width: 100%;
				overflow: auto;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 1;
			}
			
			#view_more_project_members_btn<?php echo $projectId; ?>{
				position: relative;
				float: left;
			}
			
			#view_project_members<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				float: left;
				z-index: 100;
				left: 432px;
				top: 150px !important;
				width: 360px;
				height: 450px;
				
				
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			#show_all_milestone_attachments_popup<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				float: left;
				z-index: 100;
				left: 432px;
				top: 150px !important;
				width: 360px;		
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			
			#view_project_members_bg<?php echo $projectId; ?>, #show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#edit_project_description_input<?php echo $projectId; ?>{
				display: none;
				position: relative;
				height: 166px;
				width: 300px;
			}
			
			#edit_project_description<?php echo $projectId; ?>{
				height: 166px;
				overflow: auto;
			}
			#edit_project_description<?php echo $projectId; ?>:hover{
				color: #b8b8b8;
			}
			
			#view_more_project_documents_btn<?php echo $projectId; ?>{
				position: relative;
				float: left;
				width: 100%;
				cursor: pointer;
				margin-top: 4px;
			}
			
			#project_posts<?php echo $projectId; ?>{
				position: relative;
				height: 100%;
				margin-bottom: 20px;
				top: 0;
				bottom: 0;
			}
			
			
		</style>
	<?php
	}
	
	// jquery in a loop //
	function viewJquery($projectId, $userId){ ?>
		<script type="text/javascript">
			$(function() {
				var plug_path = 'plugins/project_space/';
				
				var mid_main_position = $('#mid_main').position();
				$('#projectDetails<?php echo $projectId; ?>').css('top', mid_main_position.top + 'px' );
				$('#projectDetails<?php echo $projectId; ?>').css('left', mid_main_position.left + 'px' );
				$('#projectDetails<?php echo $projectId; ?>').css('position', 'fixed' );
				$('#projectDetails<?php echo $projectId; ?>').css('width', $('#mid_main').width() + 'px' );
				
				var side_project_milestone_position = $('#project_milestones<?php echo $projectId; ?>').position();
				
				$(window).scroll(function(){
					var $win = $(window);
					$('#projectDetails<?php echo $projectId; ?>').css('top', mid_main_position.top -$win.scrollTop());
					$('#view_project_members<?php echo $projectId; ?>').css('top', mid_main_position.top -$win.scrollTop());
					//$('#add_project_milestones<?php echo $projectId; ?>').css('top', mid_main_position.top -$win.scrollTop() + 300);
					//$('#view_all_project_milestones<?php echo $projectId; ?>').css('top', mid_main_position.top -$win.scrollTop() + 300);
					$('#show_all_milestone_attachments_popup<?php echo $projectId; ?>').css('top', mid_main_position.top -$win.scrollTop() + 400);
				});
				
				$('#view_project<?php echo $projectId; ?>').live('click', function() {
					$('#projectDetails<?php echo $projectId; ?>').show();
					
					/// align projects list height on project details ///
					var projectDetails_height<?php echo $projectId; ?> = $('#projectDetails<?php echo $projectId; ?>').height();
					$('#project_list').css('height', projectDetails_height<?php echo $projectId; ?> + 'px' );
					$('#project_list').css('position' , 'absolute');
					$('.project').hide();
					
					if(projectDetails_height<?php echo $projectId; ?> > 720){
						$('#mid_main').css('height', projectDetails_height<?php echo $projectId; ?> + 'px' );
					}
				});
				
				$('#close<?php echo $projectId; ?>').click( function() {
					$('#projectDetails<?php echo $projectId; ?>').hide();
					$('#project_posts<?php echo $projectId; ?>').text('loading...');
					$('#project_posts<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatewhatamiworkingon&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>' );
					$('#div a').attr('href', 'http://192.168.4.148/projects/wesm/intranet/?module=project_space');
					//$('#div a').attr('href', 'http://192.168.4.148/projects/wesm/intranet/?module=project_space#<?php echo $projectId; ?>');
					$('.project').show();
					$('#project_list').css('position' , 'relative');
					$('#project_list').css('height', '' );
					$('#mid_main').css('height', '');
				});
				
				/*$('#projectDetailsbg<?php echo $projectId; ?>').click( function() {
					$('#projectDetails<?php echo $projectId; ?>').hide();
					$('#project_posts<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatewhatamiworkingon&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>' );
					$('#projectDetailsbg<?php echo $projectId; ?>').fadeOut();
				});*/
				
				$('#upload_project_img_btn<?php echo $projectId; ?>').click(function(){
					$('#project_img_upload_form<?php echo $projectId; ?>').show();
					$('#project_img_upload_form_bg<?php echo $projectId; ?>').fadeIn();
					$('#upload_project_img<?php echo $projectId; ?>').show();
					//$('#upload_project_img<?php echo $projectId; ?>').load('plugins/project_space/image_upload_form.php?project_id=<?php echo $projectId; ?>' );
						$('#add_project_milestones<?php echo $projectId; ?>').hide();
						$('#add_milesone_title_err<?php echo $projectId; ?>').hide();
						$('#add_milesone_desc_err<?php echo $projectId; ?>').hide();
						$('.add_milestone_attachment').text('loading...');
						$('.add_milestone_attachment').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
				});
				
				$('#done_project_img_upload_form<?php echo $projectId; ?>').click(function() {
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updateprojectimage&project_id=<?php echo $projectId; ?>' );
					//$('.upload_project_img').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
					$('#project_img_upload_form<?php echo $projectId; ?>').hide();
					$('#project_img_upload_form_bg<?php echo $projectId; ?>').fadeOut();
					$('#files<?php echo $projectId; ?>').html('');
				});
				
				$('#close_project_img_upload_form<?php echo $projectId; ?>').click(function() {
					/*$('#result<?php echo $projectId; ?>').load( plug_path + 'controller2.php?action=updateprojectimage&project_id=<?php echo $projectId; ?>' );*/
					//$('.upload_project_img').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
					$('#project_img_upload_form_bg<?php echo $projectId; ?>').fadeOut();
					$('#project_img_upload_form<?php echo $projectId; ?>').hide();
					$('#files<?php echo $projectId; ?>').html('');
				});
				
				$('#add_project_members_btn<?php echo $projectId; ?>').click(function() {
					$('#add_project_members<?php echo $projectId; ?>').show();
					$('#add_project_members_bg<?php echo $projectId; ?>').fadeIn();
					//$('#bgdisabler<?php echo $projectId; ?>').show();
				});
				
				/*$('#bgdisabler<?php echo $projectId; ?>').click(function(){
					$('#add_project_members<?php echo $projectId; ?>').hide();
					$('#bgdisabler<?php echo $projectId; ?>').hide();
				});*/
				
				//$('#add_members<?php echo $projectId; ?>').click(function() {
				$('#add_members<?php echo $projectId; ?>').live("click", function() { 
					var projectmembercheckbox<?php echo $projectId; ?> = $('input[name=projectmembercheckbox<?php echo $projectId; ?>]:checked').map(
					function () {return this.value;}).get().join(',');
					
					if(projectmembercheckbox<?php echo $projectId; ?> != ""){
						$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=addprojectmembers&project_id=<?php echo $projectId; ?>&project_members=' + projectmembercheckbox<?php echo $projectId; ?> + '&user_id=<?php echo $userId; ?>' );
						$('#view_more_project_members_btn<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=reloadviewmoremembers&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>');
						$('#view_project_memberslist<?php echo $projectId; ?>').text('loading...');
						$('#view_project_memberslist<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=updateviewmoreprojectmembers&project_id=<?php echo $projectId; ?>');
					}
					else{
						$('#addmembersmsg<?php echo $projectId; ?>').text('Please Select Members');
					}
				});
				
				$('#close_add_members<?php echo $projectId; ?>').click(function(){
					$('#add_project_members<?php echo $projectId; ?>').hide();
					$('#add_project_members_bg<?php echo $projectId; ?>').fadeOut();
					$('.addmembersmsg').html('&nbsp;');
					//$('#bgdisabler<?php echo $projectId; ?>').hide();
				});
				$('#add_project_members_bg<?php echo $projectId; ?>').click(function(){
					$('#add_project_members<?php echo $projectId; ?>').hide();
					$('.addmembersmsg').html('&nbsp;');
					$('#add_project_members_bg<?php echo $projectId; ?>').fadeOut();
				});
				
				$('#whatAmIWorkingOn_btn<?php echo $projectId; ?>').click(function() {
					var whatAmIWorkingOn<?php echo $projectId; ?> = $('#whatAmIWorkingOn<?php echo $projectId; ?>').val();
					var whatAmIWorkingOn<?php echo $projectId; ?> = $.trim(whatAmIWorkingOn<?php echo $projectId; ?>);
					
					if(whatAmIWorkingOn<?php echo $projectId; ?> != ''){
						var whatAmIWorkingOn<?php echo $projectId; ?> = whatAmIWorkingOn<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
						var whatAmIWorkingOn<?php echo $projectId; ?> = whatAmIWorkingOn<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
						var whatAmIWorkingOn<?php echo $projectId; ?> = whatAmIWorkingOn<?php echo $projectId; ?>.replace(/\"/g,'\\"');
						var whatAmIWorkingOn<?php echo $projectId; ?> = whatAmIWorkingOn<?php echo $projectId; ?>.replace(/\0/g,'\\0');
						var whatAmIWorkingOn<?php echo $projectId; ?> = escape(whatAmIWorkingOn<?php echo $projectId; ?>);
						
						$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=postwhatamiworkingon&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>&post=' + whatAmIWorkingOn<?php echo $projectId; ?> );
						$('#whatAmIWorkingOn<?php echo $projectId; ?>').val('');
					}
				});
				
				$('#add_project_milestones_btn<?php echo $projectId; ?>').click(function() {
					var milestone_id<?php echo $projectId; ?> = $('#milestone_id<?php echo $projectId; ?>').val();
					$('#add_project_milestones<?php echo $projectId; ?>').show();
					$('#add_project_milestones<?php echo $projectId; ?>').css('top', '195px');
					$('#add_project_milestones_bg<?php echo $projectId; ?>').show();
					//$('#add_milestone_attachment<?php echo $projectId; ?>').load('plugins/project_space/upload_form.php?project_id=<?php echo $projectId; ?>&milestone_id=' + milestone_id<?php echo $projectId; ?> );
					//$('.upload_project_img').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
					//$('#project_img_upload_form<?php echo $projectId; ?>').hide();
				});
				
				$('#edit_project_status<?php echo $projectId; ?>').click(function() {
					$('#edit_project_status_input<?php echo $projectId; ?>').show();
					$('#edit_project_status_input<?php echo $projectId; ?>').focus();
					$('#edit_project_status_input_bg<?php echo $projectId; ?>').show();
				});
				
				$('#edit_project_status_input_bg<?php echo $projectId; ?>').click(function() {
					var project_status<?php echo $projectId; ?> = $("#edit_project_status_input<?php echo $projectId; ?>").val();
					var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
					var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
					var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\"/g,'\\"');
					var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\0/g,'\\0');
					var project_status<?php echo $projectId; ?> = escape(project_status<?php echo $projectId; ?>);
					
					if(project_status<?php echo $projectId; ?> == ''){
						var error = 'y';
					}
					if(error != 'y'){
						$('#edit_project_status_input<?php echo $projectId; ?>').hide();
						$('#edit_project_status_input_bg<?php echo $projectId; ?>').hide();
					}
				});
				
				$("#edit_project_status_input<?php echo $projectId; ?>").change(function(event){
					//var keycode<?php echo $projectId; ?> = (event.keyCode ? event.keyCode : event.which);
					//if(keycode<?php echo $projectId; ?> == '13'){
						var project_status<?php echo $projectId; ?> = $("#edit_project_status_input<?php echo $projectId; ?>").val();
						var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
						var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
						var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\"/g,'\\"');
						var project_status<?php echo $projectId; ?> = project_status<?php echo $projectId; ?>.replace(/\0/g,'\\0');
						var project_status<?php echo $projectId; ?> = escape(project_status<?php echo $projectId; ?>);
						
						if(project_status<?php echo $projectId; ?> == ''){
							var error = 'y';
						}
						
						if(error != 'y'){
							$('#project_status_result<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=updateprojectstatus&project_id=<?php echo $projectId; ?>&project_status=' + project_status<?php echo $projectId; ?> + '&user_id=<?php echo $userId; ?>');
							$('#edit_project_status_input<?php echo $projectId; ?>').hide();
							$('#edit_project_status_input_bg<?php echo $projectId; ?>').hide();
						}
					//}
				});
				
				$('#view_more_project_documents_btn<?php echo $projectId; ?>').click(function(){
					$('#show_all_milestone_attachments_popup<?php echo $projectId; ?>').show();
					$('#show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>').show();
				});

				$('#view_project_description<?php echo $projectId; ?>').click(function() {
					$('#project_description_popup<?php echo $projectId; ?>').show();
					$('#project_description_popup_bg<?php echo $projectId; ?>').fadeIn();
					$('.proj_desc_err').text('');
				});
				
				$('#close_project_description_popup<?php echo $projectId; ?>').click(function(){
					//$('#edit_project_description_input<?php echo $projectId; ?>').val('<?php echo $this->getProjectDescription($projectId); ?>');
					$('#edit_project_description_input<?php echo $projectId; ?>').hide();
					$('#edit_project_description<?php echo $projectId; ?>').show();
					$('#project_description_popup<?php echo $projectId; ?>').hide();
					$('#project_description_popup_bg<?php echo $projectId; ?>').fadeOut();
				});
				
				$('#project_description_popup_bg<?php echo $projectId; ?>').click(function(){
					//$('#edit_project_description_input<?php echo $projectId; ?>').val('<?php echo $this->getProjectDescription($projectId); ?>');
					$('#edit_project_description_input<?php echo $projectId; ?>').hide();
					$('#edit_project_description<?php echo $projectId; ?>').show();
					$('#project_description_popup<?php echo $projectId; ?>').hide();
					$('#project_description_popup_bg<?php echo $projectId; ?>').fadeOut();
				});
				
				$('#edit_project_description<?php echo $projectId; ?>').click(function(){
					$('#edit_project_description_input<?php echo $projectId; ?>').val($("#edit_project_description<?php echo $projectId; ?>").text());
					$('#edit_project_description<?php echo $projectId; ?>').hide();
					$('#edit_project_description_input<?php echo $projectId; ?>').show();
					$('#update_project_description_popup<?php echo $projectId; ?>').show();
				});
				
				$('#update_project_description_popup<?php echo $projectId; ?>').click(function(){
					var project_description<?php echo $projectId; ?> = $("#edit_project_description_input<?php echo $projectId; ?>").val();
					var project_description<?php echo $projectId; ?> = project_description<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
					var project_description<?php echo $projectId; ?> = project_description<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
					var project_description<?php echo $projectId; ?> = project_description<?php echo $projectId; ?>.replace(/\"/g,'\\"');
					var project_description<?php echo $projectId; ?> = project_description<?php echo $projectId; ?>.replace(/\0/g,'\\0');
					var project_description<?php echo $projectId; ?> = $.trim(project_description<?php echo $projectId; ?>);
					
					if(project_description<?php echo $projectId; ?> == ''){
						$('.proj_desc_err').show();
						$('.proj_desc_err').text('Please fill up project description');
						var error = 'y';
					}
					
					if(error != 'y'){
						//$('#edit_project_description_input<?php echo $projectId; ?>').load('plugins/project_space/controller.php?action=updateprojectdesc?project_id=<?php echo $projectId; ?>');
						//$('#edit_project_description_input<?php echo $projectId; ?>').val(project_description<?php echo $projectId; ?>);
						
						var project_description<?php echo $projectId; ?> = escape(project_description<?php echo $projectId; ?>);
						var project_description<?php echo $projectId; ?> = project_description<?php echo $projectId; ?>.replace(/\%0A/g,'<br/>')
						
						$('.proj_desc_err').show();
						$('.proj_desc_err').text('Project description updated successfully');
						$('.proj_desc_err').fadeOut(5000);
						$('#project_description_result<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=updateprojectdescription&project_id=<?php echo $projectId; ?>&project_description=' + project_description<?php echo $projectId; ?> + '&user_id=<?php echo $userId; ?>');
						$('#edit_project_status_input<?php echo $projectId; ?>').hide();
						$('#edit_project_status_input_bg<?php echo $projectId; ?>').hide();

						$('#edit_project_description_input<?php echo $projectId; ?>').hide();
						$('#edit_project_description<?php echo $projectId; ?>').text('loading');
						$('#edit_project_description<?php echo $projectId; ?>').show();
						
						$('#update_project_description_popup<?php echo $projectId; ?>').hide();
					}
				});
				
				$('#view_more_project_milestones_btn<?php echo $projectId; ?>').click(function(){
					$('#view_all_project_milestones<?php echo $projectId; ?>').show();
					$('#view_all_project_milestones_bg<?php echo $projectId; ?>').show();
				});
			});	
		</script>
	<?php
	}
	
	function updateProjectDescription($projectId, $project_description, $user_id){
		$updateProjectDescription = mysql_query("UPDATE tbl_projects SET project_description = '".addslashes($project_description)."' WHERE project_id = ".$projectId."");
		
		if($updateProjectDescription){
			echo "<script type='text/javascript'>
				$('#edit_project_description".$projectId."').load('plugins/project_space/controller2.php?action=updateprojectdesc&project_id=".$projectId."');
			</script>";
		}
	}
	
	function updateProjectStatus($projectId, $projectStatus){
		$updateProjectStatus = mysql_query("UPDATE tbl_projects SET project_status = '".$projectStatus."' WHERE project_id = ".$projectId."");
		
		if($updateProjectStatus){
			echo "<script type='text/javascript'>
				$('#edit_project_status".$projectId."').load('plugins/project_space/controller2.php?action=updateprojectinfo&project_id=".$projectId."');
				$('#edit_project_status2".$projectId."').load('plugins/project_space/controller2.php?action=updateprojectinfo&project_id=".$projectId."');
			</script>";
		}
		
	}
	
	//////////////////////////////// for display project page ////////////////////////////////
	
	function uploadProjectMilestone($projectId, $milestoneId){ ?>
		<div id="upload_milestone<?php echo $projectId.$milestoneId; ?>"><span>Upload File</span></div><span id="status<?php echo $projectId.$milestoneId; ?>" class="upload_status"></span>
		<ul id="files<?php echo $projectId.$milestoneId; ?>" ></ul>
		<!-- CSS -->
		<style type="text/css">
			#upload_milestone<?php echo $projectId.$milestoneId; ?>{
				line-height: 30px;
				width: 78px;
				font-family: 'CicleGordita';
				font-size: 1.25em;
				letter-spacing: 1px;
				cursor: pointer;
				margin: 8px 0 0 0;
				border: #fff 1px solid;
				color: #15b6ec;
				background-color: #e5e5e5;
				text-shadow: 1px 1px #fff;
				height: 30px;
				padding: 0 10px 0 10px;
				background: -moz-linear-gradient( 
					top,
					#f2f2f2,
					#dbdbdb);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#f2f2f2),
					to(#dbdbdb));
					-moz-box-shadow: 1px 2px 3px 0px #acacac;
					-webkit-box-shadow: 1px 2px 3px 0px #acacac3;
					box-shadow: 1px 2px 3px 0px #acacac;
				border-radius: 2px;  
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
			}
			
			#upload_milestone<?php echo $projectId.$milestoneId; ?>:hover{	
				color: #069;
				background: -moz-linear-gradient(
					top,
					#eaeaea,
					#c9c9c9);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#eaeaea),
					to(#c9c9c9));
			}
			.darkbg<?php echo $projectId.$milestoneId; ?>{
				background:#ddd !important;
			}
			#status<?php echo $projectId.$milestoneId; ?>{
				font-family:Arial; padding:5px;
			}
			ul#files<?php echo $projectId.$milestoneId; ?>{ list-style:none; padding:0; margin:0; }
			ul#files<?php echo $projectId.$milestoneId; ?> li{ width:188px; float:left;}
			ul#files<?php echo $projectId.$milestoneId; ?> li img{ max-width:180px; max-height:150px; }
			.success<?php echo $projectId.$milestoneId; ?>{ background:#99f099; border:1px solid #339933; }
			.error<?php echo $projectId.$milestoneId; ?>{ background:#f0c6c3; border:1px solid #cc6622; }
		</style>
		
		<!-- Javascript -->
		<script type="text/javascript" >
		$(function(){
			var btnUpload<?php echo $projectId.$milestoneId; ?>=$('#upload_milestone<?php echo $projectId.$milestoneId; ?>');
			var status<?php echo $projectId.$milestoneId; ?>=$('#status<?php echo $projectId.$milestoneId; ?>');

			new AjaxUpload(btnUpload<?php echo $projectId.$milestoneId; ?>, {
				action: 'plugins/project_space/includes/upload-milestone.php',
				name: 'uploadfile<?php echo $projectId.$milestoneId; ?>',
				data: {milestone_id: <?php echo $milestoneId; ?>, project_id: <?php echo $projectId; ?>},
				onSubmit: function(file<?php echo $projectId.$milestoneId; ?>, ext<?php echo $projectId.$milestoneId; ?>){
					 if (! (ext<?php echo $projectId.$milestoneId; ?> && /^(doc|docx|xls|xlsx|jpg|jpeg|png|gif|pdf)$/.test(ext<?php echo $projectId.$milestoneId; ?>))){
						// extension is not allowed
						status<?php echo $projectId.$milestoneId; ?>.text('Only .doc, .pdf, .xls, .jpg, .png or .gif files are allowed');
						return false;
					}
					status<?php echo $projectId.$milestoneId; ?>.text('Uploading...');
				},
				onComplete: function(file<?php echo $projectId.$milestoneId; ?>, response<?php echo $projectId.$milestoneId; ?>){
					//On completion clear the status
					status<?php echo $projectId.$milestoneId; ?>.text('');
					
					var myString = file<?php echo $projectId.$milestoneId; ?>;
					var myArray = myString.split('.');
					//alert(newFileName<?php echo $projectId.$milestoneId; ?> + '.' + myArray[myArray.length-1])
					
					//Add uploaded file to list
					if(response<?php echo $projectId.$milestoneId; ?>=="upload successful" || response<?php echo $projectId.$milestoneId; ?>=='upload successful<div id="isChromeWebToolbarDiv" style="display:none"></div>'){
						/*$('<li></li>').appendTo('#files<?php echo $projectId.$milestoneId; ?>').html('<img src="plugins/project_space/tempfiles/<?php echo $milestoneId; ?>/'+ file<?php echo $projectId.$milestoneId; ?> +'" alt="" /><br />'+file<?php echo $projectId.$milestoneId; ?>).addClass('success');*/
						$('<li></li>').appendTo('#files<?php echo $projectId.$milestoneId; ?>').html(file<?php echo $projectId.$milestoneId; ?>).addClass('success');
					}else{
						$('<li></li>').appendTo('#files<?php echo $projectId.$milestoneId; ?>').text('error').addClass('error');
					}
				}
			});
			
		});
		</script>
	<?php	
	}
	
	function removeMilestoneAttachment($milestoneId){
		$tempDir = "tempfiles/".$milestoneId;
		
		if (!file_exists($tempDir)) {
			mkdir($tempDir, 0777);
		}
		
		$results = array();
		$handler = opendir($tempDir);
		
		while ($file = readdir($handler)) {

		  if ($file != "." && $file != "..") {
			$results[] = $file;
		  }
		}
		
		foreach($results as $filename){
			unlink($tempDir."/".$filename);
		}
		
		echo "<script type='text/javascript'>
				$('.error').hide();
				$('.milestone_input').val('');
			</script>";
	}
	
	function insertMilestoneAttachment($milestoneId, $projectId){
		$tempDir = "tempfiles/".$milestoneId;
		$attachmentDir = "attachments/".$milestoneId;
		
		if (!file_exists($tempDir)) {
			mkdir($tempDir, 0777);
		}
		
		if (!file_exists($attachmentDir)) {
			mkdir($attachmentDir, 0777);
		}
		
		$results = array();
		$handler = opendir($tempDir);

		while ($file = readdir($handler)) {

		  if ($file != "." && $file != "..") {
			$results[] = $file;
		  }
		}
		
		$numOnList = count($results);
		$allfiles = "";
		$count = 0;
		
		foreach($results as $filename){
			if (file_exists($filename)) {
				$filename = $filename."(1)";
			}
			$count = $count + 1;
			if($count != 1){ $seperator = ","; }
			$allfiles = $allfiles.$seperator.$filename;
			
			rename($tempDir."/".$filename , $attachmentDir."/".$filename);
		}
		
		$updateMilestoneAttachments = mysql_query("UPDATE tbl_project_milestones SET attachments = '".$allfiles."' WHERE milestone_id = ".$milestoneId."");
		
		if($updateMilestoneAttachments){
			echo "<script type='text/javascript'>
					$('#update_show_all_milestone_attachments_popup".$projectId."').load('plugins/project_space/controller2.php?action=updatedocumentslistpopup&project_id=".$projectId."');
				</script>";
		}
		
		closedir($handler);
	}
	
	function addProjectMilestonesQuery($milestoneId, $projectId, $userId, $milestoneTitle, $milestone, $dateToday){
		//echo "<script>alert('".$milestoneId." ".$projectId." ".$userId." ".$milestoneTitle." ".$milestone." ".$dateToday."');</script>";
	
		$project_creator = mysql_query("SELECT user_id FROM tbl_projects WHERE project_id = ".$projectId);
		$get_project_creator = mysql_fetch_array($project_creator);	
		$projectMembers = mysql_query("SELECT * FROM tbl_project_members WHERE project_id = ".$projectId." AND user_id != ".$userId);
		
		$userIds = "";
		while($row = mysql_fetch_array($projectMembers)){
			$userIds = $userIds.",".$row['user_id'];
		}
		
		$member_notification = substr($userIds, 1);
	
		$addProjectMilestones = mysql_query("INSERT INTO tbl_project_milestones SET milestone_id = ".$milestoneId.", project_id = ".$projectId.", user_id = ".$userId.", milestone_title = '".$milestoneTitle."', milestone = '".$milestone."', date_posted = '".$dateToday."', attachments = '', confirmation = 1, member_notification = '".$member_notification."'") or die(mysql_error());
		
		$newProjectId = $projectId + 1;
		
		if($addProjectMilestones){
			echo "<script type='text/javascript'>
					$('#project_milestones_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatemilestonelist&project_id=".$projectId."&user_id=".$userId."' );
					$('#project_documents_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=".$projectId."' );
					$('#result".$projectId."').load( 'plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$projectId."&user_id=".$userId."&project_creator_id=".$get_project_creator['user_id']."' );
					$('#add_project_milestone_success".$projectId."').show();
					$('.error').hide();
				</script>";
		}
		/*$('#add_project_milestones_bg".$projectId."').delay(2000).fadeOut();
		$('#add_project_milestones".$projectId."').delay(2000).fadeOut();*/
	}
	
	function getProjectImage($projectId, $projectImg){ 
		/*if($projectImg == ""){ ?>
			<div class="project_img" style="background-image:url('plugins/project_space/includes/imgsize.php?h=100&img=plugins/project_space/project_img/default.jpg')"></div>
			<?php
		}
		else { ?>
		<div class="project_img" style="background-image:url('plugins/project_space/includes/imgsize.php?h=100&img=../project_img/<?php echo $projectId; ?>/<?=$projectImg?>')"></div>
		<?php
		}*/
		
		if(file_exists("plugins/project_space/project_img/".$projectId)){
			$profile_path = "plugins/project_space/project_img/".$projectId;
			$addtext = "";
		}
		else{
			$profile_path = "project_img/".$projectId;
			$addtext = "plugins/project_space/";
		}
		
		if(file_exists($profile_path."/thumb_".$projectImg)){
			?>
			<div class="project_img<?php echo $projectId; ?>" style="background:url('<?php echo $addtext; ?><?php echo $profile_path; ?>/thumb_<?php echo $projectImg; ?>') center no-repeat"></div>
			<?php
		}
		else{ 
			if(file_exists("plugins/project_space/project_img")){
				$path = "plugins/project_space/project_img";
				$addtext = "";
			}
			else{
				$path = "project_img";
				$addtext = "plugins/project_space/";
			}
		?>
			<div class="project_img<?php echo $projectId; ?>" style="background:url('<?php echo $addtext; ?><?php echo $path; ?>/default.jpg') center no-repeat;"></div>
		<?php
		} ?>
		<style>
			.project_img<?php echo $projectId; ?>{
				position: relative;
				float: left;
				height: 96px;
				width: 124px;
				border: 4px solid white;
				-moz-box-shadow: 1px 1px 3px 0px #b7b7b7;
				-webkit-box-shadow: 1px 1px 3px 0px #B7B7B7;
				box-shadow: 1px 1px 3px 0px #B7B7B7;
			}
		</style>
	<?php	
	}
	
	function updateProjectImage($projectId){
		$tempDir = "project_img/temp/".$projectId;
		$projDir = "project_img/".$projectId;
		
		if (!file_exists('project_img')) {
			mkdir('project_img', 0777);
		}
		
		if (!file_exists('project_img/temp')) {
			mkdir('project_img/temp', 0777);
		}
		
		if (!file_exists($tempDir)) {
			mkdir($tempDir, 0777);
		}
		
		if (!file_exists($projDir)) {
			mkdir($projDir, 0777);
		}	
		
		$results = array();
		$handler = opendir($tempDir);
		
		while ($file = readdir($handler)) {

			if ($file != "." && $file != "..") {
				$results[] = $file;
			}
		  
			foreach($results as $filename){
				if(file_exists($projDir."/".$filename)){
					unlink($projDir."/".$filename);
				}
			}
			
			foreach($results as $filename){
				if(file_exists($tempDir."/".$filename)){
					rename($tempDir."/".$filename , $projDir."/".$filename);
					
					$path = 'plugins/project_space/includes/simple_image.php';
		
					if(file_exists($path)){
						require_once($path);
					}
					else{
						require_once('includes/simple_image.php');
					}
					
					$image = new SimpleImage();
					$image->load($projDir."/".$filename);
					$image->resizeToHeight(100);
					$image->save($projDir."/thumb_".$filename);
				}
			}
		}
		
		$newImage = str_replace(' ', '%20', $results[0]);

		$projectImageUpdate = mysql_query("UPDATE tbl_projects SET project_img = '".$newImage."' WHERE project_id = ".$projectId); 
		
		$newProjectImage = mysql_query("SELECT project_img FROM tbl_projects WHERE project_id = ".$projectId);
		$getNewProjectImage = mysql_fetch_array($newProjectImage);
		$newProjectImage = htmlentities($getNewProjectImage['project_img']);
		
		/*echo "<script type='text/javascript'>
					$('#project_img".$projectId."').html('<div class=project_img".$projectId." style=\'background:url(plugins/project_space/project_img/".$projectId."/thumb_".$newProjectImage.")center no-repeat\'></div>');
			</script>";*/
		
		echo "<script type='text/javascript'>
					$('.project_img".$projectId."').css('background-image','url(plugins/project_space/project_img/".$projectId."/thumb_".$newProjectImage.")');
			</script>";
			//$('#project_img".$projectId."').load('plugins/project_space/controller2.php?action=updateprojectdsplayimage&project_id=".$projectId."&project_img=".$newProjectImage."');
		?>
		<style>
			.project_img<?php echo $projectId; ?>{
				position: relative;
				float: left;
				height: 96px;
				width: 124px;
				border: 4px solid white;
				-moz-box-shadow: 1px 1px 3px 0px #b7b7b7;
				-webkit-box-shadow: 1px 1px 3px 0px #B7B7B7;
				box-shadow: 1px 1px 3px 0px #B7B7B7;
			}
		</style>
	<?php	
	}
	
	function uploadProjectImage($projectId){ ?>
		<div id="upload_project_img<?php echo $projectId; ?>"><span>Upload File</span></div><span id="status<?php echo $projectId; ?>" ></span>
		<ul id="files<?php echo $projectId; ?>" ></ul>
		<!-- CSS -->
		<style type="text/css">
			#upload_project_img<?php echo $projectId; ?>{
				display: none;
				
				font-family: 'CicleGordita';
				font-size: 1.25em;
				letter-spacing: 0.035em;
				cursor: pointer;
				margin: 0;
				color: white;
				background-color: #e68a1b;
				text-shadow: 1px 1px #ac6614;
				height: 30px;
				border: #fff 1px solid;
				padding: 0 15px 0 15px;
				background: -moz-linear-gradient( 
					top,
					#ff991e,
					#cf7c18);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#ff991e),
					to(#cf7c18));
				-moz-box-shadow: 1px 2px 3px 0px #acacac;    /*** Box Shadow ***/
				-webkit-box-shadow: 1px 2px 3px 0px #acacac;
				box-shadow: 1px 2px 3px 0px #acacac;
				border-radius: 2px;  /*** Rounded Corner ***/
				-moz-border-radius: 2px;
				-webkit-border-radius: 2px;
				line-height: 30px;
			}
			
			#upload_project_img<?php echo $projectId; ?>:hover{
				cursor: pointer;
				background: -moz-linear-gradient(
					top,
					#f2911c,
					#b96500);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#f2911c),
					to(#b96500));
			}
			.darkbg<?php echo $projectId; ?>{
				background:#ddd !important;
			}
			#status<?php echo $projectId; ?>{
				font-family:Arial; padding:5px;
			}
			ul#files<?php echo $projectId; ?>{ list-style:none; padding:0; margin:0; }
			ul#files<?php echo $projectId; ?> li{ width:188px; float:left;}
			ul#files<?php echo $projectId; ?> li img{ max-width:180px; max-height:150px; }
			.success<?php echo $projectId; ?>{ background:#99f099; border:1px solid #339933; }
			.error<?php echo $projectId; ?>{ background:#f0c6c3; border:1px solid #cc6622; }
		</style>
		
		<!-- Javascript -->
		<script type="text/javascript" >
		$(function(){
			var btnUpload<?php echo $projectId; ?>=$('#upload_project_img<?php echo $projectId; ?>');
			var status<?php echo $projectId; ?>=$('#status<?php echo $projectId; ?>');
			
			new AjaxUpload(btnUpload<?php echo $projectId; ?>, {
				action: 'plugins/project_space/includes/upload-file.php',
				name: 'uploadfile<?php echo $projectId; ?>',
				data: {project_id: <?php echo $projectId; ?>},
				onSubmit: function(file<?php echo $projectId; ?>, ext<?php echo $projectId; ?>){
					 if (! (ext<?php echo $projectId; ?> && /^(jpg|png|jpeg|gif)$/.test(ext<?php echo $projectId; ?>))){ 
						// extension is not allowed 
						status<?php echo $projectId; ?>.html('<div style="position: relative; float: left; padding: 5px;">Only .jpg, .png or .gif files are allowed.</div>');
						return false;
					}
					status<?php echo $projectId; ?>.text('Uploading...');
				},
				onComplete: function(file<?php echo $projectId; ?>, response<?php echo $projectId; ?>){
					//On completion clear the status
					status<?php echo $projectId; ?>.text('');

					//Add uploaded file to list
					if(response<?php echo $projectId; ?>=="upload successful"){
						file<?php echo $projectId; ?> = escape(file<?php echo $projectId; ?>);
						
						$('<li></li>').appendTo('#files<?php echo $projectId; ?>').html('<img src="plugins/project_space/project_img/temp/<?php echo $projectId; ?>/'+file<?php echo $projectId; ?>+'" alt="" width="340" /><br /><br />'+file<?php echo $projectId; ?>).addClass('success');
						$('#proj_image_temp<?php echo $projectId; ?>').html('<img src="plugins/project_space/project_img/temp/<?php echo $projectId; ?>/'+file<?php echo $projectId; ?>+'" alt="" width="300" />');
						$('#upload_project_img<?php echo $projectId; ?>').hide();
					} else{
						$('<li></li>').appendTo('#files<?php echo $projectId; ?>').text('error').addClass('error');
						$('#upload_project_img<?php echo $projectId; ?>').hide();
					}
				}
			});
			
		});
		</script>
	<?php	
	}
	
	function showProjectDetails($projectId, $userId){ // get's the project details by passing project_id
		$projectDetails = mysql_query("SELECT * FROM tbl_projects WHERE project_id = ".$projectId); 
		$limit = 5; ?>
		<div id="projectDetailsbg<?php echo $projectId; ?>"></div>
		<div id="projectDetails<?php echo $projectId; ?>">
			
			<div id="add_project_members_bg<?php echo $projectId; ?>"></div>
			<div id="add_project_members<?php echo $projectId; ?>">
				<div id="close_add_members<?php echo $projectId; ?>" class="btn"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0"></div>
				<div id="add_members<?php echo $projectId; ?>" class="btn" style="float: left;"><img src="plugins/project_space/images/plus_small.gif" style="box-shadow: none !important; border: 0; margin: 0"> Add</div>
				<!--<div id="add_members_success<?php echo $projectId; ?>" class="btn"><span style="margin-left: 15px; color: #598E30;">Members successfully added!</span></div><div class="clear"></div><hr />-->
				<span id="addmembersmsg<?php echo $projectId; ?>" style="margin-left: 15px; color: #598E30;" class="addmembersmsg">&nbsp;</span>
				<hr />
				<div id="addProjectMembersForm<?php echo $projectId; ?>">
					<?php $this->addProjectMembers($projectId, $userId); ?>
				</div>
			</div>
			
			<div id="bgdisabler<?php echo $projectId; ?>"></div>
			<?php while($row = mysql_fetch_array($projectDetails)){ ?>
				<div class="project_left">

					<div id="project_img<?php echo $projectId; ?>">
						<?php $this->getProjectImage($projectId, $row['project_img']); ?>
					</div>
					
					<?php 
						if($row['user_id'] == $userId){ ?>		
							<img src="plugins/project_space/images/edit_small.gif" id="img_nob" />
                            <div id="upload_project_img_btn<?php echo $projectId; ?>" class="btn" style="margin-top: 3px;">Select Image</div>
							<hr />
							<div id="project_img_upload_form_bg<?php echo $projectId; ?>"></div>
							<div id="project_img_upload_form<?php echo $projectId; ?>">
								<?php $this->uploadProjectImage($projectId); ?>
								<div style="float:right;">
									<div id="done_project_img_upload_form<?php echo $projectId; ?>" class="btn">Done</div>
									<div style="padding: 0px 6px; float: left;"> | </div>
									<div id="close_project_img_upload_form<?php echo $projectId; ?>" class="btn">Cancel</div>
								</div>
							</div>
					<?php 
					}	
					?>
					
					<div class="left_sub">
						<div class="project_members"> <div class="form_title" style="margin-bottom: 10px; float: left; width: 80px;">Members</div>
							<?php 
								if($row['user_id'] == $userId){ ?>
									<div id="add_project_members_btn<?php echo $projectId; ?>" class="btn" style="float: right;"><img src="plugins/project_space/images/plus_small.gif" style="box-shadow: none !important; border: 0; margin: 0" /> Add</div>
                                    <div class="clear"></div>
								<?php
								}
							?>
							<div id="result<?php echo $projectId; ?>"></div>
							
                            <div class="clear"></div>	
                            <div id="project_members_list<?php echo $projectId; ?>">
                               	<?php $this->getProjectMembers($projectId, $userId); ?> 
                           	</div>
							<div id="update_view_more_project_members<?php echo $projectId; ?>">
								<?php $this->viewAllProjectMembers($projectId, $userId); ?>
							</div>
							<!--<div id="view_more_project_members_btn<?php echo $projectId; ?>" class="btn">
								<?php $this->getProjectMembersNo($projectId, $userId); ?>
							</div>-->
						</div>
						
                        <?php if($this->checkIfUserIsMember($projectId, $userId) > 0){ ?>
							<div class="project_milestones" id="project_milestones<?php echo $projectId; ?>"> <div class="form_title" style="margin-bottom: 10px; float: left;">Milestones</div> 
							<div id="add_project_milestones_btn<?php echo $projectId; ?>" class="btn" style="float: right;"><img src="plugins/project_space/images/plus_small.gif" style="box-shadow: none !important; border: 0; margin: 0" /> Add</div>
                            <div class="clear"></div>	
                                <div id="project_milestones_list<?php echo $projectId; ?>">
									<?php $this->getProjectMilestones($projectId, $userId); ?>
								</div>
								<?php
								if($this->checkIfUserIsMember($projectId, $userId) > 0){ ?>
								<?php } ?>
								<div id="view_more_project_milestones_btn<?php echo $projectId; ?>" class="btn" >
									<?php $this->getProjectMilestonesNo($projectId); ?>
								</div>
								
								<div id="add_project_milestones_bg<?php echo $projectId; ?>"></div>
								<div id="add_project_milestones<?php echo $projectId; ?>">
									<?php $this->addProjectMilestones($projectId, $userId, ''); ?>
								</div>
							</div>
							
							<div class="project_documents"> <div class="form_title" style="margin-bottom: 10px;">Documents</div>
								<div id="project_documents_list<?php echo $projectId; ?>">
									<?php $this->showAllMilestoneAttachments($projectId); ?>
								</div>
								<div id="update_show_all_milestone_attachments_popup<?php echo $projectId; ?>">
									<?php $this->showAllMilestoneAttachmentsPopup($projectId); ?>
								</div>
								<div id="view_more_project_documents_btn<?php echo $projectId; ?>" class="btn">
									<?php $this->showAllMilestoneAttachmentsNo($projectId); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div><!-- Project Left -->
				<div class="project_right">
                	<div style="line-height: 30px;">
                    <div id="view_project_description<?php echo $projectId; ?>"><button class="blue_01">Project Description </button></div>
                    <a href="#"><div id="close<?php echo $projectId; ?>"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 8px 0 0 0" /></div></a><br /><br />
                        <!--<span style="position:relative; float:left; margin-right: 10px;" class="form_title"><?php echo $row['project_title']; ?></span>-->
						<div class="form_title"><p><pre><?php echo $row['project_title']; ?></pre></p></div>
                        
                        <?php if($row['user_id'] == $userId){ ?>
                            <div id="edit_project_status_input_bg<?php echo $projectId; ?>"></div>
                            <select id="edit_project_status_input<?php echo $projectId; ?>">
                                <option value="On Going" <?php if($row['project_status']=='On Going'){ echo "selected"; } ?> >On Going</option>
                                <option value="On Hold" <?php if($row['project_status']=='On Hold'){ echo "selected"; } ?> >On Hold</option>
                                <option value="Canceled" <?php if($row['project_status']=='Canceled'){ echo "selected"; } ?> >Canceled</option>
                                <option value="Completed" <?php if($row['project_status']=='Completed'){ echo "selected"; } ?> >Completed</option>
                            </select>
                            <span id="edit_project_status<?php echo $projectId; ?>"><?php $this->getProjectStatus($projectId); ?></span>
                        <?php }  else { echo $this->getProjectStatus($projectId); } ?>
                        
                    <div class="clear"></div>
                    </div>
					<div id="project_description_result<?php echo $projectId; ?>"></div>
					<div id="project_description_popup_bg<?php echo $projectId; ?>"></div>
					<div id="project_description_popup<?php echo $projectId; ?>">
                    	<div id="close_project_description_popup<?php echo $projectId; ?>" class="btn"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0 0 8px 0"></div>
						<br />
                        <div class="proj_desc_err"></div>
                        <h3><?php echo $row['project_title']; ?></h3>
						<?php if($row['user_id'] == $userId){ ?>
							<div id="edit_project_description_input_bg<?php echo $row['project_id']; ?>"></div>
							<textarea id="edit_project_description_input<?php echo $projectId; ?>"><?php $this->getProjectDescription($projectId); ?></textarea>
							<div id="edit_project_description<?php echo $row['project_id']; ?>"><?php $this->getProjectDescription($projectId); ?></div>
							
							<div id="update_project_description_popup<?php echo $projectId; ?>"><button class="orange_02" style="margin-top: 20px;">Update</button></div>
						<?php } else {?>
							<p><?php $this->getProjectDescription($projectId); ?></p>
							<div id="close_project_description_popup<?php echo $projectId; ?>"></div>
						<?php } ?>
						
					</div>
					<?php 
					if($this->checkIfUserIsMember($projectId, $userId) > 0){
						$this->whatAmIWorkingOn($projectId, $userId); ?>
						
						<div class="bgdisabler"></div>
						<div class="post_lighters">
                        	<a href="#" class="close_lighters"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: 0px 0px !important; border: 0; margin: 0 0 8px 0; float: right;" /></a><div class="clear"></div>
							<div class="form_title">Who lights your post</div>
                            <hr /><br />
                            <div class="post_lighters_list"></div>
						</div>
						<div class="project_posts_wrap">
						<div id="project_posts<?php echo $projectId; ?>" class="project_posts">
							<?php $this->getProjectPosts($projectId, $limit, $userId); ?>
						</div>
						</div>
					<?php
					}
					else{ ?>
						<div class="project_notification">This section is for members only</div>
					<?php
					}
					?>
				</div>
			<?php } ?>
		</div>
	<?php	
	}
	
	function assignMilestoneId($projectId){
		$assignMilestoneId = mysql_query("SELECT milestone_id FROM tbl_project_milestones ORDER BY milestone_id DESC LIMIT 1");
		$getNewMilestoneId = mysql_fetch_array($assignMilestoneId);
		
		if($getNewMilestoneId['milestone_id'] == ''){
			$milestoneId = 1;
		}
		else{
			$milestoneId = $getNewMilestoneId['milestone_id'] + 1;
		}
		?>
		<input type="hidden" name="milestone_id<?php echo $projectId; ?>" id="milestone_id<?php echo $projectId; ?>" value="<?php echo $milestoneId; ?>" />
	<?php
	}
	
	function addProjectMilestones($projectId, $userId, $msg = ''){ 
		$assignMilestoneId = mysql_query("SELECT milestone_id FROM tbl_project_milestones ORDER BY milestone_id DESC LIMIT 1");
		$getNewMilestoneId = mysql_fetch_array($assignMilestoneId);
		
		if($getNewMilestoneId['milestone_id'] == ''){
			$milestoneId = 1;
		}else{
			$milestoneId = $getNewMilestoneId['milestone_id'] + 1;
		}
		
		if($msg == 'add_success'){
			echo "<script>
					$('.add_project_milestone_success_msg').show();
					$('.add_project_milestone_success_msg').text('Milestone Added Successfully');
					$('.add_project_milestone_success_msg').fadeOut(5000);
				</script>";
		}
		?>
		<div id="assign_milestone_id<?php echo $projectId; ?>">
			<?php $this->assignMilestoneId($projectId); ?>
		</div>
			<span id="add_project_milestone_success_msg<?php echo $projectId; ?>" class="add_project_milestone_success_msg"></span>
		<div id="close_add_milestone<?php echo $projectId; ?>" class="btn"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0 0 8px 0"></div>
		<br /><div class="form_title">Add Milestone</div><hr /><div class="mart20"></div>
        <div class="userinput">
			Milestone Title: <span style="color:RED">*</span> <!--<span id="add_milesone_title_err<?php echo $projectId; ?>" class="errmsg" >*</span>--><br/>
			<input type="text" name="milestone_title<?php echo $projectId; ?>" id="milestone_title<?php echo $projectId; ?>" class="milestone_input" maxlength="250" /><br/>Maximum of 250 characters only.
		</div>
		<div class="userinput">
			Milestone: <span style="color:RED">*</span><!--<span id="add_milesone_desc_err<?php echo $projectId; ?>" class="errmsg" >*</span>--><br/>
			<textarea name="milestone_desc<?php echo $projectId; ?>" id="milestone_desc<?php echo $projectId; ?>" rows="2" class="milestone_input"></textarea>
		</div>
		<div class="userinput">
			Add Attachment:
			<?php $this->uploadProjectMilestone($projectId, $milestoneId); ?>
		</div>
		<!--<div class="userinput">
			Attachment: <input type="file" name="milestone_attachment<?php echo $projectId; ?>" id="milestone_attachment<?php echo $projectId; ?>">
		</div>-->
		<div id="add_milestone_btn<?php echo $projectId; ?>" class="btn">Add</div> 
		<script type="text/javascript">
			var plug_path = 'plugins/project_space/';
			
			$('#close_add_milestone<?php echo $projectId; ?>').click(function() {
				var milestone_id<?php echo $projectId; ?> = $('#milestone_id<?php echo $projectId; ?>').val();
				
				$('.upload_status').html('');
				$('.add_project_milestone_success_msg').html('');
				$('#add_project_milestones<?php echo $projectId; ?>').hide();
				$('#add_project_milestones_bg<?php echo $projectId; ?>').fadeOut();
					$('#add_milesone_title_err<?php echo $projectId; ?>').hide();
					$('#add_milesone_desc_err<?php echo $projectId; ?>').hide();
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=removetempmilestoneattachments&milestone_id=' + milestone_id<?php echo $projectId; ?> );
					$('.add_milestone_attachment').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
			});
			
			
			$('#add_project_milestones_bg<?php echo $projectId; ?>').click(function() {
				var milestone_id<?php echo $projectId; ?> = $('#milestone_id<?php echo $projectId; ?>').val();
				
				$('.upload_status').html('');
				$('.add_project_milestone_success_msg').html('');
				$('#add_project_milestones<?php echo $projectId; ?>').hide();
				$('#add_project_milestones_bg<?php echo $projectId; ?>').fadeOut();
					$('#add_milesone_title_err<?php echo $projectId; ?>').hide();
					$('#add_milesone_desc_err<?php echo $projectId; ?>').hide();
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=removetempmilestoneattachments&milestone_id=' + milestone_id<?php echo $projectId; ?> );
					$('.add_milestone_attachment').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
			});
			$('#add_milestone_btn<?php echo $projectId; ?>').click(function() {
				
				var milestone_title<?php echo $projectId; ?> = $('#milestone_title<?php echo $projectId; ?>').val();
				var milestone_title<?php echo $projectId; ?> = $.trim(milestone_title<?php echo $projectId; ?>);
				var milestone_desc<?php echo $projectId; ?> = $('#milestone_desc<?php echo $projectId; ?>').val();
				var milestone_desc<?php echo $projectId; ?> = $.trim(milestone_desc<?php echo $projectId; ?>);
				
				var regexp = new RegExp("^[a-zA-Z0-9. &()?!;:,_'\"\-]+$");
				
				if(milestone_title<?php echo $projectId; ?> == '' || milestone_desc<?php echo $projectId; ?> == ''){
					$('#add_project_milestone_success_msg<?php echo $projectId; ?>').text('Please Fill Up Required Field(s)');
					return false;
				}else if( !regexp.test( milestone_title<?php echo $projectId; ?> ) ){
					$('#add_project_milestone_success_msg<?php echo $projectId; ?>').text('Invalid Input');
					return false;
				}
				else{
					var milestone_title<?php echo $projectId; ?> = milestone_title<?php echo $projectId; ?>.replace(/^\s+|\s+$/g,"");
					var milestone_title<?php echo $projectId; ?> = milestone_title<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
					var milestone_title<?php echo $projectId; ?> = milestone_title<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
					var milestone_title<?php echo $projectId; ?> = milestone_title<?php echo $projectId; ?>.replace(/\"/g,'\\"');
					var milestone_title<?php echo $projectId; ?> = milestone_title<?php echo $projectId; ?>.replace(/\0/g,'\\0');
					var milestone_title<?php echo $projectId; ?> = escape(milestone_title<?php echo $projectId; ?>);

					var milestone_desc<?php echo $projectId; ?> = milestone_desc<?php echo $projectId; ?>.replace(/^\s+|\s+$/g,"");
					var milestone_desc<?php echo $projectId; ?> = milestone_desc<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
					var milestone_desc<?php echo $projectId; ?> = milestone_desc<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
					var milestone_desc<?php echo $projectId; ?> = milestone_desc<?php echo $projectId; ?>.replace(/\"/g,'\\"');
					var milestone_desc<?php echo $projectId; ?> = milestone_desc<?php echo $projectId; ?>.replace(/\0/g,'\\0');
					var milestone_desc<?php echo $projectId; ?> = escape(milestone_desc<?php echo $projectId; ?>);
					
					var milestone_id<?php echo $projectId; ?> = $('#milestone_id<?php echo $projectId; ?>').val();
				
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=addnewmilestone&milestone_id=' + milestone_id<?php echo $projectId; ?> + '&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>&milestone_title=' + milestone_title<?php echo $projectId; ?> + '&milestone_desc=' + milestone_desc<?php echo $projectId; ?> );
					$('#milestone_title<?php echo $projectId; ?>').val('');
					$('#milestone_desc<?php echo $projectId; ?>').val('');
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=movemilestoneattachments&milestone_id=' + milestone_id<?php echo $projectId; ?> + '&project_id=<?php echo $projectId; ?>' );
					//$('.add_milestone_attachment').load('plugins/project_space/controller2.php?action=emptyuploadbtn&project_id=<?php echo $projectId; ?>');
					
					/*$('#assign_milestone_id<?php echo $projectId; ?>').delay(2000).queue(function( nxt ) {
						$(this).load( plug_path + 'controller2.php?action=assignmilestoneid&project_id=<?php echo $projectId; ?>' );
					});*/
					
					$('#assign_milestone_id<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=assignmilestoneid&project_id=<?php echo $projectId; ?>' );
					
					/*$('#add_project_milestones<?php echo $projectId; ?>').delay(2000).queue(function( nxt ) {
						$(this).load( 'plugins/project_space/controller2.php?action=reloadaddnewmilestone&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>' );
					});*/
					$('#add_project_milestones<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=reloadaddnewmilestone&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>&msg=add_success' );
					
					//$('#view_more_project_milestones_btn<?php echo $projectId; ?>').delay(2000).queue(function( nxt ) {
						$.get('plugins/project_space/controller2.php?action=reloadviewmoreprojectmilestonesbtn&project_id=<?php echo $projectId; ?>', function(data) {
								$('#view_more_project_milestones_btn<?php echo $projectId; ?>').html(data);
							});						
						//$(this).text('loading...');
						//$(this).load( 'plugins/project_space/controller2.php?action=reloadviewmoreprojectmilestonesbtn&project_id=<?php echo $projectId; ?>' );
					//});
					$('#view_more_project_documents_btn<?php echo $projectId; ?>').delay(2000).queue(function( nxt ) {
						$(this).load( 'plugins/project_space/controller2.php?action=reloadviewmoreprojectdocumentsbtn&project_id=<?php echo $projectId; ?>' );
					});
					
					$('#add_project_milestone_success_msg<?php echo $projectId; ?>').text('Milestone Added Successfully');
					//$('.success' ).html('');
					
				}
				
			});
		</script>
		<style type="text/css">
			#add_project_milestone_success<?php echo $projectId; ?>{
				color: RED;
				display: none;
			}
			
			#add_project_milestone_success_msg<?php echo $projectId; ?>{
				color: RED;
			}
		</style>
	<?php
	}
	
	function getProjectMilestones($projectId, $userId){
		$getProjectMilestones = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_id, tbl_project_milestones.*, tbl_project_milestones.user_id AS milestone_creator_id FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_projects.project_id = tbl_project_milestones.project_id AND tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_milestones.confirmation = 1 ORDER BY milestone_id DESC");
		
		$getAllProjectMilestones = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_id, tbl_project_milestones.* FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_projects.project_id = tbl_project_milestones.project_id AND tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_milestones.confirmation = 1");
		
		$no_of_milestones = mysql_num_rows($getAllProjectMilestones);
		
		if($no_of_milestones == 0){ ?>
			<style type="text/css">
				#project_milestones_list<?php echo $projectId; ?>{
					height: 52px;
					overflow: hidden;
					color: #B8B8B8;
				}
			</style>
		<?php
			echo "No project milestones yet";
		}
		
		else{ 
			if($no_of_milestones > 5){
				$milestone_list_height = 280;
				?>
				<script>
					
				</script>
				<?php 
			}
			else{
				$milestone_list_height = $no_of_milestones * 60;
			}
		}
		
		while($row = mysql_fetch_array($getProjectMilestones)){ 
			$milestone = substr($row['milestone_title'], 0, 17);
			if(strlen($row['milestone_title']) > 17){
				$dots = "...";
			}
			?>
			<div class="milestone_list">
				<span id="milestone<?php echo $row['milestone_id']; ?>"><?php echo $milestone.$dots; ?></span>
				<br/>
				<span id=""><a href='?module=myprofile&id=<?php echo $row['milestone_creator_id']; ?>' id="user_milstone"><?php echo $row['firstname']." ".$row['lastname']."</a> <br /><span id='milestone_date'> ".$row['date_posted']; ?></span></span>
			</div>
			<?php 
			$this->viewProjectMilestones($projectId, $row['milestone_id'], $row['milestone_title'], $row['milestone'], $row['firstname'], $row['lastname'], $userId);
			$this->projectMilestonesJquery($projectId, $row['milestone_id'], $userId);
			?>
			<style type="text/css">
				#milestone<?php echo $row['milestone_id']; ?>{
					color: #00BFF3;
				}
					
				#project_milestones_list<?php echo $projectId; ?>{
					height: <?php echo $milestone_list_height; ?>px;
					overflow: hidden;
				}
			</style>
			<?php
			}
		?>
		
		<div id="view_all_project_milestones_bg<?php echo $projectId; ?>"></div>
		<div id="view_all_project_milestones<?php echo $projectId; ?>">
			<?php $this->viewAllProjectMilestones($projectId, $userId); ?>
		</div>
		
		<?php
	}
	
	function viewAllProjectMilestones($projectId, $userId){
		$projectMilestones = mysql_query("SELECT CONCAT(tbl_users.firstname, ' ', tbl_users.lastname) AS uploader, tbl_project_milestones.*, tbl_project_milestones.user_id AS uploader_id FROM tbl_users, tbl_project_milestones WHERE tbl_users.user_id = tbl_project_milestones.user_id AND tbl_project_milestones.project_id = ".$projectId." ORDER BY milestone_id DESC");
		
		echo "<div class='form_title' style='padding-top: 16px;'>Project Milestones</div><hr /><div class='marb10'></div>";
		
		echo "<div class='milestone_list_wrap'>";
		while($row = mysql_fetch_array($projectMilestones)){
			echo "	<div class='milestone_list'>
						<span id='milestone_2".$row['milestone_id']."'>".$row['milestone_title']."</span>
						<a href='?module=myprofile&id=".$row['uploader_id']."'>".$row['uploader']."</a>
					</div>"; ?>
			<script type="text/javascript">
				$('#milestone_2<?php echo $row['milestone_id']; ?>').click(function() {
					$('#project_milestones_details<?php echo $row['milestone_id']; ?>').show();
					var view_all_project_milestones<?php echo $projectId; ?> = $('#project_milestones_details<?php echo $row['milestone_id']; ?>').height();
					
					$('#view_all_project_milestones<?php echo $projectId; ?>').css('height', view_all_project_milestones<?php echo $projectId; ?>);
					$('#view_all_project_milestones<?php echo $projectId; ?>').css('position', 'fixed');
					$('#view_all_project_milestones<?php echo $projectId; ?>').css('overflow', 'auto');
				});
				
				$('#close_milestone<?php echo $row['milestone_id']; ?>').click(function() {
					$('#view_all_project_milestones<?php echo $projectId; ?>').css('height', '');
					$('#project_milestones_details<?php echo $row['milestone_id']; ?>').hide();
					$('#project_milestones_details_bg<?php echo $row['milestone_id']; ?>').fadeOut();
				});
				$('#project_milestones_details_bg<?php echo $row['milestone_id']; ?>').click(function() {
					$('#project_milestones_details<?php echo $row['milestone_id']; ?>').hide();
					$('#project_milestones_details_bg<?php echo $row['milestone_id']; ?>').fadeOut();
					
					$('#milestone_description<?php echo $row['milestone_id']; ?>').show();
					//$('#milestone_description_input<?php echo $row['milestone_id']; ?>').val('<?php $this->getMilestoneDescription($row['milestone_id']); ?>');
					$('.milestone_desc_err').text('');
					$('#milestone_description_input<?php echo $row['milestone_id']; ?>').hide();
					$('#update_milestone_description<?php echo $row['milestone_id']; ?>').hide();

				});
			</script>
			<style type="text/css">
				#milestone_2<?php echo $row['milestone_id']; ?>{
					cursor: pointer;
					color: #686868;
				}
				
				#milestone_2<?php echo $row['milestone_id']; ?>:hover{
					color: #00BFF3;
				}
				
				#show_view_more_project_details<?php echo $row['milestone_id']; ?>{
					display: none;
					position: relative;
					float: left;
					border-top: 1px solid #bbb;
					border-bottom: 1px solid #bbb;
					background-color: #EDEDED;
					z-index: 100;
					width: 100%;
				}
			</style>
			<div id="show_view_more_project_details<?php echo $row['milestone_id']; ?>">
				<?php $this->viewMoreProjectMilestones($row['milestone_id'], $row['milestone_title'], $row['milestone'], $row['date_posted'], $row['uploader'], $projectId, $userId); ?>
			</div>
			
			<script type="text/javascript"> 
				$('#view_all_project_milestones_bg<?php echo $projectId; ?>').click(function() {
					$('#view_all_project_milestones<?php echo $projectId; ?>').css('height', '');
					$('#view_all_project_milestones<?php echo $projectId; ?>').hide();
					$('.project_milestones_details').hide();
					$('#view_all_project_milestones_bg<?php echo $projectId; ?>').fadeOut();
				});
			</script>
			
		<?php
		}
		echo "</div>";
		?>
		<div id="close_more_project_milestones<?php echo $projectId; ?>"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0 0 8px 0"></div>	
		<script type="text/javascript">
			$('#close_more_project_milestones<?php echo $projectId; ?>').click(function() {
				$('#view_all_project_milestones<?php echo $projectId; ?>').hide();
				$('#view_all_project_milestones_bg<?php echo $projectId; ?>').fadeOut();
			});
		</script>
		<style type="text/css">
			#close_more_project_milestones<?php echo $projectId; ?>{
				position: relative;
				float: right;
				text-align: right;
				width: 100%;
				cursor: pointer;
				top: -168px;
			}
		</style>
	<?php
	}
	
	function viewMoreProjectMilestones($milestone_id, $milestone_title, $milestone, $date_posted, $uploader, $projectId, $userId){
		?>
		<div id="all_milestone_description_result<?php echo $milestoneId; ?>"></div>
		<div class="userinput">
			<?php echo $milestone_title; ?><br/>
			Posted by: <?php echo $uploader; ?>
		</div>
		<div class="userinput">
			<?php echo $date_posted; ?>
		</div>
		
		<?php if($this->getMilestoneCreator($milestone_id) == $userId){ ?>
			<textarea id="all_milestone_description_input<?php echo $milestoneId; ?>" ><?php $this->getMilestoneDescription($milestone_id); ?></textarea>
			<p id="all_milestone_description<?php echo $milestoneId; ?>"><?php $this->getMilestoneDescription($milestone_id); ?></p>
			<div id="update_all_milestone_description<?php echo $milestoneId; ?>">Update</div>
		<?php }
		
		else { ?>
			<p><?php $this->getMilestoneDescription($milestone_id, $userId); ?></p>
		<?php } ?>
			Attachments:<br/>
			<div id="all_milestone_attachments<?php echo $milestoneId; ?>">
				<?php $this->showMilestonesAttachment($milestone_id, $userId, $projectId); ?>
			</div>
			<div id="update_edit_all_attachment_btn<?php echo $milestoneId; ?>">
				<?$this->loadUploadButton($projectId, $milestone_id, $userId); ?>
			</div>
		
		<div id="close_view_more_project_details<?php echo $milestoneId; ?>">Hide</div>
		<script type="text/javascript">
			$('#close_view_more_project_details<?php echo $milestoneId; ?>').click(function(){
				$('#show_view_more_project_details<?php echo $milestoneId; ?>').hide();
			});
			
			$('#all_milestone_description<?php echo $milestoneId; ?>').click(function(){
				$('#all_milestone_description_input<?php echo $milestoneId; ?>').show();
				$('#update_all_milestone_description<?php echo $milestoneId; ?>').show();
				$('#all_milestone_description<?php echo $milestoneId; ?>').hide();
			});
			
			$('#update_all_milestone_description<?php echo $milestoneId; ?>').click(function(){
				var all_milestone_description<?php echo $milestoneId; ?> = $('#all_milestone_description_input<?php echo $milestoneId; ?>').val();
				var all_milestone_description<?php echo $projectId; ?> = all_milestone_description<?php echo $projectId; ?>.replace(/\\/g,'\\\\');
				var all_milestone_description<?php echo $projectId; ?> = all_milestone_description<?php echo $projectId; ?>.replace(/\'/g,'\\\'');
				var all_milestone_description<?php echo $projectId; ?> = all_milestone_description<?php echo $projectId; ?>.replace(/\"/g,'\\"');
				var all_milestone_description<?php echo $projectId; ?> = all_milestone_description<?php echo $projectId; ?>.replace(/\0/g,'\\0');
				var all_milestone_description<?php echo $milestoneId; ?> = escape(all_milestone_description<?php echo $milestoneId; ?>);
				
				$('#all_milestone_description<?php echo $milestoneId; ?>').show();
				
				$('#all_milestone_description_result<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestonedescription&milestone_id=<?php echo $milestoneId; ?>&milestone_description=' + all_milestone_description<?php echo $milestoneId; ?> );
				
				$('#all_milestone_description_input<?php echo $milestoneId; ?>').hide();
				$('#update_all_milestone_description<?php echo $milestoneId; ?>').hide();
			});
		</script>
		<style type="text/css">
			#all_milestone_description_input<?php echo $milestoneId; ?>, #update_all_milestone_description<?php echo $milestoneId; ?>{
				display: none;
			}
			#close_view_more_project_details<?php echo $milestoneId; ?>{
				position: relative;
				float: left;
			}
			
			#all_milestone_description<?php echo $milestoneId; ?>{
				position: relative;
				float: left;
				width: 100%;
			}
			#all_milestone_description<?php echo $milestoneId; ?>:hover{
				border: 1px solid #bbb;
			}
		</style>
	<?php
	}
	
	/*function getAllProjectMilestones($projectId, $userId){
		$getProjectMilestones = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_id, tbl_project_milestones.* FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_projects.project_id = tbl_project_milestones.project_id AND tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_milestones.confirmation = 1 ORDER BY milestone_id");
		
		$getAllProjectMilestones = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_id, tbl_project_milestones.* FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_projects.project_id = tbl_project_milestones.project_id AND tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_milestones.confirmation = 1");
		
		$no_of_milestones = mysql_num_rows($getAllProjectMilestones);

		while($row = mysql_fetch_array($getProjectMilestones)){ 
			?>
			<span id="milestone<?php echo $row['milestone_id']; ?>"><?=$milestone?></span>
			<br/>
			<span id=""><?php echo $row['firstname']." ".$row['lastname']." - ".$row['date_posted']; ?></span>
			<br/><br/>
		<?php 
		$this->viewProjectMilestones($projectId, $row['milestone_id'], $row['milestone_title'], $row['milestone'], $row['firstname'], $row['lastname'], $userId);
		$this->projectMilestonesJquery($projectId, $row['milestone_id'], $userId);
		?>
		<style type="text/css">
			#milestone<?php echo $row['milestone_id']; ?>{
				text-decoration: underline;
				color: BLUE;
			}
			#project_milestones_list<?php echo $projectId; ?>{
				height: <?=$milestone_list_height?>px;
				overflow: hidden;
			}
		</style>
		<div id="view_all_project_milestones_bg<?php echo $projectId; ?>"></div>
		<div id="view_all_project_milestones<?php echo $projectId; ?>">
			<?php $this->viewAllProjectMilestones($projectId, $row['milestone_id']); ?>
		</div>
		<?php
		}
		if($no_of_milestones > 3){
			?>
			<div id="view_more_project_milestones_btn<?php echo $projectId; ?>" class="btn">More</div>
			<?php
		}
	}*/
	
	
	function getProjectMilestonesNo($projectId){
		$getProjectMilestones = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_id, tbl_project_milestones.* FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_projects.project_id = tbl_project_milestones.project_id AND tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_milestones.confirmation = 1 ORDER BY milestone_id DESC");
		
		//echo mysql_num_rows($getProjectMilestones);
		
		if(mysql_num_rows($getProjectMilestones) > 5){
			echo "More >>";
		}
		else{
			echo "<style type='text/css'>
					#view_more_project_milestones_btn".$projectId."{
						display: none;
						position: relative;
						curosr: pointer;
					}
				</style>";
		}
	}
	
	function projectMilestonesJquery($projectId, $milestoneId, $userId){ ?>
		<script type="text/javascript">
			$('#milestone<?php echo $milestoneId; ?>').click(function() {
				$('#project_milestones_details<?php echo $milestoneId; ?>').show();
				$('#update_edit_attachment_btn<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=reloaduploadbutton&milestone_id=<?php echo $milestoneId; ?>&project_id=<?php echo $projectId; ?>&user_id=<?php echo $userId; ?>');
				$('#project_milestones_details_bg<?php echo $milestoneId; ?>').fadeIn();
			});
			
			$('#close_milestone<?php echo $milestoneId; ?>').click(function() {
				$('#project_milestones_details<?php echo $milestoneId; ?>').hide();
				$('#milestone_description<?php echo $milestoneId; ?>').show();
				$('#milestone_description_input<?php echo $milestoneId; ?>').val('<?php $this->getMilestoneDescription($milestoneId); ?>');
				$('.milestone_desc_err').text('');
				$('#milestone_description_input<?php echo $milestoneId; ?>').hide();
				$('#update_milestone_description<?php echo $milestoneId; ?>').hide();
			});
			
			$('#milestone_description<?php echo $milestoneId; ?>').click(function(){
				var milestone_description<?php echo $milestoneId; ?> = $('#milestone_description<?php echo $milestoneId; ?>').text();
			
				$('#milestone_description_input<?php echo $milestoneId; ?>').show();
				$('#update_milestone_description<?php echo $milestoneId; ?>').show();
				$('#milestone_description_input<?php echo $milestoneId; ?>').val(milestone_description<?php echo $milestoneId; ?>);
				$('#milestone_description<?php echo $milestoneId; ?>').hide();
			});
			
			$('#update_milestone_description<?php echo $milestoneId; ?>').click(function(){
				var milestone_description<?php echo $milestoneId; ?> = $('#milestone_description_input<?php echo $milestoneId; ?>').val();
				var milestone_description<?php echo $milestoneId; ?> = milestone_description<?php echo $milestoneId; ?>.replace(/\\/g,'\\\\');
				var milestone_description<?php echo $milestoneId; ?> = milestone_description<?php echo $milestoneId; ?>.replace(/\'/g,'\\\'');
				var milestone_description<?php echo $milestoneId; ?> = milestone_description<?php echo $milestoneId; ?>.replace(/\"/g,'\\"');
				var milestone_description<?php echo $milestoneId; ?> = milestone_description<?php echo $milestoneId; ?>.replace(/\0/g,'\\0');
				var milestone_description<?php echo $milestoneId; ?> = $.trim(milestone_description<?php echo $milestoneId; ?>);
				
				if(milestone_description<?php echo $milestoneId; ?> == ''){
					$('.milestone_desc_err').show();
					$('.milestone_desc_err').text('Please fill up milestone description');
					var error = y;
				}
				
				if(error != 'y'){
					var milestone_description<?php echo $milestoneId; ?> = escape(milestone_description<?php echo $milestoneId; ?>);
					
					$('.milestone_desc_err').show();
					$('.milestone_desc_err').text('Milestone description updated successfully');
					$('.milestone_desc_err').fadeOut(5000);
					$('#milestone_description_result<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestonedescription&milestone_id=<?php echo $milestoneId; ?>&milestone_description=' + milestone_description<?php echo $milestoneId; ?> );
					
					$('#milestone_description<?php echo $milestoneId; ?>').show();
					
					$('#milestone_description_input<?php echo $milestoneId; ?>').hide();
					$('#update_milestone_description<?php echo $milestoneId; ?>').hide();
				}
			});
			
		</script>
		<style type="text/css">
			#milestone<?php echo $milestoneId; ?>{
				cursor: pointer;
			}
			
			#project_milestones_details<?php echo $milestoneId; ?>{
				position: fixed;
				width: 400px;
				top: 150px;
				left: 410px;
				z-index: 100;
				display: none;
				
				border: 1px solid #BBB;
				padding: 20px 30px 30px 30px;
				background-color: #EDEDED;
				text-align: left;
				-webkit-box-shadow: 2px 2px 10px 2px #333;
				-moz-box-shadow: 2px 2px 10px 2px #333;
				box-shadow: 2px 2px 10px 2px #333;
				-webkit-border-radius: 10px;
				-moz-border-radius: 10px;
				border-radius: 10px;
			}
			#project_milestones_details_bg<?php echo $milestoneId; ?>{
				display: none;
				position: fixed;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: #000;
				opacity: 0.7;
				filter: alpha(opacity=60);
				z-index: 10;
			}
			
			#milestone_description_input<?php echo $milestoneId; ?>{
				display: none;
				position: relative;
				width: 368px;
				height: 124px;
				margin: 20px 0;
			}
			#milestone_description<?php echo $milestoneId; ?>:hover{
				color: #b8b8b8;
			}
			#update_milestone_description<?php echo $milestoneId; ?>{
				display: none;
				cursor: pointer;
			}
		</style>
	<?php
	}
	
	function viewProjectMilestones($projectId, $milestoneId, $milestoneTitle, $milestone, $firstName, $lastName, $userId){ ?>
		<div id="project_milestones_details_bg<?php echo $milestoneId; ?>"></div>
		<div id="project_milestones_details<?php echo $milestoneId; ?>" class="project_milestones_details">
			<div id="close_milestone<?php echo $milestoneId; ?>" style="float: right; cursor: pointer;"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0"></div>
			<div class="clear"></div>
            <div class="milestone_desc_err" style="padding-bottom: 10px;"></div>
            <span class="form_title"><?php echo $milestoneTitle; ?></span><br/>
			<div id="milestone_description_result<?php echo $milestoneId; ?>"></div>
			<span style="color: #b8b8b8;">Posted by:</span> <?php echo $firstName.' '.$lastName; ?>
			<?php if($this->getMilestoneCreator($milestoneId) == $userId){ ?>
            	<div class="clear"></div>
				<textarea id="milestone_description_input<?php echo $milestoneId; ?>" ><?php $this->getMilestoneDescription($milestoneId); ?></textarea>
				<p id="milestone_description<?php echo $milestoneId; ?>"><?php $this->getMilestoneDescription($milestoneId); ?></p>
				<div id="update_milestone_description<?php echo $milestoneId; ?>"><button class="orange_02">Update</button></div>
			<?php } 
			else { ?>
				<p><?php $this->getMilestoneDescription($milestoneId, $userId); ?></p>
			<?php } ?>
			<br/><br/>
			<span style="color: #b8b8b8;">Attachments:</span> <span id="milestone_attachment_err<?php echo $milestoneId; ?>"> <span style="color: #A03631;"> Filename already exists</span></span><br/>
			<div id="milestone_attachments<?php echo $milestoneId; ?>">
				<?php $this->showMilestonesAttachment($milestoneId, $userId, $projectId); ?>
			</div>
			<div id="update_edit_attachment_btn<?php echo $milestoneId; ?>">
				<?php $this->loadUploadButton($projectId, $milestoneId, $userId); ?>
			</div>
		</div>
		<style type="text/css">
			#milestone_attachment_err<?php echo $milestoneId; ?>{
				display: none;
				color: RED;
			}
		</style>
	<?php
	}
	
	function loadUploadButton($projectId, $milestoneId, $userId){
		if($this->getMilestoneCreator($milestoneId) == $userId){
			$this->editUploadProjectMilestone($projectId, $milestoneId, $userId);
		}
	}
	
	function loadUploadButton2($projectId, $milestoneId, $userId){
		if($this->getMilestoneCreator($milestoneId) == $userId){
			$this->editUploadProjectMilestone2($projectId, $milestoneId, $userId);
		}
	}
	
	function getMilestoneCreator($milestoneId){
		$getMilestoneCreator = mysql_query("SELECT user_id FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId."");
		$fetchMilestoneCreator = mysql_fetch_array($getMilestoneCreator);
		return $fetchMilestoneCreator['user_id'];
	}

	function getMilestoneDescription($milestoneId){
		$getMilestoneDescription = mysql_query("SELECT milestone FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId."");
		$fetchMilestoneDescription = mysql_fetch_array($getMilestoneDescription);
		echo $fetchMilestoneDescription['milestone'];
	}
	
	function updateMilestoneDescription($milestoneId, $milestone_description){
		$updateMilestoneDescription = mysql_query("UPDATE tbl_project_milestones SET milestone = '".$milestone_description."' WHERE milestone_id = ".$milestoneId."");
		
		if($updateMilestoneDescription){
			echo "<script type='text/javascript'>
				$('#milestone_description".$milestoneId."').text('loading');
				$('#milestone_description".$milestoneId."').load('plugins/project_space/controller2.php?action=updatemilestonedesc&milestone_id=".$milestoneId."');
				$('#all_milestone_description".$milestoneId."').load('plugins/project_space/controller2.php?action=updatemilestonedesc&milestone_id=".$milestoneId."');
			</script>";
		}
	}
	
	function showMilestonesAttachment($milestoneId, $userId, $projectId){
		
		$attachmentDir = "plugins/project_space/attachments/".$milestoneId;
		
		$getMilestoneAttachments = mysql_query("SELECT attachments FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId);
		$fetchMilestoneAttachments = mysql_fetch_array($getMilestoneAttachments );
		$milstoneAttachments = $fetchMilestoneAttachments['attachments'];
		
		$milstoneAttachments = explode(",", $milstoneAttachments);
		
		$attachment_no = 0;
		foreach($milstoneAttachments as $filename){
			$attachment_no = $attachment_no + 1;
			echo "<div id='attached_".$milestoneId."_".$attachment_no."'><a href='plugins/project_space/includes/downloads.php?file=../attachments/".$milestoneId."/".$filename."'>".$filename."</a>"; 
			if($this->getMilestoneCreator($milestoneId) == $userId){ 
				if($filename != ''){?>
					<span id="remove_attachment<?php echo $milestoneId.$attachment_no; ?>"><img src="plugins/project_space/css/images/icon-close_del.png" style="box-shadow: none !important; border: 0; margin: 0;"></span>
				<?php } ?>
				<div id="milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>"></div>
				<div id="remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>">
					<span style="color: #B8B8B8;">Remove attachment?</span> 
					<span id="remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>">Yes</span>|
					<span id="remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>">No</span>
				</div>
			<?php } ?><br/>
			<input type="hidden" id="attachment_filename<?php echo $milestoneId.$attachment_no; ?>" value="<?php echo $filename; ?>" />
			<style type="text/css">
				#remove_attachment<?php echo $milestoneId.$attachment_no; ?>{
					cursor: pointer;
				}
				#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>{
					display: none;
					top: 40%;
					left: 40%;
					text-align: center;
					padding: 3px 7px;
					font-size: .833em;
					background-color: #FFFCDA;
					border: 1px solid #F7DF9D;
					color: #D5AA04;
					margin-bottom: 10px;
				}
				#remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>, #remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>{
					position: relative;
					cursor: pointer;
					margin-right: 5px;
				}
			</style>
			<script type="text/javascript">
				var attachment_filename<?php echo $milestoneId.$attachment_no; ?> = $('#attachment_filename<?php echo $milestoneId.$attachment_no; ?>').val();
				var attachment_filename<?php echo $milestoneId.$attachment_no; ?> = escape(attachment_filename<?php echo $milestoneId.$attachment_no; ?>);
				
				$('#remove_attachment<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').show();
				});
				
				$('#remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
				$('#remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					//$("#attached_<?php echo $milestoneId; ?>_<?php echo $attachment_no; ?>").remove();
					$('#milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>').load('plugins/project_space/controller2.php?action=removemilestoneattachment&milestone_id=<?php echo $milestoneId; ?>&filename=' + attachment_filename<?php echo $milestoneId.$attachment_no; ?> + '&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&attachment_no=<?php echo $attachment_no; ?>' );
					
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
			</script>
		<?php
		echo "</div>";
		}
		/*
		foreach($results as $filename){
			$attachment_no++;
			echo "<a href='plugins/project_space/includes/downloads.php?file=../attachments/".$milestoneId."/".$filename."'>".$filename."</a>"; 
			if($this->getMilestoneCreator($milestoneId) == $userId){ ?>
				<span id="remove_attachment<?php echo $milestoneId.$attachment_no; ?>">Remove</span>
				<div id="milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>"></div>
				<div id="remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>">
					Remove attachment? <br/>
					<div id="remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>">Yes</div>
					<div id="remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>">No</div>
				</div>
			<?php } ?><br/>
			<input type="hidden" id="attachment_filename<?php echo $milestoneId.$attachment_no; ?>" value="<?php echo $filename; ?>" />
			<style type="text/css">
				#remove_attachment<?php echo $milestoneId.$attachment_no; ?>{
					border: 1px solid #bbb;
					cursor: pointer;
				}
				#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>{
					display: none;
					position: fixed;
					border: 1px solid #bbb;
					background: WHITE;
					z-index: 1000;
					top: 40%;
					left: 40%;
				}
				#remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>, #remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>{
					position: relative;
					float: left;
					border: 1px solid #bbb;
					cursor: pointer;
					margin-right: 5px;
				}
			</style>
			<script type="text/javascript">
				var attachment_filename<?php echo $milestoneId.$attachment_no; ?> = $('#attachment_filename<?php echo $milestoneId.$attachment_no; ?>').val();
				var attachment_filename<?php echo $milestoneId.$attachment_no; ?> = escape(attachment_filename<?php echo $milestoneId.$attachment_no; ?>);
				
				$('#remove_attachment<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').show();
				});
				
				$('#remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
				$('#remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>').load('plugins/project_space/controller2.php?action=removemilestoneattachment&milestone_id=<?php echo $milestoneId; ?>&filename=' + attachment_filename<?php echo $milestoneId.$attachment_no; ?> + '&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>' );
					$('#remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
			</script>
		<?php	
		}
		
		closedir($handler);*/
	}
	
	function showMilestonesAttachment2($milestoneId, $userId, $projectId){
		
		$attachmentDir = "plugins/project_space/attachments/".$milestoneId;
		
		$getMilestoneAttachments = mysql_query("SELECT attachments FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId);
		$fetchMilestoneAttachments = mysql_fetch_array($getMilestoneAttachments );
		$milstoneAttachments = $fetchMilestoneAttachments['attachments'];
		
		$milstoneAttachments = explode(",", $milstoneAttachments);
		
		$attachment_no = 0;
		foreach($milstoneAttachments as $filename){
			$attachment_no = $attachment_no + 1;
			echo "<a href='plugins/project_space/includes/downloads.php?file=../attachments/".$milestoneId."/".$filename."'>".$filename."</a>"; 
			if($this->getMilestoneCreator($milestoneId) == $userId){ 
				if($filename != ''){?>
					<span id="all_remove_attachment<?php echo $milestoneId.$attachment_no; ?>">Remove</span>
				<?php } ?>
				<div id="all_milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>"></div>
				<div id="all_remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>">
					Remove attachment? <br/>
					<div id="all_remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>">Yes</div>
					<div id="all_remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>">No</div>
				</div>
			<?php } ?><br/>
			<input type="hidden" id="all_attachment_filename<?php echo $milestoneId.$attachment_no; ?>" value="<?php echo $filename; ?>" />
			<style type="text/css">
				#all_remove_attachment<?php echo $milestoneId.$attachment_no; ?>{
					border: 1px solid #bbb;
					cursor: pointer;
				}
				#all_remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>{
					display: none;
					position: fixed;
					border: 1px solid #bbb;
					background-color: #EDEDED;
					z-index: 1000;
					top: 40%;
					left: 40%;
				}
				#all_remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>, #all_remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>{
					position: relative;
					float: left;
					border: 1px solid #bbb;
					cursor: pointer;
					margin-right: 5px;
				}
			</style>
			<script type="text/javascript">
				var all_attachment_filename<?php echo $milestoneId.$attachment_no; ?> = $('#all_attachment_filename<?php echo $milestoneId.$attachment_no; ?>').val();
				var all_attachment_filename<?php echo $milestoneId.$attachment_no; ?> = escape(all_attachment_filename<?php echo $milestoneId.$attachment_no; ?>);
				
				$('#all_remove_attachment<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#all_remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').show();
				});
				
				$('#all_remove_milestone_attachment_no<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#all_remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
				$('#all_remove_milestone_attachment_yes<?php echo $milestoneId.$attachment_no; ?>').click(function(){
					$('#all_milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>').load('plugins/project_space/controller2.php?action=removeallmilestoneattachment&milestone_id=<?php echo $milestoneId; ?>&filename=' + all_attachment_filename<?php echo $milestoneId.$attachment_no; ?> + '&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&attachment_no=<?php echo $attachment_no; ?>' );
					
					/*$('#milestone_attachment_result<?php echo $milestoneId.$attachment_no; ?>').load('plugins/project_space/controller2.php?action=removemilestoneattachment&milestone_id=<?php echo $milestoneId; ?>&filename=' + attachment_filename<?php echo $milestoneId.$attachment_no; ?> + '&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>' );*/
					
					$('#all_remove_milestone_attachment_confirmation<?php echo $milestoneId.$attachment_no; ?>').hide();
				});
			</script>
		<?php
		}
	}
	
	function updateProjectMilestonesQuery($milestoneId, $userId, $projectId, $filename, $run){
		/// get members of project for notification ///
		
		$projectMembers = mysql_query("SELECT * FROM tbl_project_members WHERE project_id = ".$projectId);
		$userIds = "";
		
		while($row = mysql_fetch_array($projectMembers)){
			$userIds = $userIds.",".$row['user_id'];
		}
		$member_notification = substr($userIds, 1);
		
		$get_prev_attachments = mysql_query("SELECT attachments FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId."");
		$fetch_prev_attachments = mysql_fetch_array($get_prev_attachments);
		$prev_attachments = $fetch_prev_attachments['attachments'];
		
		if($prev_attachments != ''){
			$seperator = ",";
		}
		
		if($run == 'add'){
			$get_prev_attachments_arr = explode(",", $prev_attachments);
			if (!in_array($filename, $get_prev_attachments_arr)) { /// check if filename already exists in database ///
				$editProjectMilestones = mysql_query("UPDATE tbl_project_milestones SET attachments = '".$filename.$seperator.$prev_attachments."', confirmation = 1, member_notification = '".$member_notification."' WHERE milestone_id = ".$milestoneId."");
				
				if($editProjectMilestones){
					echo "	<script type='text/javascript'>
								$('#project_documents_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=".$projectId."' );
								$('#view_more_project_documents_btn".$projectId."').load( 'plugins/project_space/controller2.php?action=reloadviewmoreprojectdocumentsbtn&project_id=".$projectId."' );
								$('#update_show_all_milestone_attachments_popup".$projectId."').load('plugins/project_space/controller2.php?action=updatedocumentslistpopup&project_id=".$projectId."');
								$('#milestone_attachment_err".$milestoneId."').hide();
							</script>";
				}
			}
			else{
				/// show filename already exists message ///
				echo "<script type='text/javascript'> 
					$('#milestone_attachment_err".$milestoneId."').show();
				</script>";
			}

		}
		
		if($run == 'remove'){
			$pieces = explode(",", $prev_attachments);
			
			$key = array_search($filename, $pieces);
			unset($pieces[$key]);
			
			$updated_list = "";
			foreach($pieces as $piece){
				$updated_list = $updated_list.",".$piece;
			}
			$new_updated_list = substr($updated_list, 1);
			$editProjectMilestones = mysql_query("UPDATE tbl_project_milestones SET attachments = '".$new_updated_list."', confirmation = 1, member_notification = '".$member_notification."' WHERE milestone_id = ".$milestoneId."");
			
			if($editProjectMilestones){
				echo "	<script type='text/javascript'>
							$('#project_documents_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=".$projectId."');
							$('#view_more_project_documents_btn".$projectId."').load( 'plugins/project_space/controller2.php?action=reloadviewmoreprojectdocumentsbtn&project_id=".$projectId."' );
							$('#update_show_all_milestone_attachments_popup".$projectId."').load('plugins/project_space/controller2.php?action=updatedocumentslistpopup&project_id=".$projectId."');
							
							$('#milestone_attachments".$milestoneId."').load('plugins/project_space/controller2.php?action=updatemilestoneattachmentsall&milestone_id=".$milestoneId."&user_id=".$userId."&project_id=".$projectId."');
							
							$('#all_milestone_attachments".$milestoneId."').load('plugins/project_space/controller2.php?action=updateallmilestoneattachmentsno&milestone_id=".$milestoneId."&user_id=".$userId."&project_id=".$projectId."');
						</script>";
			}
		}
	}
	
	function removeMilestonesAttachment($milestoneId, $filename, $userId, $projectId, $attachment_no){
	
		$attachmentDir = "plugins/project_space/attachments/".$milestoneId;
		$nfilename = str_replace(' ', '%20', $filename);
		
		if(!file_exists($attachmentDir)) {
			$attachmentDir = "attachments/".$milestoneId;
		}
		
		$checkfile = $attachmentDir."/".$filename;
		
		if(file_exists($checkfile)) {
			unlink($checkfile);?>
				<script type="text/javascript">
					$('#milestone_attachments<?php echo $milestoneId; ?>').text('loading...');
					$('#milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestoneattachments&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&filename=<?php echo $nfilename; ?>&run=remove');
					
					$('#project_documents_list<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=<?php echo $projectId; ?>' );
					
					$('#update_show_all_milestone_attachments_popup<?php echo $projectId; ?>">').load('plugins/project_space/controller2.php?action=updatedocumentslistpopup&project_id=<?php echo $projectId; ?>');
				</script>
			<?php
		}

	}
	
	function removeAllMilestonesAttachment($milestoneId, $filename, $userId, $projectId){
	
		$attachmentDir = "plugins/project_space/attachments/".$milestoneId;
		
		if(!file_exists($attachmentDir)) {
			$attachmentDir = "attachments/".$milestoneId;
		}
		
		$checkfile = $attachmentDir."/".$filename;
		
		if(file_exists($checkfile)) {

			unlink($checkfile);?>
				<script type="text/javascript">
					$('#all_milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updateallmilestoneattachments&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&filename=<?php echo $filename; ?>&run=remove');
					
					$('#project_documents_list<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=<?php echo $projectId; ?>' );
					/*$('#update_show_all_milestone_attachments_popup<?php echo $projectId; ?>">').load('plugins/project_space/controller2.php?action=updatedocumentslistpopup&project_id=<?php echo $projectId; ?>');*/
				</script>
			<?php
		}
	}
	
	function editUploadProjectMilestone($projectId, $milestoneId, $userId){ ?>
		<div id="upload_milestone<?php echo $projectId.$milestoneId; ?>"><span><button class="silver_01">Upload File</button><span/></div><span id="status<?php echo $projectId.$milestoneId; ?>" class="upload_status" ></span>
		<ul id="files<?php echo $projectId.$milestoneId; ?>"></ul>
		<!-- CSS -->
		<style type="text/css">
			#upload_milestone<?php echo $projectId.$milestoneId; ?>{
				
			}
			.darkbg<?php echo $projectId.$milestoneId; ?>{
				background:#ddd !important;
			}
			#status<?php echo $projectId.$milestoneId; ?>{
				font-family:Arial; padding:5px;
			}
			ul#files<?php echo $projectId.$milestoneId; ?>{ list-style:none; padding:0; margin:0; }
			ul#files<?php echo $projectId.$milestoneId; ?> li{ width:188px; float:left;}
			ul#files<?php echo $projectId.$milestoneId; ?> li img{ max-width:180px; max-height:150px; }
			.success<?php echo $projectId.$milestoneId; ?>{ background:#99f099; border:1px solid #339933; }
			.error<?php echo $projectId.$milestoneId; ?>{ background:#f0c6c3; border:1px solid #cc6622; }
		</style>
		
		<!-- Javascript -->
		<script type="text/javascript" >
		$(function(){
			var btnUpload<?php echo $projectId.$milestoneId; ?>=$('#upload_milestone<?php echo $projectId.$milestoneId; ?>');
			var status<?php echo $projectId.$milestoneId; ?>=$('#status<?php echo $projectId.$milestoneId; ?>');
			
			new AjaxUpload(btnUpload<?php echo $projectId.$milestoneId; ?>, {
				action: 'plugins/project_space/includes/edit-upload-milestone.php',
				name: 'uploadfile<?php echo $projectId.$milestoneId; ?>',
				data: {milestone_id: <?php echo $milestoneId; ?>, project_id: <?php echo $projectId; ?>, user_id: <?php echo $userId; ?>},
				onSubmit: function(file<?php echo $projectId.$milestoneId; ?>, ext<?php echo $projectId.$milestoneId; ?>){
					 if (! (ext<?php echo $projectId.$milestoneId; ?> && /^(doc|docx|xls|xlsx|jpg|jpeg|png|gif|pdf)$/.test(ext<?php echo $projectId.$milestoneId; ?>))){ 
						// extension is not allowed 
						status<?php echo $projectId.$milestoneId; ?>.text('Only .doc, .pdf, .xls, .jpg, .png or .gif files are allowed');
						return false;
					}
					status<?php echo $projectId.$milestoneId; ?>.text('Uploading...');
				},
				onComplete: function(file<?php echo $projectId.$milestoneId; ?>, response<?php echo $projectId.$milestoneId; ?>){
					//On completion clear the status
					status<?php echo $projectId.$milestoneId; ?>.text('');
					var file<?php echo $projectId.$milestoneId; ?> = escape(file<?php echo $projectId.$milestoneId; ?>);
					
					var myString = file<?php echo $projectId.$milestoneId; ?>;
					var myArray = myString.split('.');

					//Add uploaded file to list
					if(response<?php echo $projectId.$milestoneId; ?>=="upload successful" || response<?php echo $projectId.$milestoneId; ?>=='upload successful<div id="isChromeWebToolbarDiv" style="display:none"></div>'){
						$('#milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestoneattachments&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&filename=' + file<?php echo $projectId.$milestoneId; ?> + '&run=add' );
						
						$('#all_milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updateallmilestoneattachmentsno&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>');
						
						$('#project_documents_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=<?php echo $projectId; ?>' );
						
					}else{
						$('<li></li>').appendTo('#files<?php echo $projectId.$milestoneId; ?>').text('error').addClass('error');
					}
				}
			});
		});
		</script>
	<?php
	}
	
	function editUploadProjectMilestone2($projectId, $milestoneId, $userId){ ?>
		<div id="upload_milestone<?php echo $projectId.$milestoneId; ?>"><span>Upload File<span></div><span id="status<?php echo $projectId.$milestoneId; ?>" class="upload_status" ></span>
		<ul id="files<?php echo $projectId.$milestoneId; ?>" ></ul>
		<!-- CSS -->
		<style type="text/css">
			#upload_milestone<?php echo $projectId.$milestoneId; ?>{
				padding:15px;
				font-weight:bold; font-size:1.3em;
				font-family:Arial, Helvetica, sans-serif;
				text-align:center;
				background:#f2f2f2;
				color:#3366cc;
				border:1px solid #ccc;
				width:150px;
				cursor:pointer !important;
				-moz-border-radius:5px; -webkit-border-radius:5px;
			}
			.darkbg<?php echo $projectId.$milestoneId; ?>{
				background:#ddd !important;
			}
			#status<?php echo $projectId.$milestoneId; ?>{
				font-family:Arial; padding:5px;
			}
			ul#files<?php echo $projectId.$milestoneId; ?>{ list-style:none; padding:0; margin:0; }
			ul#files<?php echo $projectId.$milestoneId; ?> li{ width:188px; float:left;}
			ul#files<?php echo $projectId.$milestoneId; ?> li img{ max-width:180px; max-height:150px; }
			.success<?php echo $projectId.$milestoneId; ?>{ background:#99f099; border:1px solid #339933; }
			.error<?php echo $projectId.$milestoneId; ?>{ background:#f0c6c3; border:1px solid #cc6622; }
		</style>
		
		<!-- Javascript -->
		<script type="text/javascript" >
		$(function(){
			var btnUpload<?php echo $projectId.$milestoneId; ?>=$('#upload_milestone<?php echo $projectId.$milestoneId; ?>');
			var status<?php echo $projectId.$milestoneId; ?>=$('#status<?php echo $projectId.$milestoneId; ?>');
			
			new AjaxUpload(btnUpload<?php echo $projectId.$milestoneId; ?>, {
				action: 'plugins/project_space/includes/edit-upload-milestone.php',
				name: 'uploadfile<?php echo $projectId.$milestoneId; ?>',
				data: {milestone_id: <?php echo $milestoneId; ?>, project_id: <?php echo $projectId; ?>},
				onSubmit: function(file<?php echo $projectId.$milestoneId; ?>, ext<?php echo $projectId.$milestoneId; ?>){
					 if (! (ext<?php echo $projectId.$milestoneId; ?> && /^(jpg|png|jpeg|gif|pdf|rtf)$/.test(ext<?php echo $projectId.$milestoneId; ?>))){ 
						// extension is not allowed 
						status<?php echo $projectId.$milestoneId; ?>.text('Only .doc, .pdf, .xls, .jpg, .png or .gif files are allowed');
						return false;
					}
					status<?php echo $projectId.$milestoneId; ?>.text('Uploading...');
				},
				onComplete: function(file<?php echo $projectId.$milestoneId; ?>, response<?php echo $projectId.$milestoneId; ?>){
					//On completion clear the status
					status<?php echo $projectId.$milestoneId; ?>.text('');
					var file<?php echo $projectId.$milestoneId; ?> = escape(file<?php echo $projectId.$milestoneId; ?>);
					/*alert(response<?php echo $projectId.$milestoneId; ?>);
					alert(file<?php echo $projectId.$milestoneId; ?>);*/
					//Add uploaded file to list
					/*if(response<?php echo $projectId.$milestoneId; ?>==="success"){
						$('#milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestoneattachments&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&filename=' + file<?php echo $projectId.$milestoneId; ?> + '&run=add' );
						
						$('#all_milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updateallmilestoneattachmentsno&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>');
						
						$('#project_documents_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=<?php echo $projectId; ?>' );
							
						
					} else{
						$('#milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updatemilestoneattachments&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>&filename=' + file<?php echo $projectId.$milestoneId; ?> + '&run=add' );
						
						$('#all_milestone_attachments<?php echo $milestoneId; ?>').load('plugins/project_space/controller2.php?action=updateallmilestoneattachmentsno&milestone_id=<?php echo $milestoneId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>');
						
						$('#project_documents_list<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatedocumentslist&project_id=<?php echo $projectId; ?>' );
					}*/
				}
			});
		});
		</script>
	<?php	
	}
	
	function checkIfUserIsMember($projectId, $userId){
		$checkIfUserIsMember = mysql_query("SELECT * FROM tbl_project_members WHERE project_id = ".$projectId." AND user_id = ".$userId." AND confirmation = 1");
		
		if(mysql_num_rows($checkIfUserIsMember)){
			return mysql_num_rows($checkIfUserIsMember);
		}else{
			return 0;
		}
	}
	
	function getProjectTitle($projectId){
		
	}
	
	function getProjectPosts($projectId, $limit, $userId){ 
		
		if($limit == ''){ $limit = 5; }
		
		$getProjectposts = mysql_query("SELECT tbl_users.user_id AS postedby_id, tbl_users.firstname, tbl_users.lastname, tbl_project_posts.* FROM tbl_users, tbl_project_posts WHERE tbl_users.user_id = tbl_project_posts.user_id AND tbl_project_posts.project_id = ".$projectId." ORDER by post_id DESC LIMIT ".$limit.""); 
		while($row = mysql_fetch_array($getProjectposts)){ ?>
			<div class="post_details_wrap">
				<div class="post_date" id="post_date<?php echo $projectId; ?>">
					<?php echo $row['date_posted']; ?>	
				</div>
				<div class="post_details" id="post_details<?php echo $projectId; ?>" >
					<!--post_details<?php echo $row['post_id']; ?>-->
					<span class="post_name"><a href='?module=myprofile&id=<?php echo $row['postedby_id']; ?>'><?php echo $row['firstname']." ".$row['lastname']; ?></a></span>
					<span class="view_project_description"><?php echo $row['post']; ?></span>
					<div class="project_actions">
                        	<span style="color: #b8b8b8; float: left; margin-top: 8px;"><?php echo $row['date_posted']; ?></span>
                            
                            <div id="like_project_post_btn<?php echo $row['post_id']; ?>" style="float: left; margin-top: 4px; margin-left: 12px;"><?php $this->checkIfUserLikeProjectPost($row['post_id'], $userId, $projectId); ?></div>
							<div id="num_of_post_likes<?php echo $row['post_id']; ?>" style="float: left; margin-top: 8px;"><span><?php $this->numOfLikesProjectPost($row['post_id'], $projectId); ?></span></div>
							
                        <div class="clear"></div>
                    </div>
				</div>
			</div>
			<style type="text/css">
				#like_project_post<?php echo $row['post_id']; ?>, #unlike_project_post<?php echo $row['post_id']; ?>{
					cursor: pointer;
					color: #069;
				}
				
				#like_project_post<?php echo $row['post_id']; ?>:hover, #unlike_project_post<?php echo $row['post_id']; ?>:hover{
					color: #ff7800;
					text-decoration: none;
				}
			</style>
		<?php
		}
		$getNumOfProjectposts = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_project_posts.* FROM tbl_users, tbl_project_posts WHERE tbl_users.user_id = tbl_project_posts.user_id AND tbl_project_posts.project_id = ".$projectId."");
		
		$numOfProjectposts = mysql_num_rows($getNumOfProjectposts);
		$this->viewMoreWhatAmIWorkingOnList($projectId, $limit, $numOfProjectposts, $userId);
	}
	
	function numOfLikesProjectPost($postId, $projectId){ 
		$numOfLikesProjectPost = mysql_query("SELECT likes FROM tbl_project_posts WHERE post_id = ".$postId."");
		$getNumOfLikesProjectPost = mysql_fetch_array($numOfLikesProjectPost);
		
		$usersThatLikeThisPost = $getNumOfLikesProjectPost['likes'];
		
		if(empty($usersThatLikeThisPost)){
			//echo '<img src="plugins/project_space/images/lightbulb_off.png" style="box-shadow: none !important; border: 0; margin: 0;" />';
		}
		else{
			$numOfLikes = explode("," , $usersThatLikeThisPost);
			$likes = count($numOfLikes);
			if($likes > 1){ $likeMsg = '<img src="plugins/project_space/images/lightbulb.png" style="box-shadow: none !important; border: 0; margin: 0;" />'; } else{ $likeMsg = '<img src="plugins/project_space/images/lightbulb.png" style="box-shadow: none !important; border: 0; margin: 0;" />'; }
			
			if($likes > 1){
				$light_text = 'lights';
			}else{ $light_text = 'light'; }
			
			echo "<a href='#".$postId."' title='People who light this' class='lighters'>(".$likes." ".$light_text.")</a>";
			
			//$profile_pics = '';
			//$names = '';
			$details = '';
			foreach($numOfLikes as $lighter_user_id){
				$get_post_lighter = mysql_query("SELECT firstname, lastname, profile_pic FROM tbl_users WHERE user_id = ".$lighter_user_id);
				$post_lighter = mysql_fetch_array($get_post_lighter);
				//echo "<input type='hidden' id='post_lighters_".$postId."' value=".$usersThatLikeThisPost." />";
				//$profile_pics = $profile_pics.",".$post_lighter['profile_pic'];
				//$names = $names.",".$post_lighter['firstname']." ".$post_lighter['lastname'];
				$names = $post_lighter['firstname']." ".$post_lighter['lastname'];
				$names = str_replace(" ", "%20", $names);
				$details = $details.",".$names.":::".$post_lighter['profile_pic'];
			}
			
			$details = substr($details, 1);
			//$profile_pics = substr($profile_pics, 1);
			//$names = substr($names, 1);

			//echo "<input type='hidden' id='post_lighters_pic_".$postId."' value=".$profile_pics." />";
			//echo "<input type='hidden' id='post_lighters_name_".$postId."' value=".$names." />";

			echo "<input type='hidden' id='post_lighters_details_".$postId."' value=".$details." />";
		}
	}
	
	function checkIfUserLikeProjectPost($postId, $userId, $projectId){
		$numOfLikesProjectPost = mysql_query("SELECT likes FROM tbl_project_posts WHERE post_id = ".$postId."");
		$getNumOfLikesProjectPost = mysql_fetch_array($numOfLikesProjectPost);
		$usersThatLikeThisPost = $getNumOfLikesProjectPost['likes'];
		
		$searchUserId = explode(",", $usersThatLikeThisPost);
		$userCheck = array_search($userId, $searchUserId);
		
		if($userId != $searchUserId[$userCheck]){ ?>
			<img src="plugins/project_space/images/lightbulb_off.png" style="box-shadow: none !important; border: 0; margin: 0;" />
			<span id="like_project_post<?php echo $postId; ?>">
				Light
			</span>
			<script type="text/javascript">
				$('#like_project_post<?php echo $postId; ?>').click(function() {
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=likeprojectpost&post_id=<?php echo $postId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>' );
				});
			</script>
		<?php
		}
		
		if($userId == $searchUserId[$userCheck]){ ?>
			<img src="plugins/project_space/images/lightbulb.png" style="box-shadow: none !important; border: 0; margin: 0;" />
			<span id="unlike_project_post<?php echo $postId; ?>">
				Unlight
			</span>
			<script type="text/javascript">
				$('#unlike_project_post<?php echo $postId; ?>').click(function() {
					$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=unlikeprojectpost&post_id=<?php echo $postId; ?>&user_id=<?php echo $userId; ?>&project_id=<?php echo $projectId; ?>' );
				});
			</script>
		<?php
		}
	}
	
	function unlikeProjectPost($postId, $userId, $projectId){
		$numOfLikesProjectPost = mysql_query("SELECT likes FROM tbl_project_posts WHERE post_id = ".$postId."");
		$getNumOfLikesProjectPost = mysql_fetch_array($numOfLikesProjectPost);
		$usersThatLikeThisPost = $getNumOfLikesProjectPost['likes'];
		$numOfLikes = explode("," , $usersThatLikeThisPost);
		
		$numOnList = count($numOfLikes);
		$userCheck = array_search($userId, $numOfLikes); // search on the list the user id //
		
		echo "<script type='text/javascript'>
					$('#like_project_post_btn".$postId."').load('plugins/project_space/controller2.php?action=updatelikepostbutton&post_id=".$postId."&user_id=".$userId."&project_id=".$projectId."');
			</script>";
		
		unset($numOfLikes[$userCheck]); // removes this user from the likes list //
		
		$userIdsLeft = ""; 
		$count = 0;
		
		foreach($numOfLikes as $userId){
			$count = $count + 1;
			if($count != 1){ $seperator = ","; }
			$userIdsLeft = $userId.$seperator.$userIdsLeft;
		}
		
		$unlikeThisPost = mysql_query("UPDATE tbl_project_posts SET likes = '".$userIdsLeft."' WHERE post_id = ".$postId."");
		if($unlikeThisPost){
			echo "<script type='text/javascript'>
					$('#num_of_post_likes".$postId."').load('plugins/project_space/controller2.php?action=updatenumofpostlikes&post_id=".$postId."&user_id=".$userId."&project_id=".$projectId."');
				</script>";
		}
	}
	
	function likeProjectPost($postId, $userId, $projectId){
		$numOfLikesProjectPost = mysql_query("SELECT likes FROM tbl_project_posts WHERE post_id = ".$postId."");
		$getNumOfLikesProjectPost = mysql_fetch_array($numOfLikesProjectPost);
		$usersThatLikeThisPost = $getNumOfLikesProjectPost['likes'];
		
		if(!empty($usersThatLikeThisPost)){
			$seperator = ",";
		}
		else{
			$seperator = "";
		}
		
		$likeThisPost = mysql_query("UPDATE tbl_project_posts SET likes = '".$usersThatLikeThisPost.$seperator.$userId."' WHERE post_id = ".$postId."");
		
		if($likeThisPost){
			echo "<script type='text/javascript'>
					$('#like_project_post_btn".$postId."').load('plugins/project_space/controller2.php?action=updatelikepostbutton&post_id=".$postId."&user_id=".$userId."&project_id=".$projectId."');
					$('#num_of_post_likes".$postId."').load('plugins/project_space/controller2.php?action=updatenumofpostlikes&post_id=".$postId."&user_id=".$userId."&project_id=".$projectId."');
				</script>";
		}
		
	}
	
	function getProjectMembers($projectId, $userId){ 
		$getProjectMembers = mysql_query("SELECT tbl_projects.project_id, tbl_projects.user_id AS project_creator, tbl_users.user_id AS project_member, tbl_users.firstname, tbl_users.lastname, tbl_users.profile_pic, tbl_project_members.user_id, tbl_project_members.confirmation FROM tbl_projects, tbl_users, tbl_project_members WHERE tbl_users.user_id = tbl_project_members.user_id AND tbl_projects.project_id = tbl_project_members.project_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_members.confirmation = 1 ORDER BY tbl_users.lastname LIMIT 3");
		
		$getTotalProjectMembers = mysql_query("SELECT tbl_projects.project_id, tbl_projects.user_id AS project_creator, tbl_users.user_id AS project_member, tbl_users.firstname, tbl_users.lastname, tbl_users.profile_pic, tbl_project_members.confirmation FROM tbl_projects, tbl_users, tbl_project_members WHERE tbl_users.user_id = tbl_project_members.user_id AND tbl_projects.project_id = tbl_project_members.project_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_members.confirmation = 1 ORDER BY tbl_users.lastname");
		
		$no_of_members = mysql_num_rows($getTotalProjectMembers);
	
		while($row = mysql_fetch_array($getProjectMembers)){ 
			if($row['profile_pic'] == ''){
				$profile_pic = 'default.jpg';
			}
			else{
				$profile_pic = $row['profile_pic'];
			} ?>
				<div>
                    <div id="user_thumb"><img src="plugins/users/img/profile/thumbnail/<?php echo $profile_pic; ?>" id="user_avatar"></div>
                    <div id="user_name"><a href='?module=myprofile&id=<?php echo $row['project_member']; ?>'><?php echo $row['firstname']." ".$row['lastname']; ?></a></div>
    				
                    <?php if($row['project_creator'] == $userId && $row['project_member'] != $row['project_creator']){ ?>
                    <div id="remove_member<?php echo $projectId.$row['project_member']; ?>"><img src="plugins/project_space/css/images/icon-close_del.png" style="box-shadow: none !important; border: 0; margin: 0" /></div>
                    <div class="clear"></div>        	
                    
                    <?php 
                        $this->removeMemberConfirmation($projectId, $row['project_member'], $userId);
                        $this->projectMembersJquery($projectId, $row['project_member'], $row['project_creator'], $userId);
                    } 
                    ?>
              	</div>
               	<div class="clear">
                </div>
		<?php
		}	
		
		if($no_of_members > 3){ ?>
			<a href="#top"><div id="view_more_project_members_btn<?php echo $projectId; ?>" class="btn">More >></div></a>
			<script type="text/javascript">
				$('#view_more_project_members_btn<?php echo $projectId; ?>').click(function(){
					$('#view_project_members<?php echo $projectId; ?>').show();
					$('#view_project_members_bg<?php echo $projectId; ?>').show();
				});
			</script>
		<?php
		}
	}
	
	function getProjectMembersNo($projectId, $userId){
		$getProjectMembers = mysql_query("SELECT tbl_projects.project_id, tbl_projects.user_id AS project_creator, tbl_users.user_id AS project_member, tbl_users.firstname, tbl_users.lastname, tbl_users.profile_pic, tbl_project_members.confirmation FROM tbl_projects, tbl_users, tbl_project_members WHERE tbl_users.user_id = tbl_project_members.user_id AND tbl_projects.project_id = tbl_project_members.project_id AND tbl_projects.project_id = ".$projectId." AND tbl_project_members.confirmation = 1 ORDER BY tbl_users.lastname");
		
		//echo mysql_num_rows($getProjectMembers);
		
		if(mysql_num_rows($getProjectMembers) > 3){
			echo "More >>";
		}
		else{
			echo "<style type='text/css'>
					#view_more_project_members_btn".$projectId."{
						display: none;
					}
				</style>";
		}
	}
	
	function projectMembersJquery($projectId, $memberId, $projectCreator, $userId){ ?>
		<script type="text/javascript">
			var plug_path = 'plugins/project_space/';
			
			$('#remove_member<?php echo $projectId.$memberId; ?>').click(function() {
				$('#remove_member_confirmation<?php echo $projectId.$memberId; ?>').show();
			});
			
			$('#confirm_remove_member<?php echo $projectId.$memberId; ?>').click(function() {
				$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=removeprojectmembers&project_id=<?php echo $projectId; ?>&member_id=<?php echo $memberId; ?>&project_creator=<?php echo $projectCreator; ?>&user_id=<?php echo $userId; ?>' );
				$('#view_more_project_members_btn<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=reloadviewmoremembers&project_id=<?php echo $projectId; ?>&member_id=<?php echo $memberId; ?>&user_id=<?php echo $userId; ?>');
				$('#remove_member_confirmation<?php echo $projectId.$memberId; ?>').hide();	
				
				$('#view_project_memberslist<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=updateviewmoreprojectmembers&project_id=<?php echo $projectId; ?>');
			});
			
			$('#cancel_remove_member<?php echo $projectId.$memberId; ?>').click(function() {
				$('#remove_member_confirmation<?php echo $projectId.$memberId; ?>').hide();
			});
			
			$('#bgdisabler<?php echo $projectId; ?>').click(function() {
				$('#remove_member_confirmation<?php echo $projectId.$memberId; ?>').hide();
			});
			
		</script>
		<style type="text/css">
			#remove_member<?php echo $projectId.$memberId; ?>{
				cursor: pointer;
				position: relative;
				float: right;
				margin-left: 13px;
				margin-top: 6px;
			}
			
			#remove_member_confirmation<?php echo $projectId.$memberId; ?>{
				/*position: fixed;
				background-color: #EDEDED;*/
				display: none;
				z-index: 1000;
				width: 118px;
				top: 30%;
				left: 30%;
				text-align: center;
				padding: 3px 7px;
				font-size: .833em;
				background-color: #FFFCDA;
				border: 1px solid #F7DF9D;
				color: #D5AA04;
				margin-bottom: 10px;
			}
			
			#confirm_remove_member<?php echo $projectId.$memberId; ?>, #cancel_remove_member<?php echo $projectId.$memberId; ?>{
				cursor: pointer;
			}
			
			.remove_member_project{
				cursor: pointer;
				position: relative;
				float: right;
				margin-right: 80px;
				margin-top: 6px;
			}
		</style>
	<?php	
	}
	
	function removeMemberConfirmation($projectId, $memberId, $userId){ ?>
		<div id="remove_member_confirmation<?php echo $projectId.$memberId; ?>">
			<span style="color: #B8B8B8;">Delete?</span>
			
			<span id="confirm_remove_member<?php echo $projectId.$memberId; ?>"> Yes</span> | <span id="cancel_remove_member<?php echo $projectId.$memberId; ?>">No</span>
		</div>
	<?php
	}
	
	function removeMemberConfirmationAll($projectId, $memberId ,$projectCreator, $userId){ ?>
		<div id="remove_member_confirmation_all<?php echo $projectId.$memberId; ?>">
			<span style="color: #B8B8B8;">Delete? </span>
			
			<span id="confirm_remove_member_all<?php echo $projectId.$memberId; ?>"> Yes</span> | <span id="cancel_remove_member_all<?php echo $projectId.$memberId; ?>">No</span>
		</div>
		<style>
			#remove_member_confirmation_all<?php echo $projectId.$memberId; ?>{
				/*position: fixed;
				background-color: #EDEDED;*/
				display: none;
				z-index: 1000;
				width: 118px;
				top: 30%;
				left: 30%;
				text-align: center;
				padding: 3px 7px;
				font-size: .833em;
				background-color: #FFFCDA;
				border: 1px solid #F7DF9D;
				color: #D5AA04;
				margin-bottom: 10px;
			}
			#confirm_remove_member_all<?php echo $projectId.$memberId; ?>, #cancel_remove_member_all<?php echo $projectId.$memberId; ?>{
				cursor: pointer;
			}
		</style>
		<script>
			$('#confirm_remove_member_all<?php echo $projectId.$memberId; ?>').click(function() {
				$('#result<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=removeprojectmembers&project_id=<?php echo $projectId; ?>&member_id=<?php echo $memberId; ?>&project_creator=<?php echo $projectCreator; ?>&user_id=<?php echo $userId; ?>' );
				$('#view_more_project_members_btn<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=reloadviewmoremembers&project_id=<?php echo $projectId; ?>&user_id=<?php echo $memberId; ?>');
				$('#remove_member_confirmation<?php echo $projectId.$memberId; ?>').hide();	
				
				$('#view_project_memberslist<?php echo $projectId; ?>').load('plugins/project_space/controller2.php?action=updateviewmoreprojectmembers&project_id=<?php echo $projectId; ?>');
			});
			$('#cancel_remove_member_all<?php echo $projectId.$memberId; ?>').click(function() {
				$('#remove_member_confirmation_all<?php echo $projectId.$memberId; ?>').hide();
			});
		</script>
	<?php
	}
	
	function viewAllProjectMembers($projectId, $userId){ ?>
		<div id="view_project_members_bg<?php echo $projectId; ?>"></div>
		<div id="view_project_members<?php echo $projectId; ?>">
			<div id="close_view_project_members<?php echo $projectId; ?>" class="btn" style="float: right;"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0 0 8px 0"></div>
            <br />
            <div class="form_title">Project Members</div>
            <hr />
            <div class="mart20"></div>
			<script type="text/javascript">
				$('#close_view_project_members<?php echo $projectId; ?>').click(function(){
					$('#view_project_members<?php echo $projectId; ?>').hide();
					$('#view_project_members_bg<?php echo $projectId; ?>').fadeOut();
				});
				$('#view_project_members_bg<?php echo $projectId; ?>').click(function(){
					$('#view_project_members<?php echo $projectId; ?>').hide();
					$('#view_project_members_bg<?php echo $projectId; ?>').fadeOut();
				});
			</script>
			<div id="view_project_memberslist<?php echo $projectId; ?>" style="overflow-y: scroll; height: 396px">
				<?php $this->viewAllProjectMembersQuery($projectId, $userId); ?>
			</div>

		</div>
	<?php
	}
	
	function checkIfUserIsAlreayMember($projectId, $userId){
		$showAllUsers = mysql_query("SELECT tbl_users.*, tbl_projects.*, tbl_projects.user_id AS project_creator, tbl_project_members.*, tbl_project_members.user_id AS member_id, tbl_projects.user_id AS project_creator FROM tbl_users, tbl_projects, tbl_project_members WHERE tbl_users.user_id = tbl_project_members.user_id AND tbl_projects.project_id = tbl_project_members.project_id AND tbl_projects.project_id = ".$projectId." ORDER BY lastname ASC");
		
		$getMembers = '';
		
		while($row = mysql_fetch_array($showAllUsers)){
			$getMembers = $getMembers.",".$row['member_id'];
		}
		
		return substr($getMembers, 1);
	}
	
	function viewAllProjectMembersQuery($projectId, $userId){
		$showAllUsers = mysql_query("SELECT tbl_users.*, tbl_projects.*, tbl_projects.user_id AS project_creator, tbl_project_members.*, tbl_project_members.user_id AS member_id, tbl_projects.user_id AS project_creator FROM tbl_users, tbl_projects, tbl_project_members WHERE tbl_users.user_id = tbl_project_members.user_id AND tbl_projects.project_id = tbl_project_members.project_id AND tbl_projects.project_id = ".$projectId." ORDER BY lastname ASC");
		while($row = mysql_fetch_array($showAllUsers)){
			if($row['profile_pic'] == ''){
				$profile_pic = 'default.jpg';
			}
			else{
				$profile_pic = $row['profile_pic'];
			}
			?>
            <div>
				<div id="user_thumb"><img src="plugins/users/img/profile/thumbnail/<?php echo $profile_pic; ?>" id="user_avatar" /></div>
            	<div id="user_name2"><a href='?module=myprofile&id=<?php echo $row['member_id']; ?>'><?php echo $row['firstname']." ".$row['lastname']; ?></a></div>
				<?php if($row['project_creator'] != $row['member_id'] && $userId == $row['project_creator']){ ?>
					<div id="remove_member_all<?php echo $projectId.$row['member_id']; ?>" class="remove_member_project"><img src="plugins/project_space/css/images/icon-close_del.png" style="box-shadow: none !important; border: 0; margin: 0" /></div>
				<?php } ?>
			</div>
            <div class="clear"></div>
			<?php $this->removeMemberConfirmationAll($projectId, $row['member_id'], $row['project_creator'], $userId); ?>
			<script type="text/javascript">
				$("#remove_member_all<?php echo $projectId.$row['member_id']; ?>").click(function(){
					$("#remove_member_confirmation_all<?php echo $projectId.$row['member_id']; ?>").show();
				});
			</script>
			<?php
		}
	}

	function addProjectMembers($projectId, $userId){ 
		$memberIdArr = explode(',', $this->checkIfUserIsAlreayMember($projectId, $userId));
		$project_creator_id = $this->getProjectCreatorID($projectId, $userId);
		?>
		<div id="add_project_memberslist<?php echo $projectId; ?>">
		<?php
		$showAllUsers = mysql_query("SELECT user_id, firstname, lastname, profile_pic FROM tbl_users ORDER BY firstname ASC");
		
		while($row = mysql_fetch_array($showAllUsers)){
			if($row['profile_pic'] == ''){
				$profile_pic = 'default.jpg';
			}
			else{
				$profile_pic = $row['profile_pic'];
			}

			if($project_creator_id != $row['user_id']){
				if(!in_array($row['user_id'],$memberIdArr)){ ?>
				<div style="line-height: 36px; " id="nonMember<?php echo $row['user_id']; ?>">
					<div style="margin: 6px 12px 0 0; float: left;"><input type="checkbox" name="projectmembercheckbox<?php echo $projectId; ?>" id="" value="<?php echo $row['user_id']; ?>"></div>
					<div style="float: left; margin-right: 6px;"><img src="plugins/users/img/profile/thumbnail/<?php echo $profile_pic; ?>" id="user_avatar" /></div>
					<div style="float: left; line-height: 25px;"><?php echo $row['firstname']." ".$row['lastname']; ?></div>
					<div class="clear"></div>
				</div>
			<?php
				}
			} 
		} 
		?>
		</div>
	<?php
	}
	
	function addProjectMembersQuery($projectId, $project_members, $userId){
		$project_creator = mysql_query("SELECT user_id FROM tbl_projects WHERE project_id = ".$projectId);
		$get_project_creator = mysql_fetch_array($project_creator);
		$getProjectMembers = explode(",", $project_members);
		
		//echo "<script>alert('".$get_project_creator['user_id']."');</script>";
		
		foreach($getProjectMembers as $user_id){
			if($user_id != ''){
				$checkIfUserIsMember = mysql_query("SELECT * FROM tbl_project_members WHERE project_id = '".$projectId."' AND user_id = ".$user_id."");
				
				if(mysql_num_rows($checkIfUserIsMember) == 0){
					$addProjectMembers = mysql_query("INSERT INTO tbl_project_members SET project_id = '".$projectId."', user_id = ".$user_id.", confirmation = 1, notification = 0");
					echo "<script type='text/javascript'>$('#addmembersmsg".$projectId."').text('Members Added Successfully');</script>";
				}
			}
		}
		
		echo "<script type='text/javascript'>
			$('#project_members_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updateprojectmembers&project_id=".$projectId."&user_id=".$userId."' );
			$('#view_project_memberslist".$projectId."').load( 'plugins/project_space/controller2.php?action=updateviewmoreprojectmembers&project_id=".$projectId."&user_id=".$userId."' );
			$('#result".$projectId."').load( 'plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$projectId."&user_id=".$userId."&project_creator_id=".$get_project_creator['user_id']."' );
			$('#addProjectMembersForm".$projectId."').load('plugins/project_space/controller2.php?action=updateaddmembers&project_id=".$projectId."&user_id=".$userId."');
			$('#add_members_success".$projectId."').show();
			$('#add_members_success".$projectId."').fadeOut(4000);
		</script>";
		/*$('#add_project_members".$projectId."').delay(2000).fadeOut();
		$('#add_project_members_bg".$projectId."').delay(2000).fadeOut();*/
	}
	
	function removeProjectMembers($projectId, $memberId, $projectCreator, $userId){
		$removeProjectMember = mysql_query("DELETE FROM tbl_project_members WHERE project_id = ".$projectId." AND user_id = ".$memberId."");
		
		if($removeProjectMember){
			echo "<script type='text/javascript'>
				$('#project_members_list".$projectId."').load( 'plugins/project_space/controller2.php?action=updateprojectmembers&project_id=".$projectId."&user_id=".$projectCreator."' );
				$('#view_project_memberslist".$projectId."').load( 'plugins/project_space/controller2.php?action=updateviewmoreprojectmembers&project_id=".$projectId."&user_id=".$userId."' );
				$('#addProjectMembersForm".$projectId."').load('plugins/project_space/controller2.php?action=updateaddmembers&project_id=".$projectId."&user_id=".$userId."');
			</script>";
		}
	}
	
	function viewMoreProjectMembers($projectId){
		
	}
	
	
	//////////////////////////////// for project status update ////////////////////////////////
	
	function whatAmIWorkingOn($projectId, $userId){ ?>
		<input type="text" name="whatAmIWorkingOn<?php echo $projectId; ?>" id="whatAmIWorkingOn<?php echo $projectId; ?>" value="" placeholder="What am I working on right now?" >
		<div id="whatAmIWorkingOn_btn<?php echo $projectId; ?>" class="btn"><button class="silver_01" style="font-size: 0.917em !important; letter-spacing: 1px; padding: 0 10px 0 10px !important;">Post</button></div>
	<?php
	}
	
	function postWhatAmIWorkingOn($projectId, $userId, $post){
		$project_creator = mysql_query("SELECT user_id FROM tbl_projects WHERE project_id = ".$projectId);
		$get_project_creator = mysql_fetch_array($project_creator);
		$projectMembers = mysql_query("SELECT * FROM tbl_project_members WHERE project_id = ".$projectId." AND user_id != ".$userId);
		
		$userIds = "";
		while($row = mysql_fetch_array($projectMembers)){
			$userIds = $userIds.",".$row['user_id'];
		}
		$member_notification = substr($userIds, 1);
		
	
		$postWhatAmIWorkingOn = mysql_query("INSERT INTO tbl_project_posts SET project_id = ".$projectId.", user_id = ".$userId.", post = '".$post."', date_posted = '".date('Y')."-".date('m')."-".date('d')."', likes = '', member_notification = '".$member_notification."'");
		
		if($postWhatAmIWorkingOn){ 
			echo "<script type='text/javascript'>
					$('#project_posts".$projectId."').text('loading...');
					$('#project_posts".$projectId."').load( 'plugins/project_space/controller2.php?action=updatewhatamiworkingon&project_id=".$projectId."&user_id=".$userId."' );
					$('#result".$projectId."').load( 'plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$projectId."&user_id=".$userId."&project_creator_id=".$get_project_creator['user_id']."' );
				</script>";
		}
	}
	
	function checkIfUserCanApproveNewProject(){
		$user_functions = explode("," , USER_FUNCTIONS);
		$function_id = array_search('Publish', $user_functions);

		$user_plugins = explode(",", USER_PLUGINS);
		$plugin_id = array_search('Project Space', $user_plugins);
		
		if(is_numeric($plugin_id) && is_numeric($function_id)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function notificationForModerator($user_id, $project_id){
		
			if($project_creator_id != ''){			
				$projectNotificationForUser = mysql_query("SELECT user_id FROM tbl_projects WHERE user_id = ".$project_creator_id." AND updated = 1 AND notification = ''");
				$project = 0;
				while($getProjectNotificationForUser = mysql_fetch_array($projectNotificationForUser)){
					$project = $project + 1;
				}			
			}
			else{
				/// check if logged in user has not yet checked if the project he/she posted has been approved or disapproved ///
				$projectNotificationForUser = mysql_query("SELECT user_id FROM tbl_projects WHERE user_id = '".$user_id."' AND updated = 1 AND notification = ''");
				$project = 0;
				while($getProjectNotificationForUser = mysql_fetch_array($projectNotificationForUser)){
					$project = $project + 1;
				}
			}		
			
			//Post Notif
			$getProjectMembersForPostUpdate = mysql_query("SELECT user_id, member_notification FROM tbl_project_posts");
			$projects_posts = 0;
			
			while($count_post = mysql_fetch_array($getProjectMembersForPostUpdate)){
				$list = explode(",",$count_post['member_notification']);
				
				if($count_post['member_notification'] != ''){
					if(in_array($user_id,$list)){	
						$projects_posts = $projects_posts + 1;
					}elseif($countNow['user_id'] == $user_id){				
						$projects_posts = $projects_posts + 1;
					}
				}
			}	
			
			//check if logged in user has not yet checked if he/she is added on the project ///
			$projects_member = 0;
			$projectMemberNotificationForUser = mysql_query("SELECT user_id FROM tbl_project_members WHERE user_id = '". $user_id ."' AND notification = 0");
			while($getProjectMemberNotificationForUser = mysql_fetch_array($projectMemberNotificationForUser)){
				$projects_member = $projects_member + 1;
			}
			
			//get all user ids with access to project space approval ... here ... //
			//MODERATOR ONLY
			$projects_moderator = 0;		
			$projectModeratorNotification = mysql_query("SELECT notification FROM tbl_projects WHERE updated = 0");
			while($projectModeratorRow = mysql_fetch_array($projectModeratorNotification)){
				if($projectModeratorRow['updated'] == 0){
					$projects_moderator = $projects_moderator + 1;
				}
			}
			
			
			/// new project milestone left notification for logged in user ///
			$addMilestoneNotificationForUser = mysql_query("SELECT member_notification FROM tbl_project_milestones");
			$projects_milestones = 0;
			while($row_milestone = mysql_fetch_array($addMilestoneNotificationForUser)){
				$list = explode(",",$row_milestone['member_notification']);
				
				if($row_milestone['member_notification'] != ''){				
					if(in_array($user_id,$list)){	
						$projects_milestones = $projects_milestones + 1;
					}elseif($countNow['user_id'] == $user_id){				
						$projects_milestones = $projects_milestones + 1;
					}
				}
			}
			
			$ctr = $project + $projects_posts + $projects_member  + $projects_milestones + $projects_moderator ;		
			
			if($ctr != 0){
				echo $ctr; 
			}else{
				echo '<script>
					$(document).ready(function() {
						$("#project_space_notificationLeft").fadeOut(500);	
						$("#project_space_notificationLeft").hide();										
					});	
					</script>';		
			}
	}
	
	function createProjectNotificationsFile($user_id, $project_id, $project_creator_id=''){
		// require_once('left.php');
		// $notif = new ProjectNotif();
		// $notif->CountNotifs($user_id, $project_id, $project_creator_id);	
		
		
		//if($_SESSION['intrnt_usrlvl'] != 1){
			if($project_creator_id != ''){			
				$projectNotificationForUser = mysql_query("SELECT user_id FROM tbl_projects WHERE user_id = ".$project_creator_id." AND updated = 1 AND notification = ''");
				$project = 0;
				while($getProjectNotificationForUser = mysql_fetch_array($projectNotificationForUser)){
					$project = $project + 1;
				}			
			}
			else{
				/// check if logged in user has not yet checked if the project he/she posted has been approved or disapproved ///
				$projectNotificationForUser = mysql_query("SELECT user_id FROM tbl_projects WHERE user_id = '".$user_id."' AND updated = 1 AND notification = ''");
				$project = 0;
				while($getProjectNotificationForUser = mysql_fetch_array($projectNotificationForUser)){
					$project = $project + 1;
				}
			}		
			
			//Post Notif
			$getProjectMembersForPostUpdate = mysql_query("SELECT user_id, member_notification FROM tbl_project_posts");
			$projects_posts = 0;
			
			while($count_post = mysql_fetch_array($getProjectMembersForPostUpdate)){
				$list = explode(",",$count_post['member_notification']);
				
				if($count_post['member_notification'] != ''){
					if(in_array($user_id,$list)){	
						$projects_posts = $projects_posts + 1;
					}elseif($countNow['user_id'] == $user_id){				
						$projects_posts = $projects_posts + 1;
					}
				}
			}	
			
			//check if logged in user has not yet checked if he/she is added on the project ///
			$projects_member = 0;
			$projectMemberNotificationForUser = mysql_query("SELECT user_id FROM tbl_project_members WHERE user_id = '". $user_id ."' AND notification = 0");
			while($getProjectMemberNotificationForUser = mysql_fetch_array($projectMemberNotificationForUser)){
				$projects_member = $projects_member + 1;
			}
			
			//get all user ids with access to project space approval ... here ... //
			//MODERATOR ONLY
			$projects_moderator = 0;
		if($this->checkIfUserIsModerator($user_id) == 1){
			$projectModeratorNotification = mysql_query("SELECT notification FROM tbl_projects WHERE updated = 0");
			while($projectModeratorRow = mysql_fetch_array($projectModeratorNotification)){
				if($projectModeratorRow['updated'] == 0){
					$projects_moderator = $projects_moderator + 1;
				}
			} 
		}
			
			/// new project milestone left notification for logged in user ///
			$addMilestoneNotificationForUser = mysql_query("SELECT member_notification FROM tbl_project_milestones");
			$projects_milestones = 0;
			while($row_milestone = mysql_fetch_array($addMilestoneNotificationForUser)){
				$list = explode(",",$row_milestone['member_notification']);
				
				if($row_milestone['member_notification'] != ''){				
					if(in_array($user_id,$list)){	
						$projects_milestones = $projects_milestones + 1;
					}elseif($countNow['user_id'] == $user_id){				
						$projects_milestones = $projects_milestones + 1;
					}
				}
			}
			
			$ctr = $project + $projects_posts + $projects_member  + $projects_milestones + $projects_moderator ;		
			
			
		
		if($ctr != 0){
				echo $ctr; 
			}else{
				echo '<script>
					$(document).ready(function() {
						$("#project_space_notificationLeft").fadeOut(500);	
						$("#project_space_notificationLeft").hide();										
					});	
					</script>';		
			}
	}
	
	function whatAmIWorkingOnList($projectId){
	
	}
	
	function viewMoreWhatAmIWorkingOnList($projectId, $limit, $numOfProjectposts, $userId){ 
		
		if($numOfProjectposts <= $limit){ ?>
			<div id="no_more_project_posts<?php echo $projectId; ?>" class="noMoreRecords">No more posts to show</div>
		<?php
		}
		else{
			?>
			<div id="view_more_project_posts<?php echo $projectId; ?>" class="loadMoreRecords"><span><img src="plugins/project_space/css/images/load_icon.gif" class="valignb marr6 null_efx">Load More Posts</span></div>
			<script type="text/javascript">
				$('#view_more_project_posts<?php echo $projectId; ?>').click(function() {
					var newlimit = <?php echo $limit; ?> + 5;

					$('#project_posts<?php echo $projectId; ?>').load( 'plugins/project_space/controller2.php?action=updatewhatamiworkingon&project_id=<?php echo $projectId; ?>&limit=' + newlimit + '&user_id=<?php echo $userId; ?>');

				});
			</script>
		<?php
		}
	}

	function showAllMilestoneAttachments($projectId){
		
		$getAllMilestoneAttachments = mysql_query("SELECT CONCAT(tbl_users.firstname, ' ', tbl_users.lastname) as milestone_poster, tbl_project_milestones.milestone_id, tbl_project_milestones.attachments, tbl_project_milestones.user_id AS uploader_id FROM tbl_users, tbl_project_milestones WHERE tbl_users.user_id = tbl_project_milestones.user_id AND tbl_project_milestones.project_id = ".$projectId." AND tbl_project_milestones.attachments != '' ORDER by tbl_project_milestones.milestone_id DESC");
		
		$no_of_attachments = mysql_num_rows($getAllMilestoneAttachments);
		
		if($no_of_attachments == 0){ ?>
			<style type="text/css">
				#project_documents_list<?php echo $projectId; ?>{
					height: 52px;
					overflow: hidden;
					color: #B8B8B8;
				}
			</style>
		<?php
			echo "No document has been uploaded yet";
		}
		
		else{
			$attachment_count = 0;
			while($row = mysql_fetch_array($getAllMilestoneAttachments)){
				$attachments = explode(",", $row['attachments']);
				foreach($attachments as $attachment){
					$attachment_count++;
					$attachment_limited = substr($attachment, 0, 17);
					if(strlen($attachment) > 17){
						$dots = "...";
					}
					echo "	<div class='milestone_list'>
								<a href='plugins/project_space/includes/downloads.php?file=../attachments/".$row['milestone_id']."/".$attachment."'>".$attachment_limited.$dots."</a><br/>
								<a href='?module=myprofile&id=".$row['uploader_id']."' id='user_milstone'>".$row['milestone_poster']."</a>
							</div>";
				}
			}
			
			if($attachment_count <= 4){
				$attachment_list_height = $attachment_count * 52;
			}
			if($attachment_count > 5){
				$attachment_list_height = 200;
			}
			?>
			<style type="text/css">
				#project_documents_list<?php echo $projectId; ?>{
					height: <?php echo $attachment_list_height; ?>px;
					overflow: hidden;
				}
			</style>
		<?php
		}
	}
	
	function showAllMilestoneAttachmentsNo($projectId){
		
		$getAllMilestoneAttachments = mysql_query("SELECT milestone_id, attachments FROM tbl_project_milestones WHERE project_id = ".$projectId." AND attachments != '' ORDER by milestone_id");
		
		$attachment_list = "";
		
		while($row = mysql_fetch_array($getAllMilestoneAttachments)){
			$attachment_list = $attachment_list.",".$row['attachments'];
		}
		$attachment_list = substr($attachment_list, 1);
		
		$attachments = explode(",", $attachment_list);
		$attachment_count = 0;
		
		foreach($attachments as $attachment){
			$attachment_count++;
		}		
		
		if($attachment_count > 5){
			echo "More >>";
		}
		else{
			echo "<style type='text/css'>
					#view_more_project_documents_btn".$projectId."{
						display: none;
					}
				</style>";
		}
		
	
	}
	
	function showAllMilestoneAttachmentsPopup($projectId){ ?>
		<div id="show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>"></div>
		<div id="show_all_milestone_attachments_popup<?php echo $projectId; ?>">
			<div id="close_show_all_milestone_attachments_popup<?php echo $projectId; ?>" class="btn"><img src="plugins/project_space/css/images/popup_close.gif" style="box-shadow: none !important; border: 0; margin: 0 0 8px 0; float: right;"></div>
            <br />
            <div class="form_title">Documents</div><hr />
            <div class="mart10"></div>
			<?php
			$getAllMilestoneAttachments = mysql_query("SELECT CONCAT(tbl_users.firstname, ' ', tbl_users.lastname) as milestone_poster, tbl_project_milestones.milestone_id, tbl_project_milestones.attachments, tbl_project_milestones.user_id AS uploader_id FROM tbl_users, tbl_project_milestones WHERE tbl_users.user_id = tbl_project_milestones.user_id AND tbl_project_milestones.project_id = ".$projectId." AND tbl_project_milestones.attachments != '' ORDER by tbl_project_milestones.milestone_id DESC");
			
			echo "<div class='milestone_list_wrap'>";
			while($row = mysql_fetch_array($getAllMilestoneAttachments)){
				$attachments = explode(",", $row['attachments']);
				foreach($attachments as $attachment){
					echo "	<div class='milestone_list'>
								<a href='plugins/project_space/includes/downloads.php?file=../attachments/".$row['milestone_id']."/".$attachment."' style='color: #686868; text-decoration: none;'>".$attachment."</a><br/>
								<a href='?module=myprofile&id=".$row['uploader_id']."'>".$row['milestone_poster']."</a>
							</div>";
				}
			}
			echo "</div>";
			?>
		</div>
		<script type="text/javascript">
			$('#close_show_all_milestone_attachments_popup<?php echo $projectId; ?>').click(function(){
				$('#show_all_milestone_attachments_popup<?php echo $projectId; ?>').hide();
				$('#show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>').fadeOut();
			});
			$('#show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>').click(function(){
				$('#show_all_milestone_attachments_popup<?php echo $projectId; ?>').hide();
				$('#show_all_milestone_attachments_popup_bg<?php echo $projectId; ?>').fadeOut();
			});
		</script>
	<?php
	}
	
	function checkIfThereAreNotifications(){
		$projectNotificationForUser = mysql_query("SELECT COUNT(*) AS new_notifications FROM tbl_projects WHERE user_id = ".USER_ID." AND updated = 1 AND notification = 0");
		
		$addMemberNotificationForUser = mysql_query("SELECT COUNT(*) AS new_member_notification FROM tbl_project_members WHERE user_id = ".USER_ID." AND notification = 0");
		
		$getMemberNotificationForUser = mysql_fetch_array($addMemberNotificationForUser);
		$getProjectNotificationForUser = mysql_fetch_array($projectNotificationForUser);
		
		$total_notifications = $getMemberNotificationForUser['new_member_notification'] + $getProjectNotificationForUser['new_notifications'];
		
		if($total_notifications > 0){
			return 1;
		}
	}
		
	function showNotif(){
		echo '<span class="notificationLeft" id="project_space_notificationLeft" style="color: #F00; font-weight: bold; font-size: 11px;"></span>';
	}
	
	
	function addProjectNotificationForUser($userId){
		
			$project_id_member_notification = "";
			
			$addProjectNotificationForUser = mysql_query("SELECT * FROM tbl_projects WHERE user_id = ".$userId." AND updated = 1 AND notification = ''");
			
			$addMemberNotificationForUser = mysql_query("SELECT tbl_projects.project_title, tbl_project_members.* FROM tbl_projects, tbl_project_members WHERE tbl_projects.project_id = tbl_project_members.project_id AND tbl_project_members.user_id = ".$userId." AND tbl_project_members.notification = 0");
			
			$addPostNotificationForUser = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_title, tbl_project_posts.*, tbl_project_posts.user_id AS posted_by_user FROM tbl_users, tbl_projects, tbl_project_posts WHERE tbl_users.user_id = tbl_project_posts.user_id AND tbl_projects.project_id = tbl_project_posts.project_id");
			
			$addMilestoneNotificationForUser = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.project_title, tbl_project_milestones.* FROM tbl_users, tbl_projects, tbl_project_milestones WHERE tbl_users.user_id = tbl_project_milestones.user_id AND tbl_projects.project_id = tbl_project_milestones.project_id");
				
			$milestone_notification = 0;
			$milestone_ids = "";
			while($row_milestones = mysql_fetch_array($addMilestoneNotificationForUser)){
				$list_userId = explode(",", $row_milestones['member_notification']);
				if (in_array($userId, $list_userId)) {
					$milestone_notification = $milestone_notification + 1;
					$milestone_ids = $milestone_ids.",".$row_milestones['milestone_id'];
					echo "<div class='project_notification notif_green' id='user_milestone_notification".$row_milestones['milestone_id']."'>
						".$row_milestones['firstname']." ".$row_milestones['lastname']." has added a milestone in project ".$row_milestones['project_title']." 
						<a href='#' id='update_milestone_notification".$row_milestones['milestone_id']."' class='confirm'><div class='project_notification_close'></div></a>
					</div>";
					echo "
					<script>
						$(document).ready(function() {
							if(document.getElementById('project_space_notificationLeft') == null){					
								$('.notif').load('plugins/project_space/controller2.php?action=shownotif' );
							}								
							});
					</script>
					<script type='text/javascript'>
						$('#project_space_notificationLeft').show();
						$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$row_milestones['project_id']."&user_id=".$userId."' );
					</script>";						
					?>
					<script type="text/javascript">
						$('#update_milestone_notification<?php echo $row_milestones['milestone_id']; ?>').click(function() {
							$('#user_milestone_notification<?php echo $row_milestones['milestone_id']; ?>').remove();
							$('#result').load( 'plugins/project_space/controller2.php?action=updatemilestonenotifications&user_id=<?php echo $userId; ?>&milestone_id=<?php echo $row_milestones['milestone_id']; ?>' );
							$('#project_space_notificationLeft').show();
							$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=<?php echo $row_milestones['milestone_id']; ?>&user_id=<?php echo $userId; ?>' );
							return false;
						});
					</script>
				<?php
				}
			}
			$milestone_ids = substr($milestone_ids, 1);
			
			$post_notification = 0;
			$post_ids = "";
			while($row_members = mysql_fetch_array($addPostNotificationForUser)){
				$list_userId = explode(",", $row_members['member_notification']);
				if (in_array($userId, $list_userId)) {
					$post_notification = $post_notification + 1;
					$post_ids = $post_ids.",".$row_members['post_id'];
					//if($row_members['posted_by_user'] != $userId){
						echo "<div class='project_notification notif_green' id='user_post_notification".$row_members['post_id']."'>
								".$row_members['firstname']." ".$row_members['lastname']." has posted in project ".$row_members['project_title']."
								<a href='#' id='update_post_notification".$row_members['post_id']."' class='confirm'><div class='project_notification_close'></div></a>
							</div>";
					//}
					echo "<script>
							$(document).ready(function() {
								if(document.getElementById('project_space_notificationLeft') == null){					
									$('.notif').load( 'plugins/project_space/controller2.php?action=shownotif' );
								}								
								});
						</script>				
					<script type='text/javascript'>
						$('#project_space_notificationLeft').show();
						$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$row_members['project_id']."&user_id=".$userId."' );
					</script>";
					?>
					
					<script type="text/javascript">
						$('#update_post_notification<?php echo $row_members['post_id']; ?>').click(function() {
							$('#user_post_notification<?php echo $row_members['post_id']; ?>').remove();
							$('#result').load( 'plugins/project_space/controller2.php?action=updatepostnotifications&user_id=<?php echo $userId; ?>&post_id=<?php echo $row_members['post_id']; ?>');
							$('#project_space_notificationLeft').show();
							$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=<?php echo $row_milestones['milestone_id']; ?>&user_id=<?php echo $userId; ?>' );
							return false;
						});
					</script>
				<?php
				}
			}
			$post_ids = substr($post_ids, 1);
			
			$total_notifications = mysql_num_rows($addProjectNotificationForUser) + mysql_num_rows($addMemberNotificationForUser) + $post_notification + $milestone_notification;
			if($total_notifications == 0){
				//echo "No new notifications";
				/*echo "<script type='text/javascript'>
					$('#user_project_space_notification').fadeOut();
				</script>";*/
			}else{
				echo "<script type='text/javascript'>
						$('#user_project_space_notification').show();
						$('#close_user_project_space_notification').show();
					</script>";
				$project_ids = "";
				while($row = mysql_fetch_array($addProjectNotificationForUser)){ 
					if($row['confirmation'] == 1){
						$confirmation = "Approved";
						$notif_class = "notif_green";
					}
					if($row['confirmation'] == 0){
						$confirmation = "Disapproved";
						$notif_class = "notif_red";
					}
					echo "<script>
							$(document).ready(function() {
								if(document.getElementById('project_space_notificationLeft') == null){					
									$('.notif').load( 'plugins/project_space/controller2.php?action=shownotif' );
								}								
								});
						</script>
					<script type='text/javascript'>
						$('#project_space_notificationLeft').show();
						$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$row['project_id']."&user_id=".$userId."' );
					</script>";
					?>
					<div class="project_notification <?php echo $notif_class; ?>" id="user_approval_notification<?php echo $row['project_id']; ?>">
						Your project <?php echo $row['project_title']; ?> has been <?php echo $confirmation; ?>
						<a href="#" id="update_project_notification<?php echo $row['project_id']; ?>" class="confirm"><div class="project_notification_close"></div></a>
						<?php $project_ids = $project_ids.",".$row['project_id']; ?>
					</div>
					
					<script type="text/javascript">
						$('#update_project_notification<?php echo $row['project_id']; ?>').click(function() {
							$('#user_approval_notification<?php echo $row['project_id']; ?>').remove();
							$('#result').load( 'plugins/project_space/controller2.php?action=updateprojectnotifications&user_id=<?php echo $userId; ?>&project_id=<?php echo $row['project_id']; ?>' );
							$('#project_space_notificationLeft').show();
							$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=<?php echo $row['milestone_id']; ?>&user_id=<?php echo $userId; ?>' );
							return false;
						});
					</script>
					<?php
				}
				
				while($row_member = mysql_fetch_array($addMemberNotificationForUser)){ 
					echo "<div class='project_notification notif_green' id='user_member_notification".$row_member['project_id']."-".$row_member['user_id']."'>
							You have been added to the project ".$row_member['project_title']."
							<a href='#' id='update_member_notification".$row_member['project_id']."' class='confirm'><div class='project_notification_close'></div></a>
						</div>";
					$project_id_member_notification = $project_id_member_notification.",".$row_member['project_id'];
					echo "<script>
							$(document).ready(function() {
								if(document.getElementById('project_space_notificationLeft') == null){					
									$('.notif').load( 'plugins/project_space/controller2.php?action=shownotif' );
								}								
								});
						</script>
						<script type='text/javascript'>					
							$('#project_space_notificationLeft').show();
							$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$row_member['project_id']."&user_id=".$userId."' );
						</script>";			
					?>
					
					<script type="text/javascript">
						$('#update_member_notification<?php echo $row_member['project_id']; ?>').click(function() {
							$('#user_member_notification<?php echo $row_member['project_id']."-".$row_member['user_id']; ?>').remove();
							$('#result').load( 'plugins/project_space/controller2.php?action=updatemembernotifications&user_id=<?php echo $userId; ?>&m_project_id=<?php echo $row_member['project_id']; ?>' );						
							$('#project_space_notificationLeft').show();
							$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=<?php echo $row_member['milestone_id']; ?>&user_id=<?php echo $userId; ?>' );
							return false;
						});
					</script>
				<?php
				}					
			}
		
		
		?>
		<input type="hidden" name="project_ids" id="project_ids" value="<?php echo $project_ids; ?>" />
		<input type="hidden" name="update_user_project_space_notification" id="update_user_project_space_notification" value="<?php echo $userId; ?>" />
		<input type="hidden" name="update_member_project_notification" id="update_member_project_notification" value="<?php echo $project_id_member_notification; ?>" />
		<input type="hidden" name="update_post_project_space_notification" id="update_post_project_space_notification" value="<?php echo $post_ids; ?>" />
		<input type="hidden" name="update_member_milestone_notification" id="update_member_milestone_notification" value="<?php echo $milestone_ids; ?>" />
		
	<?php
	}
	
	function updateProjectNotifications($userId, $projectId, $memberProjectId, $postId, $milestoneId){
	
		echo "<script type'text/javascript'>
				$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$projectId."&user_id=".$userId."' )
			</script>";
			
		if($projectId != ''){
			$updateProjectNotifications = mysql_query("UPDATE tbl_projects SET notification = '0' WHERE project_id = ".$projectId." AND user_id = ".$userId."");
			
			if($updateProjectNotifications){
				echo "<script type'text/javascript'>
					$('#project_list').load( 'plugins/project_space/controller2.php?action=search&user_id=".$userId."');
					
				</script>";
			}
		}
		
		if($memberProjectId != ''){
			$member_project_ids = explode(",", $memberProjectId);
			foreach($member_project_ids as $member_project_id){
				$updateMemberNotifications = mysql_query("UPDATE tbl_project_members SET notification = 1 WHERE project_id = ".$member_project_id." AND user_id = ".$userId."");
				
				if($updateMemberNotifications){
					echo "<script type'text/javascript'>
						$('#project_list').load( 'plugins/project_space/controller2.php?action=search&user_id=".$userId."');
						
					</script>";
				}
			}
		}
		
		if($postId != ''){
			$memberPostNotificationForUser = mysql_query("SELECT member_notification FROM tbl_project_posts WHERE post_id = ".$postId); 
			$getMemberPostNotificationForUser = mysql_fetch_array($memberPostNotificationForUser);
			
			$members_notified = explode(",", $getMemberPostNotificationForUser['member_notification']);
			$userCheck = array_search($userId, $members_notified); // search on the list the user id //
			unset($members_notified[$userCheck]);
			
			$members_left = "";
			foreach($members_notified as $member_notified){
				$members_left = $members_left.",".$member_notified;
			}
			
			$members_left = substr($members_left, 1);
			$updatePostNotifications = mysql_query("UPDATE tbl_project_posts SET member_notification = '".$members_left."' WHERE post_id = ".$postId);
			
			if($updatePostNotifications){
				echo "<script type'text/javascript'>
					$('#project_list').load( 'plugins/project_space/controller2.php?action=search&user_id=".$userId."');
					
				</script>";
			}
		}
		
		if($milestoneId != ''){
			$memberMilestoneNotificationForUser = mysql_query("SELECT member_notification FROM tbl_project_milestones WHERE milestone_id = ".$milestoneId ); 
			$getMemberMilestoneNotificationForUser = mysql_fetch_array($memberMilestoneNotificationForUser);
			
			$members_notified = explode(",", $getMemberMilestoneNotificationForUser['member_notification']);
			$userCheck = array_search($userId, $members_notified); // search on the list the user id //
			unset($members_notified[$userCheck]);
			
			$members_left = "";
			foreach($members_notified as $member_notified){
				$members_left = $members_left.",".$member_notified;
			}
			
			$members_left = substr($members_left, 1);
			
			$updateMilestoneNotifications = mysql_query("UPDATE tbl_project_milestones SET member_notification = '".$members_left."' WHERE milestone_id = ".$milestoneId);
			
			if($updateMilestoneNotifications){
				echo "<script type'text/javascript'>
					$('#project_list').load( 'plugins/project_space/controller2.php?action=search&user_id=".$userId."');
					
				</script>";
			}
		}
		
		//unlink('left_notifications/left_project_space'.$userId.'.html');
		//file_put_contents('left_notifications/left_project_space'.$userId.'.html', '');
		
		echo "<script type='text/javascript'>
				$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id=".$projectId."&user_id=".$userId."' );
			</script>";
	}
	
	function checkUnapprovedAddedProjects($userId){
		$checkUnapprovedAddedProjects = mysql_query("SELECT tbl_users.firstname, tbl_users.lastname, tbl_projects.*, tbl_projects.user_id AS project_creator_id FROM tbl_users, tbl_projects WHERE tbl_users.user_id = tbl_projects.user_id and tbl_projects.updated = 0 ORDER BY tbl_projects.project_id DESC");
			
		while($row = mysql_fetch_array($checkUnapprovedAddedProjects)){		
			if($row){		
			?>			
				<script>
					$(document).ready(function() {
						if(document.getElementById('project_space_notificationLeft') == null){					
							$('.notif').load('plugins/project_space/controller2.php?action=shownotif' );
						}								
					});
				</script>
				
				<script type='text/javascript'>
					$('#project_space_notificationLeft').show();
					$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=notificationformoderator&project_id=<?php echo $row['project_id']; ?>&user_id=<?php echo $userId; ?>' );
				</script>
			<?php				
			}
		?>
			<input type="hidden" name="approve_project_user_id" id="approve_project_user_id" value="<?php echo $userId; ?>" />
			<div class="project_notification notif_yellow">
				<strong><?php echo $row['project_title']; ?></strong><br/>
				<!--<div id="added_project_info<?php echo $row['project_id']; ?>" class="btn">Project Info</div>-->
				Added by: <?php echo $row['firstname']." ".$row['lastname']; 
            
            ?><div class="approval">

               <a id="approve_project<?php echo $row['project_id']; ?>">Approve</a>   
               | <a id="disapprove_project<?php echo $row['project_id']; ?>">Disapprove</a>

            </div><br/>
				<p><?php echo $row['project_description']; ?></p>
			</div>
			
			<style type="text/css">
				#approve_project<?php echo $row['project_id']; ?>, #disapprove_project<?php echo $row['project_id']; ?>{
					cursor: pointer;
					text-decoration: underline;
				}
				#added_project_info<?php echo $row['project_id']; ?>{
					position: relative;
					float: left;
					cursor: pointer;
				}
				
				#added_project_description<?php echo $row['project_id']; ?>{
					position: absolute;
					top: 0;
					border: 1px solid #bbb;
					height: 100px;
					width: 300px;
					background-color: #EDEDED;
					display: none;
					z-index: 1000;
				}
			</style>
			<script type="text/javascript">
				$(function() {
					var plug_path = 'plugins/project_space/';
					
					$('#added_project_info<?php echo $row['project_id']; ?>').click(function() {
						$('#added_project_description<?php echo $row['project_id']; ?>').show();
						//clearInterval(auto_refresh);
					});
					
					$('#close_added_project_description<?php echo $row['project_id']; ?>').click(function() {
						$('#added_project_description<?php echo $row['project_id']; ?>').hide();
					});
					
					$('#approve_project<?php echo $row['project_id']; ?>').click(function() {
						$('#approve_result<?php echo $row['project_id']; ?>').load( 'plugins/project_space/controller2.php?action=approveaddedproject&project_id=<?php echo $row['project_id']; ?>&user_id=<?php echo $userId; ?>&project_creator_id=<?php echo $row['project_creator_id']; ?>' );	
						$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id="<?php echo $row['project_id']; ?>"&user_id="<?php echo $userId; ?>' );
					});	
					
					$('#disapprove_project<?php echo $row['project_id']; ?>').click(function(){
						$('#approve_result<?php echo $row['project_id']; ?>').load( 'plugins/project_space/controller2.php?action=disapproveaddedproject&project_id=<?php echo $row['project_id']; ?>&user_id=<?php echo $userId; ?>&project_creator_id=<?php echo $row['project_creator_id']; ?>' );
						$('#project_space_notificationLeft').load('plugins/project_space/controller2.php?action=createprojectnotificationsfile&project_id="<?php echo $row['project_id']; ?>"&user_id="<?php echo $userId; ?>' );
					});
					
				});
			</script>
			<div id="approve_result<?php echo $row['project_id']; ?>"></div>
			<?php		
		}
		
	}
	
	function approveAddedProject($projectId, $userId, $project_creator_id){
		// remove mods notified //
	
		$approveAddedProject = mysql_query("UPDATE tbl_projects SET confirmation = 1, updated = 1, notification = '' WHERE project_id = ".$projectId."");
		
		if($approveAddedProject){
            /*Whats Going on*/
            $mysql = mysql_query("SELECT project_title, project_description, project_img, user_id FROM tbl_projects WHERE project_id = '$projectId'");
            $result = mysql_fetch_array($mysql);
            
            if ($result['project_img'] == '') {
                $img_src = 'plugins/project_space/project_img/default.jpg';
            } else {
                $img_src = 'plugins/project_space/project_img/'.$projectId.'/'.$result['project_img'];
            }

            $dateRec = date('Y-m-d H:i:s', time());
            
            $reqServer = $_SERVER['REQUEST_URI'];
            $exServer = explode("/", $reqServer);
            
            if ($exServer[1] == 's3') {
                $url = "http://".$_SERVER['SERVER_NAME']."/s3/intranet/";
            } elseif ($exServer[1] == 'intranet') {
                $url = "http://".$_SERVER['SERVER_NAME']."/intranet/";
            } else {
                $url = "http://".$_SERVER['SERVER_NAME']."/";
            }
            
            $text = '<div class="whatsProfContent">
                        <div class="urlThumbnails"><a href="'.$url.'?module=project_space&details='.$projectId.'"><img src="'.$img_src.'" width="90" /></a></div>
                        <div class="forceURLDate">
                            <div><a href="'.$url.'?module=project_space&details='.$projectId.'">'.stripslashes($result['project_title']).'</a></div>
                            <div style="margin-top: 5px">'.$this->__shortenString(strip_tags($result['project_description']), 300).'</div>
                        </div>
                        <div class="clear"></div>
                    </div>';

            $msg = 'has created a new project on';
            
            $plugdir = 'project_space';
            
            $this->__whatsGoinOn($text, $dateRec, $result['user_id'], $plugdir, $msg);
            /*end*/        
		
			echo "<script type='text/javascript'>
					
					$('#project_list').text('loading...');
					$('#project_list').load( 'plugins/project_space/controller2.php?action=updateprojectlist&user_id=".$userId."&project_id=".$projectId."' );
				</script>";
				// $('#project_space_notification').load( 'plugins/project_space/controller2.php?action=reloadprojectnotification&user_id=".$userId."' );
		}
	}
	
	function disapproveAddedProject($projectId, $userId, $project_creator_id){
		$disapproveAddedProject = mysql_query("UPDATE tbl_projects SET confirmation = 0, updated = 1, notification = '' WHERE project_id = ".$projectId."");
		
		if($disapproveAddedProject){
		
			echo "<script type='text/javascript'>
					
					$('#project_list').load( 'plugins/project_space/controller2.php?action=updateprojectlist&user_id=".$userId."&project_id=".$projectId."' );
				</script>";
			// $('#project_space_notification').load( 'plugins/project_space/controller2.php?action=reloadprojectnotification&user_id=".$userId."' );
		}
	}	
	/* ==================== for inserting into whats going on page 
	//setting the date to be inserted on the whats going on plugin
	$dateRec = date('Y-m-d H:i:s a', time());		
	$test = strtotime($dateRec);
	$cuurDate = $this->__timeDisplay($test);
	//html and text to be display on the whats going on plugin
	$text = '
			<div class="whatsProfContent">
				<strong> Project <strong>'.$row_milestones['project_title'].'</strong>
			</div>
			<div class="whatsprofDate">
				'.$cuurDate.'	
			</div>
			';			
	$projspaceMsg = 'has added new milestones on';// message for the reservation plugin to be displayed at whats going on
	$this->whats = new Whats(); // calling out whats going on plugin class
	$this->whats->__insertoWhats($text, $dateRec, $userId, 'project_space', $projspaceMsg); //inserting new meeting booking to whats going on.
	======================================== */
	
	function __timeDisplay($original) // $original should be the original date and time in Unix format
	{
		$todayYear = date('Y');
		$messageYear = date('Y', $original);
		$todayDay = date('d');
		$messageDay = date('d', $original);
		
		if($todayYear == $messageYear){
			if($todayDay == $messageDay){
				$messageDate = date('h:i:s A', $original);	
			}else{
				$messageDate = date('M d', $original);		
			}
		}else{
			$messageDate = date('M d, Y', $original);		
		}
		
		return $messageDate;
	}
    
    /*********************
    * @ What's Going ON *
    ********************/

    function __whatsGoinOn($text, $date, $userid, $plugDir, $msg)
    {
        require('../../plugins/whats_going_on/what.class.php');
        $this->whats = new Whats(); // calling out whats going on plugin class
        $this->whats->__insertoWhats($text, $date, $userid, $plugDir, $msg); //inserting new plugin details to whats going on.
    } 
	
    function __shortenString($string, $amount)
    {
        if (strlen($string) > $amount) {
            $string = trim(substr($string, 0, $amount))." ...";
        }
        return $string;
    }
    
    function __defaultDisplay($id)
    {
        $reqServer = $_SERVER['REQUEST_URI'];
        $exServer = explode("/", $reqServer);

        if ($exServer[1] == 's3') {
            $url = "http://".$_SERVER['SERVER_NAME']."/s3/intranet/";
        } elseif ($exServer[1] == 'intranet') {
            $url = "http://".$_SERVER['SERVER_NAME']."/intranet/";
        } else {
            $url = "http://".$_SERVER['SERVER_NAME']."/";
        }
        
        $mysql = mysql_query("SELECT COUNT(*) as num FROM tbl_projects WHERE project_id = '$id'");
        $result = mysql_fetch_array($mysql);
        $count = $result['num'];
    
        if ($count != 0) {
            $mysql = mysql_query("SELECT project_title, project_description, project_img, date_start, date_end, project_status, user_id FROM tbl_projects WHERE project_id = '$id'");
            list($title, $description, $image, $start, $end, $status, $user) = mysql_fetch_array($mysql);
                        
            echo '<hr><div style="margin: 20px 0px 10px 0px;"><span style="font-size: 1.25em; color: #666">Project Details</span></div>';
            echo '<div id="innerDetailEventSummary">';
            echo '<div>Project Title: <span>'.$title.'</span></div>';
            echo '<div>Project Description: <span>'.$description.'</span></div>';
            echo '<div>Project Status: <span>'.$status.'</span></div>';
            echo '<div>Start: <span>'.$start.'</span> | End: <span>'.$end.'</span></div>';
            echo '<div>Project Creator: <span>'.$this->__checkForName($user).'</span></div>';
            echo '<div style="margin-top: 10px"><button class="blue_01" onclick="javascript: window.location = \''.$url.'?module=project_space\'" type="button">Go to Project Space</button></div>';
            echo '</div>';
        } else {
            echo '
            <div style="margin-top: 20px; background-color: #FFFFFF; padding: 15px; border: 1px solid #C9C9C9">
                <div style="float: left; margin-left: 5px;"><img src="plugins/news/design/images/warning.png" class="null_efx" /></div>
                <div style="float: left; margin-top: 10px; margin-left: 25px; width: 415px"><font size="2" face="Arial, Helvetica, sans-serif" color="#000000"><strong>This content cannot be displayed.</strong></font><hr /><a href="'.$url.'?module=project_space" style="text-decoration: underline">Click here to visit project space</a></div>
                <div class="clear"></div>
            </div>';
        }
    }
	
    function __checkForName($user_id)
    {
        $mysql= "SELECT firstname, middlename, lastname FROM tbl_users WHERE user_id = '".$user_id."'";
        $conn = mysql_query($mysql);
        $result = mysql_fetch_array($conn);

        if(!empty($result['middlename'])){
            $mi = ucfirst(substr($result['middlename'], 0, 1)).". ";
        }else{
            $mi = "";
        }
        $name = $result['firstname'].' '.$mi.$result['lastname']; // display full name
        return $name;
    }    
} // end class


?>