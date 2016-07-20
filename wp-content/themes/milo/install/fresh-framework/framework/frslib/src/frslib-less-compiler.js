/******************************************************************************/
/* FRSLIB - less compilation part */
/******************************************************************************/
"use strict";
(function($){
frslib.provide('frslib.less');
frslib.provide('frslib.less.regex');


frslib.less.test = function() {
	$.get('http://localhost/bstest/less/bootstrap.less', function( data ){
		//console.log( data.replaceAll('@import ', '@import /kokot') );
		
		
	//	var find = '\s';
	//	var re = new RegExp(find, 'g');
		var start = new Date().getTime();
		var cleanLess = frslib.less.getLessFileAsString( 'http://localhost/bstest/less/bootstrap.less');
//		
		
		//console.log( cleanLess );
		less.render(cleanLess , function (e, css) {
			//	console.log(css);
		});
		
		var end = new Date().getTime();
		var time = end - start;
		console.log('Execution time: ' + time);
	});
}

frslib.less.regex.import =  /@import\s*["|']([\w|:|/|.|-]*)["|']\s*;/g;

frslib.less.temporaryFileStringHolder = '';



frslib.less.getLessFileAsString = function( url, lessString ) {

	if( typeof lessString ==  "undefined" ) {
		lessString = '';
	}
	var filename = url.substring(url.lastIndexOf('/')+1);
	var cleanUrl = url.replace( filename, '');
	
	var fullFileData = '';
	
	$.ajax({
			url : url,
			async: false,
			success : function(data){
				var matchedImports = data.match( frslib.less.regex.import )|| [];
				
				
				for( var i in matchedImports ) {
					var currentImport = matchedImports[i];
					var currentImportFileName = currentImport.replace( frslib.less.regex.import, '$1');
					var currentImportFileUrl = cleanUrl + currentImportFileName;
					
					var currentImportFileString = frslib.less.getLessFileAsString( currentImportFileUrl );
					
					data = data.replace( currentImport, currentImportFileString );
				}
				fullFileData = data;
			}
			
	});
	
	
	
	
//	$.ajax( url, function(data ){
//		var matchedImports = data.match( frslib.less.regex.import )|| [];
//		
//		for( var i in matchedImports ) {
//			var currentImport = matchedImports[i];
//			
//			var currentImportFileName = currentImport.replace( frslib.less.regex.import, '$1');
//			var currentImportFileUrl = cleanUrl + currentImportFileName;
//			
//			var currentImportFileString = frslib.less.getLessFileAsString( currentImportFileUrl );
////			console.log( data );
////			//data = data.replace( currentImport, currentImportFileString );
////			console.log( currentImportFileString );
//			fullFileData = data;
//			
//				
//		}
//		
//		console.log( 'a');
//	});
//	
//	console.log( 'xxx'+fullFileData);
	
	return fullFileData;
	
//	var matchedImports = lessString.match( frslib.less.regex.import )|| [];
//	
//	for( var i in matchedImports ) {
//		var currentImportDirty = matchedImports[i];
//		var currentImportClean = currentImportDirty.replace( frslib.less.regex.import, '$1');
//		
//		console.log( currentImportClean );
//	}
//	
	//lessString = lessString.replace( regex, '@import "'+additionalPath+'$1"');
	
	//console.log( lessString.match( regex )||[] );
	
	//return lessString;
} 

})(jQuery);
