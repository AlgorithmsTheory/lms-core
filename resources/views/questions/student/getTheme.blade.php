<select name="theme" id="select-theme" class="form-control" size="1" required>
    <option value="$nbsp"></option>
    @foreach ($themes_list as $theme)
    <option value="{{$theme['theme_name']}}">{{$theme['theme_name']}}</option>/td>
    @endforeach
</select>
<label for="select-theme">Тема</label>