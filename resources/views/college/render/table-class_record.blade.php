
<div class="row">
    @if(!empty($lec_grade))
    <div class="col">
        <h5 class="text-dark font-weight-bold my-1 mr-5">Lecture</h5>
        <table class="table table-bordered table-hover table-checkable" id="frs_datatable" style="margin-top: 13px !important">
            <thead class="table-primary">
                <tr>
                    <th class="align-middle text-center">#</th>
                    <th class="align-middle">Student ID</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle text-center">CP</th>
                    <th class="align-middle text-center">QUIZ</th>
                    <th class="align-middle text-center">OTHERS</th>
                    <th class="align-middle text-center">EXAM</th>
                    <th class="align-middle text-center">TOTAL</th>
                    <th class="align-middle text-center text-uppercase">{{ $term->term }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lec_grade as $key=> $lec)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $lec->stud_id }}</td>
                        <td>{{ $lec->stud_info_lec->lname.' '.$lec->stud_info_lec->fname}}</td>
                        <td class="text-center">{{ $lec->cp }}</td>
                        <td class="text-center">{{ $lec->quiz }}</td>
                        <td class="text-center">{{ $lec->others }}</td>
                        <td class="text-center">{{ $lec->exam }}</td>
                        <td class="text-center">{{ $lec->total_lec }}</td>
                        <td class="text-center">{{ $lec->term_grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if(!empty($lab_grade))
        <div class="col">
            <h5 class="text-dark font-weight-bold my-1 mr-5">Laboratory</h5>
            <table class="table table-bordered table-hover table-checkable" id="frs_datatable" style="margin-top: 13px !important">
                <thead class="table-primary">
                    <tr>
                        <th  class="align-middle text-center number" colspan="1">#</th>
                        <th class="align-middle stud-id">Student ID</th>
                        <th class="align-middle">Name</th>
                        <th class="align-middle text-center">CP</th>
                        <th class="align-middle text-center">EXERCISE</th>
                        <th class="align-middle text-center">EXAM</th>
                        <th class="align-middle text-center">TOTAL</th>
                        <th class="align-middle text-center text-uppercase">{{ $term->term }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lab_grade as $key=> $lab)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $lec->stud_id }}</td>
                            <td>{{ $lab->stud_info_lab->lname.' '.$lab->stud_info_lab->fname}}</td>
                            <td class="text-center">{{ $lab->cp }}</td>
                            <td class="text-center">{{ $lab->exercise }}</td>
                            <td class="text-center">{{ $lab->exam }}</td>
                            <td class="text-center">{{ $lab->total_lab }}</td>
                            <td class="text-center">{{ $lab->term_grade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

