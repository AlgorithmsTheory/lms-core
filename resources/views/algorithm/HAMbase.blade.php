<section>
<div class="ham-entity">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-primary">Эмулятор нормальных алгоритмов Маркова</h1>
            </div>
            @yield('addl-info-ham')
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
                                                @for($i = 1; $i <= 13; $i++)
                                                    
                                                @if ($i == 1)
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
                                                @else
                                                <li id="p_scnt_{{$i}}" class="tile">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text" id="st_{{$i}}" class="form-control" name="start">
                                                        </div>
                                                        <span class="input-group-addon"><i class="md md-arrow-forward"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" id="end_{{$i}}" class="form-control" name="end">
                                                        </div>
                                                    </div> 
                                                    <a class="btn btn-flat ink-reaction btn-default" href="#" id="remScnt">
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
                                        <button type="button"  class="btn ink-reaction btn-raised btn-default-light" href="#" id="addScnt"><i class ="fa fa-plus" ></i></button>
                                        <br/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card-body text-center height-3" style="top: -90px;">
                                        <button type="button" class="btn ink-reaction btn-raised btn-default-light" style="right:60px" href="#" id="reset">Очистить</button>
                                        <br/>
                                    </div>
                                </div>
                            </div>	
                        </div>                    
                    </div>
                    
                    <div class="col-md-6">
                        @yield('task-ham')
                        
                        <div class="col-sm-6">
                            <div class="card-body">
                                <div class="form" role="form">
                                    <div class="form-group floating-label">
                                        <textarea name="textarea_src" id="textarea2" class="form-control" rows="1" placeholder=""></textarea>
                                        <label for="textarea2" style="top:-15px">Входное слово:</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn ink-reaction btn-primary" title="" data-original-title="Увидеть только результат преобразования" data-toggle="tooltip" data-placement="top" onClick="run_all_normal(false)">Запуск</button>	
                                    </div>
                                    <div class="col-sm-3">									
                                        <button  type="button" class="btn ink-reaction btn-primary" onClick="run_all_normal(true)" title="" data-original-title="Отладить до конца" data-toggle="tooltip" data-placement="top"><i class="md md-play-arrow"></i></button>
                                    </div>
                                    <div class="col-lg-3">
                                        <a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-right" data-toggle="offcanvas">
                                            <i class="md md-help"></i>
                                        </a>
                                    </div>
                                </div>
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
                                </div>
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
                                    <div class="form" role="form">
                                        <div class="form-group floating-label">
                                            <input type="text" class="form-control" id="disabled6" disabled value="">
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
        @yield('addl-blocks-ham')
    </div>
</div>
</section>
