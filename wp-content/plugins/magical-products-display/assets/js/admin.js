;(function($){
	$(document).ready(function(){
		$('.mgpd-dismiss').on('click',function(){
			var url = new URL(location.href);
			url.searchParams.append('mgpdismissed',1);
			location.href= url;
		});
	});
})(jQuery);