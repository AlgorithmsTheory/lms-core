@extends('algorithm.HAMbase')

@section('addl-info-ham')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                <button type="button" name="btn_submit" class="btn ink-reaction btn-primary">Проверить работу</button>
            </p>
        </article>
    </div>
@stop

@section('task-ham')
@stop

@section('help-ham')
    <script type="text/javascript">
      function HAMhelpFunc () {
        window.open("{{URL::route('HAMHelp')}}", '_blank');
      }
    </script>
    <a class="btn btn-raised ink-reaction btn-primary" onclick="HAMhelpFunc();">
        <i class="md md-help"></i>
    </a>
@stop

@section('addl-blocks-ham')
@stop
