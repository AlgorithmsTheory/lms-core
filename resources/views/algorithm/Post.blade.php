@extends('templates.MTbase')
@section('head')
		<title>Эмулятор машины Поста</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		{!! HTML::style('css/bootstrap.css?1422792965') !!}
		{!! HTML::style('css/materialadmin.css?1425466319') !!}
		{!! HTML::style('css/font-awesome.min.css?1422529194') !!}
		{!! HTML::style('css/material-design-iconic-font.min.css?1421434286') !!}
		{!! HTML::style('css/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
		{!! HTML::style('css/libs/nestable/nestable.css?1423393667') !!}
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="/laravel/resources/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
@stop

    @section('content')

				<!-- BEGIN LIST SAMPLES -->
				<section>
					
					<div class="section-body contain-lg">
					
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary">Эмулятор машины Поста</h1>
							</div><!--end .col -->
							<div class="col-lg-12">
								<article class="margin-bottom-xxl">
									<p class="lead">
										Данный эмулятор предназначен для получения навыков написания алгоритмов, а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь со справкой (кнопка "Помощь")
									</article>
							</div><!--end .col -->
							
						</div>
						<!-- BEGIN NESTABLE LISTS -->
				<div class="col-lg-12">
					<div class="card style-default-bright">
						<div class="card-head">
						<div class="col-md-6">
						  </br>
						<div class="card card-bordered style-primary" style="top: -40px; height: 700px;">

										<div class="card-head">
										<div class="tools">
											<div class="btn-group">
												
												<input type="hidden" id="inputFileNameToSaveAs" value="Алгоритм Пост"></input>
													<button type="button" title="" data-original-title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised" onclick="saveTextAsFile()"><i class="md md-file-download"></i></button>
													
													<button type="button" onclick="loadFileAsText()" style="left:5px" title="" data-original-title="Загрузить в эмулятор ранее сохраненный алгоритм. Перед этим выберите файл" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised"><i class="md md-file-upload"></i></button>
													<input type="file"  style="left:15px" class="btn ink-reaction btn-raised btn-xs btn-primary" id="fileToLoad">
												
											</div>
										</div>
											<header>Ваш алгоритм:</header>

										</div>

										<div class="card-body" style="top: -30px;">
											<div class="card">
												<div class="card-body no-padding">
													<div class="card-body height-6 scroll style-default-bright" style="height: 550px;">

														<ul id="p_scents" class="list" data-sortable="_true">
															
															<li id="p_scnt" class="tile">

																	<span class="input-group-addon"><b>1</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_1" name="select1" class="form-control">
																				<option value=" " selected="selected">&nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_1" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_1" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_1" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_2" class="tile">
																<span class="input-group-addon"><b>2</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_2" name="select_2" class="form-control">
																				<option value=" " selected="selected">&nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_2" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_2" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_2" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_3" class="tile">
																<span class="input-group-addon"><b>3</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_3" name="select1" class="form-control">
																				<option value=" " selected="selected">&nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_3" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_3" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_3" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_4" class="tile">
																<span class="input-group-addon"><b>4</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_4" name="select_4" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_4" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_4" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_4" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_5" class="tile">
																<span class="input-group-addon"><b>5</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_5" name="select_5" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_5" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_5" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_5" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_6" class="tile">
																<span class="input-group-addon"><b>6</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_6" name="select_6" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_6" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_6" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_6" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_7" class="tile">
																<span class="input-group-addon"><b>7</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_7" name="select_7" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_7" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_7" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_7" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>


															<li id="p_scnt_8" class="tile">
															<span class="input-group-addon"><b>8</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_8" name="select_8" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_8" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_8" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_8" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_9" class="tile">
															<span class="input-group-addon"><b>9</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_9" name="select_9" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_9" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_9" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_9" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_10" class="tile">
															<span class="input-group-addon"><b>10</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_10" name="select_10" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_10" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_10" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_10" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_11" class="tile">
															<span class="input-group-addon"><b>11</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_11" name="select_11" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_11" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_11" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_11" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_12" class="tile">
															<span class="input-group-addon"><b>12</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_12" name="select_12" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_12" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_12" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_12" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>
															<li id="p_scnt_13" class="tile">
															<span class="input-group-addon"><b>13</b></span>
																
																<div class="col-md-3">
																<div class="input-group-content">
																<!-- <label for="select1">&nbsp;&nbsp;&nbsp;</label> -->
																			<select id="select_13" name="select_13" class="form-control">
																				<option value=" " selected="selected"><option value=">">&nbsp;</option>nbsp;</option>
																				<option value=">">></option>
																				<option value="<"><</option>
																				<option value="1">1</option>
																				<option value="0">0</option>
																				<option value="?">?</option>
																				<option value="!">!</option>
																			</select>

																			</div>
																			</div>

																			<div class="col-md-3" style="left: -50px;">

																			<div class="input-group-content">
													
																 						<input type="number" min="1" id="goto1_13" class="form-control" required="">
																			</div>
																					 <div class="input-group-content">
																 						<input type="number" min="1" id="goto2_13" class="form-control" required="">
														
																					</div>

																					<span class="input-group-addon">|</span>
																				</div>
																			<div class="col-md-6" style="left: -40px;">
																			<div class="input-group-content">
																				<input type="text" class="form-control" name="comment" id="comment_13" placeholder="Комментарий">
																				<div class="form-control-line"></div>
																			</div>
																			</div>
															</li>

														</ul>
														<!--вставить новую строку -->	
													</div>
												</div>
											</div><!--end .card -->
										</div><!--end .card-body -->

										<div class="row"  >
											<div class="col-md-3">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button"  class="btn ink-reaction btn-raised btn-default-light" href="#" id="addScnt"><i class ="fa fa-plus" ></i></button>
													<br/>

												</div><!--end .card-body -->
											</div>
											<div class="col-md-3">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:60px" href="#" id="reset">Очистить</button>
													<br/>
												</div><!--end .card-body -->
											</div>
											
											
										</div>	
									</div><!--end .card -->


									
								
						</div>
							<div class="col-md-6">	
								
								<div class="card-body" >
								<div class="col-lg-2" style="left:400px">
							<a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
											<i class="md md-help"></i>
										</a>
							</div>
							<div class="col-lg-12">
												<form class="form" role="form">
													<div class="form-group floating-label">
												<textarea name="task_text" id="task_text" class="form-control" rows="3" placeholder="Для Вашего удобства здесь можно написать условие задачи"></textarea>
												<label for="task_text" style="top:-15px">Условие задачи: </label> 
											</div>
													
												</form>
							</div>					
								</div><!--end .card-body -->
								
								<div class="col-sm-6">
									
									<div class="card-body">
													<form class="form" role="form">
														<div class="form-group floating-label">
													<textarea name="textarea_src" id="input_word" class="form-control" rows="1" placeholder=""></textarea>
													<label for="textarea2" style="top:-15px">Входное слово:</label>
													
												</div>
														
													</form>
													
										
									</div><!--end .card-body -->
									<div class="card">
										<div class="col-sm-6">
											<button type="button" onclick="RunPost()" class="btn ink-reaction btn-primary" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top" >Запуск</button>	
										</div>
		                               <!--  <div class="col-sm-4">									
											<button type="button" style="right: -20px;"class="btn ink-reaction btn-primary" onClick="" title="" data-original-title="Шаг для отладки алгоритма" data-toggle="tooltip" data-placement="top"><i class="md md-fast-forward"></i></button>
										</div> -->
										<div class="col-sm-6">									
											<button  type="button" onclick="RunPost(true)" class="btn ink-reaction btn-primary"  title="" data-original-title="Шаг для отладки алгоритма" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
										</div>
										<br>
									</div>		
									<!-- <div class="card">
									<div class="card-head card-head-xs">
									<header>Спецсимволы:</header>
									</div>
									<div class="card-body">
										<div class="btn-group">
											<button type="button" class="btn ink-reaction btn-default-bright" id="sh">#</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="one_tild">Õ</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="big_lambda">&lambda;</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="bull">H</button>
											
																						
										</div> 
									</div>
									</div> -->
									
								</div>
											
							<div class="col-sm-6">

								<div class="card">
								
									<div class="card-body">
									<table class="table no-margin">
											<thead>
												<tr>
													<th></th>
													<th>Процесс:</th>
													
												</tr>
											</thead>
											<tbody id="debug">
												<tr>
													<td>1</td>
													<td id="input1"></td>
													
												</tr>
												<tr>
													<td>2</td>
													<td id="input2"></td>
												</tr>
												
																								
											</tbody>
										</table>
										<br>
										<form class="form" role="form">
											<div class="form-group floating-label">
												<input type="text" class="form-control" id="result_word" disabled value="">
												<label for="disabled6" style="top:-15px">Результат: </label>
											</div>
											
										</form>
									<!--end .card-body -->
									
									</div>
								</div>
							</div>	
								
							</div>						
						</div>
					</div>
				</div>
				
<div class="offcanvas">


	<div id="offcanvas-demo-right" class="offcanvas-pane width-10" style="">
		<div class="offcanvas-head">
			<header>Что это и как с этим работать?</header>
			
		</div>
		<div class="nano has-scrollbar" style="height: 318px;">
		<div class="nano-content" tabindex="0" style="right: -17px;">
		<div class="offcanvas-body">

		<h4>Что такое машина Поста?</h4>
			<ul class="list-divided">
				<li>Машина Поста — это абстрактная, но очень простая вычислительная машина.</li>
				<li>Машина Поста состоит из каретки (считывающей и записывающей головки) и ленты, разбитой на ячейки. Каждая ячейка ленты может быть либо пустой («0»), или содержать метку («1»).</li>
				<li>Программа состоит из пронумерованных строк. В каждой строке записывается одна из следующих команд:</li>
				<ol>1. → j – переместить каретку вправо на 1 ячейку и перейти к строке с номером j</ol>
				<ol>2. ← j – переместить каретку влево на 1 ячейку и перейти к строке с номером j</ol>
				<ol>3. 1 j – записать в текущую ячейку «1» (поставить метку) и перейти к строке с номером j</ol>
				<ol>4. 0 j – записать в текущую ячейку «0» (стереть метку) и перейти к строке с номером j</ol>
				<ol>5. ? i; j – если текущая ячейка содержит «0» (не отмечена), то перейти к строке с номером i, иначе перейти к строке j</ol>
				<ol>6. ! – конец программы (стоп). В команде «стоп» переход на следующую строку не указывается</ol>
			</ul>
		<h4>Как этим пользоваться?</h4>
			<ul class="list-divided">
				<li>В правой части находится поле редактора, в которое можно ввести условие задачи в свободной форме.</li>
				<li>Ниже расположено поле для ввода входного слова, которое должна обработать программа. Тут введите последовательность из нулей и единиц. Таким образом будет задана лента. </li>
				<li>В таблице справа набирается программа. Каждая строка программы нумеруется автоматически.</li>
				<ol>1. В каждой строке в первом поле из списка выбирается нужная команда.</ol>
				<ol>2. Во втором вводится номер строки для перехода (если это необходимо). </ol>
				<ol>3. В третье поле также можно ввести номер строки перехода, это требуется в случае выбора в строке команды «?».</ol>
				<ol>4. Четвертое может содержать комментарий к каждой строчке программы. </ol>
				<li>Добавить строки таблицы или очистить их можно с помощью кнопок, расположенных снизу от таблицы. </li>
				<li>Программа может выполняться сразу до конца(кнопка Запуск) или по шагам (Шаг).</li>
				<li>Задачи для машины Поста можно сохранять в файлах. Сохраняется условие задачи и программа. Для этого нажмите «Стрелку вниз».</li>
				<li>Для загрузки сохраненного алгоритма выберите файл и нажмите «Стрелку вверх».</li>
			</ul>
		</div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div>
	</div>
</div>
</section>


			<!--end #content-->
@stop		

		<!--end #base-->
		<!-- END BASE -->
@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
		
	
		{!! HTML::script('js/algorithms/jquery-1.4.3.min.js') !!}
		{!! HTML::script('js/algorithms/jquery-1.10.2.js') !!}
		{!! HTML::script('js/algorithms/symbols_post.js') !!}
		{!! HTML::script('js/algorithms/saving_post.js') !!}
		{!! HTML::script('js/algorithms/superScript.js') !!}
		{!! HTML::script('js/algorithms/post.js') !!}
		{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
		{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
		{!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}
		{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
		{!! HTML::script('js/libs/spin.js/spin.min.js') !!}
		{!! HTML::script('js/libs/jquery-validation/dist/jquery.validate.min.js') !!}
		{!! HTML::script('js/libs/jquery-validation/dist/additional-methods.min.js') !!}
		{!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
		{!! HTML::script('js/libs/nestable/jquery.nestable.js') !!}
		{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
		{!! HTML::script('js/core/source/App.js') !!}
		{!! HTML::script('js/core/source/AppNavigation.js') !!}
		{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
		{!! HTML::script('js/core/source/AppCard.js') !!}
		{!! HTML::script('js/core/source/AppForm.js') !!}
		{!! HTML::script('js/core/source/AppNavSearch.js') !!}
		{!! HTML::script('js/core/source/AppVendor.js') !!}
		{!! HTML::script('js/core/demo/Demo.js') !!}
		{!! HTML::script('js/core/demo/DemoUILists.js') !!}
		{!! HTML::script('js/algorithms/send.js') !!}
		{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
		{!! HTML::script('js/libs/toastr/toastr.js') !!}
			<!-- END JAVASCRIPT -->
@stop


