<h2>Project Space</h2>

<?php
$details = isset( $_GET['details'] ) ? $_GET['details'] : "";
if ($details) {
    $projects->__defaultDisplay($details);
} else {
 ?>
<?php $searchString = ''; ?>

<?php 
              $gRoles = $_SESSION['intrnt_group_global_roles'];
              if(in_array($gRoles[2],$_SESSION['intrnt_group_id_specs'])){    
//if($projects->checkIfUserCanApproveNewProject() == 1) {?>
<div id="project_space_notification">
	<?php $projects->checkUnapprovedAddedProjects($projects->getUserId()); ?>
</div>
<?php //} 
              }
?>

<?php 
	echo USER_ID;
	print_r( $projects->checkIfThereAreNotifications());
	if($projects->checkIfThereAreNotifications() > 0 ){ 
		$display = "style='display:block'";
		
	} 
	else{
		$display = "style='display:none'";
	}
?>
<div id="user_project_space_notification" <?php echo $display; ?>>
	
	<?php //$projects->addProjectNotificationForUser($projects->getUserId()); ?>	
	
</div>
<!--<div id="close_user_project_space_notification" class="btn" <?=$display?> >Ok</div>-->

<div class="project_page_wrapper">
	<!--<div id="project_preloader"></div>-->
	<div class="project_list_wrapper">
		<div class="top">
			<?php $projects->addNewProject(); ?>
			<?php $projects->addNewProjectForm($projects->getUserId()); ?>
			<?php $projects->searchProjects($projects->getUserId()); ?>
		</div>
		<div id="project_list">
			<?php $projects->viewAllProjects($searchString, $projects->getUserId(), ''); ?>
		</div>
	</div>
</div>
<div id="result"></div>
<?php
}
?>