<center><h3 class="text-light"><?php echo $title?></h3></center>

<table class="table table-bordered no-margin" border-color="transparent" ; cellpadding="10" border-spacing=" 7px 11px" align="center" border="0px" width="100%"  >

<tbody >

<?php
$i = 0;
$rows = count($result);
while ($i < $rows)
{
    echo '<tr style="padding:20px; margin-top:20px padding: 3px">';
    $row = $result[$i++];
    echo view('library.ebooks.book', compact('row'));

    //view
    //  echo '<td style="width:100px">';
    // echo '<p>&nbsp;</p>';
    // echo '</td>';

    if ($i < $rows){
        $row = $result[$i++];
        echo view('library.ebooks.book', compact('row'));
    }else{
        echo '<td style="width:200px; padding: 3px">';
    }

    //  echo '<td style="width:100px">';
    //  echo '<p>&nbsp;</p>';
    //   echo '</td>';

    if ($i < $rows){
        $row = $result[$i++];
        echo view('library.ebooks.book', compact('row'));
    }else{
        echo '<td style="width:200px; padding: 3px">';
    }

    echo '</tr>';
}
?>
</tbody>
<br>
</table>