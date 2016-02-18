@extends('templates.base')
@section('head')
    <title>Список заказов</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/theme-default/bootstrap.css?1422792965') !!}
    {!! HTML::style('css/theme-default/materialadmin.css?1425466319') !!}
    {!! HTML::style('css/theme-default/font-awesome.min.css?1422529194') !!}
    {!! HTML::style('css/theme-default/material-design-iconic-font.min.css?1421434286') !!}
    {!! HTML::style('css/theme-default/libs/select2/select2.css?1424887856') !!}
    {!! HTML::style('css/theme-default/libs/multi-select/multi-select.css?1424887857') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-datepicker/datepicker3.css?1424887858') !!}
    {!! HTML::style('css/theme-default/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-colorpicker/bootstrap-colorpicker.css?1424887860') !!}
    {!! HTML::style('css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862') !!}
    {!! HTML::style('css/theme-default/libs/typeahead/typeahead.css?1424887863') !!}
    {!! HTML::style('css/theme-default/libs/dropzone/dropzone-theme.css?1424887864') !!}
            <!-- END STYLESHEETS -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->
    @stop

    @section('content')
<!-- BEGIN HEADER-->


<div id="base">


          <section>
            <div class="section-header">
                <ol class="breadcrumb">
                    <li class="active">Список заказов</li>
                </ol>
            </div>
            </section>
            <div class="section-body contain-lg-12">

                <div class="row">


                    <div class="card">
                        <div class="card-body">
                            <form action="{{URL::route('order_list_delete')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tbody align ="center">
                                    <tr style="padding:20px; margin-top:20px">
                                        <td style="width:55px;padding: 5px">
                                            <h4>№</h4>
                                        </td>
                                        <td style="width:254px">
                                            <h4>ФИО студента</h4>
                                        </td>
                                        <td style="width:244px">
                                            <h4>Автор книги</h4>
                                        </td>
                                        <td style="width:350px">
                                            <h4>Название книги</h4>
                                        </td>
                                        <td style="width:105px">
                                            <h4>Дата заказа</h4>
                                        </td>
                                        <td style="width:15px">
                                            <h4>Выбрать</h4>
                                        </td>
                                    </tr>
                                    <?php $index = 1;
                                    $row = mysqli_fetch_array($result);
                                    while($row) { ?>
                                    <tr style="padding:20px; margin-top:20px">
                                        <td style="width:55px;padding: 5px">
                                            <p><?php echo $index ?></p>
                                        </td>
                                        <td style="width:254px">
                                            <p><?php echo $row["student_id"] ?></p>
                                        </td>
                                        <td style="width:244px">
                                            <p><?php echo $row["author"] ?></p>
                                        </td>
                                        <td style="width:350px">
                                            <p><?php echo $row["title"] ?></p>
                                        </td>
                                        <td style="width:105px">
                                            <p><?php echo $row["date"] ?></p>
                                        </td>
                                        <td style="width:15px">
                                            <input type="checkbox"  name="return[]" value="<?php echo $row["id"];
                                            $row = mysqli_fetch_array($result) ?>" />
                                        </td>
                                    </tr>
                                    <?php $index++; } ?>
                                    </tbody>
                                </table>
                                <br>
                                <center><input type="submit" class="btn ink-reaction btn-primary" value="Удалить из списка"> </center>
                            </form>

                        </div><!--end .card -->
                    </div><!--end .col -->

                </div><!--end .row -->
            </div><!--end .section-body -->


  <!--end #content-->


</div><!--end .offcanvas-->

</div><!--end #base-->
<!-- END BASE -->
    @stop
    @section('js-down')
            <!-- BEGIN JAVASCRIPT -->
    {!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
    {!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
    {!! HTML::script('js/libs/jquery-ui/jquery-ui.min.js') !!}
    {!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
    {!! HTML::script('js/libs/spin.js/spin.min.js') !!}
    {!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
    {!! HTML::script('js/libs/select2/select2.min.js') !!}
    {!! HTML::script('js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') !!}
    {!! HTML::script('js/libs/multi-select/jquery.multi-select.js') !!}
    {!! HTML::script('js/libs/inputmask/jquery.inputmask.bundle.min.js') !!}
    {!! HTML::script('js/libs/moment/moment.min.js') !!}
    {!! HTML::script('js/libs/bootstrap-datepicker/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js') !!}
    {!! HTML::script('js/libs/typeahead/typeahead.bundle.min.js') !!}
    {!! HTML::script('js/libs/dropzone/dropzone.min.js') !!}
    {!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/core/demo/DemoFormComponents.js') !!}
            <!-- END JAVASCRIPT -->
@stop

