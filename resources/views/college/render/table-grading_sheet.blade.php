<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-light-success add-activity">Add Activities</button>
    <button type="button" class="btn btn-light-success add-column">Add Column</button>
    <button type="button" class="btn btn-light-success remove-column">Remove Column</button>
</div>
<div class="row">
    @if( !empty($student_score) )
        <div class="col">
            <table class="table table-bordered table-hover table-checkable" id="frs_datatable" style="margin-top: 13px !important">
                <thead class="table-primary">
                    <tr>
                        <th class="align-middle text-center">#</th>
                        <th class="align-middle">Student ID</th>
                        <th class="align-middle">Name</th>
                        @foreach($import as $x =>$imports)
                            <th class="align-middle text-center"> {{ __('CP #'.$x+1) }}</th>
                        @endforeach
                        @for ($y=0; $y <count($column);$y++)
                            <th class="align-middle text-center text-uppercase">{{ __('CP #'.$x+($y+1)) }}</th>
                        @endfor
                        <th class="align-middle text-center">Total</th>
                        <th class="align-middle text-center text-uppercase">{{ $type_name }}</th>
                    </tr>
                    <tr class="bg-secondary hps-header">
                        <th class="align-middle" rowspan="1" colspan="3" >
                            <span class="pl-10"> Highest Possible Score </span>
                        </th>
                        @foreach($import as $x =>$imports)
                        <th class="align-middle text-center">
                            <input type="text" class="text-center import-input" size='1' value="{{ $imports->import_lms->hps }}" disabled>
                        </th>
                        @endforeach
                        @for ($y=0; $y<count($column);$y++)
                        <th class="align-middle text-center text-uppercase">{{ __('CP #'.$x+($y+1)) }}</th>
                        @endfor
                        <th class="align-middle text-center">
                            <input type="text" class="text-center" size='1' value="{{ $total_all_hps }}" disabled>
                        </th>
                        <th class="align-middle text-center">
                            <input type="text" class="text-center" size='1' value="{{  __(($percent_type*100).'%') }}" disabled>
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
                            <td class="text-center">{{ $stud_score['import_'.$x] }}</td>
                            @endfor
                            @for ($y=0; $y <count($column);$y++)
                            <td class="text-center">{{ $stud_score['column_'.$x] }}</td>
                            @endfor
                            <td class="text-center">{{ $stud_score['total_score'] }}</td>
                            <td class="text-center">{{ $stud_score['calculated_score'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        Empty
    @endif
</div>
