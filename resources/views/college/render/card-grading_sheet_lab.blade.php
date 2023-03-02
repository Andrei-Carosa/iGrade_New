

<div class="container-fluid mx-20" id="class-record-type">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-10">
        <div class="card card-custom gutter-b">
            <div class="card-header card-header-tabs-line">
                <div class="card-title">
                    <span class="mr-5">
                        <a href="javascript:void(0)" class="text-muted font-weight-boldest back-class-record"><i class="text-muted flaticon2-left-arrow-1"></i></a>
                    </span>
                    <h3 class="card-label">
                        {{ $class->sched_course->description }}
                        <span class="d-block text-muted pt-2 font-size-sm">{{ $class->sched_blocking->block->block_name }} | {{ $term }}</span>
                    </h3>
                </div>
            </div>
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-bold nav-tabs-line pl-5">
                    <li class="nav-item">
                        <a class="nav-link active nav-type" data-nav-type ="0" data-toggle="tab" href="#kt_tab_pane_1_4_lab">
                            <span class="nav-text">Class Participation (10%)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-type" data-nav-type ="1" data-toggle="tab" href="#kt_tab_pane_2_4_lab">
                            <span class="nav-text">Exercise (70%)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-type" data-nav-type ="3" data-toggle="tab" href="#kt_tab_pane_3_4_lab">
                            <span class="nav-text">Exam (20%)</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1_4_lab" role="tabpanel" aria-labelledby="kt_tab_pane_1_4_lab">
                    </div>
                    <div class="tab-pane fade show active" id="kt_tab_pane_2_4_lab" role="tabpanel" aria-labelledby="kt_tab_pane_2_4_lab">
                    </div>
                    <div class="tab-pane fade show active" id="kt_tab_pane_3_4_lab" role="tabpanel" aria-labelledby="kt_tab_pane_3_4_lab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
