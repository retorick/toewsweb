<?php
ob_start();
?>
<div id="sidebar">
  <h2 class="sidebartitle">Recent Posts</h2>
  <ul class="recent-titles" style="margin:0 0 10px 0;padding:0; list-style:none">
<?php 
$recent = wp_get_recent_posts(array('numberposts' => 4)); 
foreach ($recent as $post) {
    echo '<li style="margin-top:10px;"><a style="color:#ccc;" href="' . get_permalink($post["ID"]) . '" title="Look '.esc_attr($post["post_title"]).'" >' .   $post["post_title"].'</a> </li> ';
}
?>
  </ul>
  <h2 class="sidebartitle"><?php _e('Categories'); ?></h2>
  <ul class="list-cat">
    <?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
  </ul>
 
  <h2 class="sidebartitle"><?php _e('Archives'); ?></h2>
  <ul class="list-archives">
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
</div>
<?php
$sidebar = ob_get_clean();

$smarty->assign('sidebar', $sidebar);
?>
