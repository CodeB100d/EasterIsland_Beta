<!--main content-->

<form method="post" enctype="multipart/form-data">
    <?php
    $this->loadFunc('alerts');
    $this->loadFunc('forms');
    ?>
    
    <div id="content">
        <div class="breadcrumbs_container" id="breadcrumbs_container">
            <div class="breadcrumbs">
                <a href=""><i class="icon-list-alt"></i> Pages</a>
                <div class="breadcrumb_divider"></div>
                <span>Add Page Template</span>
            </div>
            <div class="clear"></div>
        </div>

        <div class="inner_tube">
            <fieldset>
                <div class="muted">
                    <h3 class="pull-left"><i class="icon-list-alt"></i> Pages</h3>
                    <!--
                    <div class="pull-right">
                            <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-plus-sign"></i> Creat new
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                            <li><a href="">Create New Page</a></li>
                                            <li><a href="">Create Page Template</a></li>
                                            <li><a href="">Create Menu Groups</a></li>
                                            <li><a href="">Create Sidebar Groups</a></li>
                                    </ul>
                            </div>
                            <button class="btn"><i class="icon-edit"></i> Page Template Editor</button>
                    </div>
                    -->
                    <div class="clear"></div>
                </div>

                <div class="white_box inner_tube">
                    <fieldset>
                        <form method="post">
                            <legend>Create New Page Template</legend>
                            <?php
                            echo (!empty($success_msg)) ? success_alert($success_msg) : '';
                            echo (!empty($upload_error)) ? error_alert($upload_error) : '';
                            
                            if (!empty($title_error)) {
                                foreach ($title_error as $inpname => $inp_err) {
                                    $error = "$inp_err <br/>";
                                }
                                echo error_alert($error);
                            }
                            ?> 
                            <label>Template Title:</label>
                            <input type="text" name="template_title" value="<?php echo set_value('template_title'); ?>">


                            <label>Choose file:</label>
                            <p class="muted"><small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas condimentum sollicitudin malesuada. Donec massa libero, luctus porta rutrum id,</small></p>
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append">
                                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="template_file" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>

                            <div class="form-actions">    
                                <button type="submit" name="save_file" class="btn btn-primary">Save Template</button>
                            </div>


                            <label>Template Code:</label>

                            <div class="white_box">
                                <textarea id="code" name="code" rows="5"><!DOCTYPE html>
<html>
<body>
	<h1>My First Heading</h1>
	<p>My first paragraph.</p>
</body>
</html></textarea>
                            </div>
                            <div class="form-actions">
                                <div class="btn-group">
                                    <button class="btn" rel="tooltip" title="Help"><i class="icon-question-sign"></i></button>

                                    <a rel="tooltip" title="Settings" href="#setting" role="button" class="btn" data-toggle="modal"><i class="icon-cog"></i></a>
                                    <!-- Modal -->
                                    <div id="setting" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove-sign"></i></button>
                                            <h4>Editor settings</h4>
                                        </div>
                                        <div class="modal-body">
                                            <select onchange="selectTheme()" id="select">
                                                <option disabled selected>Select theme</option>
                                                <option>default</option>
                                                <option>ambiance</option>
                                                <option>blackboard</option>
                                                <option>cobalt</option>
                                                <option>eclipse</option>
                                                <option>elegant</option>
                                                <option>erlang-dark</option>
                                                <option>lesser-dark</option>
                                                <option>monokai</option>
                                                <option>neat</option>
                                                <option>night</option>
                                                <option>rubyblue</option>
                                                <option>solarized dark</option>
                                                <option>solarized light</option>
                                                <option>twilight</option>
                                                <option>vibrant-ink</option>
                                                <option>xq-dark</option>
                                                <option>xq-light</option>
                                            </select>
                                        </div>
                                        <!--
                                        <div class="modal-footer">
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                                <button class="btn btn-primary">Save changes</button>
                                        </div>
                                        -->
                                    </div>
                                </div>
                                <button class="btn btn">Clear</button>
                                <button class="btn btn-primary">Save Template</button>
                                <label class="checkbox pull-right">
                                    <input id="check_preview" checked type="checkbox"> Preview Template
                                </label>

                            </div>
                        </form>
                    </fieldset>
                </div>

                <div class="white_box" id="temp_prev">
                    <div class="inner_tube">
                        <legend>Template Preview</legend>
                    </div>
                    <iframe id="preview"></iframe>
                </div>
            </fieldset>
        </div>
        <div class="spacer"></div>
    </div>
</form>
<!--end main content-->
<!--end container-->