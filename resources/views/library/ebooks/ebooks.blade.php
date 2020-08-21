@extends('templates.base')
@section('head')
	<title>Электронные книги</title>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<!-- END META -->
@stop
@section('content')
			<!-- BEGIN HEADER-->

	<div id="base">


		<div class="offcanvas">
		</div><!--end .offcanvas-->

		<div id="content">
			<section>
				<div class="row">
					<div class="col-lg-10">
				<div class="section-header">
					<ol class="breadcrumb">
						<li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
						@if($search_query == "")
							<li class="active">Электронные книги</li>
						@else
							<li class="active">{!! HTML::linkRoute('ebooks', 'Электронные книги') !!}</li>
							<li class="active">Поиск</li>
						@endif
					</ol>
				</div>
					</div>
					<div class="col-lg-2">
						@if($role == 'Админ')
							{!! HTML::link('library/ebooks/ebook/add','Добавить книгу',
							array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
						@endif
					</div>
				</div>
				<div class="section-body contain-lg">
					<div class="row">
						<div class="card">
							<div class="card-body">
								<center>
									<form class="form" action="{{URL::route('search_ebooks')}}"  method="post">
										<input type="text" name="search" id="text-to-find" size="50px" value="{{$search_query}}" placeholder="Введите название книги или имя автора" />
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<button class="btn ink-reaction btn-primary">Искать</button>
									</form>
								</center>

								@foreach($ebooks_groupBy_genre as $genre_name => $ebooks)
									<div><h3>{{ $genre_name . ':' }}</h3></div>
										@foreach($ebooks as $ebook)
										<div class="col-lg-6 col-md-6">
												<div class="row">
													<div class="col-lg-6">
														<a  href="{{ action ('LibraryController@getEbook', [$ebook['id_ebook']]) }}">
															{!! HTML::image($dir_parent_module . $ebook['ebook_path_img'], 'ebook', array('style' => 'border-color: transparent; float:left; height:280px; width:200px;'))!!}
														</a>
													</div>
													<div class="col-lg-6 ">
														<a href= "{{ action ('LibraryController@getEbook', [$ebook['id_ebook']]) }}"><h3 class="text-left" >{{$ebook['ebook_title']}}</h3></a>
														<h4 class="text-left" >{{$ebook['ebook_author']}}</h4>
														@if($role == 'Админ' )
															{!! HTML::link('library/ebooks/ebook/edit/'. $ebook['id_ebook'],'Редактировать книгу'
															,array('class' => 'btn ink-reaction btn-primary btn-sm btn-block ','role' => 'button')) !!}
															<form action = "{{route('delete_ebook',['id_ebook' => $ebook['id_ebook']])}}"
																  method="post"
															class="delete_ebook">
																{{method_field('DELETE')}}
																{{ csrf_field() }}
																<div class="form-group">
																	<button type="submit" class=" btn ink-reaction btn-danger btn-sm btn-block"
																			style="margin-top: 10px; ">
																		Удалить книгу
																	</button>
																</div>
															</form>
														@endif
														{!! HTML::link($dir_parent_module  . $ebook['ebook_path_file'], 'Скачать', array('class' => 'btn btn-warning')) !!}
													</div>
												</div>
										</div>
										@endforeach
								@endforeach
					</div><!--end .card -->
				</div><!--end .col -->
					</div><!--end .row -->
		</div><!--end .section-body -->
		</section>
	</div><!--end #content-->
	</div><!--end .offcanvas-->
	</div><!--end #base-->
	<!-- END BASE -->
	@stop

@section('js-down')
	{!! HTML::script('js/core/source/App.js') !!}
	{!! HTML::script('js/core/source/AppNavigation.js') !!}
	{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
	{!! HTML::script('js/core/source/AppCard.js') !!}
	{!! HTML::script('js/core/source/AppForm.js') !!}
	{!! HTML::script('js/core/source/AppNavSearch.js') !!}
	{!! HTML::script('js/core/source/AppVendor.js') !!}
	{!! HTML::script('js/core/demo/Demo.js') !!}
	{!! HTML::script('js/library/ebook/ebook.js') !!}

@stop
