<div class="modal fade" id="modal-activities" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Activities<br>
                    <span class="text-muted font-size-sm">
                        Select which activities to include
                    </span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="card card-stretch gutter-b mb-0 pb-0 shadow-0 rounded-0 border-0">
                    <!--begin::Header-->
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body px-0 py-2 activities-list">
                        @foreach ( $lms_post as $lms_posts )
                        <!--begin::Item-->
                            <div class="d-flex align-items-center mb-3">
                                <!--begin::Bullet-->
                                {{-- <span class="bullet bullet-bar bg-success align-self-stretch"></span> --}}
                                <!--end::Bullet-->
                                <!--begin::Checkbox-->
                                <label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">
                                    <input type="checkbox" name="select" value="" post-id="{{ $lms_posts->post_id }}"
                                        @foreach($import as $imports)
                                            @if($imports->post_id == $lms_posts->post_id)
                                                @if($imports->category == $category)
                                                checked
                                                remove-import="{{ $imports->import_id }}"
                                                @else
                                                checked
                                                @endif
                                            @endif
                                        @endforeach
                                    >
                                    <span></span>
                                </label>
                                <!--end::Checkbox-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column flex-grow-1">
                                    <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1">{{ $lms_posts->title }}</a>
                                    <span class="text-muted font-weight-bold">{{ $lms_posts->details }}</span>
                                </div>
                                <!--end::Text-->
                                <div class="mx-5">
                                    @foreach($import as $imports)
                                        @if($imports->post_id == $lms_posts->post_id)
                                            @if($imports->category != $category)
                                                <span class="label label-lg label-light-primary label-inline">{{ $imports->categoryname }}</span>
                                            @else
                                            <span class="label label-lg label-light-primary label-inline mr-2 font-size-sm">Selected</span>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                <div class="mr-3">
                                    <a href="javascript:void(0)" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip" title="@if(!$lms_posts->is_visible) Not @endif Visible to Student">
                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                            @if($lms_posts->is_visible)
                                                <i class="far fa-eye"></i>
                                            @else
                                                <i class="far fa-eye-slash"></i>
                                            @endif
                                        </span>
                                    </a>
                                </div>
                                <div>
                                    <a href="javascript:void(0)" class="btn btn-icon btn-light btn-hover-primary btn-sm" data-toggle="tooltip" title="Number of Submission">
                                        <span class="svg-icon svg-icon-md svg-icon-primary">
                                            <i class="fas fa-users"></i>{{ $lms_posts->submitted_activity_count }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        <!--end:Item-->
                        @endforeach
                    </div>
                    <!--end::Body-->
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold save-added-activities">Save</button>
            </div>
        </div>
    </div>
</div>
