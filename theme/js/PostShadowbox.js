/**
 * Class for displaying images in a gallery format
 * @author Jeff Fohl
 * @copyright Jeff Fohl, 2011
 *
 * DEPENDENCIES:
 *  jQuery
 **/


function portfolioImageHandler(images) {
	this.images = images;
	for(var i in images) {
		var id = i;
		$('#thumbnail_'+i).click(function () {
		     swapImage(this.id);
		 });
	}
	this.showImage = function () {
		$('#main-image').bind("load",function () {
			$('#spinner').fadeOut(500);
			$('#scrim').fadeOut(500);
		 });
		$('#spinner').fadeIn(0);
		$('#scrim').fadeIn(0);
		$('#current-image-description').html(this.images[id].description);
		$('#main-image').src = this.images[id].imageurl;
	}
}

function swapImage(thumbid) {
	var id = thumbid.substring(10);
	$('#main-image').bind("load",function () {
		$('#spinner').fadeOut(500);
		$('#scrim').fadeOut(500);
	 });
	$('#spinner').fadeIn(0);
	$('#scrim').fadeIn(0);
	$('#current-image-description').html(portfolioImages[id].description);
	$('#main-image')[0].src = portfolioImages[id].imageurl;
}

function clearScrim() {
	$('#spinner').fadeOut(500);
	$('#scrim').fadeOut(500);
}
