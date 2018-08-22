jQuery(document).ready(function() {
	var edit_window = jQuery("#editExpense").dialog({
	autoOpen: false,
	height: 600,
	width: 480,
	modal: true
	});

	$('.command-edit').on( "click", function(){
		var id = $(this).attr("id");
		openEditBox($(this).attr("id"));
	});
	
	function openEditBox(id) {
		edit_window = $('#editExpense').dialog({
			close: function() {
				edit_window.dialog( "close" );
			}
		});
		
		edit_id = id;
		$('input#expense_id').val(edit_id);
		var expense_title = $("#data_" + edit_id + " .expense_title").html();
		var expense_date = $("#data_" + edit_id + " .expense_date").html();
		var expense_amount = $("#data_" + edit_id + " .expense_amount").html();
		var expense_campaign_id = $("#data_" + edit_id + "_campaign").html();
		var expense_receipt_url = $("#data_" + edit_id + "_receipt").html();
		
		$('input#charitable_campaign_expense_title_edit').val(expense_title);
		$('input#charitable_campaign_expense_amount_edit').val(expense_amount);
		$('#datepicker_edit').datepicker();
		$('#txtDate').datepicker('setDate', expense_date);
		$('#image-preview-edit').attr('src', expense_receipt_url).css('width', 'auto');
		$('#charitable_campaign_list_edit').val(expense_campaign_id);
		
		edit_window.dialog("option","title","Edit Expense").dialog("open");
	}

	$('.command-delete').on("click", function() {
		var id = $(this).attr("id");
		if (confirm("Are you sure to delete selected expense row?")) {
			jQuery.ajax({
				'url': cae.ajaxurl,
				'data': {'action': 'remove_expense', 'expense_id': id},
				'dataType': 'json',
				'type': 'POST'
			}).done(function(data){
				if(!data.error) {
				$("#data_" + id).remove();
				}
			});
		}
	});
});