<?php

namespace App\Repositories\Interfaces;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface UserInterface
{
    public function getOffices($request);
    public function getSections();
    public function getTracker($request);
    public function getDocuments($request);
    
    public function forwardDocument($request);
    public function forwardSelectedDocument($request);
    public function returnDocument($request);
    public function returnSelectedDocument($request);
    
    public function updateAccountInformation($request);
}

?>