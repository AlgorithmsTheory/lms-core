@extends('templates.MTbase')
@section('head')
		<title>Эмулятор машины Нормальных алгоритмов Маркова</title>
		<meta name="csrf_token" content="{{ csrf_token() }}" />

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
			<section id="HAM-result">
					
					<div class="section-body contain-lg">
						 <div id="mytimer"></div> 	
				
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary">Контрольная работа по теме "Нормальные алгоритмы Маркова"</h1>
							</div><!--end .col -->
							
							
						</div>
						<!-- BEGIN NESTABLE LISTS -->
				<div class="col-lg-12">
					<div class="card tabs-left style-default-light">
						<ul class="card-head nav nav-tabs" data-toggle="tabs">
											<li class="active"><a href="#first5">Задача №1</a></li>
											<li><a href="#second5">Задача №2</a></li>
						</ul>
					<div class="card-body tab-content style-default-bright">
					<div class="tab-pane active" id="first5">
						<div class="card-head">
										<div class="col-lg-8"><header>Задача №1</header></div>	
										<div class="col-lg-3" style="left:72px">
								<a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
											<i class="md md-help"></i>
										</a>
								</div>
						</div>				
						<div class="col-md-6">
						  </br>
						<div class="card card-bordered style-primary" style="top: -20px; height: 700px;">

										<div class="card-head">
										
											<header > Ваш алгоритм:</header>
										</div>

										<div class="card-body" style="top: -30px;">
											<div class="card">
												<div class="card-body no-padding">
													<div class="card-body height-6 scroll style-default-bright" style="height: 570px;">

														<ul id="p_scents" class="list" data-sortable="true">
															<li id="p_scnt" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  onchange="superScript(this);" id="st_1"  class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" onchange="superScript(this);" id="end_1"  class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="p_scnt_2" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_2" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_2" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_3" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_3" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_3" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_4" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_4" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_4" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_5" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_5" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_5" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_6" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_6" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_6" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_7" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="st_7" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_7" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="p_scnt_8" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="st_8" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="end_8" class="form-control" name="end" rows="1"></input>
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
													<button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:30px" href="#" id="reset">Очистить</button>
													<br/>
												</div><!--end .card-body -->
											</div>
											<!--<div class="col-lg-2">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light" style="left:35px"><i class="md md-file-download"></i></button>
													<br/>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light"><i class="md md-file-upload"></i></button>
													<br/>
												</div>
											</div>-->
										</div>	
									</div>
								
						</div>
					
							<div class="col-md-6">	
								
								
								
									<br>
								<div class="col-lg-12">
								<div class="card">
									<div class="card-head">
										<ul class="nav nav-tabs nav-justified" data-toggle="tabs">
											<li class="active"><a href="#light1">Легкий уровень (2 балла)</a></li>
											<li class=""><a href="#hard1">Сложный уровень (3 балла)</a></li>
										</ul>
										
									</div>
									<div class="card-body tab-content">
										<div class="tab-pane active" id="light1"><p>Задача легкая</p>
										</div>
										<div class="tab-pane" id="hard1"><p>Задача сложная.</p>
										</div>
									</div>
								</div>
								</div><!--end .card-body -->
								
								<div class="col-sm-6">
									
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
									<div class="card">
									
									<div class="card-body">
										
										<button type="button" style="top:-15px; left: 30px" class="btn ink-reaction btn-primary" id="send_one" onClick="run_all_normal(0)">Отправить</button>	
																		
										<form class="form" role="form">
											<div class="form-group floating-label">
												<input type="text" class="form-control" id="result1" disabled>
												<label for="result1" style="top:-5px; left: 40px">Ваш балл:</label>
											</div>
											
									</form>
										
									</div>
									
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="card">
									<div class="card-head card-head-xs">
									<header>Отладка:</header>
									<div class="tools">
											<a class="btn btn-icon-toggle" data-container="body" data-toggle="popover" data-placement="top" data-content="В режиме предотладки вы можете один раз проверить свой алгоритм на произвольном входном слове, которое можно ввести в соответствующее поле ниже" data-original-title="" title="" aria-describedby="popover665976"><i class="md md-help"></i></a>
										</div>
									</div>
										<div class="card-body">
											<form class="form" role="form">
												<div class="form-group floating-label">
													<textarea name="textarea_src" id="textarea2" class="form-control" rows="1" placeholder="" ></textarea>
													<label for="textarea2" style="top:-15px">Входное слово:</label>

												</div>

											</form>
											<br>
											<br>
											<button type="button" id="onerun2" class="btn ink-reaction btn-primary" style="left: 40px" onClick="run_one_normal(false)">Запуск</button>
										<!--end .card-body -->
																					
											<form class="form" role="form">
												<div class="form-group floating-label">
													<input type="text" class="form-control" id="disabled6" disabled>
													<label for="disabled6" style="top: -1px; left: 40px" >Результат:</label>
												</div>
												
											</form>
									
										</div>
									</div>
									
								</div>
								<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<table class="table table-condensed no-margin">
											<thead>
												<tr>
													<th>#</th>
													<th>Входное слово</th>
													<th>Верное преобразование</th>
													<th>Ваш результат</th>
													
												</tr>
											</thead>
											<tbody>
												<tr id="first_sequence" class="success">
													<td>1</td>
													<td id="input1"></td>
													<td id="output1"></td>
													<td id="field1"></td>

													
												</tr>
												<tr id="second_sequence" class="success">
												<td>2</td>
												<td id="input2"></td>
												<td id="output2"></td> 
												<td id="field2"></td>
												
												</tr >
												<tr id="third_sequence" class="success">
												<td>3</td>
												<td id="input3"></td>
												<td id="output3"></td> 
												<td id="field3"></td>
													
												</tr>
												<tr id="fourth_sequence" class="success">
												<td>4</td>
												<td id="input4"></td>
												<td id="output4"></td>
												<td id="field4"></td>
													
												</tr >
												<tr id="fifth_sequence" class="success">
												<td>5</td>
												<td id="input5"></td>
												<td id="output5" ></td> 
												<td id="field5"></td>
													
												</tr>
											</tbody>
										</table>
									</div><!--end .card-body -->
								</div>
								</div>
							</div>
					</div>
				
					
					<div class="tab-pane" id="second5">
						<div class="card-head">
										<div class="col-lg-8"><header>Задача №2</header></div>	
										<div class="col-lg-3" style="left:72px">
								<a class="btn btn-raised ink-reaction btn-default-bright pull-right" href="#offcanvas-demo-right" data-toggle="offcanvas">
											<i class="md md-help"></i>
										</a>
								</div>
						</div>				
						<div class="col-md-6">
						  </br>
						<div class="card card-bordered style-primary" style="top: -20px; height: 700px;">

										<div class="card-head">
										
											<header > Ваш алгоритм:</header>

										</div>

										<div class="card-body" style="top: -30px;">
											<div class="card">
												<div class="card-body no-padding">
													<div class="card-body height-6 scroll style-default-bright" style="height: 570px;">

														<ul id="b_scents" class="list" data-sortable="true">
															<li id="b_scnt" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  onchange="superScript(this);" id="bst_1"  class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" onchange="superScript(this);" id="bend_1"  class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_2" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_2" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_2" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_3" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_3" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_3" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_4" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_4" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_4" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_5" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_5" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_5" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_6" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_6" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_6" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_7" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text" id="bst_7" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_7" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>


															<li id="b_scnt_8" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_8" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_8" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_9" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_9" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_9" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_10" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_10" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_10" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_11" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_11" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_11" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_12" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_12" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_12" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															<li id="b_scnt_13" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_13" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_13" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_14" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_14" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_14" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_15" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_15" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_15" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_16" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_16" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_16" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_17" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_17" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_17" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_18" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_18" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_18" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
																<li id="b_scnt_19" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_19" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_19" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_20" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_20" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_20" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_21" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_21" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_21" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_22" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_22" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_22" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_23" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_23" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_23" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_24" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_24" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_24" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_25" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_25" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_25" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_26" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_26" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_26" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_27" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_27" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_27" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_28" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_28" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_28" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_29" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_29" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_29" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_30" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_30" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_30" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_31" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_31" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_31" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_32" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_32" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_32" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_33" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_33" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_33" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_34" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_34" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_34" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_35" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_35" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_35" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_36" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_36" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_36" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_37" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_37" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_37" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_38" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_38" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_38" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_39" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_39" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_39" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_40" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_40" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_40" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_41" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_41" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_41" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_42" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_42" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_42" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_43" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_43" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_43" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_44" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_44" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_44" class="form-control" name="end" rows="1"></input>
																	</div>
																</div> 
																<a class="btn btn-flat ink-reaction btn-default"  href="#" id="remScnt">
																	<i class="fa fa-trash"></i>

																</a>
															</li>
															</li>
																<li id="b_scnt_45" class="tile">
																<div class="input-group">
																	<div class="input-group-content">
																		<input type="text"  id="bst_45" class="form-control" name="start" rows="1"></input>
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" id="bend_45" class="form-control" name="end" rows="1"></input>
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
													<button type="button"  class="btn ink-reaction btn-raised btn-default-light" href="#" id="addScnt_2"><i class ="fa fa-plus" ></i></button>
													<br/>
												</div><!--end .card-body -->
											</div>
											<div class="col-md-3">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:30px" href="#" id="reset_2">Очистить</button>
													<br/>
												</div><!--end .card-body -->
											</div>
											<!--<div class="col-lg-2">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light" style="left:35px"><i class="md md-file-download"></i></button>
													<br/>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="card-body text-center height-3" style="top: -90px;">
													<button type="button" class="btn ink-reaction btn-raised btn-default-light"><i class="md md-file-upload"></i></button>
													<br/>
												</div>
											</div>-->
										</div>	
									</div>
								
						</div>
					
							<div class="col-md-6">	
									<br>
								<div class="col-lg-12">
								<div class="card">
									<div class="card-head">
										<ul class="nav nav-tabs nav-justified" data-toggle="tabs">
											<li class="active"><a href="#light2">Легкий уровень (3 балла)</a></li>
											<li class=""><a href="#hard2">Сложный уровень (4 балла)</a></li>
										</ul>
										
									</div>
									<div class="card-body tab-content">
										<div class="tab-pane active" id="light2"><p>Задача легкая</p>
										</div>
										<div class="tab-pane" id="hard2"><p>Задача сложная</p>
										</div>
									</div>
								</div>
								</div><!--end .card-body -->
								
								<div class="col-sm-6">
									
									<div class="card">
									<div class="card-head card-head-xs">
									<header>Спецсимволы:</header>
									</div>
									<div class="card-body">
										<div class="btn-group">
											<button type="button" class="btn ink-reaction btn-default-bright" id="sh2">#</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="one_tild2">Õ</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="big_lambda2">&lambda;</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="bull2">H</button>
											<button type="button" class="btn ink-reaction btn-default-bright" id="delete2">_</button>
											
																						
										</div> 
									</div><!--end .card-body --><!--end .card-body -->
									</div>
									<div class="card">
									
									<div class="card-body">
										
										<button type="button" style="top:-15px; left: 30px" class="btn ink-reaction btn-primary" id="send_two" onClick="run_all_normal(1)">Отправить</button>	
																		
										<form class="form" role="form">
											<div class="form-group floating-label">
												<input type="text" class="form-control" id="result2" rows="1" disabled>
												<label for="result2" style="top:-5px; left: 40px" >Ваш балл:</label>
											</div>
											
									</form>
										
									</div>
									
									</div>
								</div>
								
								<div class="col-sm-6">
									<div class="card">
									<div class="card-head card-head-xs">
									<header>Отладка:</header>
									<div class="tools">
											<a class="btn btn-icon-toggle" data-container="body" data-toggle="popover" data-placement="top" data-content="В режиме предотладки вы можете один раз проверить свой алгоритм на произвольном входном слове, которое можно ввести в соответствующее поле ниже" data-original-title="" title="" aria-describedby="popover665976"><i class="md md-help"></i></a>
										</div>
									</div>
										<div class="card-body">
											<form class="form" role="form">
												<div class="form-group floating-label">
													<textarea name="textarea_src2" id="textarea2" class="form-control" rows="1" placeholder="" ></textarea>
													<label for="textarea2" style="top:-15px">Входное слово:</label>

												</div>

											</form>
											<button type="button" id="onerun" class="btn ink-reaction btn-primary" style="left: 40px" onClick="run_one_normal_2(false)">Запуск</button>
										<!--end .card-body -->
																					
											<form class="form" role="form">
												<div class="form-group floating-label">
													<input type="text" class="form-control" id="onesend_2" disabled>
													<label for="onesend_2" style="top: -1px; left: 40px" >Результат:</label>
												</div>
												
											</form>
									
										</div>
									</div>
									
								</div>	
								<div class="col-lg-12">
								<div class="card">
									<div class="card-body">
										<table class="table table-condensed no-margin">
											<thead>
												<tr>
													<th>#</th>
													<th>Входное слово</th>
													<th>Верное преобразование</th>
													<th>Ваш результат</th>
													
												</tr>
											</thead>
											<tbody>
												<tr id="first_sequence" class="success">
													<td>1</td>
													<td id="input6"></td>
													<td id="output6"></td>
													<td id="field6"></td>
													
												</tr>
												<tr id="second_sequence" class="success">
												<td>2</td>
												<td id="input7"></td>
												<td id="output7"></td>
												<td id="field7"></td> 
												
												</tr >
												<tr id="third_sequence" class="success">
												<td>3</td>
												<td id="input8"></td>
												<td id="output8"></td> 
												<td id="field8"></td>
													
												</tr>
												<tr id="fourth_sequence" class="success">
												<td>4</td>
												<td id="input9"></td>
												<td id="output9"></td>
												<td id="field9"></td>
													
												</tr >
												<tr id="fifth_sequence" class="success">
												<td>5</td>
												<td id="input10"></td>
												<td id="output10" ></td> 
												<td id="field10"></td>
													
												</tr>
											</tbody>
										</table>
									</div><!--end .card-body -->
								</div>
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
				<li>Введите в соответствующие поля входное слово, а также сам текст программы(правую и левую части).</li>
				<!-- <li>Все введенные символы отделяйте друг от друга точками. Но симол с нижними индексами считается как один. Пример: а<sub>0</sub>.a -> a.a.a</li>
				 -->
				<li>Для обозначения удаления всех символов, находящихся в левой части, используйте символ "_". Например, запись "11 -> _ " будет эквивалентна "11 ->   ".</li>
				<li>Для точки останова используйте английскую букву "H".</li>
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
		
		<!-- END JAVASCRIPT -->
		<!-- {!! HTML::script('js/algorithms/onerun.js') !!} -->
		{!! HTML::script('js/algorithms/timer.js') !!}
		{!! HTML::script('js/algorithms/jquery-1.4.3.min.js') !!}
		{!! HTML::script('js/algorithms/jquery-1.10.2.js') !!}
		{!! HTML::script('js/algorithms/symbols.js') !!}
		{!! HTML::script('js/algorithms/symols2.js') !!}
		{!! HTML::script('js/algorithms/adding.js') !!}
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
		{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
		{!! HTML::script('js/libs/toastr/toastr.js') !!}
		{!! HTML::script('js/algorithms/KontrSend_HAM.js') !!}
		{!! HTML::script('js/algorithms/onesend.js') !!}
		{!! HTML::script('js/algorithms/twosend.js') !!}
@stop


