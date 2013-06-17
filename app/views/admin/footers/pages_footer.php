
<!--end container-->
<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>jasny-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>bootstrap-bigmodal.js"></script>
<script type="text/javascript" src="<?php echo PUBLIC_JS_PATH ?>scriptbreaker-multiple-accordion-1.js"></script>

<!--codemirror-->
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/lib/codemirror.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/xml/xml.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/javascript/javascript.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/css/css.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/vbscript/vbscript.js"></script>
<script src="<?php echo PUBLIC_JS_PATH ?>codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!---->
<script>
    jQuery(document).ready(function($) {
        $('rowlink').rowlink();
        $('.btn-primary').on('click', function () {$(this).html('<i class="icon-spinner icon-spin"></i> loading')});
        
        $("#left_menu").accordion({
            accordion:false,
            speed: 300,
            closedSign: '<i class="pull-right icon-angle-right"></i>',
            openedSign: '<i class="pull-right icon-angle-down"></i>'
        });
        $("#left_menu").find('ul').css('display', 'none');
			
        //tooltip
        $("[rel='tooltip']").tooltip();
			
        //big modal
        //$('.bigmodal').bigmodal();
			
			
        //preview checkbox
        $('#check_preview').live("click", function() {
            if (this.checked) {
                $('#temp_prev').show(200);
            }
            else {
                $('#temp_prev').hide(200);
            }
        });
    });
		
    //codemirror
    // Define an extended mixed-mode that understands vbscript and
    // leaves mustache/handlebars embedded templates in html mode
    var mixedMode = {
        name: "htmlmixed",
        scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null},
            {matches: /(text|application)\/(x-)?vb(a|script)/i,
                mode: "vbscript"}]
    };
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        mode: mixedMode,
        tabMode: "indent",
        lineNumbers: true,
        viewportMargin: Infinity,
        lineWrapping: true,
        //readOnly: true
		
    });

    var input = document.getElementById("select");
    function selectTheme() {
        var theme = input.options[input.selectedIndex].innerHTML;
        editor.setOption("theme", theme);
    }
    var choice = document.location.search &&
        decodeURIComponent(document.location.search.slice(1));
    if (choice) {
        input.value = choice;
        editor.setOption("theme", choice);
    }

    var delay;
    editor.on("change", function() {
        clearTimeout(delay);
        delay = setTimeout(updatePreview, 300);
    });

    function updatePreview() {
        var previewFrame = document.getElementById('preview');
        var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
        preview.open();
        preview.write(editor.getValue());
        preview.close();
    }
    setTimeout(updatePreview, 300);
</script>
</body>
</html>