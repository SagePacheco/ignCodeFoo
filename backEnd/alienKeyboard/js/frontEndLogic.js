// JavaScript Document
var conversionResult;
var dataString;
var tempString;
$("#letters").on('input', function(){
	"use strict";
	dataString = $("#letters").serialize();
	$.ajax({
		data:dataString,
		type:"GET",
		url:"php/keyboardConverter.php",
		success: function(response){
			var responseBlock = $("#responseBlock");
			conversionResult = JSON.parse(response);
			if (typeof conversionResult.error === 'undefined'){
				conversionResult.letters.replace(/\\</g, "\\<");
				conversionResult.letters.replace(/\\>/g, "\\>");
				tempString = "<p>" + conversionResult.letters + "</p>";
				responseBlock.html(tempString);
			} else {
				tempString = "<p>" + conversionResult.error + "</p>";
				responseBlock.html(tempString);
			}
		},
		});
});