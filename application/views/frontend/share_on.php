<?php $sharing_url = site_url('classes/'.slugify($class_details['class_title']).'/'.$class_details['class_id']); ?>

<div class="container p-0 m-0">
	<h5 class="bg-light text-center m-0 py-3 ff-gt-pro"><?php echo get_phrase('choose_a_social_media_and_share_the_class_with_others'); ?></h5>
	<div class="row justify-content-center mstr-bg-blue">
		<div class="col-md-8 py-4">
			<div class="row justify-content-center">
				<div class="col-md-4 text-center pe-0 pt-1">
					<!--Facebook-->
					<iframe src="https://www.facebook.com/plugins/share_button.php?href=<?php echo $sharing_url; ?>&layout=button&appId" width="77" height="28" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" class="border-0 overflow-hidden"></iframe>
				</div>


				<div class="col-md-4 text-center ps-0 pt-1">
					<!--Twitter-->
					<a href="https://twitter.com/share?ref_src=<?php echo $sharing_url; ?>" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>

				<div class="col-md-4 text-center p-0">
					<!--Linkedin-->
					<script src="https://platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/Share" data-url="<?php echo $sharing_url; ?>"></script>
				</div>
		</div>
	</div>
</div>