"use strict"

var handleSystem = function (){

    var handleNavigationEvent = function(){

        // Use getEntriesByType() to just get the "navigation" events
        let perfEntries = performance.getEntriesByType("navigation");

        for (var i=0; i < perfEntries.length; i++) {

            let p = perfEntries[i];
            if(p.type == 'reload'){
                sessionStorage.clear();
            }

        }

        // $(document).on('hidden.bs.modal','#viewSchedule', function () {
        //     // sessionStorage.clear();
        //     $(this).remove();
        // });

    }

  return {
    init: function () {
        handleNavigationEvent();
    }
}

}();

// Initialize class on document ready
$(document).ready(function() {
    handleSystem.init();
});


"use strict"

var TeacherClass = function(){

    var HandleTeacherClass = function(){

         //view class
        $.ajax({
            url: 'my-class-fetch',
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            dataType: "json",
            beforeSend: function () {
                KTApp.block('#kt_content', {
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Loading Your Class ...'
                });
            },
            complete: function () {
                setTimeout(function() {
                    KTApp.unblock('#kt_content');
                   }, 500);
            },
            success: function (response) {
                if (response.success) {

                    $('#card-my-class').html(window.atob(response.class));

                } else if (response.error) {
                    Swal.fire({
                        icon: "error",
                        text: response.error,
                        showCancelButton: false,
                        confirmButtonText: "Ok, Got it",
                        reverseButtons: true
                    }).then(function (result) {
                        KTUtil.scrollTop();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                console.log(xhr.responseText);
                Swal.fire("Oopps!", "Something went wrong, Please try again later", "info");
            }
        })

        //view frs
        $(document).on("click", ".manage-class", function(e){

            e.preventDefault();
            let sched_id = $(this).attr('sched-id');


            if(sched_id == ''){
                return false;
            }

            $.ajax({
                url: 'frs',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id) },
                dataType: "json",
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Class ...'
                    });
                    $('#modal-frs').remove();
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                },
                success: function (response) {
                    if (response.success) {

                        $('#kt_content').last().append(window.atob(response.frs));
                        $('#modal-frs').modal('show');

                    } else if (response.empty) {
                        Swal.fire({
                            icon: "info",
                            text: response.empty,
                            showCancelButton: false,
                            confirmButtonText: "Ok, Got it",
                            reverseButtons: true
                        }).then(function (result) {
                            KTUtil.scrollTop();
                        });
                    }else{
                        console.log(response.error)
                        Swal.fire("Oopps!", "Something went wrong, Please try again later", "warning");
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    console.log(xhr.responseText);
                    Swal.fire("Oopps!", "Something went wrong, Please try again later", "error");
                }
            })
        });



    }



    return {
        init: function() {

            HandleTeacherClass();

        },
    }
}();

// webpack support
if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
    module.exports = KTApp;
}

// Initialize class on document ready
$(document).ready(function() {
    TeacherClass.init();
});


// "use strict";

// var KTDatatablesDataSourceAjaxServer = function() {

// 	var initTable1 = function() {
// 		var table = $('#kt_datatable');

// 		// begin first table
// 		table.DataTable({
// 			responsive: true,
// 			searchDelay: 500,
// 			processing: true,
// 			serverSide: true,
// 			ajax: {
// 				url: 'frs-fetch',
// 				type: 'POST',
// 				data: {
// 					// parameters for custom backend script demo
// 					columnsDef: [
// 						'OrderID', 'Country',
// 						'ShipAddress', 'CompanyName', 'ShipDate',
// 						'Status', 'Type', 'Actions'],
// 				},
// 			},
// 			columns: [
// 				{data: 'OrderID'},
// 				{data: 'Country'},
// 				{data: 'ShipAddress'},
// 				{data: 'CompanyName'},
// 				{data: 'ShipDate'},
// 				{data: 'Status'},
// 				{data: 'Type'},
// 				{data: 'Actions', responsivePriority: -1},
// 			],
// 			columnDefs: [
// 				{
// 					targets: -1,
// 					title: 'Actions',
// 					orderable: false,
// 					render: function(data, type, full, meta) {
// 						return '\
// 							<div class="dropdown dropdown-inline">\
// 								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
// 	                                <i class="la la-cog"></i>\
// 	                            </a>\
// 							  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
// 									<ul class="nav nav-hoverable flex-column">\
// 							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>\
// 							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>\
// 							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li>\
// 									</ul>\
// 							  	</div>\
// 							</div>\
// 							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
// 								<i class="la la-edit"></i>\
// 							</a>\
// 							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
// 								<i class="la la-trash"></i>\
// 							</a>\
// 						';
// 					},
// 				},
// 				{
// 					width: '75px',
// 					targets: -3,
// 					render: function(data, type, full, meta) {
// 						var status = {
// 							1: {'title': 'Pending', 'class': 'label-light-primary'},
// 							2: {'title': 'Delivered', 'class': ' label-light-danger'},
// 							3: {'title': 'Canceled', 'class': ' label-light-primary'},
// 							4: {'title': 'Success', 'class': ' label-light-success'},
// 							5: {'title': 'Info', 'class': ' label-light-info'},
// 							6: {'title': 'Danger', 'class': ' label-light-danger'},
// 							7: {'title': 'Warning', 'class': ' label-light-warning'},
// 						};
// 						if (typeof status[data] === 'undefined') {
// 							return data;
// 						}
// 						return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
// 					},
// 				},
// 				{
// 					width: '75px',
// 					targets: -2,
// 					render: function(data, type, full, meta) {
// 						var status = {
// 							1: {'title': 'Online', 'state': 'danger'},
// 							2: {'title': 'Retail', 'state': 'primary'},
// 							3: {'title': 'Direct', 'state': 'success'},
// 						};
// 						if (typeof status[data] === 'undefined') {
// 							return data;
// 						}
// 						return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
// 							'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
// 					},
// 				},
// 			],
// 		});
// 	};

// 	return {

// 		//main function to initiate the module
// 		init: function() {
// 			initTable1();
// 		},

// 	};

// }();

// jQuery(document).ready(function() {
// 	KTDatatablesDataSourceAjaxServer.init();
// });

