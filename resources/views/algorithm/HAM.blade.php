@extends('templates.MTbase')
@section('head')
		<title>Эмулятор Нормальных алгоритмов Мркова</title>

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
								<h1 class="text-primary">Эмулятор нормальных алгоритмов Маркова</h1>
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
												
												<input type="hidden" id="inputFileNameToSaveAs" value="Алгоритм НАМ"></input>
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

														<ul id="p_scents" class="list" data-sortable="true">
															<li id="p_scnt" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  onchange="superScript(this);" id="st_1"  class="form-control" name="start" >
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" onchange="superScript(this);" id="end_1"  class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_2" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_2" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_2" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_3" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_3" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_3" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_4" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_4" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_4" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_5" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_5" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_5" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_6" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_6" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_6" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_7" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_7" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_7" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_8" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_8" class="form-control" name="start">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_8" class="form-control" name="end">
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_9" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_9" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_9" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_10" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_10" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_10" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_11" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_11" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_11" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_12" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_12" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_12" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_13" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_13" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_13" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_14" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_14" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_14" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_15" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_15" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_15" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_16" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_16" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_16" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_17" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_17" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_17" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_18" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_18" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_18" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_19" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_19" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_19" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_20" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_20" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_20" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_21" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_21" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_21" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_22" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_22" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_22" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_23" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_23" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_23" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_24" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_24" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_24" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_25" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_25" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_25" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_25" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_25" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_25" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
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
													<textarea name="textarea_src" id="textarea2" class="form-control" rows="1" placeholder=""></textarea>
													<label for="textarea2" style="top:-15px">Входное слово:</label>
													
												</div>
														
													</form>
													
										
									</div><!--end .card-body -->
									<div class="card">
										<div class="col-sm-6">
											<button type="button" class="btn ink-reaction btn-primary" title="" data-original-title="Увидеть только результат преобразования" data-toggle="tooltip" data-placement="top" onClick="run_all_normal(false)">Запуск</button>	
										</div>
		                                <!-- <div class="col-sm-4">									
											<button type="button" style="right: -20px;"class="btn ink-reaction btn-primary" onClick="" title="" data-original-title="Шаг для отладки алгоритма" data-toggle="tooltip" data-placement="top"><i class="md md-fast-forward"></i></button>
										</div> -->
										<div class="col-sm-6">									
											<button  type="button" class="btn ink-reaction btn-primary" onClick="run_all_normal(true)" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
										</div>
										<br>
									</div>		
									<div class="card">
									<div class="card-head card-head-xs">
									<header>Спецсимволы:</header>
									</div>
									<div class="card-body">
										<div class="btn-group">
											<button type="button" class="btn ink-reaction btn-default-bright" id="sh">#</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="one_tild">Õ</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="big_lambda">&lambda;</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="bull">H</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="delete">_</button>
																						
										</div> 
									</div><!--end .card-body -->
									</div>
									
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
												<input type="text" class="form-control" id="disabled6" disabled value="">
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
			<header>Как работать с эмулятором</header>
			<div class="offcanvas-tools">
				<a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
					<i class="md md-close"></i>
				</a>
			</div>
		</div>
		<div class="nano has-scrollbar" style="height: 318px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">

		<p>
			Введите в соответствующие поля входное слово, алфавит, а также сам текст программы(правую и левую части).
		</p>
		
		<h4>Инструкция:</h4>
			<ul class="list-divided">
				<li>Введите в соответствующие поля входное слово, а также сам текст программы (правую и левую части).</li>
				<!-- <li>Все введенные символы отделяйте друг от друга точками. Но симол с нижними индексами считается как один. Пример: а<sub>0</sub>.a -> a.a.a</li>
				 -->
				<li>В качестве маркеров не используйте символы "+", "*", "-", так как программа не сможет их корректно считать. Рекомендуем использовать символы из панели Спецсимволов (например, "#"), символы английского алфавита и цифры.</li>
				<li>Для того чтобы записать строку, по которой алгоритм должен стереть символы, в используйте символ "_". Например, запись "11 -> _ " будет эквивалентна "11 ->   ". Если должна быть выполнена замена, например, 11 -> 2, то символ _ не требуется. </li>
				<li>Для того чтобы записать команду с точкой останова, используйте английскую букву "H". Например, 11 -> 11H. Если необходимо записать команду со удалением маркера (например, #) и остановкой работы алгоритма, то запись команды должна быть следующая: # -> _H</li>
				<li>Для перемещения строк нужно, удерживая курсором нужный элемент списка за стрелку, перетащить его на желаемую позицию.</li>
				<li>Для добавления строки нажмите кнопку "+".</li>
				<!-- <li>Для добавления нижнего индекса нужно набрать в поле ввода конструкцию вида _{цифры}. Пример: S_{00} преобразуется в S<sub>00</sub>. </li> -->
				<li>Очитстить все строки можно с помощью соответствующей кнопки. </li>
				<li>Специальный символ можно добавить, кликнув на него, находясь на нужной позиции поля ввода. </li>

			</ul>
		</div></div><div class="nano-pane"><div class="nano-slider" style="height: 199px; transform: translate(0px, 0px);"></div></div></div>
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
		{!! HTML::script('js/algorithms/symbols.js') !!}
		{!! HTML::script('js/algorithms/saving.js') !!}
		{!! HTML::script('js/algorithms/superScript.js') !!}
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


