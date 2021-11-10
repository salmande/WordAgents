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
					field: 'name_column',
					title: 'Name',
					width: 250,
					sortable: false,
					template: function(data) {
						return data.name_column;
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
					field: 'name_column',
					title: 'Name',
					width: 250,
					sortable: false,
					template: function(data) {
						return data.name_column;
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

		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_AssignersListDatatable = function() {
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	
	// Private functions

	// basic demo
	var _demo = function() {
		var datatable = $('#kt_datatable_assigners').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/users/datatable/assigners.php',
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
					field: 'name_column',
					title: 'Name',
					width: 250,
					sortable: false,
					template: function(data) {
						return data.name_column;
					}
				}
			],
		});

		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();


var WAD_AdminsListDatatable = function() {
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	
	// Private functions

	// basic demo
	var _demo = function() {
		var datatable = $('#kt_datatable_admins').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/users/datatable/admins.php',
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
					field: 'name_column',
					title: 'Name',
					width: 250,
					sortable: false,
					template: function(data) {
						return data.name_column;
					}
				}
			],
		});

		
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
					field: 'name_column',
					title: 'Name',
					width: 250,
					sortable: false,
					template: function(data) {
						return data.name_column;
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
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/all.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
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

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_NewOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var assign_writer_new_order = function(datatable){
		$(".form-assign-writer-new-order").submit(function(event) 
		{
			event.preventDefault();
			var $this_form = $(this),
				$this_btn = $this_form.find('.btn-assign-writer-new-order');
			$this_btn.addClass('disabled');
			$this_btn.attr("disabled", true);
			$this_btn.addClass('spinner spinner-right spinner-white');
			
			var formdata = $($this_form).serializeArray().reduce(function(obj, item) {
				obj[item.name] = item.value;
				return obj;
			}, {});
			
			var employee_id = formdata.employee_id,
				action = formdata.action,
				order_id = formdata.order_id;
			
			$.ajax({
				url : WAD_AJAX_URL,
				dataType: "json",
				data: {action: action, order_id: order_id, employee_id: employee_id, ajax: true },
				success:function(response){
					if( typeof response.result !== "undefined" )
					{
						if( response.result == 'writer_assigned' )
						{
							$.notify({
								message: 'Writer assigned and changed status to Working',
							},{
								// settings
								type: 'success',
								animate: {
									enter: 'animate__animated animate__fadeInDown',
									exit: 'animate__animated animate__fadeOutUp'
								},
								delay: 3000
							});
							
							if( response.result == 'already_claimed' )
							{
								$.notify({
									message: response.msg,
								},{
									// settings
									type: 'info',
									animate: {
										enter: 'animate__animated animate__fadeInDown',
										exit: 'animate__animated animate__fadeOutUp'
									},
									delay: 3000
								});			
							}
							
							datatable.reload()
							
							// location.href = BASE_URL+"/admin/orders/new";
						}
					}
				}
			});
			
			
		});
	};
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_new_orders').KTDatatable({

			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/new.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 250,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'pay_rate',
					title: 'Pay Rate',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.pay_rate;
					}
				}, {
					field: 'due_in',
					title: 'Due In',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.due_in;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 200,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						// $('.dropdown-writers').selectpicker();
						return data.assigned_writers;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
		$(datatable).on('datatable-on-layout-updated',function(e, settings, json){
			$('.dropdown-writers').selectpicker({
				"container": 'html'
			});
			assign_writer_new_order(datatable);
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_WorkingOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var assign_writer_working_order = function(datatable){
		$(".form-assign-writer-working-order").submit(function(event) 
		{
			event.preventDefault();
			var $this_form = $(this),
				$this_btn = $this_form.find('.btn-assign-writer-working-order'),
				$employee_old_id_input = $this_form.find("input[name=employee_old_id"),
				$writer_name_elem = $this_form.next('.writers-name'),
				$change_writer_trigger = $writer_name_elem.next();
				
			$this_btn.addClass('disabled');
			$this_btn.attr("disabled", true);
			$this_btn.addClass('spinner spinner-right spinner-white');
			
			var formdata = $($this_form).serializeArray().reduce(function(obj, item) {
				obj[item.name] = item.value;
				return obj;
			}, {});
			
			var employee_id = formdata.employee_id,
				action = formdata.action,
				order_id = formdata.order_id,
				employee_old_id = formdata.employee_old_id;
			
			$.ajax({
				url : WAD_AJAX_URL,
				dataType: "json",
				data: {action: action, order_id: order_id, employee_id: employee_id, employee_old_id: employee_old_id, ajax: true },
				success:function(response){
					if( typeof response.result !== "undefined" )
					{
						if( response.result=='writer_assigned' )
						{
							var writer_name = response.writer_name,
								employee_old_id = response.employee_old_id;
							
							$employee_old_id_input.val(employee_old_id);
							$writer_name_elem.html(writer_name);
							
							$this_form.addClass('d-none');
							$writer_name_elem.removeClass('d-none');
							$change_writer_trigger.removeClass('d-none');
							
							$this_btn.removeClass('disabled');
							$this_btn.attr("disabled", false);
							$this_btn.removeClass('spinner spinner-right spinner-white');
							
							$.notify({
								message: 'Writer Assigned',
							},{
								// settings
								type: 'success',
								animate: {
									enter: 'animate__animated animate__fadeInDown',
									exit: 'animate__animated animate__fadeOutUp'
								},
								delay: 3000
							});
							
							// datatable.reload()
							
						}
						// location.href = BASE_URL+"/admin/orders/new";
					}else{
						alert('Something wrong or order not available in SPP');
					}
				}
			});
			
			
		});
	};
	
	var change_writer_trigger = function(){
		$(".change-writer-trigger").on('click',function(event) 
		{
			var $this_ = $(this);
			$this_.addClass("d-none"); 
			$this_.prev().addClass("d-none"); // Writer name
			$this_.prev().prev().removeClass('d-none'); // Writers dropdown
			
			
		});
	};
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_working_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/working.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'pay_rate',
					title: 'Pay Rate',
					width: 60,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.pay_rate;
					}
				}, {
					field: 'due_in',
					title: 'Due In',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.due_in;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 200,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}/* , {
					field: 'Editor',
					title: 'Editor',
					width: 110,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				} */
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
		$(datatable).on('datatable-on-layout-updated',function(e, settings, json){
			$('.dropdown-writers').selectpicker({
				"container": 'html'
			});
			change_writer_trigger();
			assign_writer_working_order(datatable);
		});
		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_ReadyToEditOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var assign_editor_readyToEdit_order = function(datatable){
		$(".form-assign-editor-readyToEdit-order").submit(function(event) 
		{
			event.preventDefault();
			var $this_form = $(this),
				$this_btn = $this_form.find('.btn-assign-editor-readyToEdit-order');
			$this_btn.addClass('disabled');
			$this_btn.attr("disabled", true);
			$this_btn.addClass('spinner spinner-right spinner-white');
			
			var formdata = $($this_form).serializeArray().reduce(function(obj, item) {
				obj[item.name] = item.value;
				return obj;
			}, {});
			
			var employee_id = formdata.employee_id,
				action = formdata.action,
				order_id = formdata.order_id;
			
			$.ajax({
				url : WAD_AJAX_URL,
				dataType: "json",
				data: {action: action, order_id: order_id, employee_id: employee_id, ajax: true },
				success:function(response){
					if( typeof response.result !== "undefined" )
					{
						if( response.result == 'editor_assigned' )
						{
							$.notify({
								message: response.msg,
							},{
								// settings
								type: 'success',
								animate: {
									enter: 'animate__animated animate__fadeInDown',
									exit: 'animate__animated animate__fadeOutUp'
								},
								delay: 3000
							});
						}
						
						if( response.result == 'already_claimed' )
						{
							$.notify({
								message: response.msg,
							},{
								// settings
								type: 'info',
								animate: {
									enter: 'animate__animated animate__fadeInDown',
									exit: 'animate__animated animate__fadeOutUp'
								},
								delay: 3000
							});			
						}
						
						datatable.reload()
					}
				}
			});
			
			
		});
	};
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_readyToEdit_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/ready_to_edit.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'due_in',
					title: 'Due In',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.due_in;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 110,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 200,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
		$(datatable).on('datatable-on-layout-updated',function(e, settings, json){
			$('.dropdown-editors').selectpicker({
				"container": 'html'
			});
			assign_editor_readyToEdit_order(datatable);
		});
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_EditingOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_editing_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/editing.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'due_in',
					title: 'Due In',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.due_in;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 110,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 110,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_EditorRevisionOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_editorRevision_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/editor_revision.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 110,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 110,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_CompleteOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_complete_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/complete.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 110,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 110,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_RevisionOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_revision_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/revision.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 155,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 155,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}
			],
		});

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_OverdueOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_overdue_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/overdue.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 90,
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
					width: 60,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 210,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 80,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}, {
					field: 'Overdue',
					title: 'overdue',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.overdue;
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

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)	
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_StuckOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		
		var missing_doc_link = ( $('#missing_doc_link').is(':checked') ) ? 1 : 0;
		
		var datatable = $('#wad_admin_datatable_stuck_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/orders/datatable/stuck.php',
						timeout: 120000,
						params: {
						  missing_doc_link: missing_doc_link
						},
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
					width: 90,
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
					width: 60,
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
					field: 'doc_link',
					title: 'Document Link',
					width: 80,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Writer',
					title: 'Writer',
					width: 70,
					sortable: false,
					textAlign: 'center',
					template: function(data) {
						return data.assigned_writers;
					}
				}, {
					field: 'Editor',
					title: 'Editor',
					width: 70,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.assigned_editors;
					}
				}, {
					field: 'Reason',
					title: 'reason',
					width: 80,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.reason;
					}
				}, {
					field: 'Overdue',
					title: 'overdue',
					width: 100,
					textAlign: 'center',
					sortable: false,
					template: function(data) {
						return data.overdue;
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

		missing_doc_link = datatable.getDataSourceParam("missing_doc_link");
		if( missing_doc_link ){
			$('#missing_doc_link').prop('checked',missing_doc_link);
		}
		$('#missing_doc_link').on('change', function() {
			var missing_doc_link = (this.checked) ? 1 : 0;
			datatable.setDataSourceParam('missing_doc_link', missing_doc_link)	
			datatable.reload();
		});
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_UserOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var columns = [
		{
			field: 'order_id',
			title: 'Order#',
			width: 100,
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
			width: 80,
			template: function(data) {
				return data.order_words;
			}
		}, {
			field: 'article_info',
			title: 'Article Info',
			width: 400,
			sortable: false,
			template: function(data) {
				return data.article_info;
			}
		}
	];
	
	var user_role = $('#user-role').html();
	
	if( user_role == 'Writer' ){
		var columns2 = [
			{
				field: 'pay_rate',
				title: 'Pay Rate',
				textAlign: 'center',
				width: 70,
				sortable: false,
				template: function(data) {
					return data.pay_rate;
				}
			}
		];
		var columns = $.merge(columns,columns2);
	}
	
	var columns2 = [
		{
			field: 'doc_link',
			title: 'Document Link',
			width: 80,
			textAlign: 'center',
			sortable: false,
			template: function(data) {
				return data.doc_link;
			}
		}, {
			field: 'Status',
			title: 'Status',
			textAlign: 'center',
			width: 120,
			sortable: false,
			template: function(data) {
				return data.status;
			}
		}
	];
	
	var columns = $.merge(columns,columns2);
	
	// basic demo
	var _demo = function() {
		
		var datatable = $('#wad_admin_datatable_user_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/all.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
			columns: columns,
		});

	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_UserWorkingOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_user_working_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/working.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
					width: 100,
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
					width: 80,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 170,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'pay_rate',
					title: 'Pay Rate',
					textAlign: 'center',
					width: 70,
					sortable: false,
					template: function(data) {
						return data.pay_rate;
					}
				}, {
					field: 'due_in',
					title: 'Due In',
					sortable: false,
					textAlign: 'center',
					width: 100,
					template: function(data) {
						return data.due_in;
					}
				}, {
					field: 'date_due',
					title: 'Due Date',
					sortable: false,
					textAlign: 'center',
					width: 100,
					template: function(data) {
						return data.date_due;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					textAlign: 'center',
					width: 100,
					sortable: false,
					template: function(data) {
						return data.doc_link;
					}
				}, {
					field: 'Status',
					title: 'Status',
					textAlign: 'center',
					width: 120,
					sortable: false,
					template: function(data) {
						return data.status;
					}
				}
			],
		});

		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();


var WAD_Admin_UserEditingOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var user_role = $('#user-role').html();
		
	if( user_role == 'Writer' )
	{
		var columns = [
					{
						field: 'order_id',
						title: 'Order#',
						width: 100,
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
						width: 80,
						template: function(data) {
							return data.order_words;
						}
					}, {
						field: 'article_info',
						title: 'Article Info',
						width: 350,
						sortable: false,
						template: function(data) {
							return data.article_info;
						}
					}, {
						field: 'pay_rate',
						title: 'Pay Rate',
						textAlign: 'center',
						width: 70,
						sortable: false,
						template: function(data) {
							return data.pay_rate;
						}
					}, {
						field: 'doc_link',
						title: 'Document Link',
						textAlign: 'center',
						width: 100,
						sortable: false,
						template: function(data) {
							return data.doc_link;
						}
					}, {
						field: 'Status',
						title: 'Status',
						textAlign: 'center',
						width: 120,
						sortable: false,
						template: function(data) {
							return data.status;
						}
					}
				];		
	}
	
	if( user_role == 'Editor' )
	{
		var columns = [
					{
						field: 'order_id',
						title: 'Order#',
						width: 100,
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
						width: 80,
						template: function(data) {
							return data.order_words;
						}
					}, {
						field: 'article_info',
						title: 'Article Info',
						width: 350,
						sortable: false,
						template: function(data) {
							return data.article_info;
						}
					}, {
						field: 'due_in',
						title: 'Due In',
						textAlign: 'center',
						width: 70,
						sortable: false,
						template: function(data) {
							return data.due_in;
						}
					}, {
						field: 'doc_link',
						title: 'Document Link',
						textAlign: 'center',
						width: 100,
						sortable: false,
						template: function(data) {
							return data.doc_link;
						}
					}, {
						field: 'Status',
						title: 'Status',
						textAlign: 'center',
						width: 120,
						sortable: false,
						template: function(data) {
							return data.status;
						}
					}
				];	
	}
		
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_user_editing_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/editing.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
			columns: columns
		});

		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_UserEditorRevisionOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var user_role = $('#user-role').html();
	
	if( user_role == 'Writer' )
	{
		var columns = [
				{
					field: 'order_id',
					title: 'Order#',
					width: 100,
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
					width: 80,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 570,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'pay_rate',
					title: 'Pay Rate',
					textAlign: 'center',
					width: 70,
					sortable: false,
					template: function(data) {
						return data.pay_rate;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					textAlign: 'center',
					width: 100,
					sortable: false,
					template: function(data) {
						return data.doc_link;
					}
				}
			];
	}
	
	if( user_role == 'Editor' )
	{
		var columns = [
				{
					field: 'order_id',
					title: 'Order#',
					width: 100,
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
					width: 80,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 570,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					textAlign: 'center',
					width: 100,
					sortable: false,
					template: function(data) {
						return data.doc_link;
					}
				}
			];
	}
	
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_user_editor_revision_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/editor_revisions.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
			columns: columns
		});

		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_UserRevisionOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var user_role = $('#user-role').html();
	
	if( user_role == 'Writer' )
	{
		var columns = [
				{
					field: 'order_id',
					title: 'Order#',
					width: 100,
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
					width: 80,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 570,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'pay_rate',
					title: 'Pay Rate',
					textAlign: 'center',
					width: 70,
					sortable: false,
					template: function(data) {
						return data.pay_rate;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					textAlign: 'center',
					width: 100,
					sortable: false,
					template: function(data) {
						return data.doc_link;
					}
				}
			];
	}
	
	if( user_role == 'Editor' )
	{
		var columns = [
				{
					field: 'order_id',
					title: 'Order#',
					width: 100,
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
					width: 80,
					template: function(data) {
						return data.order_words;
					}
				}, {
					field: 'article_info',
					title: 'Article Info',
					width: 570,
					sortable: false,
					template: function(data) {
						return data.article_info;
					}
				}, {
					field: 'doc_link',
					title: 'Document Link',
					textAlign: 'center',
					width: 100,
					sortable: false,
					template: function(data) {
						return data.doc_link;
					}
				}
			];
	}
	
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_user_revision_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/revision.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
			columns: columns
		});

		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

var WAD_Admin_UserCompleteOrdersListDatatable = function() {
	// Private functions
	
	var ORDERS_PER_PAGE_DROPDOWN_arr = ORDERS_PER_PAGE_DROPDOWN.split(",").map(function(item) {
	  return item.trim();
	});
	
	var user_role = $('#user-role').html();
	
	if( user_role == 'Writer' )
	{
		var columns = [
					{
						field: 'order_id',
						title: 'Order#',
						width: 100,
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
						width: 80,
						template: function(data) {
							return data.order_words;
						}
					}, {
						field: 'article_info',
						title: 'Article Info',
						width: 250,
						sortable: false,
						template: function(data) {
							return data.article_info;
						}
					}, {
						field: 'pay_rate',
						title: 'Pay Rate',
						textAlign: 'center',
						width: 70,
						sortable: false,
						template: function(data) {
							return data.pay_rate;
						}
					}, {
						field: 'earning',
						title: 'Earning',
						textAlign: 'center',
						width: 70,
						sortable: false,
						template: function(data) {
							return data.earning;
						}
					}, {
						field: 'doc_link',
						title: 'Document Link',
						width: 80,
						textAlign: 'center',
						sortable: false,
						template: function(data) {
							return data.doc_link;
						}
					}, {
						field: 'Status',
						title: 'Status',
						textAlign: 'center',
						width: 120,
						sortable: false,
						template: function(data) {
							return data.status;
						}
					}
				];
	}
	
	if( user_role == 'Editor' )
	{
		var columns = [
					{
						field: 'order_id',
						title: 'Order#',
						width: 100,
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
						width: 80,
						template: function(data) {
							return data.order_words;
						}
					}, {
						field: 'article_info',
						title: 'Article Info',
						width: 400,
						sortable: false,
						template: function(data) {
							return data.article_info;
						}
					}, {
						field: 'doc_link',
						title: 'Document Link',
						width: 80,
						textAlign: 'center',
						sortable: false,
						template: function(data) {
							return data.doc_link;
						}
					}, {
						field: 'Status',
						title: 'Status',
						textAlign: 'center',
						width: 120,
						sortable: false,
						template: function(data) {
							return data.status;
						}
					}
				];
	}
	
	// basic demo
	var _demo = function() {
		var datatable = $('#wad_admin_datatable_user_complete_orders').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: BASE_URL + '/parts/admin/user/orders/datatable/complete.php',
						timeout: 120000,
						params: {
						  user_spp_id: $('#user-spp-id').html()
						},
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
			columns: columns
		});

		
		
	};

	return {
		// public functions
		init: function() {
			_demo();
		},
	};
}();

jQuery(document).ready(function($){
	
	var $loading_content_wrapper = $('.loading-content-wrapper');
	$loading_content_wrapper.children('.loading').remove();
	$loading_content_wrapper.children('.loading-content').removeClass('hide');

	WADForms.init();
	
	// Writer claims order
	WAD_writer_claim_order();
	
	// Editor claims order
	WAD_editor_claim_order();
	
	WAD_order_details_popup();
	WAD_order_complete_popup();
	
	if( $('#kt_datatable_users').length )
	WAD_UsersListDatatable.init();

	if( $('#kt_datatable_writers').length )
	WAD_WritersListDatatable.init();

	if( $('#kt_datatable_assigners').length )
	WAD_AssignersListDatatable.init();

	if( $('#kt_datatable_admins').length )
	WAD_AdminsListDatatable.init();

	if( $('#kt_datatable_editors').length )
	WAD_EditorsListDatatable.init();
	
	if( $('#wad_admin_datatable_orders').length )
	WAD_Admin_OrdersListDatatable.init();

	if( $('#wad_admin_datatable_new_orders').length )
	WAD_Admin_NewOrdersListDatatable.init();

	if( $('#wad_admin_datatable_working_orders').length )
	WAD_Admin_WorkingOrdersListDatatable.init();

	if( $('#wad_admin_datatable_readyToEdit_orders').length )
	WAD_Admin_ReadyToEditOrdersListDatatable.init();

	if( $('#wad_admin_datatable_editing_orders').length )
	WAD_Admin_EditingOrdersListDatatable.init();

	if( $('#wad_admin_datatable_editorRevision_orders').length )
	WAD_Admin_EditorRevisionOrdersListDatatable.init();

	if( $('#wad_admin_datatable_complete_orders').length )
	WAD_Admin_CompleteOrdersListDatatable.init();

	if( $('#wad_admin_datatable_revision_orders').length )
	WAD_Admin_RevisionOrdersListDatatable.init();

	if( $('#wad_admin_datatable_overdue_orders').length )
	WAD_Admin_OverdueOrdersListDatatable.init();

	if( $('#wad_admin_datatable_stuck_orders').length )
	WAD_Admin_StuckOrdersListDatatable.init();
	
	if( $('#wad_admin_datatable_user_orders').length )
	WAD_Admin_UserOrdersListDatatable.init();
	
	
	$( '[data-target="#user_all_orders_tab"]').on('click',function(){
		WAD_Admin_UserOrdersListDatatable.init();
	});
	
	$( '[data-target="#user_working_orders_tab"]').on('click',function(){
		WAD_Admin_UserWorkingOrdersListDatatable.init();
	});
	
	$( '[data-target="#user_editing_orders_tab"]').on('click',function(){
		WAD_Admin_UserEditingOrdersListDatatable.init();
	});
	
	$( '[data-target="#user_editor_revision_orders_tab"]').on('click',function(){
		WAD_Admin_UserEditorRevisionOrdersListDatatable.init();
	});
	
	$( '[data-target="#user_revision_orders_tab"]').on('click',function(){
		WAD_Admin_UserRevisionOrdersListDatatable.init();
	});
	
	$( '[data-target="#user_complete_orders_tab"]').on('click',function(){
		WAD_Admin_UserCompleteOrdersListDatatable.init();
	});
	
	
	
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
			
			WAD_order_complete_popup();
			
			$('body').tooltip({selector: '[data-toggle="tooltip"]'});
		}
	  });
	}
	// loadOrders();

	// Pagination code
	$(document).on("click", ".wad-pagination .page", function(e){
		
		$('.loader-pagination, .loading').removeClass('hide');
		
		e.preventDefault();
		
		var absurl = $('#wad-current-page-url').html(),
			action = absurl.split("/").join("-"),
			page = $(this).attr("data-page"),
			per_page = $(this).attr("data-per_page"),
			data = 'page='+page+'&per_page='+per_page+'&action='+action;
			
			
		var $form = $('.form-'+action);
		
		if($form.length ){
			$form.find('input[name=page]').val(page);
			$form.submit();
			
		}else{
			loadOrders(data);
		}		
	});
	
	jQuery(document).on("change", ".wad-pagination .select-per-page", function(e){
		
		jQuery('.loader-pagination, .loading').removeClass('hide');
		
		var absurl = $('#wad-current-page-url').html(),
			action = absurl.split("/").join("-");

		$(this).closest('form').find("input[name=action]").val(action);
		
		var data = jQuery('.pagination-form').serialize(),
			$form = $('.form-'+action);
		
		if($form.length ){
			var per_page = $(this).val();
			$form.find('input[name=page]').val(1);
			$form.find('input[name=per_page]').val(per_page);
			$form.submit();
			
		}else{
			loadOrders(data);
		}
	});

	jQuery(document).on("click", ".wad-pagination .page", function(e){
		// $('.loader-pagination, .loading').removeClass('hide');	
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
	
	function WAD_order_complete_popup()
	{
		$('.order-complete-trigger').click(function(){
		
			$('.modal-order_complete-loader').addClass('d-flex');
			$('.modal-order_complete-loader').removeClass('d-none');
			
			
			var order_id = $(this).data('order_id'),
				current_page_url = $('#wad-current-page-url').text();

			// AJAX request
			$.ajax({
				url  : BASE_URL+"/ajax?action=order_complete_modal_content_ajax",
				type: 'post',
				data: {order_id: order_id, current_page_url: current_page_url},
				success: function(response)
				{
					console.log(response);
					$('.modal-order_complete-loader').addClass('d-none');
					$('.modal-order_complete-loader').removeClass('d-flex');
					
					// Add response in Modal body
					$('#modal-order-complete .modal-body').html(response);

					// Display Modal
					$('#modal-order-complete').modal('show');	
					
				}
			});
		});
	}
	
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
	
	$('.writer-confirm-submit_working_order, .writer-submit_revision_order').on('click',function(){
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
	
	$('.btn-editor-confirm-submit_editing_order').on('click',function(e){
		e.preventDefault();
		var $this_btn = $(this);
		$this_btn.addClass('disabled');
		$this_btn.attr("disabled", true);
		$this_btn.addClass('spinner spinner-right spinner-white');
		var template_selected = $('input[name=order_complete_client_email_template]:checked', '#frm-order-complete').val();
		var template = "ORDER_COMPLETE_CLIENT_EMAIL_TEMPLATE_"+template_selected;
		if (confirm('Are you sure you want send with template '+window[template])) {
			// Send!
			$this_btn.closest('form').submit();
		} else {
			// Do nothing!
			$this_btn.removeClass('disabled');
			$this_btn.removeClass('spinner spinner-right spinner-white');
			$this_btn.prop('disabled',false);
		} 
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
	});
	
	
	if( $('.form-orders').length )
	{
		$('.form-orders').each(function()
		{
			var $form = $(this);
		
			$form.on('submit',function(e){
				e.preventDefault();
				var $this_form = $(this);
				orders_form_submit($this_form)	
			});
		});
	}
	
	function orders_form_submit($this_form)
	{
		var formdata = $this_form.serialize(),
			action = $this_form.attr('action');
				
		$.ajax({
			url  : BASE_URL+"/ajax?action="+action,
			data: formdata,
			type : "POST",
			cache: false,
			success:function(response)
			{
				$("#"+action).html(response);
			}
		});
	}
	
	if( $('[name=seach_in_orders]').length )
	{
		$('[name=seach_in_orders]').each(function()
		{
			$(this).on('keyup',function()
			{
				var $form = $(this).closest("form");
				$form.find('[name=page]').val(1);
				$form.submit();
			});
		});
	}
	
	if( $('[data-stats]').length )
	{
		$('[data-stats]').each(function()
		{
			var stats = $(this).attr('data-stats'),
				$form = $('.form-'+stats),
				$content_wraper = $('.content-'+stats+'-wrapper');
		
			$form.on('submit',function(e){
				e.preventDefault();
				var $this_form = $(this);
				stats_form_submit($this_form, stats, $content_wraper)	
			});
			
			$content_wraper.find('.dropdown-export .navi-link').on('click',function(){
				var $this_option = $(this);
				stats_export($this_option, stats, $content_wraper);
			});
			
		});
	}

	function stats_form_submit($this_form, stats, $content_wraper)
	{
		$this_form.find('[type=submit]').addClass('disabled').attr("disabled", true);
		$content_wraper.find('.loading').removeClass('hide');
				
		var formdata = $this_form.serialize(),
			action = $this_form.attr('action');
		$.ajax({
			url  : BASE_URL+"/ajax?action="+action,
			data: formdata,
			type : "POST",
			cache: false,
			success:function(response)
			{
				var export_val = $this_form.find('input[name=export]').val();
				if( export_val=='all'){
					var export_file_link = response;
					if($('#stats-export-file').length){
						$('#stats-export-file').attr('href',export_file_link);
					}else{
						$('body').append('<a id="stats-export-file" href="'+export_file_link+'"></a>');
					}
					$('#stats-export-file').get(0).click();
					$('.blockElement.loading').addClass('hide');
					
					$content_wraper.find('.btn-export').addClass('dropdown-toggle').removeClass('disabled').attr('disabled',false).html('Export');
					$this_form.find('input[name=export]').val('');
					
				}else{
					$content_wraper.find("#orders").html(response);
				}
				$this_form.find('[type=submit]').removeClass('disabled').attr("disabled", false);
			}
		});
	}

	function stats_export($this_option, stats, $content_wraper)
	{
		var val = $this_option.attr('data-value'),
			$btn_export = $content_wraper.find('.btn-export'),
			$form = $('.form-'+stats);
			
		$form.find('input[name=export]').val(val);
		
		$btn_export.removeClass('dropdown-toggle').addClass('disabled').attr('disabled',true).html('Exporting '+val+'...');
		if(val=='displaying')
		{
			var html = $('.table-'+stats).html();
			if($('#export_html').length){
				$('#export_html').html(html);
			}else{
				$('body').append('<div id="export_html" class="hide"><table>'+html+'</table></div>');
			}
			$('#export_html').find('.text-signin').remove();
			$('#export_html').find('.text-email').remove();
			$('#export_html').find('.text-email').next('div').remove();
			$('#export_html').find('.text-archived').remove();
			$('#export_html').find('.name-column').find("br").remove();
			$('#export_html').find('a').contents().unwrap();
			html = $('#export_html').html();
			var data = "filename="+stats+"&html="+html;
			$.ajax({
				url : BASE_URL+"/ajax?action=stats_export_displaying",
				data: data,
				type : "POST",
				cache: false,
				success:function(export_file_link){
					if($('#stats-export-file').length){
						$('#stats-export-file').attr('href',export_file_link);
					}else{
						$('body').append('<a id="stats-export-file" href="'+export_file_link+'"></a>');
					}
					$('#stats-export-file').get(0).click();
					$btn_export.addClass('dropdown-toggle').removeClass('disabled').attr('disabled',false).html('Export');
					$form.find('input[name=export]').val('');
				}
			});
		}else{
			$form.submit();
		}
	}
	
	// Topbar text tinymce editor
	tinymce.init({
		selector: '.tinymce.topbar-text',
		menubar: false,
		toolbar: ['undo redo | bold italic strikethrough link | alignleft aligncenter alignright | formatselect blockquote | bullist numlist | code'],
		plugins : 'link code wordcount lists advlists',
	});
	
	topbar_customHandler();
	window.addEventListener("resize", topbar_customHandler);
	
	$('#user_role').change(function(){
		var user_role = $(this).val();
		$('.field-toggle').hide();
		
		if( user_role == 'Writer'){
			$('.field-writer').show();
		}
		if( user_role == 'Editor' ){
			$('.field-editor').show();
		}
	});
	

	function getParameterByName(name, url = window.location.href) {
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	}
	
	var openpopup = getParameterByName('openpopup'),
		order_id = getParameterByName('order');
	
	if( order_id && openpopup ){
		if($('.order-details-trigger[data-order_id='+order_id+']').length)
		{
			//do nothing
		}else{
			$('.order-details-trigger.openpopup').attr('data-order_id',order_id);
		}
		$('.order-details-trigger[data-order_id='+order_id+']').click();
	}
});

const mq_min_width_992 = window.matchMedia("(min-width: 992px)");

function topbar_customHandler()
{
	var $topbar_custom = $('#kt_header .topbar-custom');
	if( $topbar_custom.length )
	{
		var $header_height_default = 145,
			$topbar_custom_height = $topbar_custom.outerHeight(),
			$height_total = $header_height_default + $topbar_custom_height;

		if (mq_min_width_992.matches)
		{
			$('.header-fixed.header-bottom-enabled .header').css({"height": $height_total+"px"});
			$('.header-fixed.header-bottom-enabled .wrapper').css({"padding-top": $height_total+"px"});
		}else{
			var $kt_header_mobile = $('#kt_header_mobile').outerHeight();
			$('.header-fixed.header-bottom-enabled .header').css({"height": "auto"});
			$('.header-fixed.header-bottom-enabled .wrapper').css({"padding-top": "15px"});
			$('#topbar_custom_mobile').css({"margin-top":$kt_header_mobile+"px"});
		}
	}
}

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