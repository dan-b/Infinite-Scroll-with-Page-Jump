/*
Scroll to top from: http://www.abeautifulsite.net/blog/2010/01/smoothly-scroll-to-an-element-without-a-jquery-plugin/

console.log();
*/
canLoadMore = true;				// Switched to TRUE when AJAX request is made, reverts to FALSE when request completed
/* Trigger attachments */
$(function() {
	totalPageCount = parseInt($('.totalPageCount')[0].innerHTML);
	
	$(window).scroll(function() {				// Function listener fires off when scrolled to the end of the document
		if ($(document).scrollTop()>($(document).height()-(window.innerHeight+200))) {
			reachedBottom();
		}
	});
	
	$("#pageMenu").hover(
		function() {
			$('#pageMenu .message').css({
				'display' : 'none',
				'visibility' : 'visible' }).fadeIn(300);
			$(".jumpTo input").focus().select();
		},
		function() {
			$(".jumpTo input").blur();
			$('#pageMenu .message').fadeOut(300, function() {
				$(this).show().css({
				'display' : 'block',
				'visibility' : 'hidden' });
			});
		}
	);
	
	$('#pageMenu form').submit(
		function() {
			$('.page').each(function() {
				$(this).fadeOut(1000, function() {
					$(this).remove()
				})
			});
			getPage($('#pageMenu input').val());
			canLoadMore = false;		// check if necessary
			$('html, body').animate({
				scrollTop: $("body").offset().top
			}, 1000);
			canLoadMore = true;
			return false;			// Prevent page refresh upon form submition
		}
	);
	
	
});

function reachedBottom() {
	var lastPage = $('#content .page').last();						// Get last page of #content container
	lastPage = lastPage[0].classList[1];									// Get page number from div's class (e.g. div class='page 9')
	if ((canLoadMore==true) && (parseInt(lastPage)<=totalPageCount)) {
		getPage(++lastPage);
	}
}

function getPage(page) {				// Get the next articles following the given ID, append .page to #content
	canLoadMore = false;
	var loadUrl = "http://yoursite.com/infinite-scroll/getArticles.php?rel&page=" + page;
	$.ajax({url:loadUrl, success: function(data){
		$('#content').append($(data).hide().fadeIn(1000));
	}}).done(function(msg) {
		console.log("Ajax complete [" + 0 + "]");
		canLoadMore = true;
		updateWindowURL(page);
		updateScrollingMenu(page);
	});
}

function updateScrollingMenu(page) {			// Change page navigation menu to reflect newly loaded pages
	$('#pageMenu input').val(page);
}

function updateWindowURL(page) {
	var newUrl = determineURL(page);
	console.log(newUrl);
	window.history.pushState({path:newUrl}, '', newUrl);
		
}

function determineURL(page) {
	var pageSlash = "/page/";
	var url = window.location.href;
	if (url.charAt(url.length-1)=="/") {
		url = url.slice(0, -1);
	}
	var position = url.search('/page/');
	if (position==-1) {
		url += pageSlash + page;
	} else {
		url = url.slice(0, position + pageSlash.length);
		url += page;
	}
	return url;
}
