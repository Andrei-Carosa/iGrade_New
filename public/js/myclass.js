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
        Cookies.remove('param1');
        Cookies.remove('term');

        Cookies.remove('#kt_tab_pane_1_4_lec');
        Cookies.remove('#kt_tab_pane_2_4_lec');
        Cookies.remove('#kt_tab_pane_3_4_lec');
        Cookies.remove('#kt_tab_pane_4_4_lec');

        Cookies.remove('#kt_tab_pane_1_4_lab');
        Cookies.remove('#kt_tab_pane_2_4_lab');
        Cookies.remove('#kt_tab_pane_3_4_lab');
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

    var ClearTab = function(){
        Cookies.remove('#kt_tab_pane_1_4_lec');
        Cookies.remove('#kt_tab_pane_2_4_lec');
        Cookies.remove('#kt_tab_pane_3_4_lec');
        Cookies.remove('#kt_tab_pane_4_4_lec');

        Cookies.remove('#kt_tab_pane_1_4_lab');
        Cookies.remove('#kt_tab_pane_2_4_lab');
        Cookies.remove('#kt_tab_pane_3_4_lab');
    }

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

    var GradingSheetTable = function(sched_id,type,term,tab){

        $.ajax({
            url: 'tbl-grading-sheet',
            type: "POST",
            dataType:'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            cache: false,
            data: {  id: JSON.stringify(sched_id),term:term,category:type },
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

                    $(tab).html(window.atob(response.grading_sheet_tbl));

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
                    Cookies.set('param1', sched_id)
                },
                complete: function () {
                    KTApp.unblock('#kt_content');
                    $('.breadcrumb').removeAttr('hidden');
                    $('.bread-my-class').addClass('text-muted');
                },
                success: function (response) {
                    if (response.success) {

                        $('#title').html('Final Rating Sheet');
                        $('#display-render').last().append(window.atob(response.frs));
                        KTDatatablesDataSourceAjaxServer.init();

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

        //back to frs
        $(document).on("click",".back-frs",function(e){

            e.preventDefault();
            KTApp.block('#kt_content', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Loading your FRS ...'
            });

            $('#title').html('Final Rating Sheet');
            $('#div-class-record').remove();
            Cookies.remove('term');
            $('#frs_datatable').DataTable().ajax.reload();

            setTimeout(function() {
                KTApp.unblock('#kt_content');
                $('#div-tbl-frs').show();
            }, 500);
            ClearTab();

        })

        //back to class record
        $(document).on("click",".back-class-record",function(e){

            e.preventDefault();
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');

            KTApp.block('#kt_content', {
                overlayColor: '#000000',
                state: 'danger',
                message: 'Loading your Class Record ...'
            });

            $('#class-record-type').remove();
            setTimeout(function() {
                KTApp.unblock('#kt_content');
                $('#div-class-record').show();
            }, 500);
            ClassRecordTable(sched_id,term,'#kt_tab_pane_1_4');
            ClearTab();
        })

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
                    Cookies.set('term',term);
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

        //sched type btn
        $(document).on("click",".sched-type-btn",function(e){

            e.preventDefault();

            let sched_id = Cookies.get('param1');
            let sched_type = $(this).attr('sched-type');
            let type = sched_type==0?0:6;
            let term = Cookies.get('term');
            let tab = sched_type==0?'#kt_tab_pane_1_4_lec':'#kt_tab_pane_1_4_lab';

            if(sched_id == '' || term == undefined){
                return false;
            }

            $.ajax({
                url: 'class-grading-sheet',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),type:type,sched_type:sched_type,type:type,term:term },
                dataType: "json",
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Class Record...'
                    });
                    $('#div-class-record').hide();
                    $('#title').html('Class Record');
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                    GradingSheetTable(sched_id,type,term,tab);
                },
                success: function (response) {
                    if (response.success) {

                        $('#display-render').last().append(window.atob(response.grading_sheet));

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

        })

        //add activity
        $(document).on("click",".add-activity",function(e){

            e.preventDefault();
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');

            if(sched_id == undefined || term == undefined){
                return false;
            }

            $.ajax({
                url: 'add-activity',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),category:type,term:term },
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Activities in Pinnacle...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                        $('#modal-activities').modal('show');
                    }, 500);
                },
                success: function (response) {

                    if (response.success) {

                        $('#modal-activities').remove();
                        $('#kt_body').last().append(window.atob(response.modal_activities));

                    } else if (response.error) {
                        Swal.fire("Oopps!",response.error,"info");

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

        });

        //save-added-activities
        $(document).on("click",".save-added-activities",function(e){

            e.preventDefault();
            let post_id = new Array();
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let tab = $('li a.nav-type.active').attr('href');

            $('.activities-list input[type="checkbox"]:checked').each(function() {
                post_id.push($(this).attr('post-id'));
            });

            if(post_id.length == 0){
                Swal.fire('Oops','Missing Request ID. Try Again Later','info');
                return false;
            }

            $.ajax({
                url: 'save-added-activity',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),category:type,post_id:post_id,term:term },
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Activities in Pinnacle...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                },
                success: function (response) {

                    if (response.success) {
                        GradingSheetTable (sched_id,type,term,tab);
                    } else if (response.error) {

                        Swal.fire("Oopps!",response.error,"info");

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


        });

        //remove added activities
        document.body.addEventListener('click', function(e){

            if(e.target.hasAttribute('remove-import')){

                let import_id = window.btoa(e.target.getAttribute('remove-import'));
                let sched_id = Cookies.get('param1');
                let term = Cookies.get('term');
                let type = $('li a.nav-type.active').attr('data-nav-type');
                let tab = $('li a.nav-type.active').attr('href');

                if(import_id == ''){
                    return false;
                }

                $.ajax({
                    url: 'remove-activity',
                    type: "POST",
                    dataType:'json',
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    cache: false,
                    data: {  id: JSON.stringify(import_id) },
                    beforeSend: function () {
                        KTApp.block('#kt_content', {
                            overlayColor: '#000000',
                            state: 'danger',
                            message: 'Loading Your Activities in Pinnacle...'
                        });
                    },
                    complete: function () {
                        setTimeout(function() {
                            KTApp.unblock('#kt_content');
                        }, 500);
                        GradingSheetTable (sched_id,type,term,tab);
                        $("#"+e.target.getAttribute('id')).removeAttr('remove-import');
                        $("."+e.target.getAttribute('id')).remove();
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Activity is Removed!","","info");
                        } else if (response.error) {
                            Swal.fire("Oopps!",response.error,"info");
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
        });

        //nav type
        $(document).on("click",".nav-type",function(e){

            e.preventDefault();
            let type = $(this).attr('data-nav-type');
            let tab = $(this).attr('href');
            let term = Cookies.get('term');
            let sched_id = Cookies.get('param1');
            let tab_cookie = Cookies.get(tab);

            if(tab_cookie == undefined){
                GradingSheetTable (sched_id,type,term,tab);
                Cookies.set(tab,type);
            }

        });

        //add column
        $(document).on("click", ".add-column", function(e){

            e.preventDefault();
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let tab = $('li a.nav-type.active').attr('href');

            $.ajax({

                url: 'add-column',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),category: type,term:term},
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Your Activities in Pinnacle...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                    GradingSheetTable (sched_id,type,term,tab);
                },
                success: function (response) {

                    if (response.success_add) {

                        Swal.fire("Column is Added",'',"info");

                    } else if (response.error) {

                        Swal.fire("Oopps!",response.error,"info");

                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    console.log(xhr.responseText);
                    Swal.fire("Oopps!", "Something went wrong, Please try again later", "warning");

                }
            })

        });

        // view column
        $(document).on("click",".view-column",function(e){

            e.preventDefault();
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');

            if(sched_id == undefined || term == undefined){
                return false;
            }


            $.ajax({
                url: 'view-column',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: JSON.stringify(sched_id),category:type,term:term },
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Please Wait...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                        $('#modal-column').modal('show');
                    }, 500);
                },
                success: function (response) {

                    if (response.success) {
                        $('#modal-column').remove();
                        $('#kt_body').last().append(window.atob(response.columns));

                    } else if (response.error) {
                        Swal.fire("Oopps!",response.error,"info");

                    } else if (response.empty){
                        Swal.fire("Oopps!",response.empty,"info");
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

        });

        //remove-column-btn
        $(document).on('click', '.remove-column', function(e){

            e.preventDefault();
            let sched_id = Cookies.get('param1');
            let term = Cookies.get('term');
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let tab = $('li a.nav-type.active').attr('href');
            let column_id = $(this).attr('col-id');
            $(this).parent().parent().remove();

            $.ajax({

                url: 'remove-column',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: column_id,term:term,category:type },
                beforeSend: function () {
                    KTApp.block('#kt_content', {
                        overlayColor: '#000000',
                        state: 'danger',
                        message: 'Loading Please Wait...'
                    });
                },
                complete: function () {
                    setTimeout(function() {
                        KTApp.unblock('#kt_content');
                    }, 500);
                    GradingSheetTable (sched_id,type,term,tab);
                },
                success: function (response) {

                    if(response.success){
                        Swal.fire('Ooops','Column is Removed','info');

                    }else if(response.error){
                        console.log(response)
                        Swal.fire('Ooops',response.error,'info');
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
        });

         //column hps
         $(document).on('change', 'table thead .hps-header th .column_hps', async function(e){

            e.preventDefault();

            let hps = parseInt(($(this).val()));
            let col_id = $(this).attr('column_id');
            let type = $('li a.nav-type.active').attr('data-nav-type');
            let total = $( e.currentTarget ).closest("thead").find('.total_all_hps');

            let column_hps = 0;
            let import_hps = 0;
            let overall_score = 0;

            if($(this).hasClass('border-danger')){
                $(this).removeClass('border-danger');
            }

            // import total hps
            $("#grading_table thead .hps-header th .import_hps").each(function() {
                $(this).each(function( index ) {
                    import_hps = import_hps+parseInt($(this).val());
                });
            });

            // column total hps
            $("#grading_table thead .hps-header th .column_hps").each(function() {
                $(this).each(function( index ) {

                    if (isNaN($(this).val())) {
                        Swal.fire('Oops','Invalid input. Numbers only','info');
                        $(this).addClass('border-danger');
                        // $(this).val(0);
                        return false;
                    }

                    if($(this).val() != ''){
                        column_hps = column_hps+parseInt($(this).val());
                    }

                });
            });

            if(column_hps != '' &&  import_hps != '' ){
                overall_score = column_hps+import_hps;
            }else{
                if(import_hps != ''){
                    overall_score = import_hps;
                }else if(column_hps !=''){
                    overall_score = column_hps;
                }
            }

            $( e.currentTarget ).closest("thead").find('.total_all_hps').val(column_hps+import_hps);

            $.ajax({
                url: 'update-column-hps',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id: col_id,hps:hps },
                success: function (response) {
                    if (response.error) {
                        Swal.fire("Oopps!",response.error,"info");
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

        });

        //column score
        $(document).on('click', '#grading_table tbody tr td .column_score', async function(e){

            e.preventDefault();
            $('#grading_table thead .hps-header th .column_hps').each(function(){
                $(this).each(function( index ) {
                    if($(this).val() == 0 || $(this).val() == '' ){
                        Swal.fire('Oops','Please set the highest possible score in this column','info');
                        $(this).addClass('border-danger');
                        return false;
                    }
                });
            })
        });

         //column score
         $(document).on('change', '#grading_table tbody tr td .column_score', async function(e){

            e.preventDefault();
            let score_id = $(this).attr('score-id');
            let type = $('li a.nav-type.active').attr('data-nav-type');

            let import_score =0;
            let column_score =0;
            let updated_total = 0;
            let calculated_score_2 = 0;

            let score = ($(this).val());
            let total_score = $( e.currentTarget ).closest("tr").find('.total_score');
            let calculated_score = $( e.currentTarget ).closest("tr").find('.calculated_total');
            let total_all_hps =  parseInt($('#grading_table thead .hps-header').find('.total_all_hps').val());
            let percentage = type==0?0.10:(type==1?0.20:(type==2?0.20:(type==3?0.50:(type==6?0.50:(type==7?0.70:0.20)))));

            $(this).closest("tr").find('.import_score').each(function() {
                $(this).each(function( index ) {
                    import_score = import_score+parseInt($(this).val());
                });
            });

            $(this).closest("tr").find('.column_score').each(function() {
                $(this).each(function( index ) {

                    if (isNaN($(this).val())) {
                        Swal.fire('Oops','Only number is allowed.','info');
                        $(this).val(0);
                        return false;
                    }

                    if($(this).val() != ''){
                        column_score = column_score+parseInt($(this).val());
                    }

                });
            });

            if(import_score !='' || column_score !=''){
                updated_total = import_score+column_score;
                calculated_score_2 = ((import_score+column_score) / (total_all_hps)*percentage)*100 ;
            }else{
                if(import_score != ''){
                    updated_total = import_score;
                    calculated_score_2 = ((import_score) / (total_all_hps)*percentage)*100;
                }else if(column_score != ''){
                     updated_total = column_score;
                     calculated_score_2 = ((column_score) / (total_all_hps)*percentage)*100;
                }
            }

            total_score.val(updated_total);
            calculated_score.val(calculated_score_2.toFixed(0));

            if(score == null || score_id == undefined ){
                return false;
            }

            $.ajax({
                url: 'update-column-score',
                type: "POST",
                dataType:'json',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                cache: false,
                data: {  id:score_id,score:score },
                success: function (response) {
                        if (response.error) {
                        Swal.fire("Oopps!",response.error,"info");
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
			searchDelay: 3000,
			processing: true,
			serverSide: true,
            paging: false,
            order: [[1, 'asc']],
			ajax: {
				url: 'frs-fetch',
				type: 'POST',
				data: { id:sched_id},
			},
			columns: [
				{data: 'stud_id'},
                {data: 'fullname',name:'fullname' },
				{data: 'prelim', className:'text-center'},
				{data: 'midterm', className:'text-center'},
				{data: 'finals', className:'text-center'},
				{data: 'final_grade', className:'text-center'},
				{data: 'equivalent', className:'text-center'},
				{data: 'remarks', className:'text-center'},
				{data: 'Actions', responsivePriority: -1},
			],
			columnDefs: [
				{
                    className:'text-center',
					targets: -1,
					title: 'Actions',
					orderable: false,
                    visible: false,
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

