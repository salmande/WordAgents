"use strict";

// Class Definition
var WADForms = function() {
	
	var _handleResetForm = function(e) {
		
		var validation;
		var form = document.getElementById('kt_login_reset_form');
						
		if (form == null)
			return;
			
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			form,
			{
				fields: {
					password: {
						validators: {
							notEmpty: {
								message: 'The password is required'
							}
						}
					},
					cpassword: {
						validators: {
							notEmpty: {
								message: 'The password confirmation is required'
							},
							identical: {
								compare: function() {
									return form.querySelector('[name="password"]').value;
								},
								message: 'These passwords don\'t match. Please try again.'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),

					// Submit the form when all fields are valid
					defaultSubmit: new FormValidation.plugins.DefaultSubmit()
				}
			}
		);
	}
	
	var _handleProfileForm = function(e) {
				
		var validation;
		var form = document.getElementById('kt_profile_form');
		
		if (form == null)
			return;
		
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			form,
			{
				fields: {
					cpassword: {
						validators: {
							identical: {
								compare: function() {
									return form.querySelector('[name="password"]').value;
								},
								message: 'These passwords don\'t match. Please try again.'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),

					// Submit the form when all fields are valid
					defaultSubmit: new FormValidation.plugins.DefaultSubmit()
				}
			}
		);
	}
	
    // Public Functions
    return {
        // public functions
        init: function() {
            _handleResetForm();
            _handleProfileForm();
        }
    };
}();

var WAD_UsersListDatatable = function() {
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// Private functions
	
	// basic demo
	var _demo = function() {
		var datatable = $('#kt_datatable_users').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/users/datatable/all.php',
						timeout: 120000,
					},
				},
				pageSize: ORDERS_PER_PAGE, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,
			toolbar: {
				items: {
					pagination: {
						pageSizeSelect: ORDERS_PER_PAGE_DROPDOWN_arr,
					}
				}
			},
			
			search: {
				input: $('#kt_subheader_search_form'),
				delay: 400,
				key: 'generalSearch'
			},

			// columns definition
			columns: [
				{
					field: 'name',
					title: 'Name',
					width: 250,
					template: function(data) {
						var output = '';
						output = '<div class="">\
								<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a class="text-dark-75 text-hover-primary" href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'">' + data.name + '</a></div>\
								<a href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'" class="text-muted font-weight-bold text-hover-primary">' + data.email + '</a>\
								<br><span class="text-muted">Role: ' + data.role + '</span>';						
						if( data.sign_in_as_user )
						output += '<br><a href="'+BASE_URL+'/admin?action=sign_in_as_user_using_admin&user='+data.spp_id+'" class="">Sign in as user</a>';
					
						output += '</div></div>';
						
						return output;
					}
				}, {
					field: 'order_pending',
					title: '# of Orders Pending',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_pending;
					}
				}, {
					field: 'order_completed',
					title: '# of Orders Completed',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_completed;
					}
				}, {
					field: 'total_orders_rejected',
					title: '# of Orders Rejected',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_rejected;
					}
				}, {
					field: 'total_orders_missed',
					title: '# of Orders Missed',
					width: 100,
					textAlign: 'center',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_missed;
					}
				}, {
					field: 'pending_earnings',
					title: 'Pending Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.pending_earnings;
					}
				}, {
					field: 'total_earnings',
					title: 'Total Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_earnings;
					}
				}
				
			],
		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_WritersListDatatable = function() {
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	
	// Private functions

	// basic demo
	var _demo = function() {
		var datatable = $('#kt_datatable_writers').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/users/datatable/writers.php',
						timeout: 120000,
					},
				},
				pageSize: ORDERS_PER_PAGE, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,
			toolbar: {
				items: {
					pagination: {
						pageSizeSelect: ORDERS_PER_PAGE_DROPDOWN_arr,
					}
				}
			},
			
			search: {
				input: $('#kt_subheader_search_form'),
				delay: 400,
				key: 'generalSearch'
			},

			// columns definition
			columns: [
				{
					field: 'name',
					title: 'Name',
					width: 250,
					template: function(data) {
						var output = '';
						output = '<div class="">\
								<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a class="text-dark-75 text-hover-primary" href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'">' + data.name + '</a></div>\
								<a href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'" class="text-muted font-weight-bold text-hover-primary">' + data.email + '</a>';
						if( data.sign_in_as_user )
						output += '<br><a href="'+BASE_URL+'/admin?action=sign_in_as_user_using_admin&user='+data.spp_id+'" class="">Sign in as user</a>';
					
						output += '</div></div>';
						
						return output;
					}
				}, {
					field: 'order_pending',
					title: '# of Orders Pending',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_pending;
					}
				}, {
					field: 'order_completed',
					title: '# of Orders Completed',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_completed;
					}
				}, {
					field: 'total_orders_rejected',
					title: '# of Orders Rejected',
					width: 100,
					textAlign: 'center',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_rejected;
					}
				}, {
					field: 'total_orders_missed',
					title: '# of Orders Missed',
					width: 100,
					textAlign: 'center',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_missed;
					}
				}, {
					field: 'pending_earnings',
					title: 'Pending Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.pending_earnings;
					}
				}, {
					field: 'total_earnings',
					title: 'Total Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_earnings;
					}
				}
			],
		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_EditorsListDatatable = function() {
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	
	// Private functions

	// basic demo
	var _demo = function() {
		var datatable = $('#kt_datatable_editors').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/users/datatable/editors.php',
						timeout: 120000,
					},
				},
				pageSize: ORDERS_PER_PAGE, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,
			toolbar: {
				items: {
					pagination: {
						pageSizeSelect: ORDERS_PER_PAGE_DROPDOWN_arr,
					}
				}
			},
			
			search: {
				input: $('#kt_subheader_search_form'),
				delay: 400,
				key: 'generalSearch'
			},

			// columns definition
			columns: [
				{
					field: 'name',
					title: 'Name',
					width: 250,
					template: function(data) {
						var output = '';
						output = '<div class="">\
								<div class="text-dark-75 font-weight-bolder font-size-lg mb-0"><a class="text-dark-75 text-hover-primary" href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'">' + data.name + '</a></div>\
								<a href="'+BASE_URL+'/admin/users/edit/'+data.spp_id+'" class="text-muted font-weight-bold text-hover-primary">' + data.email + '</a>';
						if( data.sign_in_as_user )
						output += '<br><a href="'+BASE_URL+'/admin?action=sign_in_as_user_using_admin&user='+data.spp_id+'" class="">Sign in as user</a>';
					
						output += '</div></div>';
						
						return output;
					}
				}, {
					field: 'order_pending',
					title: '# of Orders Pending',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_pending;
					}
				}, {
					field: 'order_completed',
					title: '# of Orders Completed',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.order_completed;
					}
				}, {
					field: 'total_orders_rejected',
					title: '# of Orders Rejected',
					width: 100,
					textAlign: 'center',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_rejected;
					}
				}, {
					field: 'total_orders_missed',
					title: '# of Orders Missed',
					width: 100,
					textAlign: 'center',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_orders_missed;
					}
				}, {
					field: 'pending_earnings',
					title: 'Pending Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.pending_earnings;
					}
				}, {
					field: 'total_earnings',
					title: 'Total Earnings',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.total_earnings;
					}
				}
			],
		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_OrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/all.php',
						timeout: 120000,
					},
				},
				pageSize: ORDERS_PER_PAGE, // display 20 records per page
				serverPaging: true,
				serverFiltering: true,
				serverSorting: true,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false, // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,
			toolbar: {
				items: {
					pagination: {
						pageSizeSelect: ORDERS_PER_PAGE_DROPDOWN_arr,
					}
				}
			},
			
			search: {
				input: $('#kt_subheader_search_form'),
				delay: 400,
				key: 'generalSearch'
			},

			autowidth: false,
			// columns definition
			columns: [
				{
					field: 'order_id',
					title: 'Order#',
					width: 85,
					textAlign: 'center',
					template: function(data) {
						var output = '';
						output = wad_order_number_html(data.order_id);
						return output;
					}
				}, {
					field: 'order_words',
					title: 'Words Length',
					textAlign: 'center',
					width: 70,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 150,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'Expense',
					title: 'Expense',
					sortable: false,
					width: 60,
					textAlign: 'center',
					template: function(data) {
						return data.expense;
					}
				}, {
					field: 'date_due',
					title: 'Due Date',
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.date_due;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 60,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 60,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}, {
					field: 'Status',
					title: 'Status',
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.status;
					}
				}
			],
		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

jQuery(document).ready(function($){
	
	WADForms.init();
	
	// Writer claims order
	WAD_writer_claim_order();
	
	// Editor claims order
	WAD_editor_claim_order();
	
	WAD_order_details_popup();
	
	WAD_UsersListDatatable.init();
	WAD_WritersListDatatable.init();
	WAD_EditorsListDatatable.init();
	
	WAD_Admin_OrdersListDatatable.init();


	// Load Orders -  START
	function loadOrders(data){
	  $.ajax({
		url  : BASE_URL+"/ajax?"+data,
		type : "POST",
		cache: false,
		success:function(response){
			$("#orders").html(response);
			
			// Writer claims order
			WAD_writer_claim_order();

			// Editor claims order
			WAD_editor_claim_order();
			
			//Order details popup
			WAD_order_details_popup();
			
			// Tags dropdown
			$('.selectpicker').selectpicker();
		}
	  });
	}
	// loadOrders();

	// Pagination code
	$(document).on("click", ".wad-pagination .page", function(e){
		e.preventDefault();
		var data = $(this).attr("href");
		loadOrders(data);
	});
	
	jQuery(document).on("change", ".wad-pagination .select-per-page", function(e){
		jQuery('.loader-pagination').removeClass('hide');
		
		var data = jQuery('.pagination-form').serialize();
		loadOrders(data);
		
	});

	jQuery(document).on("click", ".wad-pagination .page", function(e){
		$('.loader-pagination').removeClass('hide');	
	});
	
	// END - Load Orders
	
	// When order details poup displayed
	$('.modal-order_details').on('shown.bs.modal', function() {
		// Remove event handlers
		// Popup elements of tinymce (link, image or source code ) was not working gettting focus even by clicking to the popup.
		$(document).off('focusin.modal');
	});
	
	// Team message tinymce editor
	tinymce.init({
		selector: '.tinymce.message-team',
		menubar: false,
		toolbar: ['bold italic strikethrough link formatselect blockquote bullist numlist code undo redo'],
		plugins : 'link code wordcount lists advlists',
	});
		
	//Signing out
	$(document).on("click", "#wad-signout", function(e){
		KTCookie.setCookie("wad_user_logged_in","", { path: "/" });
		KTCookie.setCookie("wad_user_logged_in_spp_id","", { path: "/" });
		
		location.href = BASE_URL+"/login";
	});
	
	// Writer Claim Order - START
	function WAD_writer_claim_order_ajax(data, $this_btn)
	{
		var order_id = $this_btn.data('order_id'),
			employee_id = $this_btn.data('employee_id'),
			action = $this_btn.data('action');
		
		$.ajax({
			url  : WAD_AJAX_URL,
			dataType: "json",
			data: {action: action, order_id: order_id, employee_id: employee_id, ajax: true},
			success:function(response){
				if( typeof response.result !== "undefined" )
				{
					if( response.result == 'claimed' )
					{
						location.href = BASE_URL+"/orders/working";
					}
					if( response.result == 'already_claimed' )
					{
						alert(response.msg);				
					}
				}
				$this_btn.removeClass('spinner spinner-right spinner-white'); 

			}
		});
	}

	function WAD_writer_claim_order()
	{
		$('.btn-writer-claim-order').each(function(e){
			$(this).on('click',function(e){
				e.preventDefault();
				var $this_btn = $(this),
					data = $this_btn.attr("href");
				
				$this_btn.addClass('disabled');
				$this_btn.addClass('spinner spinner-right spinner-white');
				WAD_writer_claim_order_ajax(data, $this_btn);
			});
		});
	}
	// END - Writer Claim Order
	
	// Editor Claim Order - START
	function WAD_editor_claim_order_ajax(data, $this_btn)
	{
		var order_id = $this_btn.data('order_id'),
			employee_id = $this_btn.data('employee_id'),
			action = $this_btn.data('action');
		
		$.ajax({
			url  : WAD_AJAX_URL,
			dataType: "json",
			data: {action: action, order_id: order_id, employee_id: employee_id, ajax: true},
			success:function(response){
				if( typeof response.result !== "undefined" )
				{
					if( response.result == 'claimed' )
					{
						location.href = BASE_URL+"/orders/editing";
					}
					if( response.result == 'already_claimed' || response.result == 'status_changed_through_SPP' )
					{
						alert(response.msg);				
					}
				}
				$this_btn.removeClass('spinner spinner-right spinner-white');

			}
		});
	}

	function WAD_editor_claim_order()
	{
		$('.btn-editor-claim-order').each(function(e){
			$(this).on('click',function(e){
				e.preventDefault();
				var $this_btn = $(this),
					data = $this_btn.attr("href");
				
				$this_btn.addClass('disabled');
				$this_btn.addClass('spinner spinner-right spinner-white');
				WAD_editor_claim_order_ajax(data, $this_btn);
			});
		});
	}
	// END - Editor Claim Order
	
	// Order details Modal - START
	
	function WAD_order_details_popup()
	{
		$('.order-details-trigger').click(function(){
		
			$('.modal-order_details-loader').addClass('d-flex');
			$('.modal-order_details-loader').removeClass('d-none');
			
			var order_id = $(this).data('order_id'),
				current_page_url = $('#wad-current-page-url').text();

			// AJAX request
			$.ajax({
				url  : BASE_URL+"/ajax?action=order_details_modal_content_ajax",
				type: 'post',
				data: {order_id: order_id, current_page_url: current_page_url},
				success: function(response){
					
					$('.modal-order_details-loader').addClass('d-none');
					$('.modal-order_details-loader').removeClass('d-flex');
					
					// Add response in Modal body
					$('#modal-order-details .modal-body').html(response);

					// Display Modal
					$('#modal-order-details').modal('show');	
					
					// Tags dropdown
					$('.selectpicker').selectpicker();
					
					// Team message tinymce editor
					tinymce.init({
						selector: '.tinymce.message-team',
						menubar: false,
						toolbar: ['bold italic strikethrough link formatselect blockquote bullist numlist code undo redo'],
						plugins : 'link code wordcount lists advlists',
					});
									
					$('.btn-send-message').on('click',function(event){
						var $this_btn = $(this);
						$this_btn.addClass('disabled');
						$this_btn.addClass('spinner spinner-right spinner-white');
						
						console.log(event);
					});
					
					//Remove tag
					$('.tag-delete').each(function(){
						var $this_btn = $(this);
						$this_btn.on('click',function(e){
							$this_btn.addClass('disabled active');
							$this_btn.addClass('spinner spinner-right');
							$this_btn.closest('form').submit();
							// e.preventDefault();
						});
					});
					
					$(".form-add-tag").submit(function(event) {
						var $this_form = $(this),
							$this_btn = $this_form.find('.btn-add-tag');
						$this_btn.addClass('disabled');
						$this_btn.attr("disabled", true);
						$this_btn.addClass('spinner spinner-right spinner-white');
					});
					
				}
			});
		});

	}
	// END - Order details Modal	
	
	jQuery(document).ajaxComplete(function(event, xhr, settings){
		// Team message tinymce editor
		tinymce.init({
			selector: '.tinymce.message-team',
			menubar: false,
			toolbar: ['bold italic strikethrough link formatselect blockquote bullist numlist code undo redo'],
			plugins : 'link code wordcount lists advlists',
		});
		
		wadStopTimerTriggerElements();
		
		WAD_order_details_popup();
		
	});
	
	
	//Toggle Mobile Menu
	new KTOffcanvas(KTUtil.getById("kt_header_navs"), {
		overlay: true,
		baseClass: 'header-navs',
		closeBy: 'kt_header_mobile_close',
		placement: 'right',
		toggleBy: {
			target: 'kt_header_mobile_toggle',
			state: 'burge-icon-active'
		}
	});
	
	// Select all writers - Report admin side
	$('.select_all_writers').change(function(){
		if(this.checked == false){ 
			$(".checkbox-writer").prop('checked',false);
		}
		
		if(this.checked == true){ 
			$(".checkbox-writer").prop('checked',true);
		}
	});
	
	// Select all editors - Report admin side
	$('.select_all_editors').change(function(){
		if(this.checked == false){ 
			$(".checkbox-editor").prop('checked',false);
		}
		
		if(this.checked == true){ 
			$(".checkbox-editor").prop('checked',true);
		}
	});
	
	$('.writer-confirm-submit_working_order, .editor-confirm-submit_editing_order, .writer-submit_revision_order').on('click',function(){
		var $this_btn = $(this);
		$this_btn.addClass('disabled');
		$this_btn.addClass('spinner spinner-right spinner-white');
	});	
	

	$('.btn-submit-editor-request_revision_editing_order').on('click',function(e){
		var $this_btn = $(this);
		$this_btn.addClass('disabled');
		$this_btn.attr("disabled", true);
		$this_btn.addClass('spinner spinner-right spinner-white');
		$this_btn.closest('form').submit();
	});	

	
	$(window).click(function(event){
		var target_class = event.target.className;
		if( target_class != 'popover-body' && target_class != 'popover-need-help-trigger' ){
			$('.popover-need-help').popover('hide');
		}
	});
	 
	
	  // range picker
	  $('#kt_datepicker_5').datepicker({
	   rtl: KTUtil.isRTL(),
	   todayHighlight: true,
	   templates: arrows
	  });

	
});

function wad_order_number_html(order_id){
	return '<a href="https://app.wordagents.com/orders/'+order_id+'" target="_blank">'+order_id+'</a>';
}

// Auto Refresh page after some time i.e. 60 seconds
var timer = null;
// As soon as the document is ready:
jQuery(document).ready(function() {
	
   var url = window.location.href
   // Activate the timer:
   if( url.includes("orders") || url.includes("order")  ){
		//wadStartTimer();
		//wadStopTimerTriggerElements();
   }
});

function wadStopTimerTriggerElements(){
   
   $('.order-details-trigger').click(function(){
	   var id = "#modal-order-details";
	  
	   // And, when the user opens order details popup, start over
		$(id).on('show.bs.modal', function (e) {
		  // Stop the previously running timer
		  clearInterval(timer);
		})

		$(id).on('hide.bs.modal', function (e) {
		  // Start the clock over again:
		  wadStartTimer();
		})
   });
   
	$('.modal-request_revision-trigger').each(function(){
	   var id = $(this).attr('data-target');
	   // And, when the user opens order details popup, start over
		$(id).on('show.bs.modal', function (e) {
		  // Stop the previously running timer
		  clearInterval(timer);
		})

		$(id).on('hide.bs.modal', function (e) {
		  // Start the clock over again:
		  wadStartTimer();
		})
   });
   
	$(document).on("click", ".wad-pagination .page, .datatable-pager-link", function(e){
		clearInterval(timer);	   
	});
}

function wadStartTimer(){
	// Get the time to stop the effect
	var stopTime = new Date();
	stopTime.setSeconds(stopTime.getSeconds() + 60);

	// Get a reference to the timer so it can be cancelled later
	timer = setInterval(function()
	{
		// Check to see if the timer should stop
		var currentTime = new Date();
	
		if(currentTime >= stopTime){
			location.reload();
		}
	}, 60000);
}

// END - Auto Refresh page after some time