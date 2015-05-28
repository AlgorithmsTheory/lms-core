<html>
<body>
<h1>Добро пожаловать в систему тестирования</h1>


<h2>Создать новый вопрос</h2>

{!! Form::open(['method' => 'PATCH', 'route' => 'question_add']) !!}

<table>
    <tr>
        <td><p>Текст</p></td>                                                           <!--обязательное поле-->
        <td><textarea  name="title" rows="3" cols="40"></textarea></td>
    </tr>
    <tr>
        <td><p>Ответ</p></td>
        <td><textarea  name="answer" rows="3" cols="40"></textarea></td>
    </tr>
    <tr>
        <td><p>Варианты</p></td>                                                        <!--пока просто ввод через ;. Затем необходимо сделать-->
        <td><textarea  name="variants" rows="5" cols="40"></textarea></td>               <!--динамическое добавление полей ввода для вариантов через JS-->
    </tr>
    <tr>
        <td><p>Раздел</p></td>                                                               <!--обязательное поле-->
        <td><select name="section" size="1">
            <option value="Формальные описания алгоритмов">Формальные описания алгоритмов</option>/td>
            <option value="Числовые множества">Числовые множества</option>/td>
            <option value="Арифметические выражения">Арифметические выражения</option>/td>
            <option value="Рекурсивные функции">Рекурсивные функции</option>/td>
            <option value="Сложность вычислений">Сложность вычислений</option>
            <option value="Тестирование">Тестирование</option>
        </select></td>
    </tr>
    <tr>
        <td><p>Тема</p></td>                                                                 <!--обязательное поле-->
        <td><input type="text"  name="theme"></td>
    </tr>
    <tr>
        <td><p>Тип</p></td>                                                                  <!--обязательное поле-->
        <td><input type="text"  name="type"></td>
    </tr>
    <tr>
        <td><p>Баллов за верный ответ</p></td>                                                <!--обязательное поле-->
        <td><input type="number" min="0" name="points"></td>
    </tr>
 </table>

<input type="submit" value="Добавить" name="update">
{!! Form::close() !!}
</body>
</html>