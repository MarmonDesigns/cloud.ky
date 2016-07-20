jQuery(document).ready(function($){
	$('pre[data-ff-option-type="code"]').each(function() {
		var option_id = $(this).attr('id');
		var mode = $(this).attr('data-ff-option-mode');
		var textarea_id = option_id + "-textarea";
		
		var minLinesData = $(this).attr('data-ff-option-min-lines');
		var maxLinesData = $(this).attr('data-ff-option-max-lines');
		
		var editor = ace.edit(option_id);
		
		var $currentTextarea = $(this).parents('.ff-code-holder').find('textarea');
		
		editor.getSession().setMode("ace/mode/"+mode);
	    editor.session.setUseWorker(false);
	    ace.require("ace/ext/emmet");
	    editor.setTheme("ace/theme/clouds");
	    
	    var editorOptions = {};
	    editorOptions.enableEmmet = true;
	    
	    if( minLinesData != '' ) {
	    	editorOptions.minLines = minLinesData;
	    }
	    
	    if( maxLinesData != '' ) {
	    	editorOptions.maxLines = maxLinesData;
	    }
	    
		editor.setOptions(editorOptions);
		editor.setFontSize(13);
		editor.getSession().setValue( $currentTextarea.text() );
		editor.getSession().on('change', function(){
			$currentTextarea.text(editor.getSession().getValue());
		});
	})
	
	/*
    var editor = ace.edit("ff-custom-code-css");
    editor.getSession().setMode("ace/mode/css");
    editor.session.setUseWorker(false);
    ace.require("ace/ext/emmet");
    editor.setTheme("ace/theme/clouds");
	editor.setOptions({
	    enableEmmet: true,
	    minLines: 13,
		maxLines: 30
	});*/
});