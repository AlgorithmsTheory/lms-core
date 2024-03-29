<section>
<div name="mt-entity">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-primary">Эмулятор машины Тьюринга</h1>
            </div>
            @yield('addl-info-mt')
        </div>
        
        <div class="col-lg-12">
            <div class="card style-default-bright">
                <div class="card-head">
                    <div class="col-md-6">
                        </br>
                        <div class="card card-bordered style-primary" style="top: -40px; height: 700px;">
                            <div class="card-head">
                                <div class="tools">
                                    <div class="btn-group">
                                        <input type="hidden" name="inputFileNameToSaveAs" value="Алгоритм МТ" ></input>
                                        <button type="button" title="" data-original-title="Сохранить в файл алгоритм и условие задачи" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised" name="saveTextAsFile"><i class="md md-file-download"></i></button>
                                        <button type="button" name="loadFileAsText" style="left:5px" title="" data-original-title="Загрузить в эмулятор ранее сохраненный алгоритм. Перед этим выберите файл" data-toggle="tooltip" data-placement="top" class="btn btn-default-bright btn-raised"><i class="md md-file-upload"></i></button>
                                        <input type="file"  style="left:15px" class="btn ink-reaction btn-raised btn-xs btn-primary" name="fileToLoad"></input>
                                    </div>
                                </div>
                                <header > Ваш алгоритм:</header>
                            </div>
                            <div class="card-body" style="top: -30px;">
                                <div class="card">
                                    <div class="card-body no-padding">
                                        <div class="card-body height-6 scroll style-default-bright" style="height: 570px;">

                                            <ul name="p_scents" class="list" data-sortable="true">
                                                @for($i = 1; $i < 25; $i++)
                                                                    
                                                @if($i == 1)
                                                <li name="p_scnt" class="tile">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text"  onchange="superScript(this);" name="st_1"  class="form-control" value="S₀.∂">
                                                        </div>
                                                        <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" onchange="superScript(this);" name="end_1"  class="form-control" value="∂.R.S₀">
                                                        </div>
                                                    </div> 
                                                    <a class="btn btn-flat ink-reaction btn-default" href="#" name="remScnt">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </li>
                                                @else
                                                <li name="p_scnt_{{$i}}" class="tile">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text" name="st_{{$i}}" class="form-control">
                                                        </div>
                                                        <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" name="end_{{$i}}" class="form-control">
                                                        </div>
                                                    </div> 
                                                    <a class="btn btn-flat ink-reaction btn-default" href="#" name="remScnt">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </li>
                                                @endif
                                                                
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card-body text-center height-3" style="top: -90px;">
                                        <button type="button"  class="btn ink-reaction btn-raised btn-default-light" href="#" name="addScnt"><i class ="fa fa-plus" ></i></button>
                                        <br/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body text-center height-3" style="top: -90px;">
                                        <button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:30px" href="#" name="reset">Очистить</button>
                                        <br/>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                    
                        @yield('task-mt')
                        
                        <div class="col-sm-6">
                            <div class="card-body">
                                <div class="form" role="form">
                                    <div class="form-group floating-label">
                                        <textarea name="textarea_src" class="form-control" rows="1">∂</textarea>
                                        <label style="top:-15px">Входное слово:</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-sm-6">
                                        <button name = "run_turing_false" type="button" class="btn ink-reaction btn-primary" title="" data-original-title="Увидеть только результат преобразования" data-toggle="tooltip" data-placement="top">Запуск</button>    
                                    </div>
                                    <div class="col-sm-3">                                    
                                        <button name="run_turing_true" type="button" class="btn ink-reaction btn-primary" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
                                    </div>
                                    @yield('help-mt')
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-head card-head-xs">
                                    <header>Спеццисмволы</header>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group">
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="right">R</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="left">L</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="here">H</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="zero">S<sub>0</sub></button>
                                        <br>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="part">&part;</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="omega">&Omega;</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="lambda">&#955;</button>
                                        <button type="button" class="btn ink-reaction btn-default-bright" name="one">S<sub>1</sub></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            </br>
                            <div class="card">
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
                                            <input type="text" class="form-control" name="disabled6" disabled>
                                            <label for="disabled6" style="top:-15px">Результат: </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @yield('addl-blocks-mt')
    </div>
</div>
</section>
