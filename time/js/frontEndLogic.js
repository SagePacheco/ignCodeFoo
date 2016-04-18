// JavaScript Document
var dataString;
$("#convertBtn").on('click', function(){
	"use strict";
	dataString = $("#letters").serialize();
	$.ajax({
		data:dataString,
		type:"GET",
		url:"php/iso.php",
		success: function(response){
			var responseBlock = $("#responseBlock");
				responseBlock.html(response);
		},
		});
});