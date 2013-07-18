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
		var input = $(this).attr('data-input');
		if($(input).val() != ''){
			var old_html = $('.array').html();

			var new_html = '<label for="input"></label><input type="text" value="'+ $(input).val() +'" /></input>'
							+ '<button type="button" name="remove" class="array_pop">Remove</button><br />';

			$('.array').html(new_html + old_html);
		}
		$(input).val('');
	});

	$('button.array_pop')
	.live("click", function(){
		$(this).prev('input').prev('label').remove();
		$(this).prev('input').remove();
		$(this).next('br').remove();
		$(this).remove();
	});
})