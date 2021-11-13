<select name="theme" id="select-theme" class="form-control" size="1" required>
    <option value="$nbsp">Все</option>
    @if ($themes_list !== null)
        @foreach ($themes_list as $theme)
            <option value="{{$theme['theme_name']}}">{{$theme['theme_name']}}</option>
        @endforeach
    @endif
</select>
<label for="select-theme">Тема</label>