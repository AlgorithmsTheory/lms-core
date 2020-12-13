@extends('algorithm.RAMbase')
@section('addl-info-ram')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                <button type="button" name="btn_submit" class="btn ink-reaction btn-primary">Проверить работу</button>
            </p>
        </article>
    </div>
@stop
@section('help-ram')
    <script type="text/javascript">
      function RAMhelpFunc () {
        window.open("{{URL::route('RAMHelp')}}", '_blank');
      }
    </script>
    <a class="btn btn-block btn-primary" onclick="RAMhelpFunc();" name = "btn_help">
        <span>Помощь </span><i class="md md-help"></i>
    </a>
@stop
@section('addl-blocks-ram')
@stop