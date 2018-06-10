    <input type="hidden" id="js_word_number" value="1">
    <input type="hidden" id="js_word_number_eng" value="1">
    <input type="hidden" id="js_span_last" value="0">
    <input type="hidden" id="js_span_last_eng" value="0">
    <input type="hidden" id="js_span_edge" value="0">
    <input type="hidden" id="js_span_edge_eng" value="0">
    @for ($i = 1; $i <= 50; $i++)
        <input type="hidden" id="js_count_{{ $i }}" value="5">
    @endfor
    @for ($i = 1; $i <= 50; $i++)
    <input type="hidden" id="js_count_eng{{ $i }}" value="5">
    @endfor
    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox" name="control" id="control">
            <span>Только для контрольных тестов</span>
        </label>
    </div>
    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox" name="translated" id="translated">
            <span>Переведен на английский язык</span>
        </label>
    </div>
    <br>


    <!-- На русском языке -->
    <div class="style-gray card">
        <div class="card-body text-default-bright text-center text-lg">
            Русский язык
        </div>
    </div>
    <div class="form-group">
        <textarea class="form-control" name="title" id="edit-text" rows="3" placeholder="Введите текст вопроса, нажмите кнопку завершения редактирования, затем выделите пропущенные слова"></textarea>
        <p class="lead" id="general-text"></p>
        <label for="textarea1">Текст</label>
        <input type="hidden" value="">
    </div>
    <button class="btn btn-primary btn-raised" type="button" value="finish" id="finish-edit"><span id="button-title">Завершить редактирование текста</span></button>
    <button class="btn btn-primary btn-raised" type="button" id="union">Перейти в режим объединения слов</button>
    <button class="btn btn-primary btn-raised" type="button" id="cancel-selection" style="display:none">Сбросить выделение</button>
<div id="word-variants">

</div>
    <br><br>

    <!-- На английском языке -->
    <div class="style-gray card">
        <div class="card-body text-default-bright text-center text-lg">
            Английский язык
        </div>
    </div>
    <div class="form-group">
        <textarea class="form-control" name="eng-title" id="eng-edit-text" rows="3" placeholder="Type question's title, press button to finish editing, then select missed words"></textarea>
        <p class="lead" id="eng-general-text"></p>
        <label for="textarea1">Text</label>
        <input type="hidden" value="">
    </div>
    <button class="btn btn-primary btn-raised" type="button" value="finish" id="eng-finish-edit"><span id="eng-button-title">Finish editing text</span></button>
    <button class="btn btn-primary btn-raised" type="button" id="eng-union">Go to union mode</button>
    <button class="btn btn-primary btn-raised" type="button" id="eng-cancel-selection" style="display:none">Reset selection</button>
    <div id="eng-word-variants">

    </div>

    <br><br>
    <div id="other-options" class="col-md-12 col-sm-6">
        <div class="form-group">
            <select name="section" id="select-section" class="form-control" size="1">
                <option value="$nbsp"></option>
                @foreach ($sections as $section)
                <option value="{{$section['section_name']}}">{{$section['section_name']}}</option>/td>
                @endforeach
            </select>
            <label for="select-section">Раздел</label>
        </div>

        <div class="form-group" id="container">
            <!-- контейнер для ajax -->
        </div>


        <!-- Баллы за правильный ответ -->
        <div class="form-group">
            <input type="number" min="1" step="0.1" max="2" name="points" id="points" class="form-control" value="1">
            <label for="points">Баллы за верный ответ</label>
        </div>

        <!-- Сложность -->
        <div class="form-group">
            <textarea  name="difficulty" id="difficulty" class="form-control" rows="1" placeholder="" required readonly>0</textarea>
            <label for="difficulty">Сложность</label>
        </div>

        <!-- Дискриминант -->
        <div class="form-group">
            <textarea  name="discriminant" id="discriminant" class="form-control" rows="1" placeholder="" required readonly>0.5</textarea>
            <label for="discriminant">Дискриминант</label>
        </div>

        <!-- Коэффициент угадывания -->
        <div class="form-group">
            <textarea  name="guess" id="guess" class="form-control" rows="1" placeholder="" required readonly></textarea>
            <label for="guess">Коэффициент угадывания</label>
        </div>

        <!-- Время на вопрос -->
        <div class="form-group">
            <input type="number" min="30" step="1" max="3600" name="pass-time" id="pass-time" class="form-control" value="120">
            <label for="pass-time">Время на вопрос в секундах</label>
        </div>

        <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
        <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
    </div>
</div>
</div>
</div>
<input type="hidden" id="number-of-blocks" value="" name="number_of_blocks">
<input type="hidden" id="eng-number-of-blocks" value="" name="eng_number_of_blocks">
</form>
<div id="question-preview" class="modalDialog">
    <div>
        <a id="close-btn" class="btn ink-reaction btn-floating-action btn-danger close" href="#close" title="Close">X</a>
        <h2>Предварительный просмотр</h2>
        <form class="smart-blue">
            <h1>Вопрос 1</h1>
            <h2>Заполните пропуски в тексте</h2>
            <div id="preview-container"></div>
        </form>
        <button class="btn btn-primary btn-raised submit-question" type="submit" id="submit-text">Добавить вопрос</button>
    </div>
</div>
</div>

{!! HTML::script('js/question_create/fillGaps.js') !!}
{!! HTML::script('js/question_create/fillGapsEng.js') !!}
