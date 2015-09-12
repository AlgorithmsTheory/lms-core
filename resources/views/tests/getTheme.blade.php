<select name="theme[]" id="select-theme" class="form-control" size="1" required="">
    <option value="$nbsp"></option>
    @foreach ($themes_list as $theme)
    <option value="{{$theme}}">{{$theme}}</option>
    @endforeach
    <option value="Любая">Любая</option>
</select>