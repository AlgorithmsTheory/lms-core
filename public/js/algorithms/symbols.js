	$(function () {
			$('#lambda').click( function() {

				var text = $('#text');
				text.val(text.val() + 'λ'); 

			});

			$('#right').click( function() {

				var text = $('#text');
				alert($('#text').is(':focus'));
				text.val(text.val() + 'R'); 

			});
			$('#left').click( function() {

				var text = $('#text');
				text.val(text.val() + 'L'); 

			});

			$('#here').click( function() {

				var text = $('#text');
				text.val(text.val() + 'H'); 

			});
			$('#part').click( function() {

				var text = $('#text');
				text.val(text.val() + '∂'); 

			});
			$('#omega').click( function() {

				var text = $('#text');
				text.val(text.val() + 'Ω'); 

			});
			$('#one').click( function() {

				var text = $('#text');
				text.val(text.val() + 'S₁'); 

			});
			$('#zero').click( function() {

				var text = $('#text');
				text.val(text.val() + 'S₀'); 

			});
		});