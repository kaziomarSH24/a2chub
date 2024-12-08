


@extends('layouts.app')

@section('content')
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
    <form method="POST" action="{{ route('submit.add.data') }}">
        @csrf
        {{-- @dd($application) --}}
        <div class="mb-3">
            <label for="grade" class="form-label">Grade</label>
            <input type="number" class="form-control @error('grade') is-invalid @enderror" value="{{ $application->grade ?? '' }}" id="grade" name="grade" placeholder="12"> 
            @error('grade')      <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="gpa" class="form-label">GPA</label>
            <input type="text" class="form-control @error('gpa') is-invalid @enderror" value="{{$application->gpa ?? ''}}" id="gpa" name="gpa" placeholder="3.8">
            @error('gpa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sat_english_score" class="form-label">SAT English Score</label>
            <input type="number" class="form-control @error('sat_english_score') is-invalid @enderror" id="sat_english_score" value="{{$application->sat_scores['english'] ?? ''}}" name="sat_english_score">
            @error('sat_english_score')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sat_math_score" class="form-label">SAT Math Score</label>
            <input type="number" class="form-control @error('sat_math_score') is-invalid @enderror" id="sat_math_score" value="{{$application->sat_scores['math'] ?? ''}}" name="sat_math_score">
            @error('sat_math_score')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sat_total_score" class="form-label">Total SAT Score</label>
            <input type="number" class="form-control" id="sat_total_score" name="sat_total_score" value="{{$application->sat_scores['total'] ?? ''}}" >
        </div>

        <div class="mb-3">
            <label for="ap_scores" class="form-label">AP Test Scores</label>
            <div id="ap_scores_container">
                @if (isset($application))
                    @foreach(($application->ap_scores ?? []) as $index => $ap_score)      
                    <div class="mb-2 d-flex align-items-center" style="position: relative">
                        <input type="text" class="form-control @error('ap_scores') is-invalid @enderror" name="ap_scores[]" placeholder="AP Subject: Score" value="{{$ap_score ?? ''}}">
                        @if($index > 0)
                        <button type="button" onclick="remove(this)" class="btn btn-danger btn-sm ms-2 remove-ap-score" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>
                        @endif
                    </div>
                    @endforeach 
                @else
                    <div class="mb-2">
                        <input type="text" class="form-control @error('ap_scores') is-invalid @enderror" name="ap_scores[]" placeholder="AP Subject: Score" value="{{ old('ap_scores.0', 'AP Calculus: 5') }}">
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary" id="add_ap_score">Add More AP Test Scores</button>
            @error('ap_scores')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="extracurriculars" class="form-label">Extracurricular Activities</label>
            <div id="extracurriculars_container">
                @if (isset($application))
                    @foreach(($application->extracurriculars ?? []) as $index => $extracurricular)
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control @error('extracurriculars') is-invalid @enderror" name="extracurriculars[]" placeholder="Activity" value="{{$extracurricular ?? ''}}">
                        @if($index > 0)
                    <button type="button" onclick="remove(this)" class="btn btn-danger btn-sm ms-2 remove-extracurricular" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>
                    @endif
                    </div>
                    {{-- @dump($index) --}}
                    

                    @endforeach
                @else
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control @error('extracurriculars') is-invalid @enderror" name="extracurriculars[]" placeholder="Activity" value="{{ old('extracurriculars.0', 'Soccer') }}">
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary" id="add_extracurricular">Add More Activities</button>
            @error('extracurriculars')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="awards" class="form-label">Awards</label>
            <div id="awards_container">
                @if (isset($application))
                    @foreach(($application->awards ?? []) as $index => $award)
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control @error('awards') is-invalid @enderror" name="awards[]" placeholder="Award" value="{{$award ?? ''}}">
                        @if($index > 0)
                    <button type="button" onclick="remove(this)" class="btn btn-danger btn-sm ms-2 remove-award" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>
                    @endif
                    </div>
                    
                    @endforeach
                @else
                    <div class="mb-2" style="position: relative">
                        <input type="text" class="form-control @error('awards') is-invalid @enderror" name="awards[]" placeholder="Award" value="{{ old('awards.0', 'National Merit Scholar') }}">
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-primary" id="add_award">Add More Awards</button>
            @error('awards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nationality" class="form-label">Nationality</label>
            <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{$application->nationality ?? ''}}" >
            @error('nationality')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="first_choice_major" class="form-label">First Choice Major</label>
            <select class="form-select @error('first_choice_major') is-invalid @enderror" id="first_choice_major" name="first_choice_major">
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
            @error('first_choice_major')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="second_choice_major" class="form-label">Second Choice Major</label>
            <select class="form-select @error('second_choice_major') is-invalid @enderror" id="second_choice_major" name="second_choice_major">
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
            @error('second_choice_major')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="essay" class="form-label">Personal Statement</label>
            <textarea class="form-control @error('essay') is-invalid @enderror" id="essay" name="essay" rows="4" placeholder="Write your personal statement here">{{ $application->essay ?? '' }}</textarea>
            @error('essay')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<!--{{-- JavaScript to dynamically add fields for AP scores, extracurriculars, and awards --}}-->
<script>

    //add ckeditor to the textarea
    CKEDITOR.replace('essay');


    //remove button function
    function remove(e){
        e.parentElement.remove();
    }


    document.getElementById('add_ap_score').addEventListener('click', function() {
        const container = document.getElementById('ap_scores_container');
        const input = document.createElement('div');
        input.className = 'mb-2';
        input.style.position = 'relative';
        input.innerHTML = '<input type="text" class="form-control" name="ap_scores[]" placeholder="AP Subject: Score"><button type="button" class="btn btn-danger btn-sm ms-2 remove-ap-score" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>';      
        input.querySelector('.remove-ap-score').addEventListener('click', function() {
            input.remove();
        });      
        container.appendChild(input);
    });

    

    document.getElementById('add_extracurricular').addEventListener('click', function() {
        const container = document.getElementById('extracurriculars_container');
        const input = document.createElement('div');
        input.className = 'mb-2';
        input.style.position = 'relative';
        input.innerHTML = '<input type="text" class="form-control" name="extracurriculars[]" placeholder="Activity"><button type="button" class="btn btn-danger btn-sm ms-2 remove-extracurricular" style="position: absolute;right: 6px; top: 3px;"><span>&times;</span></button>';
        input.querySelector('.remove-extracurricular').addEventListener('click', function() {
            input.remove();
        });
        container.appendChild(input);
    });

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

    // Auto-calculate total SAT score
    document.getElementById('sat_english_score').addEventListener('input', calculateTotalSAT);
    document.getElementById('sat_math_score').addEventListener('input', calculateTotalSAT);

    function calculateTotalSAT() {
        const englishScore = parseInt(document.getElementById('sat_english_score').value) || 0;
        const mathScore = parseInt(document.getElementById('sat_math_score').value) || 0;
        const total = englishScore + mathScore;
        document.getElementById('sat_total_score').value = total;
    }
</script>
@endsection
