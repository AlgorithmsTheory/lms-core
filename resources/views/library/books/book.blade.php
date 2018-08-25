
<div class="col-lg-6">
    <div class="row">

        <div class="col-lg-6">
            <a  href = "{{ action ('BooksController@getBook', [$book->id]) }}">
{!! HTML::image('img/library/'.$book->coverImg, 'book', array('style' => 'border-color: transparent; float:left; height:280px; width:200px;'))!!}
            </a>

</div>
<div class="col-lg-6 ">
<a href= "{{ action ('BooksController@getBook', [$book->id]) }}"><h3 class="text-left" >{{$book->title}}</h3></a>
<h4 class="text-left" >{{$book->author}}</h4>

    @if($role == 'Студент' and $studentStatus == 0)
        {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
    @endif
    @if(($role == 'Студент' and $studentStatus != 0 and $book->name != "Теория алгоритмов и сложности вычислений"
    and $book->name != "Дискретная математика") )
        {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
        @endif
    @if(($role != 'Студент' and $role != 'Админ' and $book->name != "Теория алгоритмов и сложности вычислений"
    and $book->name != "Дискретная математика") )
        {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
    @endif
    @if($role == 'Админ' )
        {!! HTML::link('library/book/'.$book->id.'/edit','Редактировать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
<form action = "{{route('book_delete',['id' => $book->id])}}" method="post" onsubmit="return ConfirmDelete()">
    {{method_field('DELETE')}}
    {{ csrf_field() }}
    <div class="form-group">
        <button type="submit" class=" btn ink-reaction btn-warning btn-sm btn-block" style="margin-top: 10px; ">Удалить книгу</button>
    </div>
</form>




    @endif
</div>
</div>
</div>
