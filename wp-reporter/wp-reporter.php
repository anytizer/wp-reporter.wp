<?php
/**
 * @package WP Reporter
 * Plugin Name: WP Reporter
 * Plugin URI: https://wordpress.org/plugins/wp-reporter/
 * Description: Counts and reports WordPress resources
 * Author: Bimal Poudel
 * Version: 1.0
 * Author URI: #
 */

 /**
  * @see https://codex.wordpress.org/Function_Reference/wp_count_posts
  * @see https://developer.wordpress.org/reference/functions/get_terms/
  * @see https://codex.wordpress.org/Function_Reference/wp_count_terms
  * @see https://codex.wordpress.org/Function_Reference/wp_count_comments
  * @see https://codex.wordpress.org/Function_Reference/count_users
  */

add_action('admin_menu', 'print_reports_menu');

/**
 * 
 */
function print_reports_menu()
{
	add_menu_page("WP Resoruce Reporter", "WP Reporter", "manage_options", basename(dirname(__FILE__)), "print_reports_page");
}

function print_reports_page()
{
	$count_posts = wp_count_posts();
	$count_pages = wp_count_posts("page");
	$comments_count = wp_count_comments();
	$users = count_users();

	$args = array(
		'parent' => 0,
		'hide_empty' => 0
	);
	$categories = get_categories( $args );
	$total_categories = count( $categories );

	$total_posts = 0;
	foreach($count_posts as $index => $total)
	{
		$total_posts += $total;
	}

	$total_pages = 0;
	foreach($count_pages as $index => $total)
	{
		$total_pages += $total;
	}
?>

<div class="wrap">

<h1>WP Reporter</h1>

<h2>Posts: <a href="edit.php"><?php echo $total_posts; ?></a></h2>
<p>Total posts.</p>
<table class="wp-list-table widefat">
	<tr>
		<th>Publish</th>
		<th>Future</th>
		<th>Draft</th>
		<th>Pending</th>
		<th>Private</th>
		<th>Trash</th>
		<th>Auto-Draft</th>
		<th>Inherit</th>
	</tr>
	<tr>
		<td><a href="edit.php?post_status=publish&amp;post_type=post"><?php echo $count_posts->publish; ?></a></td>
		<td><a href="edit.php?post_status=trash&amp;post_type=post"><?php echo $count_posts->future; ?></a></td>
		<td><a href="edit.php?post_status=draft&amp;post_type=post"><?php echo $count_posts->draft; ?></a></td>
		<td><a href="edit.php?post_status=pending&amp;post_type=post"><?php echo $count_posts->pending; ?></a></td>
		<td><a href="edit.php?post_status=private&amp;post_type=post"><?php echo $count_posts->private; ?></a></td>
		<td><a href="edit.php?post_status=trash&amp;post_type=post"><?php echo $count_posts->trash; ?></a></td>
		<td><a href="edit.php?post_status=auto-draft&amp;post_type=post"><?php echo $count_posts->{'auto-draft'}; ?></a></td>
		<td><a href="edit.php?post_status=inherit&amp;post_type=post"><?php echo $count_posts->inherit; ?></a></td>
	</tr>
</table>

<h2>Pages: <a href="edit.php?post_type=page"><?php echo $total_pages; ?></a></h2>
<p>Total pages.</p>
<table class="wp-list-table widefat">
	<tr>
		<th>Publish</th>
		<th>Future</th>
		<th>Draft</th>
		<th>Pending</th>
		<th>Private</th>
		<th>Trash</th>
		<th>Auto-Draft</th>
		<th>Inherit</th>
	</tr>
	<tr>
		<td><a href="edit.php?post_status=publish&amp;post_type=page"><?php echo $count_pages->publish; ?></a></td>
		<td><a href="edit.php?post_status=future&amp;post_type=page"><?php echo $count_pages->future; ?></a></td>
		<td><a href="edit.php?post_status=draft&amp;post_type=page"><?php echo $count_pages->draft; ?></a></td>
		<td><a href="edit.php?post_status=pending&amp;post_type=page"><?php echo $count_pages->pending; ?></a></td>
		<td><a href="edit.php?post_status=private&amp;post_type=page"><?php echo $count_pages->private; ?></a></td>
		<td><a href="edit.php?post_status=trash&amp;post_type=page"><?php echo $count_pages->trash; ?></a></td>
		<td><a href="edit.php?post_status=auto-draft&amp;post_type=page"><?php echo $count_pages->{'auto-draft'}; ?></a></td>
		<td><a href="edit.php?post_status=inherit&amp;post_type=page"><?php echo $count_pages->inherit; ?></a></td>
	</tr>
</table>

<h2>Comments: <a href="edit-comments.php"><?php echo $comments_count->total_comments; ?></a></h2>
<p>Comments received.</p>
<table class="wp-list-table widefat">
	<tr>
		<th>In Moderation</th>
		<th>Approved</th>
		<th>In Spam</th>
		<th>In Trash</th>
		<th>Total</th>
	</tr>
	<tr>
		<td><a href="edit-comments.php?comment_status=moderated"><?php echo $comments_count->moderated; ?></a></td>
		<td><a href="edit-comments.php?comment_status=approved"><?php echo $comments_count->approved; ?></a></td>
		<td><a href="edit-comments.php?comment_status=spam"><?php echo $comments_count->spam; ?></a></td>
		<td><a href="edit-comments.php?comment_status=trash"><?php echo $comments_count->trash; ?></a></td>
		<td><a href="edit-comments.php?comment_status=approved"><?php echo $comments_count->total_comments; ?></a></td>
	</tr>
</table>

<h2>Users: <a href="users.php"><?php echo $users['total_users']; ?></a></h2>
<p>Users and roles.</p>
<table class="wp-list-table widefat">
	<tr>
		<?php foreach($users['avail_roles'] as $role => $count): ?>
		<th><?php echo $role; ?></th>
		<?php endforeach; ?>
	</tr>
	<tr>
		<?php foreach($users['avail_roles'] as $role => $count): ?>
		<td><a href="users.php?role=<?php echo $role; ?>"><?php echo $count; ?></a></td>
		<?php endforeach; ?>
	</tr>
</table>

<!-- @todo Categories -->
<!-- @todo Tags and Taxonomy -->
<!-- @todo Media uploads -->

<h2>Categories: <a href="edit-tags.php?taxonomy=category"><?php echo $total_categories; ?></a></h2>
<p>Top level categories.</p>
<table class="wp-list-table widefat">
	<tr>
		<th>Category</th>
		<th>Total</th>
	</tr>
	<?php foreach($categories as $category): ?>
	<tr>
		<td><a href="term.php?taxonomy=category&amp;tag_ID=<?php echo $category->term_id; ?>&amp;post_type=post"><?php echo $category->name; ?></a></td>
		<td><a href="edit.php?s&amp;post_status=all&amp;post_type=post&amp;action=-1&amp;m=0&amp;cat=<?php echo $category->term_id; ?>&amp;filter_action=Filter&amp;paged=1&amp;action2=-1"><?php echo $category->count; ?></a></td>
	</tr>
	<?php endforeach; ?>
</table>

<?php
/*
$args = array(
	'smallest'                  => 8, 
	'largest'                   => 22,
	'unit'                      => 'pt', 
	'number'                    => 45,  
	'format'                    => 'flat',
	'separator'                 => "\n",
	'orderby'                   => 'name', 
	'order'                     => 'ASC',
	'exclude'                   => null, 
	'include'                   => null, 
	'topic_count_text_callback' => default_topic_count_text,
	'link'                      => 'view', 
	'taxonomy'                  => 'post_tag', 
	'echo'                      => true,
	'child_of'                  => null, // see Note!
);
$tags = wp_tag_cloud( $args );
print_r($tags);
*/
?>

</div>
<?php
} # print_reports()
?>