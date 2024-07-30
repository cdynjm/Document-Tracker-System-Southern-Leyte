<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACES:
use App\Repositories\Interfaces\UserInterface; 

class UserController extends Controller
{
    protected $aes;
    protected $UserInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes, UserInterface $UserInterface) {
        $this->aes = $aes;
        $this->UserInterface = $UserInterface;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $receivedLogs = $this->UserInterface->getReceivedLogs();
        return view('pages.user.user-dashboard', compact('receivedLogs'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function profile() {
        return view('pages.user.profile');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation(Request $request) {
        $status = $this->UserInterface->updateAccountInformation($request);
        return response()->json(['Message' => 'Account information updated successfully'], $status);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function offices(Request $request) {
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        return view('pages.user.offices', compact('tracker','offices', 'sections', 'documents'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument(Request $request) {
        $this->UserInterface->forwardDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document forwarded successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument(Request $request) {
        $this->UserInterface->forwardSelectedDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Documents forwarded successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnDocument(Request $request) {
        $this->UserInterface->returnDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document returned successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnSelectedDocument(Request $request) {
        $this->UserInterface->returnSelectedDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document returned successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
}
