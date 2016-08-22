@extends('templates.base')
@section('head')
    <title>Контрольные материалы</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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
        <div class="section-header">
            <ol class="breadcrumb">
                <li class="active"> Контрольные материалы по рекурсивным функциям</li>
            </ol>
        </div>
        <div class="section-body contain-lg">

            <div class="row">
                <div class="col-lg-8">

                    <h1 class="text-primary">Работа с контрольным материалом по теме "Примитивно-рекурсивные функции"</h1>


                </div><!--end .col -->
                <div class="col-lg-12">
                    <div class="col-lg-6">
                        <article class="margin-bottom-xxl">
                            <p class="lead">
                                Добавить/удалить/изменить задачи
                            </p>
                        </article>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn ink-reaction btn-raised btn-primary"> {!! HTML::linkRoute('addtaskrec', '+ Добавить задачу') !!} </button>
                    </div>
                    <!-- <div class="col-lg-2">
                       <button type="button" class="btn ink-reaction btn-raised btn-primary"> {!! HTML::linkRoute('edit_coef', 'Изменить коэффициенты оценивания') !!} </button>
                    </div>-->
                </div><!--end .col -->

            </div>

            <!-- BEGIN NESTABLE LISTS -->

            <div class="card">
                <div class="card-body">

	<table class="spc table no-margin table-hover" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td  class="thd" onclick="sort(this)"  title="Нажмите на заголовок, чтобы отсортировать колонку">№</td>
	<td>Текст задачи</td>
    <td class="thd" onclick="sort(this)"  title="Нажмите на заголовок, чтобы отсортировать колонку">Максимальный балл</td>
	<td  class="thd" onclick="sort(this)"  title="Нажмите на заголовок, чтобы отсортировать колонку">Сложность (0 - легкий, 1 - сложный)</td>
	<td>Изменить</td>
    <td>Удалить задачу</td>
   </tr>
        <?php $index = 0;
        $r_c = count($tasks);
        while($index < $r_c) {
        $row = $tasks[$index++];
        ?>
        <tr >
            <td >
                <p><?php echo $index; ?></p>
            </td>
            <td >
                <p><?php echo $row["task"]; ?></p>
            </td>
            <td >
                <p><?php echo $row["mark"]; ?></p>
            </td>
            <td >
                <p><?php echo $row["level"]; ?></p>
            </td>
            <td >
                <p><?php echo HTML::linkRoute('editrec', '✎', array("id" => $row['id'])); ?></p>
            </td>
            <td>
                <p><?php echo HTML::linkRoute('deleterec', '✂', array("id" => $row['id'])); ?></p>
            </td>
        </tr>
        <?php  } ?>
        </tbody>
    </table>


                </div>
            </div>
        </div>
    </section>
    <!--end #content-->
    @stop

            <!--end #base-->
    <!-- END BASE -->
    @section('js-down')
            <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/library/sort.js') !!}
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
    {!! HTML::script('js/libs/utils/send.js') !!}
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
    {!! HTML::script('js/libs/toastr/toastr.js') !!}
            <!-- END JAVASCRIPT -->
@stop
