@extends('templates.base')
@section('head')
    <title>Электронная книга</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <!-- END META -->

@stop

@section('content')

    <!-- BEGIN BLANK SECTION -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('ebooks', 'Электронные книги') !!}</li>
                            <li class="active">Книга</li>
                        </ol>

                    </div><!--end .section-header -->
                    <div class="section-body">
                    </div><!--end .section-body -->
                </section>
            </div>
            <div class="col-lg-6">
                @if($role == 'Админ')
                    {!! HTML::link('library/ebooks/ebook/add','Добавить книгу',
                    array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    {!! HTML::link('library/ebooks/ebook/edit/'. $ebook['id_ebook'],'Редактировать книгу',
                    array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    <form action = "{{route('delete_ebook',['id_ebook' => $ebook['id_ebook']])}}"
                          method="post"
                          class="delete_ebook"
                          style="display: inline;">
                        {{method_field('DELETE')}}
                        {{ csrf_field() }}
                            <button type="submit"
                                    class=" btn ink-reaction btn-danger">
                                Удалить книгу
                            </button>
                    </form>

                @endif
            </div>
        </div>


    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">

            <div class="card-body">
                <article style="margin-left:10%; margin-right:10%; text-align: justify">
                    <div class="row">
                        <div class="col-lg-6">
                            {!! HTML::image($dir_parent_module . $ebook['ebook_path_img'], 'ebook', array('style' => 'border-color: transparent; float:left; height:280px; width:200px;'))!!}
                        </div>
                        <div class="col-lg-6 ">
                            <h3>Название : {{$ebook['ebook_title']}}</h3>
                            <h4 class="text-left" >Автор : {{$ebook['ebook_author']}}</h4>
                            <h4 class="text-left" >Описание : {{$ebook['ebook_desc']}}</h4>
                            {!! HTML::link($dir_parent_module . $ebook['ebook_path_file'], 'Скачать', array('class' => 'btn btn-warning')) !!}
                        </div>
                    </div>

                </article>
            </div>

    </div>
    </div>



@stop

<!-- END BASE -->
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
