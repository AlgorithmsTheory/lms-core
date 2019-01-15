
<div class="col-lg-6">
    <div class="row">

        <div class="col-lg-4">
            <a  href = "{{ action ('LibraryController@person', [$person->id]) }}">
{!! HTML::image($person->image_patch, 'person', array('style' => 'border-color: transparent; float:left; height:200px; width:150px;'))!!}
            </a>

</div>
<div class="col-lg-6 ">
<a href= "{{ action ('LibraryController@person', [$person->id]) }}"><h3 class="text-left" >{{$person->name}}</h3></a>
<h4 class="text-left" >{{$person->year_birth}} - {{$person->year_death}}</h4>

    @if($role == 'Админ' )
        <div class="row">
            <div class="col-lg-8">
        {!! HTML::link('library/persons/'.$person->id.'/edit','Редактировать',array('class' => 'btn ink-reaction btn-primary btn-block','role' => 'button')) !!}
<form action = "{{route('book_delete',['id' => $person->id])}}" method="post" onsubmit="return ConfirmDelete()">
    {{method_field('DELETE')}}
    {{ csrf_field() }}
    <div class="form-group">
        <button type="submit" class=" btn ink-reaction btn-warning btn-block" style="margin-top: 10px; ">Удалить</button>
    </div>
</form>
            </div>
            <div class="col-lg-4">
            </div>
        </div>
    @endif
</div>
        <div class="col-lg-2">
        </div>
</div>
</div>
