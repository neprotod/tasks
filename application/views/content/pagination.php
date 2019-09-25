<?php 
if($pagination["end"] != 1):
?>
<nav>
  <ul class="pagination">
    <?php if($pagination["current"] == 1):?>
        <li class="page-item disabled">
            <span class="page-link">Previous</span>
        </li>
    <?php else:?>
        <li class="page-item">
            <a class="page-link" href="/front/show/<?=$pagination["current"] - 1?>">Previous</a>
        </li>
    <?php endif;?>
    <?php for($i = $pagination["start"];$i <= $pagination["end"];$i++):?>
        <?php if($i == $pagination["current"]):?>
            <li class="page-item active" aria-current="page">
                <span class="page-link">
                    <?=$i?>
                    <span class="sr-only">(current)</span>
                </span>
            </li>
        <?php else:?>
            <li class="page-item">
                <a class="page-link" href="/front/show/<?=$i?>"><?=$i?></a>
            </li>
        <?php endif;?>
    <?php endfor;?>
    <?php if($pagination["current"] == $pagination["pages"]):?>
        <li class="page-item disabled">
            <span class="page-link">Next</span>
        </li>
    <?php else:?>
        <li class="page-item">
            <a class="page-link" href="/front/show/<?=$pagination["current"] + 1?>">Next</a>
        </li>
    <?php endif;?>
  </ul>
</nav>

<?php endif;?>