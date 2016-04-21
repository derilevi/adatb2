(function($) {

	$('#cNewRendezo').hide();


	$(function() {

		var	$window = $(window), $body = $('body');
				
		$('#AddNewRendezo').change(
		function()
		{
			if ($(this).is(':checked')) 
			{
				$('#cNewRendezo').show();
			}
			else
			{
				$('#cNewRendezo').hide();
			}
		});	
			

	});



})(jQuery);