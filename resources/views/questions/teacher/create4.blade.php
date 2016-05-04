    <div class="checkbox checkbox-styled">
        <label>
            <input type="checkbox" name="control" id="control">
            <span>Только для контрольных тестов</span>
        </label>
    </div>
    <!— ДА/НЕТ-->
    <h2>Поочередно добавляйте утверждения. Напротив верных отмечайте галочку.</h2>
    <br>
    <div id="variants" class="col-md-9 col-sm-6">
        <div class="form-group">
            <textarea name="variants[]" class="form-control textarea3" rows="1" placeholder="" required></textarea>
            <label for="textarea3">Утверждение 1</label>
        </div>
    </div>
    <div class="col-md-1 col-sm-6" id="answers">
        <div class="checkbox checkbox-styled">
            <label>
                <input type="checkbox" name="answers[]" value="1">
                <span></span>
            </label>
        </div>
    </div>
    <div class="col-md-2 col-sm-6" style="margin-top: 25px" id="add-del-buttons">
        <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var-4"><b>+</b></button>
        <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var-4"><b>-</b></button>
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
            <!— контейнер для ajax —>
        </div>

        <div class="form-group">
            <input type="number" min="1" name="points" id="points" class="form-control" value="1">
            <label for="points">Баллы за верный ответ</label>
        </div>

        <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
        <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
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

{!! HTML::script('js/question_create/yesNo.js') !!}