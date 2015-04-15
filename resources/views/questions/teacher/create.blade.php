<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>


<h2>Создать новый вопрос</h2>

{!! Form::open(['method' => 'PATCH', 'route' => 'question_add']) !!}

<form action=""
<table>
    <tr>
        <td><p>Текст</p></td>         <!--обязательное поле-->
        <td><input type="text"  name="title"></td>
    </tr>
    <tr>
        <td><p>Ответ</p></td>
        <td><input type="text"  name="answer"></td>
    </tr>
    <tr>
        <td><p>Варианты</p></td>                      <!--пока просто ввод через ;. Затем необходимо сделать-->
        <td><input type="text"  name="variants"></td> <!--динамическое добавление полей ввода для вариантов через JS-->
    </tr>
    <tr>
        <td><p>Раздел</p></td>          <!--обязательное поле-->
        <td><input type="text"  name="section"></td>
    </tr>
    <tr>
        <td><p>Тема</p></td>            <!--обязательное поле-->
        <td><input type="text"  name="theme"></td>
    </tr>
    <tr>
        <td><p>Тип</p></td>             <!--обязательное поле-->
        <td><input type="text"  name="type"></td>
    </tr>
    <tr>
        <td><p>Баллов за верный ответ</p></td>      <!--обязательное поле-->
        <td><input type="number" min="0" name="points"></td>
    </tr>
 </table>

<input type="submit" value="Добавить" name="update">
{!! Form::close() !!}
</body>
</html>