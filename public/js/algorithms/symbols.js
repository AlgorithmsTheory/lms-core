	$(function () {
var focusedElem;

		var scntDiv = $('#p_scents');
		var i = $('#p_scents li').size() + 1;

		$('#addScnt').live('click', function() {
			$('<li  id ="p_scnt_' + i +'" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="st_'+ i +'" class="form-control" name="start" onchange="superScript(this)"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="end_'+ i +'" class="form-control" name="end" onchange="superScript(this)"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

			i++;
			return false;
		});

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
			//var max_count = $('#p_scents li').size();

			//for (count = 3; count < max_count; count++ )   {

				//$('#end_'+count+'').focus( function() {

				 //focusedElem = $('#end_'+count+'');
				
			//});	

			//}

	
			$('#zero').click( function() {

				focusedElem.val(focusedElem.val() + 'S₀');

			});
			$('#end_1').focus( function() {

				 focusedElem = $('#end_1');
				
			});	
 
			$('#st_1').focus( function() {

				focusedElem = $('#st_1');
			});
			$('#end_2').focus( function() {

				 focusedElem = $('#end_2');
				
			});	
 
			$('#st_2').focus( function() {

				focusedElem = $('#st_2');
			});
			$('#st_3').focus( function() {

				focusedElem = $('#st_3');
			});
			$('#st_4').focus( function() {

				focusedElem = $('#st_4');
			});
			$('#st_5').focus( function() {

				focusedElem = $('#st_5');
			});
			$('#st_6').focus( function() {

				focusedElem = $('#st_6');
			});
			$('#st_7').focus( function() {

				focusedElem = $('#st_7');
			});
			$('#st_8').focus( function() {

				focusedElem = $('#st_8');
			});
			$('#st_9').focus( function() {

				focusedElem = $('#st_9');
			});$('#st_10').focus( function() {

				focusedElem = $('#st_10');
			});
			$('#st_11').focus( function() {

				focusedElem = $('#st_12');
			});
		


			$('#end_3').focus( function() {

				focusedElem = $('#end_3');
			});
			$('#end_4').focus( function() {

				focusedElem = $('#end_4');
			});
			$('#end_5').focus( function() {

				focusedElem = $('#end_5');
			});
			$('#end_6').focus( function() {

				focusedElem = $('#end_6');
			});
			$('#end_7').focus( function() {

				focusedElem = $('#end_7');
			});
			$('#end_8').focus( function() {

				focusedElem = $('#end_8');
			});
			$('#end_9').focus( function() {

				focusedElem = $('#end_9');
			});$('#end_10').focus( function() {

				focusedElem = $('#end_10');
			});
			$('#end_11').focus( function() {

				focusedElem = $('#end_12');
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

			
		});