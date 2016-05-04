<td style="width:200px">
    <p>{!! HTML::image('img/library/'.$row["coverImg"], 'ebook', array('style' => 'border-color: transparent; float:left; height:200px; width:150px')) !!}</p>



    <h4>{!! HTML::link($row['link'], $row['title']) !!}
    </h4>
    <p><strong>
            <?php
            print "
				<p>".$row["author"]."</p>";

            ?>
        </strong></p>

</td>
