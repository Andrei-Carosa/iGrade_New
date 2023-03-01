
    @if (count($class) >= 1)

    @foreach ($class as $classes )
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">

            <!--begin::Card-->
            <div class="card card-custom gutter-b card-stretch border border-secondary">
                <!--begin::Body-->
                <div class="card-body pt-5">
                    <!--begin::User-->
                    <div class=" mb-7">
                        <!--begin::Title-->
                        <div class="">
                            <a href="javascript:void(0)" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{ $classes->teacher_sched->sched_course->description }}</a>
                            <div class="d-flex flex-wrap my-2">

                                <a href="javascript:void(0)" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <i class="icon-sm flaticon2-menu-2"></i>
                                    </span>
                                    {{ $classes->teacher_sched->sched_course->code }}
                                </a>

                                <a href="javascript:void(0)" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Lock.svg-->
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <i class="fas fa-bookmark icon-sm"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    {{ $classes->teacher_schedule }}
                                </a>
                            </div>

                        </div>

                        <!--end::Title-->
                    </div>
                    <!--end::User-->

                    <!--begin::Info-->
                    <div class="mb-7 px-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark-75 font-weight-bolder mr-2">Class No :</span>
                            <a href="#" class="text-muted text-hover-primary">{{ $classes->teacher_sched->class_no }}</a>
                        </div>
                        <div class="d-flex justify-content-between align-items-cente my-1">
                            <span class="text-dark-75 font-weight-bolder mr-2">Section :</span>
                            <a href="#" class="text-muted text-hover-primary">{{ $classes->teacher_sched->sched_blocking->block->block_name }}</a>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-dark-75 font-weight-bolder mr-2">Units:</span>
                            <span class="text-muted font-weight-bold">{{ $classes->teacher_sched->sched_course->units }}</span>
                        </div>
                    </div>
                    <!--end::Info-->
                    <a href="#" class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4 manage-class" sched-id="{{ $classes->sched_id }}">Manage Class</a>
                </div>
                <!--end::Body-->
                <div class="card-footer d-flex align-items-center">
                    <div class="d-flex">
                        <div class="d-flex align-items-center mr-7">
                            <span class="svg-icon svg-icon-gray-500">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Text/Bullet-list.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" fill="#000000" />
                                        <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <a href="#" class="font-weight-bolder text-primary ml-2">{{ $classes->activity_count }} Activities</a>
                        </div>
                        {{-- <div class="d-flex align-items-center mr-7">
                            <span class="svg-icon svg-icon-gray-500">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                                        <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <a href="#" class="font-weight-bolder text-primary ml-2">40 Students</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!--end:: Card-->

        </div>
    @endforeach

        @else
        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
            <div class="card card-custom wave wave-warning gutter-b bg-diagonal rounded-3 border border-1">
                <div class="card-body">
                 <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                  <div class="d-flex flex-column mr-5">
                   <a href="javascript:void(0)" class="h3 text-warning mb-5">
                    <i class="text-warning flaticon2-warning"></i> No Class Found
                   </a>
                   <p class="text-dark-50">
                    Message MISD @ Facebook for inquiries or kindly visit our department for personal assistance.
                   </p>
                  </div>
                 </div>
                </div>
            </div>
            {{-- <div class="card card-custom wave wave-animate-fast wave-success">
                <div class="card-body">
                    <div class="d-flex align-items-center p-5">
                        <div class="mr-6">
                            <span class="svg-icon svg-icon-success svg-icon-4x">
                                <svg>
                                    ...
                                </svg>
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <a href="#" class="text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                            User Guide
                            </a>
                            <div class="text-dark-75">
                                ...
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    @endif

