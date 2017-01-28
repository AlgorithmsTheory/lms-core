$(function () {
var focusedElem;

		var scntDiv = $('#p_scents');
		var i = $('#p_scents li').size() + 1;

		$('#addScnt').live('click', function() {
			$('<li  id ="p_scnt_' + i +'" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="st_'+ i +'" class="form-control" name="start" onchange="superScript(this)"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="end_'+ i +'" class="form-control" name="end" onchange="superScript(this)"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

			i++;
			return false;
		});

//<li id="p_scnt_6" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="st_6" class="form-control" name="start"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="end_6" class="form-control" name="end"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt"><i class="fa fa-trash"></i>									</a>															</li>

		$('#remScnt').live('click', function() { 
			if( i > 1 ) {
				$(this).parents('li').remove();
				i--;
			}
			return false;
		});


		$('#reset').live('click', function() { 
			$('input[type=text]').each(function() {

				$(this).val('');
			});
			return false;

		});



			$('input[type=text]').focus( function() {

				focusedElem = $(this);
			});


			$('#lambda').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'λ'); 


			});

			$('#right').click( function() {

				//var text = $('#text');
				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'R'); 

			});
			$('#left').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'L'); 

			});

			$('#here').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'H'); 

			});
			$('#part').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + '∂'); 

			});
			$('#omega').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'Ω'); 

			});
			$('#one').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'S₁'); 

			});
		

	
			$('#zero').click( function() {

				focusedElem.val(focusedElem.val() + 'S₀');

			});




		
		$('#big_lambda').click( function() {

		         //var text = $('#text');
		       focusedElem.val(focusedElem.val() + 'Λ'); 

		    });

		$('#one_tild').click( function() {

		         //var text = $('#text');
		        focusedElem.val(focusedElem.val() + 'Õ'); 

		    });
		$('#sh').click( function() {

		         //var text = $('#text');
		        focusedElem.val(focusedElem.val() + '#'); 

		    });

		$('#bull').click( function() {

		         //var text = $('#text');
        		focusedElem.val(focusedElem.val() + 'H'); 

    });
		$('#delete').click( function() {

		         //var text = $('#text');
        		focusedElem.val(focusedElem.val() + '_'); 

    });

			
		});