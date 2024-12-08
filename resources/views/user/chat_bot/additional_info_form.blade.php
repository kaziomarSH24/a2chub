
@extends('layouts.app')

@section('content')

<style>
    .activitiesArea{
        position: relative;
    }
    .sec1{
        display: none !important;
    }
    .actRmvBtn{
        position: absolute;
        right: 35px;
        top: -3px;
        background-color: crimson;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
<div class="container mt-5">
    <h2 class="mb-4">Application Form</h2>
    
    {{-- Display success message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- Display validation errors as a list --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form starts here --}}
    <form id="applicationSubmitForm">
        @csrf
        {{-- @dd(count($application->sat_scores['future_testing_date'])); --}}
        {{-- @dd($application->extracurriculars); --}}
        <div class="mb-3">
            <label for="grade" class="form-label">Grade</label>
            <input type="number" class="form-control input-validate" value="{{ $application->grade ?? '' }}" id="grade" name="grade" placeholder="12" required> 
            <div class="invalid-feedback">The grade filed is required</div>
        </div>
        
        <div class="mb-3">
            <label for="gpa" class="form-label">GPA</label>
            <input type="text" class="form-control input-validate" value="{{$application->gpa ?? ''}}" id="gpa" name="gpa" placeholder="3.8" required>
            <div class="invalid-feedback">The GPA filed is required</div>
        </div>

        {{-- dropdwon selected button SAT Score--}}
        <div class="card mb-3">
            <div class="card-body mb-3">
                <h3 for="ap_scores" class="form-label">SAT Test Scores</h3>
                <p class="card-text mt-1">Number of past SAT scores you wish to report</p>
                <select class="form-select selected_filed fs-6" name="past_sat_score" id="pastSARscores" aria-label="satTest">
                    <option value="" selected> - Choose an Option - </option>
                    @if (isset($application->sat_scores))
                        
                        @for ($i = 0; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ $application->sat_scores['past_sat_score'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    @else
                        @for ($i = 0; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    @endif
                   
                </select>
                <div class="invalid-feedback">The SAT scores field is required</div>
        
                <div id="dynamicSATArea" class="mt-4">
                    {{-- Dynamic AP test fields will be added here --}}
                </div>
            </div>
        </div>

        {{-- dropdwon selected button --}}
        <div class="card mb-3">
            <div class="card-body mb-3">
                <h3 for="ap_scores" class="form-label">AP Test Scores</h3>
                <p class="card-text mt-1">Number of AP Tests you wish to report, including tests you expect to take</p>
                <select class="form-select fs-6" id="apTestSelect" aria-label="apTest">
                    <option value="" selected> - Choose an Option - </option>
                    @if(isset($application->ap_scores))
                        @for ($i = 0; $i <= 15; $i++)
                            <option value="{{ $i }}" {{ count($application->ap_scores) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor

                    @else
                        @for ($i = 0; $i <= 15; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    @endif
                </select>
        
                <div id="dynamicApArea" class="mt-4">
                    {{-- Dynamic AP test fields will be added here --}}
                </div>
            </div>
        </div>


        {{-- Activities  --}}
        <div class="card mb-3">
            <div class="card-body mb-3">
                <h3 for="extracurricular" class="form-label">Extracurricular Activities</h3>
                <div class="mb-3">
                    <p>Do you have any activities that you wish to report? </p>
                        <div class="mb-2">
                            <input class="form-check-input" type="radio" name="act" id="actYes" value="yes" {{ isset($application->extracurriculars) ? "checked" : "" }}>
                            <label class="form-check-label ms-2" for="actYes" style="font-size: 1.2rem;">Yes</label>
                        </div>
                        <div class="mb-2">
                            <input class="form-check-input" type="radio" name="act" id="actNo" value="no">
                            <label class="form-check-label ms-2" for="actNo" style="font-size: 1.2rem;">No</label>
                        </div>
                </div>
            </div>
                <div id="dynamicActivities" class="mt-4">
                    {{-- Dynamic Activities area --}}
                    
                </div>
                <div id="addActivityBtn" class="my-3 px-3 text-end d-none">
                    <button type="button" class="btn btn-primary">Add another activity</button>
                </div>
            </div>

        <div class="mb-3">
            <label for="awards" class="form-label">Awards</label>
            <div id="awards_container">
                @if (isset($application))
                    @foreach(($application->awards ?? []) as $index => $award)
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control input-validate" name="awards[]" placeholder="Award" value="{{$award ?? ''}}">
                        @if($index > 0)
                    <button type="button" onclick="remove(this)" class="btn btn-danger btn-sm ms-2 remove-award" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>
                    @endif
                    </div>
                    
                    @endforeach
                @else
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control" name="awards[]" placeholder="Award" value="{{ old('awards.0', 'National Merit Scholar') }}">
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary" id="add_award">Add More Awards</button>
            <div class="invalid-feedback">The award filed is required</div>
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" class="form-control input-validate" id="nationality" name="nationality" value="{{$application->nationality ?? ''}}">
            <div class="invalid-feedback">The nationality filed is required</div>
        </div>

        <div class="mb-3">
            <label for="first_choice_major" class="form-label">First Choice Major</label>
            <select class="form-select" id="first_choice_major" name="first_choice_major">
               @if(isset($application))
                    <option value="Mathematics" {{ $application->first_choice_major == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                    <option value="Computer Science" {{ $application->first_choice_major == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Physics" {{ $application->first_choice_major == 'Physics' ? 'selected' : '' }}>Physics</option>
                @else
                    <option value="Mathematics" {{ old('first_choice_major') == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                    <option value="Computer Science" {{ old('first_choice_major') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Physics" {{ old('first_choice_major') == 'Physics' ? 'selected' : '' }}>Physics</option>
                @endif
            </select>
        </div>

        <div class="mb-3">
            <label for="second_choice_major" class="form-label">Second Choice Major</label>
            <select class="form-select" id="second_choice_major" name="second_choice_major">
                @if(isset($application))
                    <option value="Mathematics" {{ $application->second_choice_major == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                    <option value="Computer Science" {{ $application->second_choice_major == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Physics" {{ $application->second_choice_major == 'Physics' ? 'selected' : '' }}>Physics</option>
                @else
                    <option value="Mathematics" {{ old('second_choice_major') == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                    <option value="Computer Science" {{ old('second_choice_major') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    <option value="Physics" {{ old('second_choice_major') == 'Physics' ? 'selected' : '' }}>Physics</option>
                @endif
            </select>
        </div>

        <div class="mb-3">
            <label for="essay" class="form-label">Personal Statement</label>
            <textarea class="form-control" id="essay" name="essay" rows="4" placeholder="Write your personal statement here">{{ $application->essay ?? '' }}</textarea>
            <div class="invalid-feedback">The essay filed is required</div>
        </div>

        <button type="submit" id="submitBtn" class="btn btn-primary">Submit Application</button>
    </form>



    {{-- //modal for add subject --}}
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubjectModalLabel">Add New Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSubjectForm">
                        <div class="mb-3">
                            <label for="newSubject" class="form-label">New Subject</label>
                            <input type="text" class="form-control" id="newSubject" name="newSubject" placeholder="Enter new subject" required>
                        </div>
                        <button type="submit" id="addSubject" class="btn btn-primary">Add Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>


<!--{{-- JavaScript to dynamically add fields for AP scores, extracurriculars, and awards --}}-->
@push('additional_form_js')
<script>
    $(document).ready(function () {
            /**
             * SAT Test start
             */
            let count = $('#pastSARscores').val();
            let container = $('#dynamicSATArea');
            let container2 = $('.fTestingDate');
            loadFutureSatTest(count);
            
            $('#pastSARscores').on('change', function () {
                 count = $(this).val();
                container.empty(); 
    
                loadFutureSatTest(count);// load future sat test here
            });
    
            //add future sat test
            function loadFutureSatTest(count){
                if (count > 0) {
                    let s_count = {{(isset($application) && isset($application->sat_scores['future_testing_date'])) ? count($application->sat_scores['future_testing_date']) : 0}};
                        container.append(`
                            <div class="sat_area mb-4">
                                <div class="mb-3">
                                    <label>Number of future SAT sittings you expect</label>
                                    ${[0, 1, 2, 3].map(score => `
                                        <div class="mb-2">
                                            <input class="form-check-input satSitting" type="radio" name="SATSitting[]" id="SATSitting${score}" value="${score}" ${s_count == score ? 'checked' : ''}>
                                            <label class="form-check-lebel ms-2" for="SATSitting${score}" style="font-size: 1.2rem;">${score}</label>
                                        </div>
                                    `).join('')}
                                </div>
                                <div class="mb-3 fTestingDate">
                                    {{-- future testing --}}
                                </div>
    
                                <div class="mb-2">
                                    <label for="math_score" class="form-label">Highest math score</label>
                                    <select class="form-select" id="math_score" name="math_score">
                                        <option value="" selected> - Choose an Option - </option>
                                       @if(isset($application->sat_scores['math_score']))
                                            @for ($i = 800; $i >= 200; $i -= 10)
                                                <option value="{{ $i }}" {{ $application->sat_scores['math_score'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        @else
                                            @for ($i = 800; $i >= 200; $i -= 10)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Please seletc your Math score</div>
                                </div>
    
                                <div class="mb-2">
                                    <label for="english_score" class="form-label">Highest English score</label>
                                    <select class="form-select" id="english_score" name="english_score">
                                        <option value="" selected> - Choose an Option - </option>
                                        @if(isset($application->sat_scores['english_score']))
                                            @for ($i = 800; $i >= 200; $i -= 10)
                                                <option value="{{ $i }}" {{ $application->sat_scores['english_score'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        @else
                                            @for ($i = 800; $i >= 200; $i -= 10)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        @endif
                                    </select>
                                    <div class="invalid-feedback">Please seletc your English score</div>
                                </div>
                                 
                            </div>
                            
                        `);
                      
                        let count = {{(isset($application) && isset($application->sat_scores['future_testing_date'])) ? count($application->sat_scores['future_testing_date']) : 0}};
                        fTestingDate(count);
                        $(document).on('change', '.satSitting', function () {
                        let count = $(this).val(); 
                        let container2 = $('.fTestingDate');
    
                        container2.empty(); 
                        fTestingDate(count);
                    });
                }
    
                //add future sat test date
                
            }
    
            /**
             * Add future sat test date
             * @param {number} count 
             */
            
            function fTestingDate(count){
                let setDate = [];
                @if(isset($application->sat_scores['future_testing_date']))
                    @foreach($application->sat_scores['future_testing_date'] as $index => $date)
                       setDate.push('{{ $date }}');
                    @endforeach
                @endif
                let container2 = $('.fTestingDate');
                    if (count > 0) {
                            for (let i = 1; i <= count; i++) {
                                container2.append(`
                                    <div class="mb-3">
                                        <label for="date${i}">Future testing date ${i}</label>
                                        <input type="month" name="future_testing_date[]" class="form-control input-validate" id="fdate${i}" value="${setDate && setDate[i-1] ? setDate[i-1] : ''}">
                                        <div class="invalid-feedback">The Future testing date ${i} filed is required</div>
                                    </div>
                                `);
                            }
                        }
                }
           
           /**
            * SAT Test end
            */
           
    
           /**
            *  AP Test start 
            */
           let APcoutn = $('#apTestSelect').val();
           let APcontainer = $('#dynamicApArea');
           let ap_score = [];
    
           @if(isset($application->ap_scores))
                @foreach($application->ap_scores as $index => $ap_score)
                ap_score.push({
                    plan_date: "{{$ap_score['plan_date']}}",
                    subject: "{{$ap_score['subject']}}",
                    score: "{{$ap_score['score']}}"
                });
                @endforeach
            @endif
    
           loadAPtest(APcoutn); //initial load ap test
    
            $('#apTestSelect').on('change', function () {
                 APcoutn = $(this).val(); 
                APcontainer.empty(); 
                loadAPtest(APcoutn); // load after change
    
                //add subject
                $(document).on('submit', '#addSubjectForm', function (e) {
                    e.preventDefault();
    
                    const newSubject = $('#newSubject').val().trim();
    
                    if (newSubject) {
                        $.ajax({
                            url: '{{ route('add.subject') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                name: newSubject
                            },
                            success: function (response) {
                                if (response.status == 'success') {
                                    $('#subject1').append(`<option value="${newSubject}">${newSubject}</option>`);
                                    $('#subject1').val(newSubject);
                                    $('#addSubjectModal').modal('hide');
                                    $('#addSubjectForm')[0].reset();
                                    toastr.success(response.message);
                                }else{
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                });
            });
    
            function loadAPtest(count){
                        
                if (count > 0) {
                    for (let i = 1; i <= count; i++) {
                        APcontainer.append(`
                                   <div class="ap_area mb-4">
                                <h5 style="color: #018749">AP Test ${i}</h5>
                                <div class="mb-3">
                                    <label for="date${i}">Date taken or planned</label>
                                    <input type="month" name="ap_plan_date[]" class="form-control planned-date" id="date${i}" name="date${i}" value="${ap_score.length > 0 && ap_score.length >= i ? ap_score[i-1]['plan_date'] : '' }"> 
                                     <div class="invalid-feedback">The date filed is required</div>
                                </div>
                                <div class="mb-3">
                                    <label for="subject${i}">Subject</label>
                                    <div class="d-flex align-items-center">
                                        <select class="form-select subject-dropdown" id="subject${i}" name="ap_subjects[]">
                                            <option value="" selected> - Choose an Option - </option>
                                            @if(isset($subjects))
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->name }}" ${ ap_score.length > 0 && ap_score.length >= i ? ap_score[i-1]['subject'] == "{{$subject->name}}" ? "selected" : "" : "" }  >{{ $subject->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                                        <span style="font-size: 22px;">&#43;</span>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">The subject filed is required</div>
                                </div>
    
                                <div class="mb-3">
                                    <p>Score</p>
                                    ${[5, 4, 3, 2, 1].map(score => `
                                        <div class="mb-2">
                                            <input data-i="${i}" class="form-check-input ap_sub_score" type="radio" name="ap_scores_${i}[]" id="score${i}_${score}" value="${score}" ${ap_score.length > 0 && ap_score.length >= i ? ap_score[i-1]['score'] == score ? "checked" : "" : ""} >
                                            <label class="form-check-label ms-2" for="score${i}_${score}" style="font-size: 1.2rem;">${score}</label>
                                            
                                        </div>
                                    `).join('')}
                                    <div class="invalid-feedback">Please complete the required filed</div>
                                </div>
                            </div>
                        `);
                    }
                }
            }
    
    
            /**
             * AP Test end
             */
    
    
             /**@argument
              * Activities start
              */
             let activitiesStatus = $('#actYes');
             let ATcontainer = $('#dynamicActivities');
             let addActivityBtn = $('#addActivityBtn');
             let setExtracurriculars = [];
             
             //set extracurriculars from database
            @if(isset($application->extracurriculars))
                @foreach($application->extracurriculars as $index => $activity)
                    setExtracurriculars.push({
                        second_major: "{{$activity['second_major']}}",
                        position_description: "{{$activity['position_description']}}",
                        organization_name: "{{$activity['organization_name']}}",
                        activity_describe: "{{$activity['activity_describe']}}",
                        activity_participation: "{{$activity['activity_participation']}}",
                        timing_participation: "{{$activity['timing_participation']}}",
                        hours_per_week: "{{$activity['hours_per_week']}}",
                        weeks_per_year: "{{$activity['weeks_per_year']}}"
                    });
                @endforeach
            @endif
            
            let sectionCount = setExtracurriculars.length > 0 ? setExtracurriculars.length : 1;
            console.log(sectionCount);
            
    
             if(activitiesStatus.is(':checked')){
                ATcontainer.empty();
                addActivityBtn.removeClass('d-none'); 
                $('#addActivityBtn button').off('click').on('click', function () {
                        sectionCount++;
                        // console.log(sectionCount);
                        if (sectionCount <= 10) {
                            loadActivity(sectionCount, ATcontainer, setExtracurriculars);
                        }else{
                            toastr.error('You can add only 10 activities');
                        }  
                });
                let actRmvBtn = $('.actRmvBtn');
                        $(document).on('click', '.actRmvBtn', function () {
                            $(this).parent().remove();
                            sectionCount--;
                            if (sectionCount < 1) {
                                sectionCount = 1;
                            }
                        });
             }
             
             
            $('input[name="act"]').on('change', function () {
                let value = $(this).val();
                addActivityBtn.addClass('d-none');
                ATcontainer.empty();
                if (value === 'yes') {
                    addActivityBtn.removeClass('d-none');
                        if(setExtracurriculars.length > 0){
                            for(let i = 1; i <= setExtracurriculars.length ; i++){
                        loadActivity(i, ATcontainer, setExtracurriculars[i-1], setExtracurriculars.length);
                        }
                    }else{
                        loadActivity(sectionCount, ATcontainer, setExtracurriculars);
                    }
    
                    $('#addActivityBtn button').off('click').on('click', function () {
                        sectionCount++;
                        if (sectionCount <= 10) {
    
                            loadActivity(sectionCount, ATcontainer, setExtracurriculars);
                        }   
                });
                };
            
                    //remove activity button handel
                   
                        let actRmvBtn = $('.actRmvBtn');
                        $(document).on('click', '.actRmvBtn', function () {
                            $(this).parent().remove();
                            sectionCount--;
                            if (sectionCount < 1) {
                                sectionCount = 1;
                            }
                        });
            });
    
    
            //load activity from database
            if(setExtracurriculars.length > 0){
                for(let i = 1; i <= setExtracurriculars.length ; i++){
               loadActivity(i, ATcontainer, setExtracurriculars[i-1], setExtracurriculars.length);
            }
            }
                
    
            function loadActivity(sectionCount, container, setExtracurriculars, len){
                console.log(len != undefined);
                
                        container.append(`
                        <div class="activitiesArea mx-2 px-3">
                            <div class="countActivity" style="color: #018749" data-count="${sectionCount}">Activity ${sectionCount}</div>
                            <div class="mb-3 mt-5">
                                <label for="second_choice_major" class="form-label">Second Choice Major</label>
                                <select class="form-select fs-6 selected_filed" id="activitySelected${sectionCount}" aria-label="apTest" name="ex_Subject[]">
                                    <option value="" selected> - Choose an Option - </option>
                                    ${['Mathematics', 'Computer Science', 'Physics'].map(major => `
                                        <option value="${major}" ${ major == setExtracurriculars['second_major'] ? 'selected' : ''} >${major}</option>
                                    `).join('')}
                                </select>
                                <div class="invalid-feedback">The Second Choice Major filed is required</div>
                            </div>
                            <div class="mb-5">
                                <label for="position_description" class="form-label">
                                    <span>Position/Leadership description <br>
                                        (Max characters: 50)</span>
                                </label>
                                <input type="text" class="form-control input-validate" id="position_description" name="ex_position_description[]" maxlength="50" value="${ setExtracurriculars != 0 && len != undefined ? setExtracurriculars['position_description'] : ''}" required>
                               <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
                            <div class="mb-5">
                                <label for="exOrganization" class="form-label">
                                    <span>Organization Name <br>
                                        (Max characters: 100)</span>
                                </label>
                                <input class="form-control" id="exOrganization" name="ex_organization[]" rows="1" maxlength="100" required>${ setExtracurriculars != 0 && len != undefined ? setExtracurriculars['organization_name'] : ''}</input>
                            </div>
                            <div class="mb-5">
                                <label for="ex_activiy_describe" class="form-label">
                                    <span>Please describe this activity, including what you accomplished and any recognition you received, etc. <br>
                                        (Max characters: 150)</span>
                                </label>
                                <textarea class="form-control" id="ex_activiy_describe" name="ex_activiy_describe" rows="1" maxlength="150" required>${setExtracurriculars != 0 && len != undefined ? setExtracurriculars['activity_describe'] : ''}</textarea>
                                <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
    
                            <div class="mb-5">
                                <label for="ex_activity_participation" class="form-label">Participation grade levels</label>
                                ${[9, 10, 11, 12, 'Post-graduate'].map(level => `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ex_activity_participation${level}" name="ex_activity_participation[]" value="${level}" ${true == setExtracurriculars['activity_participation'].split(', ').map(item => item.trim()).includes(String(level)) ? "checked" : '' }>
                                        <label class="form-check-label" for="ex_activity_participation${level}">${level}</label>
                                    </div> 
                                `).join('')}
                                <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
          
                            <div class="mb-5">
                                <label for="timing_participation${sectionCount}" class="form-label">Timing of participation*</label>
                                ${['During school year', 'During school break', 'All year'].map(timing =>`
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="timing_participation${sectionCount}" name="timing_participation[]" value="${timing}" ${true == setExtracurriculars['timing_participation'].split(', ').map(item => item.trim()).includes(String(timing)) ? "checked" : '' }>
                                        <label class="form-check-label" for="timing_participation${timing}">${timing}</label>
                                    </div>
                                `).join('')}
                                <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
                            <div class="mb-5">
                                <label for="hours_spent_per_week${sectionCount}" class="form-label">
                                    <span>Hours spent per week</span>
                                </label>
                                <input type="text" class="form-control input-validate" id="hours_spent_per_week${sectionCount}" name="hours_per_week[]" maxlength="50" value="${setExtracurriculars != 0 && len != undefined ? setExtracurriculars['hours_per_week'] : ''}">
                                <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
                            <div class="mb-5">
                                <label for="weeks_spent_per_year${sectionCount}" class="form-label">
                                    <span>Weeks spent per year</span>
                                </label>
                                <input type="text" class="form-control input-validate" id="weeks_spent_per_year${sectionCount}" name="weeks_per_year[]" maxlength="50" value="${setExtracurriculars != 0 && len != undefined ? setExtracurriculars['weeks_per_year'] : ''}">
                                <div class="invalid-feedback">Please complete this required question.</div>
                            </div>
                           
                                <button type="button" class="btn btn-danger actRmvBtn sec${sectionCount}"> &#x2716;</button>
                                
                            
                        </div>
                    `);
                    }
    
    
       
            /**
             * Activities end
             */
    
    
    
            //ajax request for submit form
    
            $('#submitBtn').on('click', function (e) {
                e.preventDefault();
                let grade = $('#grade').val().trim();
                let gpa = $('#gpa').val().trim();
                let pastSARscores = $('#pastSARscores').val();
                let satSitting = $('input[name="SATSitting[]"]:checked').val();
                let future_testing_date = {};
                for(let i = 1; i <= satSitting; i++){
                    future_testing_date = {
                        ...future_testing_date,
                        [`date${i}`]: $(`#fdate${i}`).val()
                    };
                }
                let math_score = $('#math_score').val();
                let english_score = $('#english_score').val();
                let sat_scores = {
                    future_testing_date,
                    'past_sat_score': pastSARscores,
                    'math_score': math_score,
                    'english_score': english_score
                };
               
                let apTestSelect = $('#apTestSelect').val();
                let ap_scores = [];
                for (let i = 1; i <= apTestSelect; i++) {
                   let date = $(`#date${i}`).val();
                   let subject = $(`#subject${i}`).val();
                   let score = $(`input[name="ap_scores_${i}[]"]:checked`).val();
                   if (date && subject && score) {
                       ap_scores.push({
                           plan_date: date,
                           subject: subject,
                           score: score
                       });
                   }
                }
    
                let activitiesData = {};
                $(".activitiesArea").each(function (index) {
                    const sectionIndex = index + 1; 
                    const activity = {
                        second_major: $(this).find("select[name='ex_Subject[]']").val(),
                        position_description: $(this).find("input[name='ex_position_description[]']").val(),
                        organization_name: $(this).find("input[name='ex_organization[]']").val(),
                        activity_describe: $(this).find("textarea[name='ex_activiy_describe']").val(),
                        activity_participation: $(this)
                            .find("input[name='ex_activity_participation[]']:checked")
                            .map(function () {
                                return this.value;
                            })
                            .get()
                            .join(", "),
                        timing_participation: $(this)
                            .find("input[name='timing_participation[]']:checked")
                            .map(function () {
                                return this.value;
                            })
                            .get()
                            .join(", "),
                        hours_per_week: $(this).find("input[name='hours_per_week[]']").val(),
                        weeks_per_year: $(this).find("input[name='weeks_per_year[]']").val(),
                    };
    
                    activitiesData[`Activity_${sectionIndex}`] = activity;
                });
    
                let awards = [];
                $('input[name="awards[]"]').each(function () {
                    const award = $(this).val().trim();
                    if (award) {
                        awards.push(award);
                    }
                });
                let nationality = $('#nationality').val();
                let first_choice_major = $('#first_choice_major').val();
                let second_choice_major = $('#second_choice_major').val();
                let essay = CKEDITOR.instances.essay.getData();
    
    
    
                /*==================
                validate form start
                =================*/
    
                $('.input-validate, .selected_filed, textarea').each(function () {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
    
                if(math_score == '' || english_score == ''){
                    $('#math_score').addClass('is-invalid');
                    $('#english_score').addClass('is-invalid');
                }
    
                if(apTestSelect > 0){
                    $('.subject-dropdown').each(function () {
                        if ($(this).val() === '') {
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                    $('.ap_sub_score').each(function () {
                        let i = $(this).data('i');
                        if ($('input[name="ap_scores_' + i + '[]"]:checked').length > 0) {
                            $(this).removeClass('is-invalid');
                        } else {
                            $(this).addClass('is-invalid');
                        }
                    });
                    $('.planned-date').each(function () {
                        if ($(this).val() === '') {
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                }
    
                if(activitiesStatus.is(':checked')){
                    $('.selected_filed').each(function () {
                        if ($(this).val() === '') {
                            $(this).addClass('is-invalid');
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });
                    if('input[name="ex_activity_participation[]"]:checked'){
                        $(this).removeClass('is-invalid');
                    }else{
                        $(this).addClass('is-invalid');
                    }
                    if('input[name="timing_participation[]"]:checked'){
                        $(this).removeClass('is-invalid');
                    }else{
                        $(this).addClass('is-invalid');
                    }
                }
                if(essay == ''){
                    $('#essay').addClass('is-invalid');
                }else{
                    $('#essay').removeClass('is-invalid');
                }
    
                
                //check invalid field
                if ($('.is-invalid').length > 0) { 
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 200
                    }, 500);
                    toastr.error('Please fill all required fields');
                    return;
                }

                /*==================
                validate form end
                =================*/
    
                $.ajax({
                    url: '{{ route('submit.add.data') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        grade: grade,
                        gpa: gpa,
                        sat_scores: sat_scores,
                        ap_scores: ap_scores,
                        extracurriculars: activitiesData,
                        awards: awards,
                        nationality: nationality,
                        first_choice_major: first_choice_major,
                        second_choice_major: second_choice_major,
                        essay: essay
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
    
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href = "{{ route('user.add.data') }}";
                            }, 2000);
                        }else{
                            toastr.error(response.message);
                        }
                    }
                });
            });
        });
    
        //add ckeditor to the textarea
        CKEDITOR.replace('essay');
    
    
        //remove button function
        function remove(e){
            e.parentElement.remove();
        }
    
        // document.getElementById('add_ap_score').addEventListener('click', function() {
        //     const container = document.getElementById('ap_scores_container');
        //     const input = document.createElement('div');
        //     input.className = 'mb-2';
        //     input.style.position = 'relative';
        //     input.innerHTML = '<input type="text" class="form-control" name="ap_scores[]" placeholder="AP Subject: Score"><button type="button" class="btn btn-danger btn-sm ms-2 remove-ap-score" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>';      
        //     input.querySelector('.remove-ap-score').addEventListener('click', function() {
        //         input.remove();
        //     });      
        //     container.appendChild(input);
        // });
    
        
    
        // document.getElementById('add_extracurricular').addEventListener('click', function() {
        //     const container = document.getElementById('extracurriculars_container');
        //     const input = document.createElement('div');
        //     input.className = 'mb-2';
        //     input.style.position = 'relative';
        //     input.innerHTML = '<input type="text" class="form-control" name="extracurriculars[]" placeholder="Activity"><button type="button" class="btn btn-danger btn-sm ms-2 remove-extracurricular" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>';
        //     input.querySelector('.remove-extracurricular').addEventListener('click', function() {
        //         input.remove();
        //     });
        //     container.appendChild(input);
        // });
    
        document.getElementById('add_award').addEventListener('click', function() {
            const container = document.getElementById('awards_container');
            const input = document.createElement('div');
            input.className = 'mb-2';
            input.style.position = 'relative';
            input.innerHTML = '<input type="text" class="form-control" name="awards[]" placeholder="Award"><button type="button" class="btn btn-danger btn-sm ms-2 remove-award" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>';
            input.querySelector('.remove-award').addEventListener('click', function() {
                input.remove();
            });
            container.appendChild(input);
        });
    
        // // Auto-calculate total SAT score
        // document.getElementById('sat_english_score').addEventListener('input', calculateTotalSAT);
        // document.getElementById('sat_math_score').addEventListener('input', calculateTotalSAT);
    
        // function calculateTotalSAT() {
        //     const englishScore = parseInt(document.getElementById('sat_english_score').value) || 0;
        //     const mathScore = parseInt(document.getElementById('sat_math_score').value) || 0;
        //     const total = englishScore + mathScore;
        //     document.getElementById('sat_total_score').value = total;
        // }
    </script>
@endpush

@endsection
