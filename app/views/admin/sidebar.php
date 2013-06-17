<?php
if(empty($parent_page)) $parent_page = 'dashboard';
$active = ' class="active"';
?>
<div id="left-sidebar">
    <ul class="nav nav-list left_menu" id="left_menu">
        <li class="nav-header">System Modules</li>
        <li <?php echo ($parent_page=='dashboard')?$active:''; ?>><a href="#"><i class="icon-home"></i> Dashboard</a></li>
        <li <?php echo ($parent_page=='pages')?$active:''; ?>>
            <a href="#"><i class="icon-list-alt"></i> Pages</a>
            <ul class="nav nav-list">
                <li><a href="pages">Manage Pages</a></li>
                <li><a href="">Add New Page</a></li>
                <li><a href="pages/manage_templates">Manage Templates</a></li>
                <li><a href="pages/add_page_template">Add Page Templates</a></li>
                <li><a href="#">Create Menu Group</a></li>
                <li><a href="#">Create Sidebar Groups</a></li>
                <li><a href="#">Page Template Editor</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='files')?$active:''; ?>><a href="#"><i class="icon-file"></i> Files</a></li>
        <li <?php echo ($parent_page=='posts')?$active:''; ?>>
            <a href="#"><i class="icon-bullhorn"></i> Posts </a>
            <ul class="nav nav-list">
                <li><a href="#">Manage Category</a></li>
                <li><a href="#">Add category</a></li>
                <li><a href="#">Post News / Aticles</a></li>
                <li><a href="#">Manage News/Articles</a></li>
                <li><a href="#">Enable Comments</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='schedule')?$active:''; ?>><a href="#">
                <i class="icon-calendar"></i> Schedule</a>
            <ul class="nav nav-list">
                <li><a href="#">Manage Schedule Category</a></li>
                <li><a href="#">Post Events and Activities</a></li>
                <li><a href="#">View Calendar</a></li>
                <li><a href="#">Manage Event Color Coding</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='comments')?$active:''; ?>>
            <a href="#"><i class="icon-comments"></i> Comments</a>			
            <ul class="nav nav-list">
                <li><a href="#">Manage Comments</a></li>
                <li><a href="#">Filter Reported Comments</a></li>
                <li><a href="#">Enable Captcha</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='newsletters')?$active:''; ?>>
            <a href="#"><i class="icon-envelope"></i> Newsletter</a>
            <ul class="nav nav-list">
                <li><a href="#">Add News Letter Page</a></li>
                <li><a href="#">Create Custom SMTP Mail Sender</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='themes')?$active:''; ?>>
            <a href="#"><i class="icon-th"></i> Themes</a>
        </li>
        <li>
            <a href="#"><i class="icon-user"></i> Users</a>
            <ul class="nav nav-list">
                <li><a href="#">Members</a></li>
                <li><a href="#">Member Groups</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="#">Users Groups</a></li>
            </ul>
        </li>
        <li <?php echo ($parent_page=='system')?$active:''; ?>>
            <a href="#"><i class="icon-cog"></i> System</a>
            <ul class="nav nav-list">
                <li><a href="#">Configurations</a></li>
                <li><a href="#">Maintenance</a></li>
                <li><a href="#">System Backup</a></li>
                <li><a href="#">System Logs</a></li>
                <li><a href="#">System status</a></li>
            </ul>
        </li>

    </ul>
</div>