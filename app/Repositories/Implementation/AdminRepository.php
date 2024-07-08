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
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\AdminInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;

class AdminRepository implements AdminInterface {
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
    public function createOffice($request) {
        Offices::create(['office' => $request->office]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOffice($request) {
        $id = $this->aes->decrypt($request->id);
        Offices::where(['id' => $id])->update(['office' => $request->office]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOffice($request) {
        $id = $this->aes->decrypt($request->id);
        Offices::where(['id' => $id])->delete();
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
    public function createSection($request) {
        $officeID = $this->aes->decrypt($request->office);
        Sections::create([
            'officeID' => $officeID,
            'section' => $request->section
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateSection($request) {
        $id = $this->aes->decrypt($request->id);
        $officeID = $this->aes->decrypt($request->office);
        Sections::where(['id' => $id])->update([
            'officeID' => $officeID,
            'section' => $request->section
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteSection($request) {
        $id = $this->aes->decrypt($request->id);
        Sections::where(['id' => $id])->delete();
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOfficeAccounts() {
       return User::where(['role' => 2])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createOfficeAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $officeID = $this->aes->decrypt($request->office);
        $officeAccount = User::create([
            'name' => $request->name,
            'officeID' => $officeID,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2
        ]);

        $trackerID = 1;
        foreach($request->tracker as $key => $value) {
            $sectionID = $this->aes->decrypt($value);
            Tracker::create([
                'trackerID' => $trackerID,
                'sectionID' => $sectionID,
                'officeID' => $officeID,
                'userID' => $officeAccount->id
            ]);
            $trackerID += 1;
        }

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOfficeAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $officeID = $this->aes->decrypt($request->office);
        $id = $this->aes->decrypt($request->id);
    
        User::where(['id' => $id])->update([
            'name' => $request->name,
            'officeID' => $officeID,
            'email' => $request->email,
        ]);

        if(!empty($request->password)) {
            User::where(['id' => $id])->update([
                'password' => Hash::make($request->password),
            ]);
        }

        Tracker::where(['userID' => $id])->delete();
        $trackerID = 1;
        foreach($request->tracker as $key => $value) {
            $sectionID = $this->aes->decrypt($value);
            Tracker::create([
                'trackerID' => $trackerID,
                'sectionID' => $sectionID,
                'officeID' => $officeID,
                'userID' => $id
            ]);
            $trackerID += 1;
        }

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOfficeAccount($request) {
        $id = $this->aes->decrypt($request->id);
        return User::where(['id' => $id])->first();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTracker($request) {
        $id = $this->aes->decrypt($request->id);
        return Tracker::where(['userID' => $id])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOfficeAccount($request) {
        $id = $this->aes->decrypt($request->id);
        Tracker::where(['userID' => $id])->delete();
        User::where(['id' => $id])->delete();
     }


     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getUserAccounts() {
        return User::where(['role' => 3])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createUserAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $sectionID = $this->aes->decrypt($request->section);
        User::create([
            'name' => $request->name,
            'sectionID' => $sectionID,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        return Response::HTTP_OK;
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateUserAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $id = $this->aes->decrypt($request->id);
        $sectionID = $this->aes->decrypt($request->section);
        User::where(['id' => $id])->update([
            'name' => $request->name,
            'sectionID' => $sectionID,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if(!empty($request->password)) {
            User::where(['id' => $id])->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteUserAccount($request) {
        $id = $this->aes->decrypt($request->id);
        User::where(['id' => $id])->delete();
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