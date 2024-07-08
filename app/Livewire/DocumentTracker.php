<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;

class DocumentTracker extends Component
{
    public $id;
    public $logs;
    public $tracker;
    public $offices;
    public $sections;
    public $documents;
    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function mount() {
        $this->fetchTracker();
    }
    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function fetchTracker() {
        $aes = new AESCipher();
        $qrcodeID = $aes->decrypt(Session::get('id'));

        $this->documents = Documents::where(['id' => $qrcodeID])->first();
        $this->tracker = Tracker::where(['userID' => Auth::user()->id])->get();
        $this->offices = Offices::get();
        $this->sections = Sections::get();
        $this->logs = Logs::where(['userID' => Auth::user()->id])->get();
    }
    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function render() {
        $logs = $this->logs;
        $tracker = $this->tracker;
        $offices = $this->offices;
        $sections = $this->sections;
        $documents = $this->documents;

        return view('livewire.document-tracker', compact('logs','tracker','offices', 'sections', 'documents'));
    }
}
