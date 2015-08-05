<div class="card-body">
    <div class="form-group">
        <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder=""></textarea>
        <label for="textarea1">Текст</label>
    </div>

    <!--<div class="form-group">
        <textarea  name="answer" id="textarea2" class="form-control" rows="3" placeholder=""></textarea>
        <label for="textarea2">Ответ</label>
    </div> -->

    <div class="col-md-1 col-sm-6" id="answers">
        <div class="checkbox checkbox-styled">
            <label>
                <input type="checkbox" name="answers[]" value="1">
                <span></span>
            </label>
        </div>
        <div class="checkbox checkbox-styled" style="margin-top:49px">
            <label>
                <input type="checkbox" name="answers[]" value="2">
                <span></span>
            </label>
        </div>
        <div class="checkbox checkbox-styled" style="margin-top:49px">
            <label>
                <input type="checkbox" name="answers[]" value="3">
                <span></span>
            </label>
        </div>
        <div class="checkbox checkbox-styled" style="margin-top:49px">
            <label>
                <input type="checkbox" name="answers[]" value="4">
                <span></span>
            </label>
        </div>
    </div>

    <div id="variants" class="col-md-9 col-sm-6">
        <div class="form-group">
            <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
            <label for="textarea3">Вариант 1</label>
        </div>
        <div class="form-group">
            <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
            <label for="textarea3">Вариант 2</label>
        </div>
        <div class="form-group">
            <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
            <label for="textarea3">Вариант 3</label>
        </div>
        <div class="form-group">
            <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
            <label for="textarea3">Вариант 4</label>
        </div>
    </div>
    <div class="col-md-2 col-sm-6" style="margin-top: 220px" id="add-del-buttons">
        <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var-2"><b>+</b></button>
        <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var-2"><b>-</b></button>
    </div>
</div>
<div class="card-body">
    <div class="form-group">
        <select name="section" id="select-section" class="form-control" size="1">
            <option value="$nbsp"></option>
            @foreach ($sections as $section)
            <option value="{{$section}}">{{$section}}</option>/td>
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

    <button class="btn btn-primary btn-raised" type="submit">Добавить вопрос</button>
</div>
</div>
</div>
</form>
</div>



