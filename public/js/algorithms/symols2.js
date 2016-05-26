	$(function () {
var focusedElem;

		var scntDiv = $('#b_scents');
		var i = $('#b_scents li').size() + 1;

		$('#addScnt_2').live('click', function() {
			$('<li  id ="b_scnt_' + i +'" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="bst_'+ i +'" class="form-control" name="start" onchange="superScript(this)"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="bend_'+ i +'" class="form-control" name="end" onchange="superScript(this)"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt_2"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

			i++;
			return false;
		});

		$('#remScnt_2').live('click', function() { 
			if( i > 1 ) {
				$(this).parents('li').remove();
				i--;
			}
			return false;
		});


		$('#reset_2').live('click', function() { 
			$('input[type=text]').each(function() {

				$(this).val('');
			});
			return false;

		});


			$('#lambda2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'λ'); 


			});

			$('#right2').click( function() {

				//var text = $('#text');
				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'R'); 

			});
			$('#left2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'L'); 

			});

			$('#here2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'H'); 

			});
			$('#part2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + '∂'); 

			});
			$('#omega2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'Ω'); 

			});
			$('#one2').click( function() {

				//var text = $('#text');
				focusedElem.val(focusedElem.val() + 'S₁'); 

			});
			//var max_count = $('#p_scents li').size();

			//for (count = 3; count < max_count; count++ )   {

				//$('#end_'+count+'').focus( function() {

				 //focusedElem = $('#end_'+count+'');
				
			//});	

			//}

	
			$('#zero2').click( function() {

				focusedElem.val(focusedElem.val() + 'S₀');

			});
			$('#bend_1').focus( function() {

				 focusedElem = $('#bend_1');
				
			});	
 
			$('#bst_1').focus( function() {

				focusedElem = $('#bst_1');
			});
			$('#bend_2').focus( function() {

				 focusedElem = $('#bend_2');
				
			});	
 
			$('#bst_2').focus( function() {

				focusedElem = $('#bst_2');
			});
			$('#bst_3').focus( function() {

				focusedElem = $('#bst_3');
			});
			$('#bst_4').focus( function() {

				focusedElem = $('#bst_4');
			});
			$('#bst_5').focus( function() {

				focusedElem = $('#bst_5');
			});
			$('#bst_6').focus( function() {

				focusedElem = $('#bst_6');
			});
			$('#bst_7').focus( function() {

				focusedElem = $('#bst_7');
			});
			$('#bst_8').focus( function() {

				focusedElem = $('#bst_8');
			});
			$('#bst_9').focus( function() {

				focusedElem = $('#bst_9');
			});$('#bst_10').focus( function() {

				focusedElem = $('#bst_10');
			});
			$('#bst_11').focus( function() {

				focusedElem = $('#bst_12');
			});
		


			$('#bend_3').focus( function() {

				focusedElem = $('#bend_3');
			});
			$('#bend_4').focus( function() {

				focusedElem = $('#bend_4');
			});
			$('#bend_5').focus( function() {

				focusedElem = $('#bend_5');
			});
			$('#bend_6').focus( function() {

				focusedElem = $('#bend_6');
			});
			$('#bend_7').focus( function() {

				focusedElem = $('#bend_7');
			});
			$('#bend_8').focus( function() {

				focusedElem = $('#bend_8');
			});
			$('#bend_9').focus( function() {

				focusedElem = $('#bend_9');
			});$('#bend_10').focus( function() {

				focusedElem = $('#bend_10');
			});
			$('#bend_11').focus( function() {

				focusedElem = $('#bend_12');
			});

				$('#big_lambda2').click( function() {

		         //var text = $('#text');
		       focusedElem.val(focusedElem.val() + 'Λ'); 

		    });

		$('#one_tild2').click( function() {

		         //var text = $('#text');
		        focusedElem.val(focusedElem.val() + 'Õ'); 

		    });
		$('#sh2').click( function() {

		         //var text = $('#text');
		        focusedElem.val(focusedElem.val() + '#'); 

		    });

		$('#bull2').click( function() {

		         //var text = $('#text');
        		focusedElem.val(focusedElem.val() + 'H'); 

    });

			
		});