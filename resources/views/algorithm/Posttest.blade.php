@extends('algorithm.Postbase')
@section('addl-info-post')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                <button type="button" name="btn_submit" class="btn ink-reaction btn-primary">Проверить работу</button>
            </p>
        </article>
    </div>
@stop

@section('task-post')
@stop

@section('help-post')
    <script type="text/javascript">
      function PosthelpFunc () {
        window.open("{{URL::route('PostHelp')}}", '_blank');
      }
    </script>
    <a class="btn btn-raised ink-reaction btn-primary" onclick="PosthelpFunc();">
        <i class="md md-help"></i>
    </a>
@stop

@section('addl-blocks-post')
@stop