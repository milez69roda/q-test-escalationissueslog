COMMON = {

	alert: function(title, body, type, redirectlink){
	
		var div = '<div id="myModal" class="modal hide fade '+type+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
			'<div class="modal-header">'+
				'<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> x </button>'+
				'<h3 id="myModalLabel">'+title+'</h3>'+
			'</div>'+
			'<div class="modal-body">'+
				body+
			'</div>'+
			'<div class="modal-footer">'+
				'<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>'+						
			'</div>'+
		'</div>';

		$(div).modal()
		.on('hide', function(){
			if( redirectlink != '' ){ 
				window.location = redirectlink;
			}
		});
	},
	
	clearForm: function(oForm) {
	   
		var elements = oForm.elements;

		oForm.reset();

		for(i=0; i<elements.length; i++) {

			field_type = elements[i].type;

			switch(field_type) {

				case "text":
				case "password":
				case "textarea":
				case "hidden":  

				elements[i].value = "";
				break;

				case "radio":
				case "checkbox":
				if (elements[i].checked) {
				elements[i].checked = false;
				}
				break;

				case "select-one":
				case "select-multi":
					elements[i].selectedIndex = 0;
				break;

				default:
				break;
			}
		}
	},

	confirm: function(heading, question, cancelButtonTxt, okButtonTxt, callback) {

		var confirmModal = 
			$('<div class="modal hide fade">' +    
			'<div class="modal-header">' +
			'<a class="close" data-dismiss="modal" >&times;</a>' +
			'<h3>' + heading +'</h3>' +
			'</div>' +

			'<div class="modal-body">' +
			'<p>' + question + '</p>' +
			'</div>' +

			'<div class="modal-footer">' +
			'<a href="#" class="btn" data-dismiss="modal">' + 
			  cancelButtonTxt + 
			'</a>' +
			'<a href="javascript:void(0)" id="okButton" class="btn btn-primary">' + 
			  okButtonTxt + 
			'</a>' +
			'</div>' +
			'</div>');

			confirmModal.find('#okButton').click(function(event) {
				
				callback();
				confirmModal.modal('hide');
			});

		confirmModal.modal('show');     
	},
	
	exportexcel: function(ch){
		
		var from = $("#date_from").val();
		var to = $("#date_to").val();
		
		window.location = 'export/?ch='+ch+'&from='+from+'&to='+to;
		
	}

 
}

$(document).ready(function(){
	$("textarea[maxlength]").bind('input propertychange', function() {	
		var maxLength = $(this).attr('maxlength');
		
		//I'm guessing JavaScript is treating a newline as one character rather than two so when I try to insert a "max length" string into the database I get an error.
		//Detect how many newlines are in the textarea, then be sure to count them twice as part of the length of the input.
		var newlines = ($(this).val().match(/\n/g) || []).length
		
		if( ($(this).val().length + newlines) >= maxLength ){
				alert('Allowed only 300 characters');
		}	
		
		if ( $(this).val().length + newlines > maxLength) {

			$(this).val($(this).val().substring(0, maxLength - newlines));
			
		} 
		 
	 
	});

});