$(document).ready(function(){
	var menuButton = $("#menu-controller");
	var menu = $("#menu");
	menuButton.bind("click", function(){
		if (menu.hasClass("open")) {
			menuButton.removeClass("open");
			menu.removeClass("open");
		} else {
			menuButton.addClass("open");
			menu.addClass("open");
		}
	});
});