<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Subject;
use Google\Cloud\Storage\Connection\Rest;
use Illuminate\Http\Request;
// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use YooKassa\Validator\Constraints\Valid;

class ChatbotController extends Controller
{
    public function additionalDataForm()
    {
        $application = Application::where('user_id', auth()->user()->id)->first();
        $subjects = Subject::where('user_id', auth()->user()->id)->get();

        if ($application) {
            $application->sat_scores = json_decode($application->sat_scores, true);
            $application->ap_scores = json_decode($application->ap_scores, true);
            $application->extracurriculars = json_decode($application->extracurriculars, true);
            $application->awards = json_decode($application->awards, true);
            // dd($application);
            return view('user.chat_bot.additional_info_form', compact('application','subjects'));
        } else {
            return view('user.chat_bot.additional_info_form', compact('subjects'));
        }
    }



    // public function submitApplication(Request $request)
    // {
    //     // dd($request->all());
    //     $user_id = auth()->user()->id;

    //     // dd($request->all());
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'grade' => 'required|integer',
    //         'gpa' => 'required|numeric',
    //         'past_sat_score' => 'required|integer', // new field
    //         'future_testing_date' => 'nullable|array', // new field
    //         'future_testing_date.*' => 'date', // new field
    //         'sat_english_score' => 'nullable|integer',
    //         'sat_math_score' => 'nullable|integer',
    //         'ap_plan_date' => 'nullable|array', // new field
    //         'ap_plan_date.*' => 'date', // new field
    //         'ap_subjects' => 'nullable|array',
    //         'ap_subjects.*' => 'string',
    //         'ap_scores' => 'nullable|array',
    //         'ap_scores.*' => 'integer',
    //         'timing_participation' => 'nullable|array',
    //         'timing_participation.*' => 'string',
    //         'hours_per_week' => 'nullable|array',
    //         'hours_per_week.*' => 'string',
    //         'weeks_per_year' => 'nullable|array',
    //         'weeks_per_year.*' => 'string',

    //         'awards' => 'nullable|array',
    //         'awards.*' => 'string',
    //         'nationality' => 'nullable|string',
    //         'first_choice_major' => 'nullable|string',
    //         'second_choice_major' => 'nullable|string',
    //         'essay' => 'nullable|string',
    //     ]);

    //     if ($request->has('act') && $request->act == 'yes') {
    //         $validatedData = array_merge($validatedData, $request->validate([
    //             'ex_Subject' => 'required|array',
    //             'ex_Subject.*' => 'string',
    //             'ex_position_description' => 'required|array',
    //             'ex_position_description.*' => 'string',
    //             'ex_organization' => 'nullable|array',
    //             'ex_organization.*' => 'string',
    //             'ex_activiy_describe' => 'required|array',
    //             'ex_activiy_describe.*' => 'string',
    //             'ex_activity_participation' => 'required|array',
    //             'ex_activity_participation.*' => 'string',
    //         ]));
    //     }

    //     // Calculate the total SAT score
    //     $total_sat_score = $validatedData['sat_english_score'] + $validatedData['sat_math_score'];

    //     $sat_scores = json_encode([
    //         'past_sat_score' => $validatedData['past_sat_score'],
    //         'sat_sitting' => $request->SATsitting,
    //         'future_testing_date' => json_encode($validatedData['future_testing_date']),
    //         'english' => $validatedData['sat_english_score'],
    //         'math' => $validatedData['sat_math_score'],
    //     ]);

    //     $apData = [];
    //     foreach ($request->ap_plan_date as $index => $date) {
    //         $apData[] = [
    //             'plan_date' => $date,
    //             'subject' => $request->ap_subject[$index] ?? null,
    //             'score' => $request->ap_scores[$index] ?? null,
    //         ];
    //     }

    //     $experienceData = [];
    //     foreach ($request->ex_Subject as $index => $subject) {
    //         $experienceData[] = [
    //             'subject' => $subject,
    //             'position_description' => $request->ex_position_description[$index] ?? null,
    //             'organization' => $request->ex_organization[$index] ?? null,
    //             'activity_describe' => $request->ex_activiy_describe[$index] ?? null,
    //             'activity_participation' => $request->ex_activity_participation[$index] ?? null,
    //             'timing_participation' => $request->timing_participation[$index] ?? null,
    //             'hours_per_week' => $request->hours_per_week[$index] ?? null,
    //             'weeks_per_year' => $request->weeks_per_year[$index] ?? null,
    //         ];
    //     }

    //     // Store the data in the applications table
    //     // $application = Application::updateOrCreate(
    //     //     ['user_id' => $user_id],
    //     //     [
    //     //         'grade' => $validatedData['grade'],
    //     //         'gpa' => $validatedData['gpa'],
    //     //         'sat_scores' => json_encode([
    //     //             'english' => $validatedData['sat_english_score'],
    //     //             'math' => $validatedData['sat_math_score'],
    //     //             'total' => $total_sat_score
    //     //         ]),
    //     //         'ap_scores' => json_encode($validatedData['ap_scores']),
    //     //         'extracurriculars' => json_encode($validatedData['extracurriculars']),
    //     //         'awards' => json_encode($validatedData['awards']),
    //     //         'nationality' => $validatedData['nationality'],
    //     //         'first_choice_major' => $validatedData['first_choice_major'],
    //     //         'second_choice_major' => $validatedData['second_choice_major'],
    //     //         'essay' => $validatedData['essay']
    //     //     ]
    //     // );
    //     $application = Application::updateOrCreate(
    //         ['user_id' => $user_id],
    //         [
    //             'grade' => $validatedData['grade'],
    //             'gpa' => $validatedData['gpa'],
    //             'sat_scores' => $sat_scores,
    //             'ap_scores' => json_encode($apData),
    //             'extracurriculars' => json_encode($experienceData),
    //             'awards' => json_encode($validatedData['awards']),
    //             'nationality' => $validatedData['nationality'],
    //             'first_choice_major' => $validatedData['first_choice_major'],
    //             'second_choice_major' => $validatedData['second_choice_major'],
    //             'essay' => $validatedData['essay']
    //         ]
    //     );

    //     // Redirect back with a success message
    //     return redirect()->back()->with('success', 'Application submitted successfully!');
    // }

    public function submitApplication(Request $request)
    {
        $user_id = auth()->user()->id;

        $application = Application::updateOrCreate(
            ['user_id' => $user_id],
            [
                'grade' => $request->grade,
                'gpa' => $request->gpa,
                'sat_scores' => json_encode($request->sat_scores),
                'ap_scores' => json_encode($request->ap_scores),
                'extracurriculars' => json_encode($request->extracurriculars),
                'awards' => json_encode($request->awards),
                'nationality'=> $request->nationality,
                'first_choice_major' => $request->first_choice_major,
                'second_choice_major' => $request->second_choice_major,
                'essay' => $request->essay
            ]
        );
    
        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully!',
            'data' => $application
        ]);
    }

    //add subject to the database
    public function addSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:subjects'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $subject = new Subject();
        $subject->user_id = auth()->user()->id;
        $subject->name = $request->name;
        $subject->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Subject added successfully!'
        ]);
    }




    public function customChatbotV2()
    {
        return view('user.chat_bot.chat_view');
    }


    // public function getDataAndGenerateResponse(Request $request)
    //     {
    //         try {
    //             // Get the authenticated user's ID
    //             $user_id = auth()->user()->id;
    //             // Retrieve the user data from the Application model
    //             $user_data = Application::where('user_id', $user_id)->first();
    //             dd($user_data);
    //             // If no data is found, return a default response
    //             if (!$user_data) {
    //                 return response()->json(['error' => 'No application data found for this user.'], 404);
    //             }

    //             // Extract the data from the $user_data object
    //             $grade = $user_data->grade;
    //             $gpa = $user_data->gpa;
    //             $sat_scores = $user_data->sat_scores;
    //             $ap_scores = $user_data->ap_scores;
    //             $extracurriculars = $user_data->extracurriculars;
    //             $awards = $user_data->awards;
    //             $nationality = $user_data->nationality;
    //             $first_choice_major = $user_data->first_choice_major;
    //             $second_choice_major = $user_data->second_choice_major;
    //             $message = $request->message;

    //             // Combine the data into a prompt
    //             $prompt = "The student has provided the following information about their application:\n";
    //             $prompt .= "Grade: $grade\n";
    //             $prompt .= "GPA: $gpa\n";
    //             $prompt .= "SAT Scores: $sat_scores\n";
    //             $prompt .= "AP Scores: $ap_scores\n";
    //             $prompt .= "Extracurricular Activities: $extracurriculars\n";
    //             $prompt .= "Awards: $awards\n";
    //             $prompt .= "Nationality: $nationality\n";
    //             $prompt .= "First Choice Major: $first_choice_major\n";
    //             $prompt .= "Second Choice Major: $second_choice_major\n";
    //             $prompt .= "Response should be based on those promt";
    //             $prompt .= "$message\n";

    //             dd($prompt);

    //             // Call the OpenAI API to generate a response based on this prompt
    //             $response = Http::withHeaders([
    //                 "Content-Type" => "application/json",
    //                 "Authorization" => "Bearer " . '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'
    //             ])->post('https://api.openai.com/v1/chat/completions', [
    //                 "model" => "gpt-4o-mini", // You can adjust the model if needed
    //                 // "model" => "ft:gpt-4o-2024-08-06:a2chub:eric1:AAZYz3u3",
    //                 "messages" => [
    //                     [
    //                         "role" => "user",
    //                         "content" => $prompt
    //                     ]
    //                 ],
    //                 "temperature" => 0,
    //                 "max_tokens" => 2048
    //             ])->json(); // Convert the response to JSON


    //             // Check if there is an error in the response
    //             if (isset($response['error'])) {
    //                 return response()->json([
    //                     'error' => $response['error']['message']
    //                 ], 400);  // Return the specific error from OpenAI API
    //             }

    //             // Return the response from OpenAI
    //             return response()->json([
    //                 'response' => $response['choices'][0]['message']['content']
    //             ]);
    //         } catch (Throwable $e) {
    //             // Return the error message if an exception occurs
    //             return response()->json([
    //                 'error' => $e->getMessage()
    //             ], 500);
    //         }
    //     }

    public function getDataAndGenerateResponse(Request $request)
    {
        try {
            $user_id = auth()->user()->id;

            // Check if application data is already stored in the session
            if (!session()->has('application_data')) {
                // Retrieve the user data from the Application model
                $user_data = Application::where('user_id', $user_id)->first();

                if (!$user_data) {
                    return response()->json(['error' => 'No application data found for this user.'], 404);
                }

                // Store application data in a session to use it in prompts
                session()->put('application_data', [
                    'grade' => $user_data->grade,
                    'gpa' => $user_data->gpa,
                    'sat_scores' => json_decode($user_data->sat_scores, true),
                    'ap_scores' => json_decode($user_data->ap_scores, true),
                    'extracurriculars' => json_decode($user_data->extracurriculars, true),
                    'awards' => json_decode($user_data->awards, true),
                    'nationality' => $user_data->nationality,
                    'first_choice_major' => $user_data->first_choice_major,
                    'second_choice_major' => $user_data->second_choice_major,
                    'essay' => $user_data->essay,
                ]);
            }

            // Prepare prompt based on stored application data and the user's question
            $application_data = session('application_data');
            $message = $request->message;
            $prompt = "Based on the user's application data:\n";

            // Format application data into a prompt-friendly structure
            foreach ($application_data as $key => $value) {
                if (is_array($value)) {
                    $value = implode(', ', $value); // Convert arrays to comma-separated lists
                }
                $prompt .= ucfirst($key) . ": $value\n";
            }

            // Add user message to the prompt for dynamic response generation
            $prompt .= "\nUser's Question: \"$message\"";

            // Send the prompt to OpenAI API to get a response
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . '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'
            ])->post('https://api.openai.com/v1/chat/completions', [
                // "model" => "gpt-4o-mini",
                "model" => "ft:gpt-4o-2024-08-06:a2chub:eric1:AAZYz3u3",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $prompt
                    ]
                ],
                "temperature" => 0.7,
                "max_tokens" => 500
            ])->json();

            if (isset($response['error'])) {
                return response()->json([
                    'error' => $response['error']['message']
                ], 400);
            }

            return response()->json([
                'response' => $response['choices'][0]['message']['content']
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
