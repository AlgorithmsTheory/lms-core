{!! HTML::style('css/RAM_style.css') !!}
    <div name = "ram-entity">
        <div class = "container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-primary">Эмулятор Random Access Machine</h1>
                </div>
                @yield('addl-info')
            </div>
        </div>
        <div class = "container-fluid">
            <div class = "row">
                <div class = "col-md-8">
                    <div name = "editor">
                    </div>
                </div>
                <div class = "col-md-2">
                    <div class = "input-group mb-3">
                        <span class="input-group-addon"><b>R0</b></span>
                        <input type = "number" class = "form-control" value = "0" name = "r0">
                    </div>
                    <div name = "registerContainer">
                        <div class = "input-group mb-1">
                            <span class="input-group-addon"><b>R1</b></span>
                            <input type = "number" class = "form-control" value = "0" name = "r1">
                        </div>
                    </div>    
                </div>
                <div class = "col-md-2">
                    <div class = "row justify-content-md-center">
                        <div class = "col col-md-auto">    
                            <div class="dropdown">
                                <button class="btn btn-block btn-primary dropdown-toggle" type="button" name="dropdownChoiceMod" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span name = "mod">Отладка</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownChoiceMod">
                                    <li name = "drop_debug"><a>Отладка</a></li>
                                    <li name = "drop_animate"><a>Анимация</a></li>
                                    <li name = "drop_run"><a>Исполнение</a></li>
                                </ul>
                            </div>
                            </br>
                            <button type="button" class="btn btn-block btn-primary mt-5" name = "btn_start">Старт</button>
                            <button type="button" class="btn btn-block btn-primary" name = "btn_pause" disabled>Пауза</button>
                            <button type="button" class="btn btn-block btn-primary" name = "btn_next" disabled>След. Операция</button>
                            <button type="button" class="btn btn-block btn-primary" name = "btn_reset">Сброс</button>
                            </br>
                            <button type="button" class="btn btn-block btn-primary" name = "btn_save_doc">Сохранить в файл</button>
                            </br>
                            <input type="file" class="btn btn-block ink-reaction btn-raised btn-xs btn-primary" name="fileToLoad">
                            <button type="button" class="btn btn-block btn-primary" name = "btn_load_doc">Загрузить из файла</button>
                            </br>
                            <a class="btn btn-block btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas" name = "btn_help">
                                <span>Помощь </span><i class="md md-help"></i>
                            </a>
                            </br>
                            <div class = "row justify-content-md-center">
                                <div class = "col-md-10 col-md-offset-1">
                                    <b>Работа с регистрами</b>
                                </div>
                            </div>
                            <div class = "row">
                                <div class = "col-md-2">
                                    <button type="button" class="btn btn-block btn-primary" name = "btn_reg_plus">+</button>
                                </div>
                                <div class = "col-md-2">
                                    <button type="button" class="btn btn-block btn-primary" name = "btn_reg_minus">-</button>
                                </div>
                                <div class = "col-md-8">
                                    <button type="button" class="btn btn-block btn-primary" name = "btn_reg_default">Стандартно</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class = "container-fluid">
            <div class = "row">
                <div class="form-horizontal">
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label"><b>Входная лента</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="input" placeholder="">
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label"><b>Выходная лента</b></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="output" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('addl-blocks')
    </div>
<!-- BEGIN JAVASCRIPT -->
{!! HTML::script('js/ram/popper.min.js') !!}
{!! HTML::script('js/ram/src-noconflict/ace.js') !!}
