<td style="width:155px;padding: 5px">
    <p>{!! HTML::image('img/library/'.$row["coverImg"], 'book', array('style' => 'border-color: transparent; float:left; height:200px; width:150px')) !!}</p>
</td>
<td style="width:154px">

    <center><h3>{!! HTML::linkRoute('book', $row['title'], array('id' => $row['id'])) !!}</h3>
        <p><strong>
                <?php
                print "
				<p>".$row["author"]."</p>";
                    ?>
            </strong></p>
    </center>
</td>
