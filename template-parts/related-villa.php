<div class="mt-8">
<h2 class="text-lg font-semibold">Other Villa Type</h2>
<div class="grid md:grid-cols-2 gap-4">
<?php
$villasql = new WP_Query(
		array(
			'post_type' => 'page',
			'category_name' => 'villa',
			'posts_per_page' => -1,
			'post__not_in' => array(
				get_queried_object_id()
			)
		)
	);

if ($villasql->have_posts()) {
	 while ( $villasql->have_posts()) {
	 	$villasql->the_post();

	 	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($villasql->ID), 'medium');
?>
<div class="w-full block relative" style="padding-top:70%">
<a href="<?php the_permalink();?>" title="<?php the_title();?>" class="group">
<div 
class="absolute inset-1.5 bg-center bg-cover before:content-[''] before:absolute before:inset-0
before:transition-all before:ease before:opacity-0 before:bg-black/75
group-hover:before:opacity-100"
style="background-image:url('<?php echo $thumbnail[0];?>')"
>
<img 
	src="data:image/svg+xml,%3Csvg%20xmlns=%22http://www.w3.org/2000/svg%22%20viewBox=%220%200%20%20%22%3E%3C/svg%3E""
	data-src="<?php echo $thumbnail[0];?>"
	class="hidden"
>
<span
class="inline-block absolute text-white text-center top-1/2 left-1/2 mt-12 opacity-0
transition-all ease -translate-x-1/2 -translate-y-1/2
group-hover:mt-0 group-hover:opacity-100 group-hover:text-white"
>
<?php the_title();?>
</span>
<div class="p-2 block absolute bottom-0 bg-slate-700/75 w-full text-sm text-white">
<?php the_title();?>
</div>
</div>
</a>

</div>
<?php
	 }
}
?>

</div>
</div>