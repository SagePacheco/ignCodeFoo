// JavaScript Document
$("#letters").on('input', function(){
	"use strict";
	var userInput = $("#letters").val();
	var dataString = "letterInput=" + userInput;
	if(userInput.length < 15){
		$.ajax({
			data:dataString,
			type:"GET",
			url:"php/wordEngine.php",
			success: function(response){
				var responseBlock = $("#responseBlock");
				var bestWord = JSON.parse(response);
				var tileBuilder = "";
				if (typeof bestWord.error === 'undefined'){
					for(var i = 0; i < bestWord.letters.length; i++){
						var currentLetter = bestWord.letters[i];
						tileBuilder +=
						"<div class='scrabbleTile'>" +
						"<p class='tileLetter'>" +
						currentLetter + 
						"</p><p class='tileScore'>" +
						bestWord.letterScore[currentLetter] +
						"</p></div>";
					}
					responseBlock.html(tileBuilder);
				} else {
					responseBlock.html(bestWord.error);	
				}
			},
			});
	}
});