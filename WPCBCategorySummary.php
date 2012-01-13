<?php
if(!class_exists('WPCBCategorySummary'))
{

class WPCBCategorySummary extends cfct_build_module
{
	public function __construct()
	{
		$this->pluginDir		= basename(dirname(__FILE__));
		$this->pluginPath		= WP_PLUGIN_DIR . '/' . $this->pluginDir;
		$this->pluginUrl 		= WP_PLUGIN_URL.'/'.$this->pluginDir;	
		
		$opts = array
		(
			'description' => 'Choose and display an yearly summary from specific category.',
			'icon' => $this->pluginUrl.'/icon.png'
		);
		parent::__construct('cfct-wp-cb-category', 'Yearly Summary', $opts);
	}
	
	public function display($data)
	{
		$title=isset($data[$this->get_field_id('WPCBCategorySummary_title')])?$data[$this->get_field_id('WPCBCategorySummary_title')]:'';
		$category=isset($data[$this->get_field_id('WPCBCategorySummary_category')])?$data[$this->get_field_id('WPCBCategorySummary_category')]:'';
		$display=isset($data[$this->get_field_id('WPCBCategorySummary_display')])?$data[$this->get_field_id('WPCBCategorySummary_display')]:'';
		$linkto=isset($data[$this->get_field_id('WPCBCategorySummary_linkto')])?$data[$this->get_field_id('WPCBCategorySummary_linkto')]:'';
		$featured_media=isset($data[$this->get_field_id('WPCBCategorySummary_featured_media')])?$data[$this->get_field_id('WPCBCategorySummary_featured_media')]:'';
		$image=isset($data[$this->get_field_id('WPCBCategorySummary_image')])?$data[$this->get_field_id('WPCBCategorySummary_image')]:'';
		$imagelink=isset($data[$this->get_field_id('WPCBCategorySummary_imagelink')])?$data[$this->get_field_id('WPCBCategorySummary_imagelink')]:'';

		?>
			<p><font class="headline"><?php echo $title; ?></font></p>
		<?php
			$args = array(
				'category'        => get_cat_ID($category),
				'orderby'         => 'post_date',
				'order'           => 'DESC',
				'post_type'       => 'post',
				'post_status'     => 'publish' );
			$posts = get_posts($args);
	
		
		
		
			?>
			<div id="WPCBCategoryArchive_summary">
			<?php
			$year=null;
			foreach($posts as $post)
			{			
				if(substr($post->post_date, 0, 4) != $year)
				{
					$year=substr($post->post_date, 0, 4);
					?>
						<div class="archive_listing_title"><?php echo $year; ?></div>
					<?php
				}
				?>
					<div class="archive_listing_content">
						<?php
						if($featured_media=='Show'  && ($id = get_post_thumbnail_id($post->ID))!=NULL)
						{
							
							$image=strtolower($image);
							if($image=='icon'){$image=array(16, 16);};
							$img_url = wp_get_attachment_image_src($id, $image);
							$img_url = $img_url[0];
							
							
							if($imagelink=='nothing')
							{
								?>
								<img src="<?php echo $img_url;?>"/>
								<?php
							}
							else if($imagelink=='featured media')
							{
								$img_url_f = wp_get_attachment_image_src($id, 'full');
								?>
								<a href="<?php echo $img_url_f[0]; ?>"> <img src="<?php echo $img_url;?>"/> </a>
								<?php
							}
							else
							{
								?>
								<a href="<?php echo get_permalink($post->ID); ?>"> <img src="<?php echo $img_url;?>"/> </a>
								<?php
							}
							
							
							
						}
						else if($featured_media=='Do Not Show')
						{
						}
						
						if($linkto=='nothing')
						{
							echo $post->post_title;
						}
						else if($linkto=='featured media' && ($id = get_post_thumbnail_id($post->ID))!=NULL)
						{
							$img_url = wp_get_attachment_image_src($id, 'full');
							?>
							<a href="<?php echo $img_url[0]; ?>"><?php echo $post->post_title; ?></a>
							<?php
						}
						else
						{
							?>
							<a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
							<?php
						}
						?>
						<div style="margin-top:5px;">
						<?php
						if($display=='Title and Exceprt' && $post->post_excerpt != '')
						{
							echo $post->post_excerpt;
						}
						?>
						</div>
					</div>
				<?php
				
			}
			?>
			</div>
			<?php
	}
	
	public function text($data)
	{
		return "Category: ".$data[$this->get_field_id('WPCBCategorySummary_category')];
	}
	
	public function admin_form($data)
	{
		$title=isset($data[$this->get_field_id('WPCBCategorySummary_title')])?$data[$this->get_field_id('WPCBCategorySummary_title')]:'';
		$category=isset($data[$this->get_field_id('WPCBCategorySummary_category')])?$data[$this->get_field_id('WPCBCategorySummary_category')]:'';
		$display=isset($data[$this->get_field_id('WPCBCategorySummary_display')])?$data[$this->get_field_id('WPCBCategorySummary_display')]:'';
		$linkto=isset($data[$this->get_field_id('WPCBCategorySummary_linkto')])?$data[$this->get_field_id('WPCBCategorySummary_linkto')]:'';
		$featured_media=isset($data[$this->get_field_id('WPCBCategorySummary_featured_media')])?$data[$this->get_field_id('WPCBCategorySummary_featured_media')]:'';
		$image=isset($data[$this->get_field_id('WPCBCategorySummary_image')])?$data[$this->get_field_id('WPCBCategorySummary_image')]:'';
		$imagelink=isset($data[$this->get_field_id('WPCBCategorySummary_imagelink')])?$data[$this->get_field_id('WPCBCategorySummary_imagelink')]:'';

		$output = '
			<table>
				<tr>
					<td><label for="WPCBCategorySummary_title">Title</label></td>
					<td><input type="text" id="'.$this->get_field_id('WPCBCategorySummary_title').'" name="'.$this->get_field_name('WPCBCategorySummary_title').'" value="'.$title.'"/></td>
				</tr>
				
				<tr>
					<td><label for="WPCBCategorySummary_category">Category</label>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>
						<select id="WPCBCategorySummary_category" name="'.$this->get_field_name('WPCBCategorySummary_category').'">
							<option></option>
							';
		$category_ids = get_all_category_ids();
		foreach($category_ids as $cat_id)
		{
			$cat_name = get_cat_name($cat_id);
			$output .= "<option ".(($category==$cat_name)?'selected ':'')."value='{$cat_name}'>".$cat_name."</option>";
		}							
							
		$output .=
							'.
						</select>
					</td>
				</tr>
			</table>
			 
			<fieldset class="cfct-ftl-border">
				<legend>Diaply Options</legend>
				
				<ul>
					<li>
						For each post in the category display
						<select name="'.$this->get_field_name('WPCBCategorySummary_display').'">
							<option '.(($display=='Title')?'selected ':'').'>Title</option>
							<option '.(($display=='Title and Exceprt')?'selected ':'').'>Title and Exceprt</option>
						</select>.
					</li>
					<li>
						Link the title to the 
						<select name="'.$this->get_field_name('WPCBCategorySummary_linkto').'">
							<option '.(($linkto=='post')?'selected ':'').'>post</option>
							<option '.(($linkto=='featured media')?'selected ':'').'>featured media</option>
							<option '.(($linkto=='nothing')?'selected ':'').'>nothing</option>
						</select>
					</li>
					<li>
						<select name="'.$this->get_field_name('WPCBCategorySummary_featured_media').'">
							<option '.(($featured_media=='Show')?'selected ':'').'>Show</option>
							<option '.(($featured_media=='Do not show')?'selected ':'').'>Do not show</option>
						</select>
						 an image of the featured media before the title.
					</li>
					<li>
						This image should be 
						<select name="'.$this->get_field_name('WPCBCategorySummary_image').'">
							<option '.(($image=='Icon')?'selected ':'').'>Icon</option>
							<option '.(($image=='Thumbnail')?'selected ':'').'>Thumbnail</option>
							<option '.(($image=='Medium')?'selected ':'').'>Medium</option>
							<option '.(($image=='Large')?'selected ':'').'>Large</option>
							<option '.(($image=='Full')?'selected ':'').'>Full</option>
						</select>
						 size and should link to 
						<select name="'.$this->get_field_name('WPCBCategorySummary_imagelink').'">
							<option '.(($imagelink=='post')?'selected ':'').'>post</option>
							<option '.(($imagelink=='featured media')?'selected ':'').'>featured media</option>
							<option '.(($imagelink=='nothing')?'selected ':'').'>nothing</option>
						</select>
					</li>
				</ul>
			</fieldset>
		';
	
	
		/*
		$selector_tabs = array();
		$selector_tabs[$this->id_base.'-summary-select-archive']='Select Archive';
		$selector_tabs[$this->id_base.'-summary-display-options']='Display Options';
		$active_tab = $this->id_base.'-summary-select-archive';
		$output =
		$this->cfct_module_tabs($this->id_base.'-category-summary-tabs', $selector_tabs, $active_tab).		
		'	
		
		<div class="cfct-module-tab-contents">
			<div id="'.$this->id_base.'-summary-select-archive" '.($active_tab == $this->id_base.'-summary-select-archive' ? ' class="active"' : null).'>
				'.'one'.'
			</div>
	
			<div id="'.$this->id_base.'-summary-display-options" '.($active_tab == $this->id_base.'-summary-display-options' ? ' class="active"' : null).'>
				'.'two'.'
			</div>
		</div>
	
		';*/
		return $output;
	}
}



cfct_build_register_module('cfct-wp-cb-category', 'WPCBCategorySummary');

//cfct_build_register_module('cfct-build-page-options', 'WPCBCategorySummaryOptions');
}