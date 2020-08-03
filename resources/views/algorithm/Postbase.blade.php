<div name="post-entity">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-primary">Эмулятор машины Поста</h1>
            </div>
            <div name="test_seq"  style="display:none">{{ $test_seq }}</div>
            @yield('addl-info-post')
        </div>
        <div class="col-lg-12">
            <div class="card style-default-bright">
                <div class="card-head">
                    <div class="col-lg-8">
                        </br>
                        <div class="card card-bordered style-primary" style="top: -40px; height: 700px;">
                            <div class="card-head">
                                <div class="tools">
                                    <div class="btn-group">            
                                        <input type="hidden" name="inputFileNameToSaveAs" value="Алгоритм Пост"></input>
                                        <button type="button" name = "saveTextAsFile" title="" data-original-title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised"><i class="md md-file-download"></i></button>
                                        <button type="button" name = "loadFileAsText" style="left:5px" title="" data-original-title="Загрузить в эмулятор ранее сохраненный алгоритм. Перед этим выберите файл" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised"><i class="md md-file-upload"></i></button>
                                        <input type="file"  style="left:15px" class="btn ink-reaction btn-raised btn-xs btn-primary" name="fileToLoad">
                                    </div>
                                </div>
                                <header>Ваш алгоритм:</header>
                            </div>
                                    
                            <div class="card-body" style="top: -30px;">
                                <div class="card">
                                    <div class="card-body no-padding">
                                        <div class="card-body height-6 scroll style-default-bright" style="height: 550px;">

                                            <ul name="p_scents" class="list" data-sortable="_true">
                                                @for ($i = 1; $i <= 13; $i++)
                                                @if($i == 1)
                                                <li name="p_scnt" class="tile">
                                                @else
                                                <li name="p_scnt_{{$i}}" class="tile">
                                                @endif
                                                    <div class="col-sm-1">
                                                        <span class="input-group-addon"><b>{{$i}}</b></span>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        
                                                            <select name="select_{{$i}}" name="select_{{$i}}" class="form-control" style="width:100px">
                                                                <option value=" " selected="selected">&nbsp;</option>
                                                                <option value=">">></option>
                                                                <option value="<"><</option>
                                                                <option value="1">1</option>
                                                                <option value="0">0</option>
                                                                <option value="?">?</option>
                                                                <option value="!">!</option>
                                                            </select>
                                                        
                                                    </div>
                                                    <div class="col-sm-3" style="">
                                                        <div class="input-group">
                                                            <input type="number" min="1" name="goto1_{{$i}}" class="form-control" required="">
                                                        
                                                            <span class="input-group-addon">|</span>
                                                        
                                                            <input type="number" min="1" name="goto2_{{$i}}" class="form-control" required="">
                                                            <span class="input-group-addon">|</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" style="">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="comment_{{$i}}" placeholder="Комментарий">
                                                            <div class="form-control-line"></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div><!--end .card -->
                            </div><!--end .card-body -->
                            
                            <div class="row"  >
                                <div class="col-md-3">
                                    <div class="card-body text-center height-3" style="top: -90px;">
                                        <button type="button"  class="btn ink-reaction btn-raised btn-default-light" href="#" name="addScnt"><i class ="fa fa-plus" ></i></button>
                                        <br/>
                                    </div><!--end .card-body -->
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body text-center height-3" style="top: -90px;">
                                        <button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:60px" href="#" name="reset">Очистить</button>
                                        <br/>
                                    </div><!--end .card-body -->
                                </div>
                            </div>
                        </div><!--end .card -->
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card-body">
                            <div class="form" role="form">
                                <div class="form-group floating-label">
                                    <textarea name="input_word" class="form-control" rows="1" placeholder=""></textarea>
                                    <label for="textarea2" style="top:-30px">Входное слово:</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card" style="top: -25px;">
                            <div class="card-body">
                                <div class="col-sm-4">
                                    <button type="button" name="runPost" class="btn ink-reaction btn-primary" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top" >Запуск</button>    
                                </div>
                                <div class="col-sm-4">                                    
                                    <button  type="button" name="runPostTrue" class="btn ink-reaction btn-primary"  title="" data-original-title="Шаг для отладки алгоритма" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
                                </div>
                                <div class="col-sm-4">
                                    <a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                        <i class="md md-help"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card" style="top: -25px">
                            <div class="card-body">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Процесс:</th>
                                        </tr>
                                    </thead>
                                    <tbody name="debug">
                                        <tr>
                                            <td>1</td>
                                            <td name="input1"></td>    
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td name="input2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="form" role="form">
                                    <div class="form-group floating-label">
                                        <input type="text" class="form-control" name="result_word" disabled value="">
                                        <label for="disabled6" style="top:-15px">Результат: </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('addl-blocks-post')
    </div>
</div>
