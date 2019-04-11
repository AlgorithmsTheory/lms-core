@extends('templates.base')
@section('head')
		<title>Эмулятор машины Тьюринга</title>

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

@stop

    @section('content')

				<!-- BEGIN LIST SAMPLES -->
			<section>
						<div class="row">
							<div class="col-lg-12">
								<h1 class="text-primary">Эмулятор машины Тьюринга</h1>
							</div><!--end .col -->
							<div class="col-lg-12">
								<article class="margin-bottom-xxl">
									<p class="lead">
										Данный эмулятор предназначен для получения навыков написания алгоритмов, а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь со справкой (кнопка "Помощь")
									</p>
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
												
												<input type="hidden" id="inputFileNameToSaveAs" value="Алгоритм МТ" ></input>
													<button type="button" title="" data-original-title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised" onclick="saveTextAsFile()"><i class="md md-file-download"></i></button>
													
													<button type="button" onclick="loadFileAsText()" style="left:5px" title="" data-original-title="Загрузить в эмулятор ранее сохраненный алгоритм. Перед этим выберите файл" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised"><i class="md md-file-upload"></i></button>
													<input type="file"  style="left:15px" class="btn ink-reaction btn-raised btn-xs btn-primary" id="fileToLoad">
												
											</div>
										</div>
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
																		<input type="text"  onchange="superScript(this);" id="st_1"  class="form-control" name="start" value="S₀.∂">
																	</div>
																	<span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
																	<div class="input-group-content">
																		<input type="text" onchange="superScript(this);" id="end_1"  class="form-control" name="end" value="∂.R.S₀">
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
									</div><!--end .card -->
									


</div>
<div class="col-md-6">	

	<div class="card-body">
		<div class="col-lg-2" style="left:400px">
			<a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
				<i class="md md-help"></i>
			</a>
		</div>
		<div class="col-lg-12">
			<form class="form" role="form">
				<div class="form-group floating-label">
					<textarea name="task_text" id="task_text" class="form-control" rows="3" placeholder="Для Вашего удобства здесь можно написать условие задачи"></textarea>
					<label for="textarea2" style="top:-15px">Условие задачи: </label> 
				</div>

			</form>
		</div><!--end .card-body -->
	</div>
	<div class="col-sm-6">
		<div class="card-body">
			<form class="form" role="form">
				<div class="form-group floating-label">
					<textarea name="textarea_src" id="textarea2" class="form-control" rows="1">∂</textarea>
					<label for="textarea2" style="top:-15px">Входное слово:</label>

				</div>

			</form>
		</div><!--end .card-body -->
		<div class="card">

			<div class="col-sm-6">
				<button type="button" class="btn ink-reaction btn-primary" title="" data-original-title="Увидеть только результат преобразования" data-toggle="tooltip" data-placement="top" onClick="run_all_turing(false)">Запуск</button>	
			</div>
            <!-- <div class="col-sm-4">									
				<button type="button" style="right: -20px;"class="btn ink-reaction btn-primary" onClick="" title="" data-original-title="Шаг для отладки алгоритма" data-toggle="tooltip" data-placement="top"><i class="md md-fast-forward"></i></button>
			</div> -->
			<div class="col-sm-6">									
				<button  type="button" class="btn ink-reaction btn-primary" onClick="run_all_turing(true)" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
			</div>
			<br>

		</div>
		<div class="card">
			<div class="card-head card-head-xs">
				<header>Спеццисмволы</header>
			</div>
			<div class="card-body">
				<div class="btn-group">
					<button type="button" class="btn ink-reaction btn-default-bright" id="right">R</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="left">L</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="here">H</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="zero">S<sub>0</sub></button>
					<br>
					<button type="button" class="btn ink-reaction btn-default-bright" id="part">&part;</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="omega">&Omega;</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="lambda">&#955;</button>
					<button type="button" class="btn ink-reaction btn-default-bright" id="one">S<sub>1</sub></button>

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
												<input type="text" class="form-control" id="disabled6" disabled>
												<label for="disabled6" style="top:-15px">Результат: </label>
											</div>
											
										</form>
									<!--end .card-body -->
									
									</div>
								</div><!--end .card-body -->

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
					<div class="nano has-scrollbar" style="height: 633px;"><div class="nano-content" tabindex="0" style="right: -17px;"><div class="offcanvas-body">
						
						<p>
							Введите в соответствующие поля входное слово после сивола ∂, а также сам текст программы(правую и левую части).
						</p>
						
						<h4>Инструкция:</h4>
						<ul class="list-divided">
							<li>Для записи строк исользуйте такой порядок, который представлен в первой строке по умолчанию: Состояние.Символ -> Символ.Напраление движения.Состояние</li>
							<li>Для добавления нижнего индекса нужно набрать в поле ввода конструкцию вида _{цифры}. Пример: S_{00} преобразуется в S<sub>00</sub>. </li>
							<li>Входное слово по умолчанию пустое, эта запись соответствует той, что представлена в соответствующем поле: ∂. Ваше входное слово введите после этого символа, например: ∂aabb</li>
							<li>Вы можете поменять местами написанные строки алгоритма. Для этого нужно, удерживая курсором нужный элемент списка за стрелку, перетащить его на желаемую позицию.</li>
							<li>Для добавления строки нажмите кнопку "+".</li>
							<li>Используйте кнопку "Очистить", чтобы удалить все символы с поля ввода алгоритма.</li>
							<li>Специальный символ можно добавить, кликнув на него, находясь на нужной позиции поля ввода. Внимание: спецсимвол добавляется в конец редактируемого поля без учета конкретной позиции курсора в нем. </li>
						</ul>
					</div></div><div class="nano-pane" style="display: none;"><div class="nano-slider" style="height: 616px; transform: translate(0px, 0px);"></div></div></div>
					
				</div>
</div>
</section>


			<!--end #content-->
@stop		

		<!--end #base-->
		<!-- END BASE -->
@section('js-down')
	{!! HTML::script('js/algorithms/symbols.js') !!}
	{!! HTML::script('js/algorithms/saving.js') !!}
	{!! HTML::script('js/algorithms/superScript.js') !!}
	{!! HTML::script('js/algorithms/send.js') !!}

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
@stop


