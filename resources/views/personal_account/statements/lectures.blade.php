<h2>Посещение лекций</h2>
<br>
<table class="table table-condensed table-bordered">
    <tr>
        <td rowspan="2" class="warning">Группа</td>
        <td rowspan="2" class="warning">Фамилия</td>
        <td rowspan="2" class="warning">Имя</td>
        <td colspan="7" class="info">1 Раздел</td>
        <td colspan="4" class="warning">2 Раздел</td>
        <td colspan="4" class="info">3 Раздел</td>
        <td colspan="1" class="warning">4 Раздел</td>
    </tr>
    <tr class="active">
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
        <td>9</td>
        <td>10</td>
        <td>11</td>
        <td>12</td>
        <td>13</td>
        <td>14</td>
        <td>15</td>
        <td>16</td>
    </tr>
    <tbody id="target">
    <?php
                $count = 0;
                foreach($statement as $state) {
                    echo "<tr>";
                    echo "<td>";
                    echo $state['group_name'];
                    echo "</td>";
                    echo "<td>";
                    echo $last_names[$count];
                    echo "</td>";
                    echo "<td>";
                    echo $first_names[$count];
                    echo "</td>";
                    echo "<td>";
                    if ($state['col1'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col1' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col1' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col2'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col2' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col2' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col3'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col3' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col3' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col4'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col4' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col4' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col5'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col5' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col5' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col6'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col6' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col6' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col7'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col7' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col7' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col8'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col8' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col8' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col9'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col9' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col9' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col10'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col10' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col10' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col11'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col11' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col11' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col12'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col12' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col12' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col13'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col3' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col13' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col14'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col14' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col14' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col15'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col15' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col15' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td><td>";
                    if ($state['col16'] == 1) {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' checked name='";
                        echo $state['userID'];
                        echo "' id='col16' class='was'> ";
                        echo "<span></span></<label></label></div>";
                    }
                    else {
                        echo "<div class='checkbox checkbox-inline checkbox-styled'><label>";
                        echo "<input type='checkbox' name='";
                        echo $state['userID'];
                        echo "' id='col16' class='was'> ";
                        echo "<span></span></<label></label></div>";

                    }
                    echo "</td></tr>";
                    $count++;
                }
    ?>

    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col1" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col2" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col3" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col4" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col5" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col6" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col7" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col8" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col9" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col10" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col11" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col12" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col13" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col14" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col15" name="{{ $group }}">Все</button>
        </td>
        <td>
            <button class="btn btn-warning btn-raised all" id="col16" name="{{ $group }}">Все</button>
        </td>
    </tr>

    </tbody>
</table>



{!! HTML::script('js/statements/lectures.js') !!}