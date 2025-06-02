// start jquery
$(document).ready(function() {
   
	$('.on_sort_time').on('change', function () {
            var val = $(this).val();
            const url = new URL(window.location);
            url.searchParams.set('time', val);
            history.pushState(null, null, url);
            location.reload();
      })

      $('.on_sort_catalog').on('change', function () {
            var val = $(this).val();
            const url = new URL(window.location);
            url.searchParams.set('catalog', val);
            history.pushState(null, null, url);
            location.reload();
      })

      $('.on_sort_company').on('change', function () {
            var val = $(this).val();
            const url = new URL(window.location);
            url.searchParams.set('company', val);
            history.pushState(null, null, url);
            location.reload();
      })












}) // end jquery