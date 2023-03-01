"use strict"

var handleSystem = function (){

    var handleNavigationEvent = function(){

        // Use getEntriesByType() to just get the "navigation" events
        let perfEntries = performance.getEntriesByType("navigation");

        for (var i=0; i < perfEntries.length; i++) {

            let p = perfEntries[i];
            if(p.type == 'reload'){
                ClearCookies();
            }

        }

        // $(document).on('hidden.bs.modal','#viewSchedule', function () {
        //     // sessionStorage.clear();
        //     $(this).remove();
        // });

    }

    var ClearCookies = function(){
        Cookies.remove('#kt_tab_pane_1_4');
        Cookies.remove('#kt_tab_pane_2_4');
        Cookies.remove('#kt_tab_pane_3_4');
        Cookies.remove('param1');
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
                KTApp.unblock('#kt_content');
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

    }

    var ClassRecordTable = function (sched_id,term,tab){

        $.ajax({
            url: 'class-record-tbl',
            type: "POST",
            dataType:'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            cache: false,
            data: {  id: JSON.stringify(sched_id),term:term },
            dataType: "json",
            beforeSend: function () {
                KTApp.block('#kt_content', {
                    overlayColor: '#000000',
                    state: 'danger',
                    message: 'Loading Your Class Record...'
                });
            },
            complete: function () {
                setTimeout(function() {
                    KTApp.unblock('#kt_content');
                }, 500);
            },
            success: function (response) {
                if (response.success) {

                    $(tab).html(window.atob(response.class_record_tbl));

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

    }

    var HandleTeacherAction = function(){

        //back to my class
        $(document).on("click",".back-my-class",function(e){

            e.preventDefault();
            KTApp.block('#kt_content', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Loading your Class ...'
            });
            $('#title').html('My Class');
            $('#div-tbl-frs').remove();

            setTimeout(function() {
                KTApp.unblock('#kt_content');
                $('#hide-card').show();
                handleSystem.init;
            }, 500);

        })

        //back to back-frs
        $(document).on("click",".back-frs",function(e){

            e.preventDefault();
            KTApp.block('#kt_content', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Loading your FRS ...'
            });

            $('#title').html('Final Rating Sheet');
            $('#div-class-record').remove();
            $('#frs_datatable').DataTable().ajax.reload();

            setTimeout(function() {
                KTApp.unblock('#kt_content');
                $('#div-tbl-frs').show();
            }, 500);

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
                        message: 'Loading your FRS ...'
                    });
                    $('#hide-card').hide();
                },
                complete: function () {
                    KTApp.unblock('#kt_content');
                    Cookies.set('param1', sched_id)
                    KTDatatablesDataSourceAjaxServer.init();
                    $('.breadcrumb').removeAttr('hidden');
                    $('.bread-my-class').addClass('text-muted');
                },
                success: function (response) {
                    if (response.success) {

                        $('#display-render').last().append(window.atob(response.frs));
                        console.log(response)
                        $('#title').html('Final Rating Sheet');

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

         //set as inc
         $(document).on("click",".btn-inc", function(e){

            e.preventDefault();
            let grade_id = $(this).attr('grade-id');
            let sched_id = Cookies.get('param1');

            if(grade_id == '' || grade_id == null){
                return false;
            }

            $.ajax({
                url: 'frs-student-inc',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(grade_id) },
                dataType: "json",
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Please Wait ...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                },
                success: function (response) {
                    if (response.success) {

                        $('#frs_datatable').DataTable().ajax.reload();

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

         })

        //view specific term
        $(document).on("click",".dropdown-term",function(e){

            e.preventDefault();
            let term = $(this).attr('data-term');
            let sched_id = Cookies.get('param1');

            if(sched_id == undefined || term ==''){
                return false;
            }

            $.ajax({
                url: 'class-record-term',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),term:term },
                dataType: "json",
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Class Record...'
                    });
                    $('#div-tbl-frs').hide();
                    $('#title').html('Class Record');
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                    ClassRecordTable(sched_id,term,'#kt_tab_pane_1_4');
                },
                success: function (response) {
                    if (response.success) {

                        $('#display-render').last().append(window.atob(response.class_record));

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

        // term tab
        $(document).on("click",".class-term",function(e){

            e.preventDefault();
            let term = $(this).attr('class-term');
            let sched_id = Cookies.get('param1');
            let tab = $(this).attr('href');
            let tab_cookies = Cookies.get(tab);

            if(sched_id == undefined || term ==''){
                return false;
            }

            if(tab_cookies == undefined){
                ClassRecordTable(sched_id,term,tab);
                Cookies.set(tab,tab);
            }

        });



    }

    return {
        init: function() {

            HandleTeacherClass();
            HandleTeacherAction();

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


"use strict";

var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {

		var table = $('#frs_datatable');
        let sched_id = Cookies.get('param1');

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
            paging: false,
			ajax: {
				url: 'frs-fetch',
				type: 'POST',
				data: { id:sched_id},
			},
			columns: [
				{data: 'stud_id'},
				{data: 'fullname',name:'fullname'},
				{data: 'prelim'},
				{data: 'midterm'},
				{data: 'finals'},
				{data: 'final_grade'},
				{data: 'equivalent'},
				{data: 'remarks'},
				{data: 'Actions', responsivePriority: -1},
			],
			columnDefs: [
				{
                    className:'text-center',
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
                        if(full.remarks != 'INC'){
						    return ' \<a grade-id="'+data+'" href="javascript:void(0)" class="btn btn-outline-danger btn-light-danger btn-sm btn-inc"><i class="flaticon2-layers-2"></i>Set as INC</a>\ ';
                        }else{
                            return '<span class="text-muted">No Action</span>';
                        }
					},
				},
				// {
				// 	width: '75px',
				// 	targets: -3,
				// 	render: function(data, type, full, meta) {
				// 		var status = {
				// 			1: {'title': 'Pending', 'class': 'label-light-primary'},
				// 			2: {'title': 'Delivered', 'class': ' label-light-danger'},
				// 			3: {'title': 'Canceled', 'class': ' label-light-primary'},
				// 			4: {'title': 'Success', 'class': ' label-light-success'},
				// 			5: {'title': 'Info', 'class': ' label-light-info'},
				// 			6: {'title': 'Danger', 'class': ' label-light-danger'},
				// 			7: {'title': 'Warning', 'class': ' label-light-warning'},
				// 		};
				// 		if (typeof status[data] === 'undefined') {
				// 			return data;
				// 		}
				// 		return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
				// 	},
				// },
				// {
				// 	width: '75px',
				// 	targets: -2,
				// 	render: function(data, type, full, meta) {
				// 		var status = {
				// 			1: {'title': 'Online', 'state': 'danger'},
				// 			2: {'title': 'Retail', 'state': 'primary'},
				// 			3: {'title': 'Direct', 'state': 'success'},
				// 		};
				// 		if (typeof status[data] === 'undefined') {
				// 			return data;
				// 		}
				// 		return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
				// 			'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
				// 	},
				// },
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

// jQuery(document).ready(function() {
// 	KTDatatablesDataSourceAjaxServer.init();
// });

