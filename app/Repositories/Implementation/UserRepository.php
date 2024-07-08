<?php

namespace App\Repositories\Implementation;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\UserInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;

class UserRepository implements UserInterface {
    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }
   /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOffices($request) {
        $officeID = $this->aes->decrypt($request->id);
        return Offices::where(['id' => $officeID])->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSections() {
        return Sections::get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTracker($request) {
        $officeID = $this->aes->decrypt($request->id);
        return Tracker::where(['officeID' => $officeID])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocuments($request) {
        $officeID = $this->aes->decrypt($request->id);
        return Documents::where(['officeID' => $officeID])
                    ->where(['status' => 1])
                    ->orderBy('created_at', 'DESC')->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->documentID);
        $officeID = $this->aes->decrypt($request->id);
        $get = Documents::where(['id' => $qrcodeID])->first();
        $tracker = Tracker::where(['officeID' => $officeID])
                ->orderBy('trackerID', 'DESC')
                ->first();

        if($tracker->trackerID != $get->trackerID) {
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'remarks' => null
            ]);
        }
        else {
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'status' => 0,
                'remarks' => 'Done'
            ]);
        }
        $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->count();

        if($logs != 0) {
            Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->update([
                    'documentID' => $qrcodeID,
                ]);
        }
        else {
            Logs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $get->trackerID + 1,
                'officeID' => $get->officeID,
                'userID' => $get->userID
            ]);
        }
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument($request) {
        foreach($request->documentID as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $officeID = $this->aes->decrypt($request->id);
            $get = Documents::where(['id' => $qrcodeID])->first();
            $tracker = Tracker::where(['officeID' => $officeID])
                    ->orderBy('trackerID', 'DESC')
                    ->first();
    
            if($tracker->trackerID != $get->trackerID) {
                Documents::where(['id' => $qrcodeID])->update([
                    'trackerID' => $get->trackerID + 1,
                    'remarks' => null
                ]);
            }
            else {
                Documents::where(['id' => $qrcodeID])->update([
                    'trackerID' => $get->trackerID + 1,
                    'status' => 0,
                    'remarks' => 'Done'
                ]);
            }
            $logs = Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->count();
    
            if($logs != 0) {
                Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->update([
                        'documentID' => $qrcodeID,
                    ]);
            }
            else {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => $get->userID
                ]);
            }
        }
        
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->documentID);
        $officeID = $this->aes->decrypt($request->id);
        
        $get = Documents::where(['id' => $qrcodeID])->first();
        $tracker = Tracker::where(['officeID' => $officeID])->orderBy('trackerID', 'DESC')->first();
        Documents::where(['id' => $qrcodeID])->update(['trackerID' => $get->trackerID - 1]);
        
        $reason = "
            <div class='mt-2'>
                Returned by: 
            </div>
            <div class='mt-0 text-dark'>
                ".Auth::user()->Section->Office->office."
            </div>
            <div class='mt-0 text-dark'>
                ".Auth::user()->Section->section."
            </div>
            <div>
                Reason: ".$request->reason."
            </div>";
        
        $remarks = $get->remarks . $reason;
        Documents::where(['id' => $qrcodeID])->update([
            'remarks' => $remarks
        ]);

        $logs = Logs::where(['documentID' => $qrcodeID])
            ->where(['trackerID' => $get->trackerID - 1])
            ->count();

        if($logs != 0) {
            Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID - 1])
                ->update([
                    'documentID' => $qrcodeID,
                ]);
        }
        else {
            Logs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $get->trackerID + 1,
                'officeID' => $get->officeID,
                'userID' => $get->userID
            ]);
        }
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnSelectedDocument($request) {

        foreach($request->documentID as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $officeID = $this->aes->decrypt($request->id);
            
            $get = Documents::where(['id' => $qrcodeID])->first();
            $tracker = Tracker::where(['officeID' => $officeID])->orderBy('trackerID', 'DESC')->first();
            Documents::where(['id' => $qrcodeID])->update(['trackerID' => $get->trackerID - 1]);
            
            $reason = "
                <div class='mt-2'>
                    Returned by: 
                </div>
                <div class='mt-0 text-dark'>
                    ".Auth::user()->Section->Office->office."
                </div>
                <div class='mt-0 text-dark'>
                    ".Auth::user()->Section->section."
                </div>
                <div>
                    Reason: ".$request->reason."
                </div>";
            
            $remarks = $get->remarks . $reason;
            Documents::where(['id' => $qrcodeID])->update([
                'remarks' => $remarks
            ]);

            $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID - 1])
                ->count();

            if($logs != 0) {
                Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID - 1])
                    ->update([
                        'documentID' => $qrcodeID,
                    ]);
            }
            else {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => $get->userID
                ]);
            }
        }
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation($request) {
       
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')->ignore(Auth::user()->id)
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        User::where(['id' => Auth::user()->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        
        if(!empty($request->password))
            User::where(['id' => Auth::user()->id])->update(['password' => Hash::make($request->password)]);

        return Response::HTTP_OK;
     }
}

?>