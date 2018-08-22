<?php
$campaigns = isset($view_args['campaigns']) ? $view_args['campaigns'] : '';
/*if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
		update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
	endif; */
$expenses = get_admin_expenses();
?>
<div id="add_expense">
	<form method="post" id="charitable_expense" class="charitable-form" action="<?php echo admin_url('admin-post.php'); ?>">
	<input type="hidden" name="action" value="expense_form_save_response"/>
	<input type="hidden" name="cae_add_user_meta_nonce" value="<?php echo $view_args['cae_nonce'] ?>" />
	
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">Expense Title</th>
					<td><input required type="text" id="charitable_campaign_expense_title" name="<?php echo "expense";?>[expense_title]" value="" class="charitable-settings-field"/>
					<div class="charitable-help">The name of the expense made</div>
					</td>
				</tr>
				<tr>
					<th scope="row">Amount</th>
					<td><input required type="number" id="charitable_campaign_expense_amount" name="<?php echo "expense";?>[expense_amount]" value="" class="charitable-settings-field"/>
					<div class="charitable-help">Enter the Expense Amount</div>
					</td>
				</tr>
				<tr>
					<th scope="row">Date</th>
					<td><input required type="date" id="datepicker" name="<?php echo "expense";?>[expense_date]" value="" class="charitable-settings-field" />
					<div class="charitable-help">Enter the date an expense was made</div>
					</td>
				</tr>
				<tr>
					<th scope="row">Select Appropriate Campaign</th>
					<td>
						<select required id="charitable_campaign_list" name="<?php echo "expense";?>[expense_campaign_id]" class="charitable-settings-field">
							<option value=""><?php _e('Select a Campaign', 'charitable-admin-exoenses'); ?></option>
							<?php
							foreach ($campaigns as $campaign) : ?>
							<option value="<?php echo $campaign['id'] ?>"><?php echo $campaign['title']; ?></option>
							<?php endforeach;
							?>
						</select>
						<div class="charitable-help">Choose an Activity for the expense made</div>
					</td>
				</tr>
				<tr>
					<th scope="row">Upload Receipt</th>
					<td>
					<img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' height='100'>
					<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
					<input type='hidden' name="<?php echo "expense";?>[expense_receipt_id]" id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
					<!--<input type="submit" name="submit_image_selector" value="Save" class="button-primary"> -->
			
					</td>
				</tr>
				
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Add Expense"></p>
	</form>
</div>
<div class="clear"></div>
<div id="expenses">
	<table class="charitable-creator-expenses table table-bordered" width="100%" style="border: 1px solid;">
		<thead>
			<tr><th colspan="5">Activities Expenses Overview</th></tr>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">Expense Title</th>
				<th scope="col">Expense Amount</th>
				<th scope="col">For the Acitvity</th>
				<th scope="col">Receipt</th>
				<th scope="col">Delete</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(!empty($expenses)) {
			foreach($expenses as $expense) :?>
			<?php
			$url = wp_get_attachment_url($expense->expense_receipt_id); 
			?>
			<input type="hidden" value="<?php echo $expense->expense_campaign_id; ?>" id="data_<?php echo $expense->expense_id;?>_campaign" />
			<input type="hidden" value="<?php echo $url; ?>" id="data_<?php echo $expense->expense_id;?>_receipt" />
			<tr id="data_<?php echo $expense->expense_id; ?>" style="text-align: center;">
				<td class="expense_date"><?php echo $expense->expense_date; ?></td>
				<td class="expense_title"><?php echo $expense->expense_title; ?></td>
				<td class="expense_amount"><?php echo $expense->expense_amount; ?></td>
				<td><?php echo get_the_title($expense->expense_campaign_id); ?></td>
				<td>
				<?php if(!empty($url)) {?>
				<a id='expense-receipt' target="_blank" href="<?php echo $url; ?>">Receipt</a>
				<?php } else {?>
				No Receipt
				<?php } ?>
				</td>
				<td>
				<button type="button" class="btn btn-xs btn-default command-delete" id="<?php echo $expense->expense_id; ?>"><i class="fa fa-remove"></i></button></td>
			</tr>
			<?php endforeach; 
			} else {
			?>
			<tr><td colspan="6" style="text-align:center;">No Expenses</td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>

 
