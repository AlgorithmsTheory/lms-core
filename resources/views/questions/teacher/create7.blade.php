        <div class="checkbox checkbox-styled">
            <label>
                <input type="checkbox" name="control" id="control">
                <span>Только для контрольных тестов</span>
            </label>
        </div>
        <div class="col-md-2 col-sm-2" id="variants">
            <div class="form-group">
                <textarea name="variants[]" class="form-control textarea3" rows="3" placeholder="" required></textarea>
                <label for="textarea3">Определение 1</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-8" id="answers">
            <div class="form-group">
                <textarea name="answers[]" class="form-control textarea3" rows="3" placeholder="" required></textarea>
                <label for="textarea3">Расшифровка 1</label>
            </div>
        </div>
        <div class="col-md-2 col-sm-2" style="margin-top: 50px" id="add-del-buttons">
            <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var-7"><b>+</b>   </button>
            <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var-7"><b>-</b></button>
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

{!! HTML::script('js/question_create/definition.js') !!}