<center><h3 class="text-light"><?php echo $title?></h3></center>

<table border="0" cellpadding="0" cellspacing="0" align="center">

    <tbody >

    <?php
    $i = 0;
    $rows = mysqli_num_rows($result);
    while ($i < $rows)
    {
        $i++;
        echo '<tr style="padding:20px; margin-top:20px">';
        $row = mysqli_fetch_array($result);
        $i++;
        echo view('library.ebooks.book', compact('row'));
        //view
        echo '<td style="width:100px">';
        echo '<p>&nbsp;</p>';
        echo '</td>';

        if ($i < $rows){
            $row = mysqli_fetch_array($result);
            echo view('library.ebooks.book', compact('row'));
            $i++;
        }else{
            echo '<td style="width:200px">';
        }

        echo '<td style="width:100px">';
        echo '<p>&nbsp;</p>';
        echo '</td>';

        if ($i < $rows){
            $row = mysqli_fetch_array($result);
            echo view('library.ebooks.book', compact('row'));
            $i++;
        }else{
            echo '<td style="width:200px">';
        }

        echo '</tr>';
    }
    ?>
    </tbody>
    <br>
</table>