
<div class="row">
    @if(!empty($lec_grade))
    <div class="col">
        <h5 class="text-dark font-weight-bold my-1 mr-5">Lecture</h5>
        <table class="table table-bordered table-hover table-checkable" id="frs_datatable" style="margin-top: 13px !important">
            <thead class="table-primary">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Finals</th>
                    <th>Final Grade</th>
                    <th>Equivalent</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
    @endif

    @if(!empty($lab_grade))
        <div class="col">
            <h5 class="text-dark font-weight-bold my-1 mr-5">Laboratory</h5>
            <table class="table table-bordered table-hover table-checkable" id="frs_datatable" style="margin-top: 13px !important">
                <thead class="table-primary">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>Final Grade</th>
                        <th>Equivalent</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endif

</div>

