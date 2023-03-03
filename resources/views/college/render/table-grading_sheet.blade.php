<style>
    input:focus, textarea:focus, select:focus{
        outline: none !important;
    }
</style>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-light-success add-activity">Add Activities</button>
    <button type="button" class="btn btn-light-success add-column">Add Column</button>
    <button type="button" class="btn btn-light-success view-column">Remove Column</button>
</div>
<div class="row">
    @if( !empty($student_score) )
        <div class="col">
            <table class="table table-bordered table-hover table-checkable" id="grading_table" style="margin-top: 13px !important">
                <thead class="table-primary">
                    <tr>
                        <th class="align-middle text-center">#</th>
                        <th class="align-middle">Student ID</th>
                        <th class="align-middle">Name</th>
                        @foreach($import as $x => $imports)
                            <th class="align-middle text-center"> {{ __('CP #'.$x+1) }}</th>
                        @endforeach
                        @for ($y=0; $y<count($column);$y++)
                            <th class="align-middle text-center text-uppercase">{{ __('CP #'.count($import)+($y+1)) }}</th>
                        @endfor
                        <th class="align-middle text-center">Total</th>
                        <th class="align-middle text-center text-uppercase">{{ $type_name }}</th>
                    </tr>

                    <tr class="bg-light-secondary hps-header">
                        <th class="align-middle" rowspan="1" colspan="3" >
                            <span class="pl-10"> Highest Possible Score </span>
                        </th>
                        @foreach($import as $x =>$imports)
                            <th class="align-middle text-center">
                                <input type="text" class="text-center import_hps" size='1' value="{{ $imports->import_lms->hps }}" readonly>
                            </th>
                        @endforeach
                        @foreach($column as $columns)
                            <th class="align-middle text-center text-uppercase">
                                <input type="text" class="text-center column-input column_hps" column_id="{{ $columns->col_id }}" size='1' value="{{ $columns->hps }}">
                            </th>
                        @endforeach
                        <th class="align-middle text-center">
                            <input type="text" class="text-center total_all_hps" size='1' value="{{ $total_all_hps }}" readonly>
                        </th>
                        <th class="align-middle text-center">
                            <input type="text" class="text-center calculated_score" size='1' value="{{  __(($percent_type*100).'%') }}" readonly>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student_score as $key=> $stud_score)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $stud_score['stud_id'] }}</td>
                            <td>{{ $stud_score['name']}}</td>
                            @for ($x=0; $x<count($import);$x++)
                            <td class="text-center">
                                <input type="text" class="text-center border-0 bg-transparent import_score" size='1' value="{{ $stud_score['import_'.$x] }}">
                            </td>
                            @endfor
                            @for ($y=0; $y <count($column);$y++)
                            <td class="text-center">
                            <input type="text" class="text-center border-0 bg-transparent column_score" score-id="{{ $column[$y]->column_score[$key]->score_id }}" data-id="{{ $stud_score['stud_id'] }}" size='1' value="{{ $stud_score['column_'.$y] }}">
                            </td>
                            @endfor
                            <td class="text-center">{{ $stud_score['total_score'] }}</td>
                            <td class="text-center">{{ $stud_score['calculated_score'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 mt-5">
            <div class="card card-custom wave wave-warning gutter-b bg-diagonal rounded-3 border border-1">
                <div class="card-body">
                 <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                  <div class="d-flex flex-column mr-5">
                   <a href="javascript:void(0)" class="h3 mb-5 text-warning">
                    <i class="flaticon2-information mr-2 text-warning"></i>Click 'Add Activity' or 'Add Column' To Start Grading Your Student
                   </a>
                   <p class="text-dark-50">
                    Message MISD @ Facebook for inquiries or kindly visit our department for personal assistance.
                   </p>
                  </div>
                 </div>
                </div>
            </div>

        </div>
    @endif
</div>
