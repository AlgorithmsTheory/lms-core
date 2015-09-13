<select name="theme[]" id="select-theme" class="form-control select-theme" size="1" required="">
    <option value="Любая" selected>Любая</option>
    @foreach ($themes_list as $theme)
    <option value="{{$theme}}">{{$theme}}</option>
    @endforeach
</select>