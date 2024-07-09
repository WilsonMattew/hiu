<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-lg-3 category-list-parent">
			<ul class="category-list">
				<li>
					<a href="javascript:;" onclick="load_all_classes(this, 'browse')" class="ff-gt-pro text-17 <?php if(!isset($category_slugify) || empty($category_slugify) && !isset($_GET['search']) && !isset($_GET['featured']) && !isset($_GET['recommended']) && !isset($_GET['skill'])){ echo 'active';} ?>">
						<span><?php echo get_phrase('all_classes'); ?></span>
					</a>
				</li>
				
				<li>
					<a href="javascript:;" onclick="load_all_classes(this, 'browse?featured=yes')" class="ff-gt-pro text-17 <?php if(isset($_GET['featured']) && $_GET['featured'] == 'yes')echo 'active'; ?>">
						<span><?php echo get_phrase('featured'); ?></span>
					</a>
				</li>

				<li>
					<a href="javascript:;" onclick="load_all_classes(this, 'browse?recommended=yes')" class="ff-gt-pro text-17 <?php if(isset($_GET['recommended']) && $_GET['recommended'] == 'yes')echo 'active'; ?>">
						<span><?php echo get_phrase('recommended'); ?></span>
					</a>
				</li>
			</ul>

			<ul class="category-list">
				<?php $parent_categories = $this->crud_model->get_parent_categories(); ?>
				<?php foreach($parent_categories->result_array() as $key => $parent_category): ?>
					<li class="header ff-gt-pro"><?php echo $parent_category['title']; ?></li>

					<?php $sub_categories = $this->crud_model->get_sub_categories($parent_category['category_id']); ?>
					<?php foreach($sub_categories->result_array() as $key => $sub_category): ?>
						<li>
							<a href="javascript:;" onclick="load_all_classes(this, 'browse/<?php echo $sub_category['slugify'] ?>')" class="ff-poppins text-14 <?php if(isset($category_slugify) && $category_slugify == $sub_category['slugify'])echo 'active'; ?>">
								<span><?php echo $sub_category['title']; ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="col-md-8 col-lg-9 pt-4">
			
				<div class="w-100 mh-160px rounded" style="background-image: url('<?php echo base_url('assets/frontend/image/course_page_banner.jpg'); ?>'); background-size: contain;">
					<div class="placeholder-1 rounded bg-gradient-lh"></div>
					
					<h2 class="ps-3 pt-3 text-uppercase text-white position-relative"><?php echo get_phrase('online_classes'); ?></h2>
					<p class="ps-3 text-white position-relative"><?php echo get_phrase('search_all_the_classes_you_need_here_and_start_acquiring_your_knowledge'); ?>.</p>

					<?php if(subscription_status()): ?>
						<p class="ps-3 mstr-color-green position-relative"><?php echo get_phrase('start_study_with_a_premium_class_quickly'); ?>.</p>
					<?php else: ?>
						<a href="<?php echo site_url('membership'); ?>" class="ms-3 mb-4 mstr-bg-green text-decoration-none position-relative ff-gt-pro fw-500 radius-1 mstr-color-blue py-2 px-3 rounded"><?php echo get_phrase('Go_Premium'); ?></a>
					<?php endif; ?>
				</div>

			<div id="loadAllClasses">
				<?php include "browse_classes_list.php"; ?>
			</div>
		</div>
	</div>
</div>