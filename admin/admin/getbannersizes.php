<?php
include('../include/connection.php');
include('../include/app_config.php');
if($_GET['position'] == POP_UP_POSITION)
{
?>
	<option value="700 x 400">Recommended Size: 700 x 400</option>
<?php 
}
else
{
?>
<option value="">--select size--</option>
                                                                <option value="<?php echo FOUR_SMALL_BANNER_SIZE?>">Four/Row Small Banners (<?php echo FOUR_SMALL_BANNER_SIZE; ?>)</option>
                                                                <option value="<?php echo THREE_SMALL_BANNER_SIZE?>">Three/Row Small Banners (<?php echo THREE_SMALL_BANNER_SIZE; ?>)</option>
                                                                <option value="<?php echo TWO_HALF_WIDTH_BANNER_SIZE?>">Two/Row Half Banners (<?php echo TWO_HALF_WIDTH_BANNER_SIZE; ?>)</option>
                                                                <option value="<?php echo ONE_FULL_WIDTH_BANNER_SIZE?>">One Full Width Banner (<?php echo ONE_FULL_WIDTH_BANNER_SIZE; ?>)</option> 
<?php
}
?>