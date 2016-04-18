// JavaScript Document

var loader = "<img id='loader' src='media/ign.gif'>";
var pullType = 'videos';
var startIndex = 1;

$(document).ready(function() {
	"use strict";
	callArticles(pullType, startIndex);
	startIndex += 10;
});

$("#seeMore").on('click', function(e){
	"use strict";
	e.preventDefault();
	$("#loaderCon").html(loader);
	callArticles(pullType, startIndex);
	startIndex += 10;
	setTimeout(function(){
		$("#loaderCon").empty();
	}, 1000);
});

$("#vidBtn").on('click', function(e){
	"use strict";
	e.preventDefault();
	$(this).toggleClass('chosen');
	$('#artBtn').toggleClass('chosen');
	pullType = 'videos';
	startIndex = 1;
	$('.ignLink').remove();
	callArticles(pullType, startIndex);
});

$("#artBtn").on('click', function(e){
	"use strict";
 	e.preventDefault();
 	$(this).toggleClass('chosen');
	$('#vidBtn').toggleClass('chosen');
	pullType = 'articles';
	startIndex = 1;
	$('.ignLink').remove();
	callArticles(pullType, startIndex);
});

function callArticles(pullType, startIndex){
	"use strict";
	var dataString = "pullType=" + pullType + "&startIndex=" + startIndex;
		$.ajax({
			data:dataString,
			type:"GET",
			url:"php/listBuilder.php",
			success: function(response){
				$("#seeMoreCon").before(response);
			}
			});
}