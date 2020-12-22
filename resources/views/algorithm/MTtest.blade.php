@extends('algorithm.MTbase')

@section('addl-info-mt')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                <button type="button" name="btn_submit" class="btn ink-reaction btn-primary">Проверить работу</button>
            </p>
        </article>
    </div>
@stop

@section('task-mt')
@stop

@section('help-mt')
    <script type="text/javascript">
      function MThelpFunc () {
        window.open("{{URL::route('MTHelp')}}", '_blank');
      }
    </script>
    <a class="btn btn-raised ink-reaction btn-primary" onclick="MThelpFunc();">
        <i class="md md-help"></i>
    </a>
@stop

@section('addl-blocks-mt')
@stop
