
$(document).ready(function(){
		var pname='';
		var olelemnt;
	$('select').dblclick(function(){
		$('#make_move').submit();
	});
	
	$('.draggable_piece').on("dragstart", function (event) {
		var dt = event.originalEvent.dataTransfer;		
		dt.setData('Text', $(this).closest('td').attr('id'));
			pname = $(this).attr('name');
			olelemnt=$(this).closest('td');
			
	});
	
	$('table td').on("dragenter dragover drop", function (event) {	
		event.preventDefault();		
		if (event.type === 'drop') {			
			var oldsquare = event.originalEvent.dataTransfer.getData('Text', $(this).attr('id'));
		    var newsquare = $(this).attr('id');

			//olelemnt.find('span').attr('name','');
			//debugger
			var coordinate_notation = pname+oldsquare + newsquare;
			var option_tag_in_select_tag = $("select[name='move'] option[data-coordinate-notation='" + coordinate_notation + "']");
			if ( option_tag_in_select_tag.length != 0 ) {
				option_tag_in_select_tag.attr('selected','selected');
				$(this).find('span').attr('name',pname);
				olelemnt.find('span').attr('name','');
				//$(this).closest('td').find('span').attr('name','');
				$('#make_move').submit();
			}
	    };
    });
	
	$('#perft').click(function(){
		window.location.href = 'perft.php?fen='  + $('#fen').val();
	});
});
