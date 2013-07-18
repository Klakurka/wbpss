$(function(){

	$('.autocomplete')
	.focus(function(){
		var func_name = $(document.activeElement).attr('data-method');
		$('.autocomplete').autocomplete('option', 'source', '/'+func_name);
	})
	.autocomplete({
		source: 'void'
	});

	$('button.array_push')
	.click(function(){
		var input_area = $(this).attr('data-input');
		var output_area = $(this).attr('data-output');

		$(output_area).add("div").addClass("output_row");
		var output_row = $(output_area).last("div");

		$(input_area).clone(':input').appendTo(output_row);
		$('<button type="button" class="array_pop">remove</button>').appendTo($(output_row).children().last());
		$(output_area).children().removeAttr('name');

		$(input_area).children().val('');
		$(input_area).children().first().focus();
	});

	$('button.array_pop')
	.live("click", function(){
		var containter = $(this).parent();
		$(containter).empty();
		$(containter).remove();
	});
})