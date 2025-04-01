// start jquery
$(document).ready(function() {

   
      // 
	$('.on_sort_time').on('change', function () {
            var val = $(this).children('option:selected').attr('data-val');
            const url = new URL(window.location);
            url.searchParams.set('time', val);
            history.pushState(null, null, url);
            location.reload();
	})
   



























}) // end jquery