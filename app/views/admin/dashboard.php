<!--main content-->
<div id="content" class="content">
    <div class="breadcrumbs_container" id="breadcrumbs_container">
        <div class="breadcrumbs">
            <span><i class="icon-list-alt"></i> Pages</span>
            <div class="breadcrumb_divider"></div>
            <a href="">Next bread</a>
        </div>
        <div class="clear"></div>
    </div>
    
    <?php
    $this->loadFunc('sample');
    echo blahblah();
    ?>

    <div class="inner_tube">
        <fieldset>
            <div class="muted">
                <h3 class="pull-left"><i class="icon-home"></i> Dashboard</h3>
                <!--
                <div class="pull-right">
                        <a href="" class="muted"><h2><i class="icon-cog"></i></h2></a>
                </div>
                -->
                <div class="clear"></div>
            </div>


            <div class="white_box inner_tube">
                <div class="alert alert-info">Sample alert message</div>
                <div class="well well-small">
                    <strong class="muted">All (4) | <a href="">published</a> (4)</strong>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Page Title</th>
                            <th>Author</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href=""><strong>sample page</strong></a>
                                <div>
                                    <span class="muted">2013/04/03 [Published]</span>
                                </div>
                            </td>
                            <td width="250"><a href="">name of the author</a></td>
                            <td width="140">
                                <div class="action">
                                    <a href="">Edit</a> |
                                    <a href="">Delete</a> |
                                    <a href="">Deactivate</a>
                                </div>
                            </td>

                        <tr>
                            <td>
                                <a href=""><strong>sample page</strong></a>
                                <div>
                                    <span class="muted">2013/04/03 [Published]</span>
                                </div>
                            </td>
                            <td width="250"><a href="">name of the author</a></td>
                            <td width="140">
                                <div class="action">
                                    <a href="">Edit</a> |
                                    <a href="">Delete</a> |
                                    <a href="">Deactivate</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <a href=""><strong>sample page</strong></a>
                                <div>
                                    <span class="muted">2013/04/03 [Published]</span>
                                </div>
                            </td>
                            <td width="250"><a href="">name of the author</a></td>
                            <td width="140">
                                <div class="action">
                                    <a href="">Edit</a> |
                                    <a href="">Delete</a> |
                                    <a href="">Deactivate</a>
                                </div>
                            </td>
                        </tr>
                        </tr>
                    </tbody>
                </table>
                <div class="form-actions">
                    <button class="btn btn">Default</button>
                    <button class="btn btn-primary">Primary</button>
                </div>
            </div>

            <div class="white_box inner_tube">
                <fieldset>
                    <legend>Sample CKEDITOR</legend>
                    <form action="" method="post">
                        <textarea class="ckeditor" id="editor1"></textarea>
                        <div class="form-actions">
                            <button class="btn btn">Default</button>
                            <button class="btn btn-primary">Primary</button>
                        </div>
                    </form>
                </fieldset>
            </div>
        </fieldset>
    </div>
    <div class="spacer"></div>
</div>
<!--end container-->