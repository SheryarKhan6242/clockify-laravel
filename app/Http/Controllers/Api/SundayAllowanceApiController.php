<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllowanceType;
use App\Models\Allowance;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use App\Jobs\GetEmailTemplates;
use Spatie\Permission\Models\Role;

class SundayAllowanceApiController extends Controller
{
    public function addRequest(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'allowance_date' => 'required|date_format:Y-m-d',
            'description' => 'required|min:8',
            // 'time_in' => 'required|regex:/^\d{1,2}:\d{2}:\d{2}$/',
            // 'time_out' => 'required|regex:/^\d{1,2}:\d{2}:\d{2}$/',
            'time_in' => 'required',
            'time_out' => 'required',
            ], 
            // [
            //     'time_in.regex' => 'The time_in must be in the format H:m:s.',
            //     'time_out.regex' => 'The time_out must be in the format H:m:s.',
            // ]
        );

        if($validator->fails())
        {
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        $allowanceType = AllowanceType::find(1);
        //If Allowance Type doesn't have that type in DB
        if(!$allowanceType)
            return response()->json(['success' => false, 'message' => 'Allowance type does not exist!']);
        
        try {    
            $allowance = new Allowance();
            $allowance->user_id = $request->user_id;
            $allowance->allowance_date = $request->allowance_date;
            $allowance->description = $request->description;
            // dd(Carbon::createFromFormat('d-m-Y', $request->allowance_date)->format('Y-m-d'));
            // 1 => Sunday, 2 => General, 3 => Medical
            $allowance->allowance_id = 1;
            $allowance->status = 'Pending';
            
            //Convert values to array
            $officeIn = explode(",",$request->time_in);
            $officeOut = explode(",",$request->time_out);

            // Check if the office_in and office_out values are arrays
            if (is_array($officeIn) && is_array($officeOut) && count($officeIn) === count($officeOut)) {
                for ($i = 0; $i < count($officeIn); $i++) {
                    $allowance->time_in = $officeIn[$i];
                    $allowance->time_out = $officeOut[$i];
                    $allowance->save();
                }
            }

            //Email Sunday Allowance to hr-manager
            $hrManagerRole = Role::where('name', 'hr-manager')->first();
            if ($hrManagerRole) {
                //NOTE: Currently fetching only one manager. We need to change this logic later to finalize to whom the email should go based on roles
                // Instead of sending mails directly to hr@inaequo.net send to attendance@inaequostudios.com
                //#################################################HR MANAGER########################################
                //Send one Email based on Hr-manager role 
                $hrManager = User::role($hrManagerRole)->first();
                $current_date = Carbon::now()->format('d M Y');
                $formattedAllowanceDate = Carbon::createFromFormat('Y-m-d',$request->allowance_date)->format('d M Y'); 
                if($hrManager){
                    //Prepare Sunday Allowance Request queue job for Admin and Lead
                    $templateName = 'sunday_allowance_request';
                    //Fetch user information
                    $user = User::find($request->user_id);
                    $placeholders = ['[hr]','[name]','[username]','[allowance_date]','[current_date]'];
                    $values = [$hrManager->name,$user->name,$user->username,$formattedAllowanceDate,$current_date];
                    //Dispatch queue job to Hr/Admin
                    // dd($hrManager->email);
                    GetEmailTemplates::dispatch($hrManager->email, $templateName, $placeholders, $values);
                }
                //#################################################HR MANAGER########################################
                
                //Send another email to attendance-inaequo(THIS EMAIL IS ONLY SENT TO FORWARD IT TO HR@INAEQUO.NET. SINCE @INAEQUO.NET DELAYS THE MAILS DUE TO SOME ISSUE. SO A FORWARDER HAS BEEN ADDED.) 
                //#################################################HR@INAEQUO########################################
                $current_date = Carbon::now()->format('d M Y');
                $formattedAllowanceDate = Carbon::createFromFormat('Y-m-d',$request->allowance_date)->format('d M Y'); 
                //Prepare Sunday Allowance Request queue job for Admin and Lead
                $templateName = 'sunday_allowance_request';
                //Fetch user information
                $user = User::find($request->user_id);
                $placeholders = ['[hr]','[name]','[username]','[allowance_date]','[current_date]'];
                $values = ['HR',$user->name,$user->username,$formattedAllowanceDate,$current_date];
                //Dispatch queue job to Hr/Admin
                GetEmailTemplates::dispatch('attendance@inaequostudios.com', $templateName, $placeholders, $values);
                //#################################################HR@INAEQUO########################################

            }
            else
            {
                Log::error('HR Manager role does not Exist.');
            }
            //#################################################USER MAIL########################################
            // Send Sunday Allowance submission email to user
            $templateName = 'sunday_allowance_submission';
            //Fetch user
            $user = User::find($request->user_id);
            $placeholders = ['[username]'];
            $values = [$user->name];
            //Dispatch queue job
            GetEmailTemplates::dispatch($user->email, $templateName, $placeholders, $values);
            //#################################################USER MAIL########################################

            
            return response()->json(['success' => true, 'message' => 'Sunday Allowance Submitted Successfully!']);
    
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function getAllowanceRecord($userId)
    {
        $allowanceDate = request()->query('allowance_date');
    
        $dateRegex = '/^\d{4}-\d{2}-\d{2}$/';
        if ($allowanceDate == null || !preg_match($dateRegex, $allowanceDate))
            abort(404);
    
        $allowance = Report::where('user_id', $userId)
            ->where('login_date', Carbon::parse($allowanceDate)->format('Y-m-d'))
            ->get();
    
        if ($allowance->count() <=0) {
            return response()->json(['success' => false, 'message' => 'No Allowance Request Submitted.']);
        }
    
        return response()->json(['success' => true, 'data' => $allowance]);               
    }
}
