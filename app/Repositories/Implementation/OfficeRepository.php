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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\OfficeInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;
use App\Models\ReturnedLogs;
use App\Models\ReceivedLogs;

class OfficeRepository implements OfficeInterface { 
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
    public function getOffices() {
        return Offices::get();
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
    public function getTracker() {
        return Tracker::where(['userID' => Auth::user()->id])->get();
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getLogs() {
        return Logs::where(['userID' => Auth::user()->id])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getReturnedLogs() {
        return ReturnedLogs::where(['userID' => Auth::user()->id])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocuments() {
        return Documents::where(['userID' => Auth::user()->id])
                    ->where(['status' => 1])
                    ->orderBy('created_at', 'DESC')->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        return Documents::where(['id' => $qrcodeID])->first();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getArchives() {
        return Documents::where(['userID' => Auth::user()->id])
                    ->where(['status' => 0])
                    ->orderBy('created_at', 'DESC')->get();
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createQRCode($request) {

        for($count = 0; $count < $request->quantity; $count++) {
            $document = Documents::create([
                'qrcode' => \Str::slug(Carbon::now()->addSeconds($count)."-".$request->extension),
                'trackerID' => 0,
                'officeID' => Auth::user()->officeID,
                'userID' => Auth::user()->id,
                'remarks' => null,
                'status' => 1
            ]);

            Logs::create([
                'documentID' => $document->id,
                'trackerID' => $document->trackerID,
                'officeID' => Auth::user()->officeID,
                'userID' => Auth::user()->id
            ]);
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        $get = Documents::where(['id' => $qrcodeID])->first();
        Documents::where(['id' => $qrcodeID])->update([
            'trackerID' => $get->trackerID + 1,
            'remarks' => null
        ]);

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
                'userID' => Auth::user()->id
            ]);
        }

        $section = Tracker::where('userID', Auth::user()->id)
                ->where('trackerID', $get->trackerID + 1)
                ->first();

        ReceivedLogs::create([
            'documentID' => $qrcodeID,
            'sectionID' => $section->sectionID,
            'userID' => Auth::user()->id,
            'username' => Auth::user()->name
        ]);
       
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument($request) {

        foreach($request->id as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $get = Documents::where(['id' => $qrcodeID])->first();
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'remarks' => null
            ]);
    
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
                    'userID' => Auth::user()->id
                ]);
            }

            $section = Tracker::where('userID', Auth::user()->id)
            ->where('trackerID', $get->trackerID + 1)
            ->first();

            ReceivedLogs::create([
                'documentID' => $qrcodeID,
                'sectionID' => $section->sectionID,
                'userID' => Auth::user()->id,
                'username' => Auth::user()->name
            ]);
        }
       
    }
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function deleteQRCode($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        Documents::where(['id' => $qrcodeID])->delete();
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