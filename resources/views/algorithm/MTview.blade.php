@extends('algorithm.MTbase')

@section('addl-info-mt')
    <div class="col-lg-12">
        <article class="margin-bottom-xxl">
            <p class = 'lead'>
                Данный эмулятор предназначен для получения навыков написания алгоритмов,
                а также для проверки решения задач. Перед работой ВНИМАТЕЛЬНО ознакомьтесь
                со справкой (кнопка "Помощь")
            </p>
        </article>
    </div>
@stop

@section('task-mt')
    <div class="card-body">
        <div class="col-lg-12">
            <div class="form" role="form">
                <div class="form-group floating-label">
                    <textarea name="task_text" class="form-control" rows="3" placeholder="Для Вашего удобства здесь можно написать условие задачи"></textarea>
                    <label style="top:-15px">Условие задачи: </label> 
                </div>
            </div>
        </div>
    </div>
@stop

@section('addl-blocks-mt')
    <div class="offcanvas">
        <div id="offcanvas-demo-right" class="offcanvas-pane width-10" style="">
            <div class="offcanvas-head">
                <header>Как работать с эмулятором</header>
                <div class="offcanvas-tools">
                    <a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
                        <i class="md md-close"></i>
                    </a>
                </div>
            </div>
            
            <div class="nano has-scrollbar" style="height: 633px;">
                <div class="nano-content" tabindex="0" style="right: -17px;">
                    <div class="offcanvas-body">
                        <p>
                            Введите в соответствующие поля входное слово после сивола ∂, а также сам текст программы(правую и левую части).
                        </p>
                        <h4>Инструкция:</h4>
                        <ul class="list-divided">
                            <li>Для записи строк исользуйте такой порядок, который представлен в первой строке по умолчанию: Состояние.Символ -> Символ.Напраление движения.Состояние</li>
                            <li>Для добавления нижнего индекса нужно набрать в поле ввода конструкцию вида _{цифры}. Пример: S_{00} преобразуется в S<sub>00</sub>. </li>
                            <li>Входное слово по умолчанию пустое, эта запись соответствует той, что представлена в соответствующем поле: ∂. Ваше входное слово введите после этого символа, например: ∂aabb</li>
                            <li>Вы можете поменять местами написанные строки алгоритма. Для этого нужно, удерживая курсором нужный элемент списка за стрелку, перетащить его на желаемую позицию.</li>
                            <li>Для добавления строки нажмите кнопку "+".</li>
                            <li>Используйте кнопку "Очистить", чтобы удалить все символы с поля ввода алгоритма.</li>
                            <li>Специальный символ можно добавить, кликнув на него, находясь на нужной позиции поля ввода. Внимание: спецсимвол добавляется в конец редактируемого поля без учета конкретной позиции курсора в нем. </li>
                        </ul>
                    </div>
                </div>
                <div class="nano-pane" style="display: none;">
                    <div class="nano-slider" style="height: 616px; transform: translate(0px, 0px);">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
