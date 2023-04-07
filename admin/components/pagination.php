<?php
if (!$isForSearch) {
    $getLink = "?";
    if (isset($_GET['filter-by'])) {
        $getLink .= "filter-by=" . $_GET['filter-by'] . "&";
    } 
    
    if (isset($_GET['filter'])) {
        $getLink .= "filter=" . $_GET['filter'] . "&";
    }
?>
    <div class="mt-20">
        <p>Showing <?php echo $offset + 1; ?> - <?php if (($offset + $limit) < $count)
                                                    echo $offset + $limit;
                                                else
                                                    echo $count; ?> of <?php echo $count; ?>
        </p>
    </div>

    <?php
    if ($page > 1 || $page < $total_pages) {
        $visible_pages = 1;
        $start_page = max(1, $page - $visible_pages);
        $end_page = min($total_pages, $page + $visible_pages);

        $prev_ellipsis = $start_page > 2;
        $next_ellipsis = $end_page < $total_pages - 1;
    ?>
        <div class="pagination flex items-center gap wrap justify-center mt-20">

            <?php if ($page > 1) { ?>
                <a href='<?php if (isset($getLink))
                                echo $getLink; ?>page=<?php echo $page - 1; ?>' class='pagination-nums border-curve button gray'>Prev</a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <?php if ($i == 1 || $i == $total_pages || ($i >= $start_page && $i <= $end_page)) { ?>
                    <a href="<?php if (isset($getLink))
                                    echo $getLink; ?>page=<?php echo ($i); ?>">
                        <div class="pagination-nums border-curve button <?php if ($page != $i)
                                                                            echo "gray"; ?>"><?php echo $i; ?></div>
                    </a>
                <?php } elseif ($prev_ellipsis && $i == $start_page - 1) { ?>
                    <div class="pagination-nums border-curve button gray">...</div>
                <?php } elseif ($next_ellipsis && $i == $end_page + 1) { ?>
                    <div class="pagination-nums border-curve button gray">...</div>
                <?php } ?>
            <?php } ?>

            <?php if ($page < $total_pages) { ?>
                <a href='<?php if (isset($getLink))
                                echo $getLink; ?>page=<?php echo $page + 1; ?>' class='pagination-nums border-curve button gray'>Next</a>
            <?php } ?>
        </div>
<?php }
} ?>