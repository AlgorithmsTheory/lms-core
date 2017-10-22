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
<div class="form-group">
    <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder="Введите условие задачи" required></textarea>
    <label for="textarea1">Текст</label>
</div>
<div class="form-group">
    <textarea  name="eng-title" id="textarea1" class="form-control" rows="3" placeholder="Type task's condition"></textarea>
    <label for="textarea1">Text</label>
</div>

<div class="form-group">
    <textarea  name="answer" id="textarea1" class="form-control" rows="5" placeholder="Введите решение задачи"></textarea>
    <label for="textarea1">Решение</label>
</div>
<div class="form-group">
    <textarea  name="eng-answer" id="textarea1" class="form-control" rows="5" placeholder="Type the answer"></textarea>
    <label for="textarea1">Answer</label>
</div>

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

    <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
    <!-- <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a> -->
</div>
</div>
</div>
</div>
</form>
<div id="question-preview" class="modalDialog">
    <div>
        <a id="close-btn" class="btn ink-reaction btn-floating-action btn-danger close" href="#close" title="Close">X</a>
        <h2>Предварительный просмотр</h2>
        <form class="smart-blue">
            <h1>Вопрос 1</h1>
            <h2 id="preview-text"></h2>
            <div id="preview-container"></div>
        </form>
        <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
    </div>
</div>
</div>

{!! HTML::script('js/question_create/theorem.js') !!}