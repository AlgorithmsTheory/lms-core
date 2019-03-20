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
	
	<!-- Текст на русском языке -->
    <div class="form-group">
        <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder="" required></textarea>
        <label for="textarea1">Текст</label>
    </div>

    <!-- Текст на английском языке -->
    <div class="form-group">
        <textarea  name="eng-title" id="eng-textarea1" class="form-control" rows="3" placeholder=""></textarea>
        <label for="eng-textarea1">Text</label>
    </div>

    <div id="text-images-container">
        <input type="file" name="text-images[]" id="text-image-input-1" class="text-image-input">
    </div>
    <br>
	
	<!-- Номер задачи выбранного эмулятора -->
    <div class="form-group">
        <input type="number" step="1" name="task_id" id="task_id" class="form-control">
        <label for="task_id">Номер задачи в таблице эмулятора</label>
    </div>
	<br>

    <div id="other-options" class="col-md-10 col-sm-6">
        <div class="form-group">
            <select name="section" id="select-section" class="form-control" size="1" required>
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

        <!-- Время на вопрос -->
        <div class="form-group">
            <input type="number" min="30" step="1" max="3600" name="pass-time" id="pass-time" class="form-control" value="120">
            <label for="pass-time">Время на вопрос в секундах</label>
        </div>

        <button class="btn btn-primary btn-raised submit-question" type="submit">Добавить вопрос</button>
        <a id="preview-btn" class="btn btn-primary btn-raised" href="#question-preview">Preview</a>
    </div>
</div>  <!-- Закрываем card-body -->
</div>  <!-- Закрываем card -->
</div>  <!-- Закрываем col-md -->
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

{!! HTML::script('js/question_create/imageInTitle.js') !!}
