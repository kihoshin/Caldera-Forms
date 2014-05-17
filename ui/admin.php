<?php

// Just some basics.
$per_page_limit = 20;
// form tempalte
$template_style = 'form-card-tmpl';
// get all forms
$forms = get_option( '_caldera_forms' );

// Modal Height
$modal_height = '400';

// check there are groups
if(!empty($meta_groups['groups'])){
	if( count($meta_groups['groups']) > 7){
		$multiplier = count($meta_groups['groups']) - 7;
		$modal_height = $modal_height + ( 30 * $multiplier );
	}
}
// load fields
//$field_types = apply_filters('caldera_forms_get_field_types', array() );

// create user modal buttons
$modal_new_form = __('Create Form', 'caldera-forms').'|{"data-action" : "create_form", "data-active-class": "disabled", "data-load-class": "disabled", "data-callback": "new_form_redirect", "data-before" : "serialize_modal_form", "data-modal-autoclose" : "new_form" }';

?><div class="caldera-editor-header">
	<ul class="caldera-editor-header-nav">
		<li class="caldera-editor-logo">
			Caldera Forms
		</li>
		<li class="caldera-forms-version">
			v<?php echo CFCORE_VER; ?>
		</li>
		<li class="caldera-forms-search">
			<a class="button ajax-trigger" data-request="start_new_form" data-modal-buttons='<?php echo $modal_new_form; ?>' data-modal-width="600" data-modal-height="300" data-load-class="none" data-modal="new_form" data-modal-title="Create New Form" data-template="#new-form-tmpl"><?php echo __('New Form', 'caldera-forms'); ?></a>
		</li>		
		
	</ul>
</div>

<div class="form-panel-wrap">
	<?php

		if(!empty($forms)){

			foreach($forms as $form_id=>$form){
				?>
				<div class="form-panel postbox">
					<h4><?php echo $form['name']; ?></h4>
					<?php if(!empty($form['description'])){ ?><h5><?php echo $form['description']; ?></h5><?php } ?>

					<ul class="form-controls">
						<li><a class="form-control" href="admin.php?page=caldera-forms&edit=<?php echo $form_id; ?>"><?php echo __('Edit Form', 'caldera-forms'); ?></a></li>
						<li><span  class="form-control">[caldera_form id="<?php echo $form_id; ?>"]</li>
					</ul>					
				</div>

				<?php

			}
		}else{

			echo '<p>' . __('You don\'t have any forms yet.', 'caldera-forms');

		}
	?>
</div>

<script type="text/html" id="new-form-tmpl">
	<form class="new-form-form">
		<div class="caldera-config-group">
			<label for=""><?php echo __('Form Name', 'caldera-forms'); ?></label>
			<div class="caldera-config-field">
				<input type="text" class="new-form-name block-input field-config" name="name" value="">
			</div>
		</div>
		<div class="caldera-config-group">
			<label for=""><?php echo __('Description', 'caldera-forms'); ?></label>
			<div class="caldera-config-field">
				<textarea class="block-input field-config" name="description" value=""></textarea>
			</div>
		</div>
	</form>
</script>
<script type="text/html" id="pop-over-tmpl">	
	<div class="pointer"></div>
	<div class="popover-content" style="display:none;">
		<button type="button" class="button popover-button">Change Image</button>
	</div>
	<div class="popover-content image-thumb">
		<div class="popover-side-bar">
			<?php echo get_avatar(1, 62); ?>
		</div>
		<div class="popover-main-content">
			<div>
				<select>
					<option>Thumbnail</option>
					<option>Medium</option>
					<option>Large</option>
					<option>Full</option>
				</select>
			</div>
			<button class="button popover-button" type="button">Change Image</button>
		</div>
	</div>
</script>
<script type="text/html" id="form-card-tmpl">
{{#each_limit this}}
	<div class="tag user-panel postbox ajax-trigger" data-index="{{index}}" data-action="get_users" data-modal-buttons='<?php echo $modal_profile_buttons; ?>' data-modal-width="600" data-modal-height="<?php echo $modal_height; ?>" data-load-class="spinner" data-user_id="{{ID}}" data-modal="user_profile" data-modal-title="{{name}}" data-template="#profile-modal-detail-tmpl">
		<div class="avatar-link {{role}}">
			<span class="user-avatar-{{ID}}">{{{avatar}}}</span>
		</div>
		<h4>{{name}}</h4>
		<h5>{{email}}</h5>
	</div>
{{/each_limit}}
</script>

<script type="text/html" id="general-settings-tmpl">


</script>
<script type="text/javascript">

function new_form_redirect(obj){
	if(typeof obj.data === 'string'){
		window.location = 'admin.php?page=caldera-forms&edit=' + obj.data;
	}else{
		alert(obj.data.error);
	}
}

// profile form saver
function serialize_modal_form(el){
	
	var clicked	= jQuery(el),
		data 	= clicked.closest('.caldera-modal-wrap').find('.new-form-form'),
		name = data.find('.new-form-name');
	
	//verify name is set
	if(name.val().length < 1){
		alert("<?php echo __('An form name is required', 'caldera-forms'); ?>");
		name.focus().addClass('has-error');
		return false;
	}


	clicked.data('data', data.serialize());

	return true;
}


function start_new_form(){

	
	return {};

}
</script>