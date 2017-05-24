$(document).ready(function(){
	if($('.center-wrap>.item-list').length > 0){
		var getParams = getRequest();
		if(typeof getParams.sort_by == 'undefined'){
			var getParams = {
				sort_by: 'title',
				dir: 'asc'
			}
		}
		$('.center-wrap>.item-list #'+getParams.sort_by + ' .'+getParams.dir).addClass('active');
	}
});