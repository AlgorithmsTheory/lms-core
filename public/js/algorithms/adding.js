$(function() {
											var scntDiv = $('#p_scents');
											var i = $('#p_scents li').size() + 1;

											$('#addScnt').live('click', function() {
												$('<li  id ="p_scnt_' + i +'" class="tile"><div class="input-group"><div class="input-group-content"><input type="text" id="text" class="form-control" name="start" onchange="superScript(this)"></div><span class="input-group-addon"><i class="md md-arrow-forward"></i></span><div class="input-group-content"><input type="text" id="text" class="form-control" name="end" onchange="superScript(this)"></div></div><a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt"><i class="fa fa-trash"></i></a> </li>').appendTo(scntDiv);

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

										});