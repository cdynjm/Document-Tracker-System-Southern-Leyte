<?php

namespace App\Repositories\Interfaces;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface AdminInterface
{
    public function getOffices();
    public function createOffice($request);
    public function updateOffice($request);
    public function deleteOffice($request);

    public function getSections();
    public function createSection($request);
    public function updateSection($request);
    public function deleteSection($request);

    public function getOfficeAccounts();
    public function getOfficeAccount($request);
    public function getTracker($request);
    public function createOfficeAccount($request);
    public function deleteOfficeAccount($request);

    public function getUserAccounts();
    public function createUserAccount($request);
    public function updateUserAccount($request);
    public function deleteUserAccount($request);

    public function updateAccountInformation($request);

}

?>