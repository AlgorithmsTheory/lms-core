    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox" name="control" id="control">
            <span>Только для контрольных тестов</span>
        </label>
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
    <div id="other-options" class="col-md-10 col-sm-6">
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

        <div class="form-group">
            <input type="number" min="1" name="points" id="points" class="form-control" value="1">
            <label for="points">Баллы за верный ответ</label>
        </div>

        <button class="btn btn-primary btn-raised submit-question" type="submit" id="submit-text">Добавить вопрос</button>
        <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
    </div>
</div>
</div>
</div>
<input type="hidden" id="number-of-blocks" value="" name="number_of_blocks">
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