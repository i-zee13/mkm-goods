<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */


Route::get('/', function () {
    return redirect('/home');
});

//Mail::send('test', [], function ($message){ $message->to('danial@allomate.com')->subject('Expertphp.in - Testing mail'); });
//
//$path = base_path('.env');
//
//if (file_exists($path)) {
//    $key    =   env('SES_SECRET1');
//    //dd($key);
//    file_put_contents($path, str_replace(
//        'SES_SECRET1='.$key, 'SES_SECRET1=test', file_get_contents($path)
//    ));
//    Artisan::call('config:clear');
//    Artisan::call('cache:clear');
//    dd($key,env('SES_SECRET1'));
//}

Auth::routes();

Route::get('/change_password',     [App\Http\Controllers\Auth\LoginController::class, 'change_password'])->name('change_password');
Route::post('/ChangeUserPassword', [App\Http\Controllers\Auth\LoginController::class, 'ChangeUserPassword'])->name('ChangeUserPassword');

Route::Resource('/Customer'         , App\Http\Controllers\Customer::class);
Route::Resource('/AccessRights'     , App\Http\Controllers\AccessRights::class);
Route::Resource('/main-category'    , App\Http\Controllers\Categories::class);

Route::get('/home'                             , [App\Http\Controllers\HomeController::class, 'index']) ->name('home.index');
Route::get('/GetCustomersList'                 , [App\Http\Controllers\Customer::class, 'CustomersList'])->name('GetCustomersList');
Route::get('/EmployeesList'                    , [App\Http\Controllers\Auth\RegisterController::class, 'EmployeesList'])->name('EmployeesList');
Route::post('/UploadUserImage'                 , [App\Http\Controllers\Auth\RegisterController::class, 'uploadUserImage'])->name('uploadUserImage');
Route::get('/Employee/{id}'                    , [App\Http\Controllers\Employee::class, 'getEmployeeInfo'])->name('Employee');
Route::post('/UpdateEmployee/{id}'             , [App\Http\Controllers\Employee::class, 'UpdateEmployee'])->name('UpdateEmployee');
Route::get('/CustomerTypes'                    , [App\Http\Controllers\CustomerTypes::class, 'index'])->name('CustomerTypes');
Route::post('/SaveCustomerType'                , [App\Http\Controllers\CustomerTypes::class, 'store'])->name('SaveCustomerType');
Route::get('/GetCustomerTypes'                 , [App\Http\Controllers\CustomerTypes::class, 'customerTypesList'])->name('GetCustomerTypes');
Route::delete('/DeleteCustomerType/{typeId}'   , [App\Http\Controllers\CustomerTypes::class, 'deleteCustomerType'])->name('DeleteCustomerType');
Route::get('/GetCustomerTypeInfo/{typeId}'     , [App\Http\Controllers\CustomerTypes::class, 'getCustomerTypeInfo'])->name('GetCustomerTypeInfo');
Route::post('/UpdateCustomerType/{typeId}'     , [App\Http\Controllers\CustomerTypes::class, 'update'])->name('UpdateCustomerType');

Route::get('/logout'                  , [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::post('/update_user_password'   , [App\Http\Controllers\Employee::class, 'update_user_password'])->name('update_user_password');
Route::post('/update_user_profile_pic', [App\Http\Controllers\Employee::class, 'update_user_profile_pic'])->name('update_user_profile_pic');

Route::post('/Notifications/readFourNotifs', [App\Http\Controllers\Notifications::class, 'readFourNotifs'])->name('Notifications');
Route::get('/ViewAllNotifications'     , [App\Http\Controllers\ViewAllNotifications::class, 'index'])->name('ViewAllNotifications');
Route::get('/listAllRights'            , [App\Http\Controllers\AccessRights::class, 'listAllRights'])->name('listAllRights');
Route::get('/revokeAccRight/{empId}'   , [App\Http\Controllers\AccessRights::class, 'revokeAccRight'])->name('revokeAccRight');
// primary-services
// Services
Route::get('/get-categories'                 ,   [App\Http\Controllers\Categories::class, 'getMainCategories'])       ->name('get-categories');
Route::get('/sub-categories'                 ,   [App\Http\Controllers\Categories::class, 'subCategory'])             ->name('sub-categories');
Route::get('/get-sub-category'               ,   [App\Http\Controllers\Categories::class, 'listSubCategories'])       ->name('get-sub-category');
Route::post('/save-sub-category'             ,   [App\Http\Controllers\Categories::class, 'storeSubCat'])             ->name('save-sub-category');
Route::get('/del-sub-cat/{catId}'            ,   [App\Http\Controllers\Categories::class, 'delSubCat'])               ->name('del-sub-cat');
Route::post('/update-sub-cat/{id}'           ,   [App\Http\Controllers\Categories::class, 'updateSubCat'])            ->name('update-sub-cat');
Route::get('/get-sub-cat/{catId}'            ,   [App\Http\Controllers\Categories::class, 'getSubCatToUpdate'])       ->name('get-sub-cat');

// Route::get('/sub-secondary-service'          ,   [App\Http\Controllers\Categories::class, 'SubSecondaryServices'])    ->name('sub-secondary-service');
// Route::post('/SaveSubSecondaryService'       ,   [App\Http\Controllers\Categories::class, 'StoreSubSecondaryService'])->name('SaveSubSecondaryService');
// Route::get('/GetSubSecondaryServices'        ,   [App\Http\Controllers\Categories::class, 'ListSubSecondaryServices'])->name('GetSubSecondaryServices');
// Route::get('/getSubSecondaryService/{Servicid}', [App\Http\Controllers\Categories::class, 'getSubSecondartServiceToUpdate'])->name('getSubSecondaryService');
// Route::post('/UpdateSubSecondaryService/{id}',   [App\Http\Controllers\Categories::class, 'UpdateSubSecondaryService'])->name('UpdateSubSecondaryService');
// Route::get('/DelSubSecondartService/{catId}',    [App\Http\Controllers\Categories::class, 'DelSubSecondartService'])  ->name('DelSubSecondartService');

//get Primary services
Route::get('/get-primary-services'          , [App\Http\Controllers\Categories::class, 'GetPrimaryServices'])->name('get-primary-services');
Route::get('/get-sub-category-against-main-cat/{primary_id}', [App\Http\Controllers\Categories::class, 'GetSecondaryServicesAgainstPrimary'])->name('get-sub-category-against-main-cat');

// Download Business Contact
Route::get('/download_sample_agency', [App\Http\Controllers\Customer::class, 'download_sample_agency'])->name('download_sample_agency');
Route::get('/download_sample_contact', [App\Http\Controllers\Customer::class, 'download_sample_contact'])->name('download_sample_contact');

Route::get('/Profile', [App\Http\Controllers\Auth\RegisterController::class, 'edit_profile'])->name('Profile');
Route::get('/notif_pref_against_emp/{id}', [App\Http\Controllers\Notifications::class, 'notif_pref_against_emp'])->name('notif_pref_against_emp');

///Contacts Upload From Excel
Route::post('/upload_agency_bulk', [App\Http\Controllers\Customer::class, 'upload_agency_bulk'])->name('upload_agency_bulk');
Route::post('/upload-contacts-bulk', [App\Http\Controllers\Customer::class, 'upload_contacts_bulk'])->name('upload-contacts-bulk');
//End Contacts Upload From Excel

Route::post('/Admin/SaveSubMod'             , [App\Http\Controllers\Admin::class, 'SaveSubMod'])->name('SaveSubMod');
Route::post('/Admin/DeleteSubNavItem'       , [App\Http\Controllers\Admin::class, 'DeleteSubNavItem'])->name('DeleteSubNavItem');
Route::post('/Admin/UpdateSubModPriority'   , [App\Http\Controllers\Admin::class, 'UpdateSubModPriority'])->name('UpdateSubModPriority');
Route::post('/Admin/UpdateParentMod'        , [App\Http\Controllers\Admin::class, 'UpdateParentMod'])->name('UpdateParentMod');
Route::post('/Admin/UpdateParentModPriority', [App\Http\Controllers\Admin::class, 'UpdateParentModPriority'])->name('UpdateParentModPriority');

Route::post('/Admin/SaveParentMod'          , [App\Http\Controllers\Admin::class, 'SaveParentMod'])->name('SaveParentMod');
Route::post('/Admin/DeleteParentMod'        , [App\Http\Controllers\Admin::class, 'DeleteParentMod'])->name('DeleteParentMod');

Route::get('/GetSearchedCustomersList/{str}', [App\Http\Controllers\Customer::class, 'GetSearchedCustomersList'])->name('GetSearchedCustomersList');
Route::get('/GetSiteSearchResult/{str}'     , [App\Http\Controllers\HomeController::class, 'GetSiteSearchResult'])->name('GetSiteSearchResult');

Route::get('/AcquisitionSource'             , [App\Http\Controllers\Customer::class, 'AcquisitionSource'])->name('AcquisitionSource');
Route::post('/saveAcquisitionSource'        , [App\Http\Controllers\Customer::class, 'saveAcquisitionSource'])->name('saveAcquisitionSource');
Route::get('/GetAcquisitionTypeList'        , [App\Http\Controllers\Customer::class, 'GetAcquisitionTypeList'])->name('GetAcquisitionTypeList');
Route::get('/get_selected_AcquisitionSource/{id}', [App\Http\Controllers\Customer::class, 'get_selected_AcquisitionSource'])->name('get_selected_AcquisitionSource');
Route::post('/deleteAcquisition/{id}'       , [App\Http\Controllers\Customer::class, 'deleteAcquisition'])->name('deleteAcquisition');

Route::post('/ChangeEmpStatus'              , [App\Http\Controllers\Auth\RegisterController::class, 'ChangeEmpStatus'])->name('ChangeEmpStatus');

Route::get('/view_all_activities'           , [App\Http\Controllers\HomeController::class, 'view_all_activities'])->name('view_all_activities');
Route::get('/GetActivities'                 , [App\Http\Controllers\HomeController::class, 'GetActivities'])->name('GetActivities');

Route::get('/fetchAllNotifications'         , [App\Http\Controllers\ViewAllNotifications::class, 'fetchAllNotifications'])->name('fetchAllNotifications');

Route::get('/manage_settings'               , [App\Http\Controllers\SettingsController::class, 'manage_settings'])->name('manage_settings');
Route::get('/GetSettingsData'               , [App\Http\Controllers\SettingsController::class, 'GetSettingsData'])->name('GetSettingsData');
Route::get('/GetDesignation/{id}'           , [App\Http\Controllers\SettingsController::class, 'GetDesignation'])->name('GetDesignation');
Route::get('/GetDepartment/{id}'            , [App\Http\Controllers\SettingsController::class, 'GetDepartment'])->name('GetDepartment');
Route::get('/GetAssets/{id}'                , [App\Http\Controllers\SettingsController::class, 'GetAssets'])->name('GetAssets');
Route::get('/GetCustType/{id}'              , [App\Http\Controllers\SettingsController::class, 'GetCustType'])->name('GetCustType');
Route::get('/GetRate/{id}'                  , [App\Http\Controllers\SettingsController::class, 'GetRate'])->name('GetRate');
Route::get('/GetPalletInfo/{id}'            , [App\Http\Controllers\SettingsController::class, 'GetPallet'])->name('GetPalletInfo');
Route::get('/GetContact_types/{id}'         , [App\Http\Controllers\SettingsController::class, 'GetContact_types'])->name('GetContact_types');
Route::get('/GetCompanyInfor/{id}'          , [App\Http\Controllers\SettingsController::class, 'GetCompanyInfor'])->name('GetCompanyInfor');
Route::post('/save_settings'                , [App\Http\Controllers\SettingsController::class, 'save_settings'])->name('save_settings');
Route::get('/GetDocumentVerification/{id}'  , [App\Http\Controllers\SettingsController::class, 'GetDocumentVerification'])->name('GetDocumentVerification');
Route::get('/GetGender/{id}'                , [App\Http\Controllers\SettingsController::class, 'GetGender'])->name('GetGender');
Route::get('/GetProperty/{id}'              , [App\Http\Controllers\SettingsController::class, 'GetProperty'])->name('GetProperty');
Route::get('/GetResidence-status/{id}'      , [App\Http\Controllers\SettingsController::class, 'GetResidenceStatus'])->name('GetResidence-status');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/Admin', [App\Http\Controllers\Admin::class, 'index'])->name('Admin');
//Teachers Routes
Route::get('/teacher-create'            , [App\Http\Controllers\TeacherController::class, 'create'])->name('create-teacher');
Route::post('/teacher'                  , [App\Http\Controllers\TeacherController::class, 'store'])->name('teacher-store');
Route::get('/teachers'                  , [App\Http\Controllers\TeacherController::class, 'index'])->name('teachers');
Route::get('/teacher-list'               , [App\Http\Controllers\TeacherController::class, 'teacherList'])->name('teacher-list');
Route::get('/teacher-edit/{id}'          , [App\Http\Controllers\TeacherController::class, 'edit'])->name('edit');

//Teacher Bulk Uploads
Route::get('/download-sample-teacher'    ,[App\Http\Controllers\TeacherController::class, 'DownloadSampleCLients'])->name('download-sample-teacher');
Route::post('/upload-excel-file-teacher' ,[App\Http\Controllers\TeacherController::class, 'UploadExcelFile'])->name('upload-excel-file-teacher');

//Student Routs
Route::get('/student-create'            , [App\Http\Controllers\StudentController::class, 'create'])->name('create-student');
Route::post('/student'                  , [App\Http\Controllers\StudentController::class, 'store'])->name('store-student');
Route::get('/client-view/{id}'          , [App\Http\Controllers\StudentController::class, 'show'])->name('view-client');
Route::get('/edit/{id}'                 , [App\Http\Controllers\StudentController::class, 'edit_client'])->name('edit-client');
Route::get('/student-edit/{id}'         , [App\Http\Controllers\StudentController::class, 'edit'])->name('edit');
Route::get('/GetClient_AllData/{id}'    , [App\Http\Controllers\StudentController::class, 'GetClient_AllData'])->name('GetClient_AllData');
Route::post('/student-update/{id}'      , [App\Http\Controllers\StudentController::class, 'Update'])->name('student-update');
Route::get('/GetClientRelative/{id}'    , [App\Http\Controllers\StudentController::class, 'GetClientRelative'])->name('GetClientRelative');
Route::get('/students'                  , [App\Http\Controllers\StudentController::class, 'index'])->name('students');
Route::get('/student-list'              , [App\Http\Controllers\StudentController::class, 'studentList'])->name('student-list');

// Clients Modules Routes
Route::post('/save-address'             , [App\Http\Controllers\StudentController::class, 'save_address'])->name('save-address');
Route::post('/save-employe'             , [App\Http\Controllers\StudentController::class, 'save_employment'])->name('save-employe');
Route::post('/save-document'            , [App\Http\Controllers\StudentController::class, 'save_document'])->name('save-document');
Route::post('/save-relation'            , [App\Http\Controllers\StudentController::class, 'save_relation'])->name('save-relation');

//Client Bulk Uploads
Route::get('/download-sample-client'    , [App\Http\Controllers\StudentController::class, 'DownloadSampleCLients'])->name('download-sample-client');
Route::post('/upload-excel-file'        , [App\Http\Controllers\StudentController::class, 'UploadExcelFile'])->name('upload-excel-file');

//Client Module Routes for Editing Record
Route::get('/get-client-address/{id}'       , [App\Http\Controllers\StudentController::class, 'GetClientAddress'])->name('get-client-address');
Route::get('/get-client-emploment-info/{id}', [App\Http\Controllers\StudentController::class, 'GetClientEmplomentInfo'])->name('get-client-emploment-info');
Route::get('/get-client-document/{id}'      , [App\Http\Controllers\StudentController::class, 'GetClientDocument'])->name('get-client-document');
Route::get('/geographical_data'             , [App\Http\Controllers\StudentController::class, 'geographical_data'])->name('geographical_data');
Route::get('/getStateAgainst_Country/{id}'  , [App\Http\Controllers\StudentController::class, 'getStateAgainst_Country'])->name('getStateAgainst_Country');
Route::get('/getCityAgainst_States/{id}'    , [App\Http\Controllers\StudentController::class, 'getCityAgainst_States'])->name('getCityAgainst_States');
Route::get('/getPostalcodeAgainst_City/{id}', [App\Http\Controllers\StudentController::class, 'getPostalcodeAgainst_City'])->name('getPostalcodeAgainst_City');
Route::get('/get-countries'                 , [App\Http\Controllers\StudentController::class, 'get_all_countries'])->name('get-countries');
Route::get('/client_detail_form'            , [App\Http\Controllers\StudentController::class, 'client_detail_form'])->name('client_detail_form');
//end Client Routes

//Admin Intake Form Routes
Route::get('/intake-forms'              ,[App\Http\Controllers\IntakeController::class, 'index'])->name('intake-forms');
// Route::get('/intake-form-edit/{id}'     ,[App\Http\Controllers\IntakeController::class, 'edit'])->name('intake-form-edit');
Route::get('/intake-view/{id}'          ,[App\Http\Controllers\IntakeController::class, 'detail'])->name('intake-view');
Route::get('/intake-list'               ,[App\Http\Controllers\IntakeController::class, 'getForms'])->name('intake-list');
Route::get('/create-intake'             ,[App\Http\Controllers\IntakeController::class, 'create'])->name('create-intake');
Route::get('/get-client/{id}'           ,[App\Http\Controllers\IntakeController::class, 'GetClient'])->name('get-client');
Route::get('/get-residence-status'      ,[App\Http\Controllers\IntakeController::class, 'GetResidence'])->name('get-residence-status');
Route::post('/add-client-intake-form'   ,[App\Http\Controllers\IntakeController::class, 'store'])->name('add-client-intake-form');
Route::get('/get-intake-form-list'      ,[App\Http\Controllers\IntakeController::class, 'getList'])->name('get-intake-form-list');
Route::post('/intake-form-approve/{id}' ,[App\Http\Controllers\IntakeController::class, 'approve'])->name('intake-form-approve');
Route::get('/send-intake-form-email/{client_id}/{key}',[App\Http\Controllers\IntakeController::class, 'sendIntakeFormEmail'])->name('send-intake-form-email');

Route::get('/intake-form-type'          ,[App\Http\Controllers\IntakeFormTypeController::class, 'index'])->name('intake-form-type');
Route::get('/create-intake-form-type'   ,[App\Http\Controllers\IntakeFormTypeController::class, 'create'])->name('create-intake-form-type');
Route::post('/intake-form-type'         ,[App\Http\Controllers\IntakeFormTypeController::class, 'store'])->name('store-intake-form-type');
Route::get('/intake-form-type/{id}'     ,[App\Http\Controllers\IntakeFormTypeController::class, 'show'])->name('show-intake-form-type');
Route::get('/intake-form-type/{id}/edit',[App\Http\Controllers\IntakeFormTypeController::class, 'edit'])->name('edit-intake-form-type');
Route::post('/intake-form-type/{id}/edit',[App\Http\Controllers\IntakeFormTypeController::class, 'update'])->name('update-intake-form-type');

// Dashboard
Route::post('/fetchDashboardReports'    ,[App\Http\Controllers\DashboardController::class, 'fetchDashboardReports'])->name('fetchDashboardReports');
Route::post('/fetchDashboardMonthWiseGraph',[App\Http\Controllers\DashboardController::class, 'fetchDashboardMonthWiseGraph'])->name('fetchDashboardMonthWiseGraph');
// End Dashboard

Route::post('/save_company_poc'         ,[App\Http\Controllers\Customer::class, 'save_company_poc'])->name('save_company_poc');
Route::get('/fetchCustomersPOC'         ,[App\Http\Controllers\Customer::class, 'fetchCustomersPOC'])->name('fetchCustomersPOC');
Route::get('/get_selected_POC/{id}'     ,[App\Http\Controllers\Customer::class, 'get_selected_POC'])->name('get_selected_POC');

Route::get('/device_logs',[App\Http\Controllers\Employee::class, 'device_logs'])->name('device_logs');
Route::get('/GetDeviceLogs/{id}',[App\Http\Controllers\Employee::class, 'GetDeviceLogs'])->name('GetDeviceLogs');
Route::post('/update_device_activation',[App\Http\Controllers\Employee::class, 'update_device_activation'])->name('update_device_activation');

Route::post('/delete_from_settings',[App\Http\Controllers\SettingsController::class, 'delete_from_settings'])->name('delete_from_settings');

Route::get('/RemoveOldBackups', function () {
    $dir = '../storage/app/Import-Export/';
    $backupFiles = array_filter(scandir($dir, 1), function ($f) {
        return $f !== '.' && $f !== '..';
    });
    foreach ($backupFiles as $file) {
        // echo date("F d Y H:i:s.", filemtime($file)."<br>";
        if (date('Y-m-d', filemtime($dir . $file)) <= date('Y-m-d', strtotime('-10 days'))) {
            unlink($dir . $file);
        }

    }
});

//GeographicalSettings
Route::get('/geographicalsetting',[App\Http\Controllers\GeographicalSettingsController::class, 'geographicalsetting'])->name('geographicalsetting');
Route::get('/GetGeoData',[App\Http\Controllers\GeographicalSettingsController::class, 'GetGeoData'])->name('GetGeoData');
Route::get('/GetStatesagianstCountry/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetStatesagianstCountry'])->name('GetStatesagianstCountry');
Route::get('/GetCitiesagianstStates/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetCitiesagianstStates'])->name('GetCitiesagianstStates');
Route::get('/GetCitiesagianstStatesforPostal/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetCitiesagianstStatesforPostal'])->name('GetCitiesagianstStatesforPostal');
Route::get('/GetStatesagianstCountryforPostal/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetStatesagianstCountryforPostal'])->name('GetStatesagianstCountryforPostal');
Route::post('/save_country',[App\Http\Controllers\GeographicalSettingsController::class, 'save_country'])->name('save_country');
Route::get('/GetCountry/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetCountry'])->name('GetCountry');
Route::post('/delete_geographical',[App\Http\Controllers\GeographicalSettingsController::class, 'delete_geographical'])->name('delete_geographical');
Route::get('/GetState/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetState'])->name('GetState');
Route::get('/GetCity/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetCity'])->name('GetCity');
Route::get('/GetPostalCode/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetPostalCode'])->name('GetPostalCode');
Route::get('/GetCitiesforPostal/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'GetCitiesforPostal'])->name('GetCitiesforPostal');
Route::get('/get-cities-against-state/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'get_cities_against_state'])->name('get-cities-against-state');
Route::get('/get-postal-code-against-city/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'get_postal_code_against_city'])->name('get-postal-code-against-city');
Route::get('/get-postal-code-against-cities/{id}',[App\Http\Controllers\GeographicalSettingsController::class, 'get_postal_code_against_city'])->name('get-postal-code-against-cities');
Route::get('/get-states-cities',[App\Http\Controllers\GeographicalSettingsController::class, 'getStatesCities'])->name('get-states-cities');


//EndGeographicalSettings

///Get Some Data for Agency or Contacts
Route::get('/get-countries', [App\Http\Controllers\Customer::class, 'get_all_countries'])->name('get-countries');
Route::get('/get-postal-code-against-cities/{id}', [App\Http\Controllers\Customer::class, 'get_postal_code_against_cities'])->name('get-postal-code-against-cities');
Route::get('/get-contact-types', [App\Http\Controllers\Customer::class, 'get_all_contact_types'])->name('get-contact-types');
Route::get('/get-genders', [App\Http\Controllers\Customer::class, 'get_all_genders'])->name('get-genders');
Route::post('/delete-econtact-number', [App\Http\Controllers\Customer::class, 'delete_econtact_number'])->name('delete-econtact-number');




//Integrations 1
Route::get('/integrations'              , [App\Http\Controllers\IntegrationController::class, 'index'])->name('integrations');
Route::get('/integration/{id}'          , [App\Http\Controllers\IntegrationController::class, 'show'])->name('integration');
Route::get('/edit-integration/{id}'     , [App\Http\Controllers\IntegrationController::class, 'edit'])->name('edit-integration');
Route::post('/update-integration/{id}'  , [App\Http\Controllers\IntegrationController::class, 'update'])->name('update-integration');

//Business Contacts

Route::get('/contact-list', [App\Http\Controllers\Customer::class, 'contactList'])->name('contact-list');
Route::get('/agency-list' , [App\Http\Controllers\Customer::class, 'agencyList'])->name('agency-list');

 


//Change Country Status

Route::post('/country-status',[App\Http\Controllers\GeographicalSettingsController::class, 'changeCountryStatus'])->name('country-status');


Route::get('/intake-form-document/{id}',[App\Http\Controllers\DocumentController::class, 'index'])->name('intake-form-document');
Route::get('/intake-form-document-print/{id}',[App\Http\Controllers\DocumentController::class, 'pdf'])->name('intake-form-document-print');
Route::post('/intake-form-document-print/{id}', [App\Http\Controllers\DocumentController::class, 'print'])->name('intake-form-document-print');

////Intake form Frontend
Route::prefix('intake')->group(function () {
    Route::get('/form/{key}', [App\Http\Controllers\IntakeFormFrontendController::class, 'show'])->name('intake.form');
    Route::get('/clients-all-documents/{client_id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'clients_all_documents'])->name('clients-all-documents');
    Route::get('/clients-all-relations/{intake_form_id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'clients_all_relations'])->name('clients-all-relations');
    Route::get('/client-employment-info/{client_id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'clients_employment_info'])->name('client-employment-info');
    Route::get('/client-marital-details/{client_id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'client_marital_details'])->name('client-marital-details');
    Route::post('/save-client', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client'])->name('save-client');
    Route::post('/save-client-employee-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client_employee_info'])->name('save-client-employee-info');
    Route::get('/get-all-countries', [App\Http\Controllers\IntakeFormFrontendController::class, 'get_all_countries'])->name('get-all-countries');
    Route::get('/get-states-against-countries/{id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'get_states_against_country'])->name('get-states-against-countries');
    Route::get('/get-cities-against-states/{id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'get_city_against_states'])->name('get-cities-against-states');
    Route::get('/get-postalcode-against-cities/{id}', [App\Http\Controllers\IntakeFormFrontendController::class, 'get_postal_code_against_cities'])->name('get-postalcode-against-cities');
    Route::post('/save-client-marital-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client_marital_info'])->name('save-client-marital-info');
    Route::post('/save-client-capacity', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client_capacity'])->name('save-client-capacity');
    Route::post('/save-client-consent-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client_consent'])->name('save-client-consent-info');
    Route::post('/save-client-document', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_documents'])->name('save-client-document');
    Route::post('/save-client-relation', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_client_relation'])->name('save-client-relation');
    Route::post('/save-guardian-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_guardian_info'])->name('save-guardian-info');
    Route::post('/save-will-assets', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_will_assets'])->name('save-will-assets');
    Route::post('/save-will-estate-distributed', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_will_estate_distributed'])->name('save-will-estate-distributed');
    Route::post('/delete-document-relation', [App\Http\Controllers\IntakeFormFrontendController::class, 'delete_documents_relations'])->name('delete-document-relation');
    Route::post('/intake-form-status-update', [App\Http\Controllers\IntakeFormFrontendController::class, 'intake_form_status_update'])->name('intake-form-status-update');
    Route::get('/thankyou', [App\Http\Controllers\IntakeFormFrontendController::class, 'thankyou_form'])->name('thankyou');
    Route::POST('/save-realtor-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_realtor_info'])->name('save-realtor-info');
    Route::POST('/save-mortgage-info', [App\Http\Controllers\IntakeFormFrontendController::class, 'save_mortgage_info'])->name('save-mortgage-info');
});

 /**organization-CRUD Routes */
 Route::get('/organization-detail'          , [App\Http\Controllers\OrganizationController::class, 'index'])->name('organization');
 Route::post('/organization/store'          , [App\Http\Controllers\OrganizationController::class, 'store'])->name('organization.store');
//Add Mulitiple Locations of Organization
 Route::post('/organization-location/store' , [App\Http\Controllers\OrganizationController::class, 'storeLocaion'])->name('organization-location');
 Route::get('/location-list'                , [App\Http\Controllers\OrganizationController::class, 'locationList'])->name('location-list');
 Route::get('/get-location-form/{id}'       , [App\Http\Controllers\OrganizationController::class, 'getLocation'])->name('get-location-form');
 Route::POST('/location-delete/{id}'        , [App\Http\Controllers\OrganizationController::class, 'deleteLocation'])->name('location-delete');

 /**End Organization  Routes */

//GetGraphical Data
Route::get('/get-city-against-states/{id}'      , [App\Http\Controllers\OrganizationController::class, 'getCityAgainst_States'])->name('getCityAgainst_States');
Route::get('/get-state-against-country/{id}'    , [App\Http\Controllers\OrganizationController::class, 'getStateAgainst_Country'])->name('getStateAgainst_Country');
Route::get('/get-countries'                     , [App\Http\Controllers\OrganizationController::class, 'getCountries'])->name('getCountries');

//Blogs

Route::get('/blogs'                 , [App\Http\Controllers\BlogsController::class, 'index'])->name('blogs');
Route::get('/add-blog'              , [App\Http\Controllers\BlogsController::class, 'add_blog'])->name('add-blog');
Route::get('/blog-slug/{blog_title}', [App\Http\Controllers\BlogsController::class, 'blog_slug'])->name('blog-slug');
Route::get('/add-blog'              , [App\Http\Controllers\BlogsController::class, 'add_blog'])->name('add-blog');
Route::post('/save-blog'            , [App\Http\Controllers\BlogsController::class, 'store'])->name('save-blog');
Route::get('/all-blogs-list'        , [App\Http\Controllers\BlogsController::class, 'all_blogs_list'])->name('all-blogs-list');
Route::post('/blog-status-change'   , [App\Http\Controllers\BlogsController::class, 'blog_status_change'])->name('blog-status-change');
Route::get('/edit-blog/{id}'        , [App\Http\Controllers\BlogsController::class, 'edit'])->name('edit-blog');
Route::post('/delete-blog'          , [App\Http\Controllers\BlogsController::class, 'delete_blog'])->name('delete-blog');
//End  Blogs

//Faqs
Route::get('/faqs', [App\Http\Controllers\FaqsController::class, 'index'])->name('faqs');

Route::post('/save-faqs', [App\Http\Controllers\FaqsController::class, 'save_faqs'])->name('save-faqs');
Route::get('/all-faqs-list', [App\Http\Controllers\FaqsController::class, 'all_faqs_list'])->name('all-faqs-list');
Route::get('/GetFaqs/{id}', [App\Http\Controllers\FaqsController::class, 'edit'])->name('GetFaqs');
// Route::get('/get-sub-category-against-main-cat/{primary_id}', [App\Http\Controllers\FaqsController::class, 'secondary_services'])->name('get-sub-category-against-main-cat');
// Route::get('/get-sub-secondary-services-against-secondary/{primary_id}', [App\Http\Controllers\FaqsController::class, 'sub_secondary_services'])->name('get-sub-secondary-services-against-secondary');
Route::post('/delete-faq', [App\Http\Controllers\FaqsController::class, 'delete_faq'])->name('delete-faq');
Route::post('/faq-status-change', [App\Http\Controllers\FaqsController::class, 'faq_status_change'])->name('faq-status-change');

//End Faqs

//Attributes

Route::get('/attributes'                     ,[App\Http\Controllers\AttributeController::class,'index'])->name('attributes');
Route::post('/save-attribute'                ,[App\Http\Controllers\AttributeController::class, 'save_attribute'])->name('save-attribute');
Route::post('/save-attribute-value'          ,[App\Http\Controllers\AttributeController::class, 'save_attribute'])->name('save-attribute-value');
Route::get('/get-attribute/{id}'             ,[App\Http\Controllers\AttributeController::class, 'get_attribute'])->name('get-attribute');
Route::get('/get-attribute-value/{id}'       ,[App\Http\Controllers\AttributeController::class, 'get_AttributeValue'])->name('get-attribute-value');
Route::post('/delete-attribute'              ,[App\Http\Controllers\AttributeController::class, 'deleteAttribute'])->name('delete-attribute');
Route::get('/get-all-Attributes'             ,[App\Http\Controllers\AttributeController::class, 'getAllAttributes'])->name('get-all-Attributes');

//End Attributes

//Add Course 

Route::get('/add-course'                    ,[App\Http\Controllers\CourseController::class,'index'])->name('add-course');
Route::get('/edit-course/{id}'              ,[App\Http\Controllers\CourseController::class,'edit'])->name('edit-course');
Route::get('/get-data'                      ,[App\Http\Controllers\CourseController::class,'getData'])->name('get-data');
Route::post('/store-course'                 ,[App\Http\Controllers\CourseController::class,'store'])->name('store-course');
Route::get('/courses'                       ,[App\Http\Controllers\CourseController::class,'show'])->name('show-courses');
Route::get('/course-list'                   ,[App\Http\Controllers\CourseController::class,'courseList'])->name('list-course');
Route::get('/get-attribute-and-tags/{id}'   ,[App\Http\Controllers\CourseController::class,'getAttributeAndTags'])->name('get-attribute-tags');
Route::post('/update-course-status'         ,[App\Http\Controllers\CourseController::class,'updateCourseStatus'])->name('update-course-status');
//Batch Routes

Route::get('/batches'                       ,[App\Http\Controllers\CourseBatchController::class,'index'])->name('batches');
Route::get('/add-batch'                     ,[App\Http\Controllers\CourseBatchController::class,'addBatch'])->name('add-batch');
Route::post('/save-batch'                   ,[App\Http\Controllers\CourseBatchController::class,'store'])->name('save-batch');
Route::get('/all-batches-list'              ,[App\Http\Controllers\CourseBatchController::class,'batchList'])->name('batches-list');
Route::post('/batch-status-change'          ,[App\Http\Controllers\CourseBatchController::class,'batchStatusChange'])->name('batch-status-change');
Route::get('/edit-batch/{id}'               ,[App\Http\Controllers\CourseBatchController::class,'edit'])->name('edit-batch');
Route::get('/get-batch/{id}'                ,[App\Http\Controllers\CourseBatchController::class,'getBatch'])->name('get-batch');
Route::post('/delete-batch'                 ,[App\Http\Controllers\CourseBatchController::class,'delteBatch'])->name('delete-batch');
Route::get('/get-batch-slots/{id}'          ,[App\Http\Controllers\CourseBatchController::class,'getBatchSlots'])->name('get-batch-slots');

              /** End **/     

            /** Lesson Routes Start **/
Route::get('/course-lesson/{id}'             ,[App\Http\Controllers\CourseLessonController::class,'index'])->name('course-lesson');
Route::post('/save-lesson'                   ,[App\Http\Controllers\CourseLessonController::class,'store'])->name('save-lesson');
Route::get('/all-lesson-list/{course_id}'    ,[App\Http\Controllers\CourseLessonController::class,'lessonList'])->name('lesson-list');
Route::get('/get-lesson/{id}'                ,[App\Http\Controllers\CourseLessonController::class,'edit'])->name('edit-lesson');
Route::post('/delete-lesson'                 ,[App\Http\Controllers\CourseLessonController::class, 'destroy'])->name('delete-lesson');
            /**  End **/

            /**  Batch Sessions  **/
Route::get('/batch-sessions'                 ,[App\Http\Controllers\BatchSessionController::class,'index'])->name('batch-sessions');
Route::post('/save-session'                  ,[App\Http\Controllers\BatchSessionController::class,'store'])->name('save-session');
Route::get('/get-batches-against-course/{id}',[App\Http\Controllers\BatchSessionController::class,'getBatchAgainstCourse'])->name('get-batches-against-course');
Route::get('/all-sessions-list'              ,[App\Http\Controllers\BatchSessionController::class,'sessionList'])->name('all-session-list');
Route::get('/get-session/{id}'               ,[App\Http\Controllers\BatchSessionController::class,'edit'])->name('get-session');
Route::post('/delete-session'                ,[App\Http\Controllers\BatchSessionController::class, 'destroy'])->name('delete-session');

   
             /**  End **/
Route::get('/enrollments'                    ,[App\Http\Controllers\EnrollmentController::class,'index'])->name('enrollments');
Route::get('/all-enrollment-list'            ,[App\Http\Controllers\EnrollmentController::class,'enrollmentList'])->name('all-enrollment-list');

  /**  Disscount Offers  **/
Route::get('/campaigns'                      ,[App\Http\Controllers\CampaignController::class,'index'])->name('campaigns');
Route::get('/all-campaigns'                  ,[App\Http\Controllers\CampaignController::class,'list'])->name('all-campaigns');
Route::get('/create-campaign'                ,[App\Http\Controllers\CampaignController::class,'create'])->name('create-campaign');
Route::post('/save-campaign'                 ,[App\Http\Controllers\CampaignController::class,'store'])->name('save-campaign');
Route::get('/edit-campaign/{id}'             ,[App\Http\Controllers\CampaignController::class,'edit'])->name('/edit-campaign');
Route::get('/get-courses/{id}'               ,[App\Http\Controllers\CampaignController::class,'getCourse'])->name('get-courses');
Route::get('/get-campaign-courses/{id}'      ,[App\Http\Controllers\CampaignController::class,'getCampaignCourses'])->name('get-campaign-courses');
Route::post('/delete-campaign/{id}'          ,[App\Http\Controllers\CampaignController::class,'delete'])->name('delete-campaign');
Route::post('/campaign-status-change'        ,[App\Http\Controllers\CampaignController::class, 'campaignStatusChange'])->name('campaign-status-change');
  







//End Course
Route::post('/sendinbluewebhook', [App\Http\Controllers\EmailWebHooksController::class, 'sendinblue'])->name('sendinbluewebhook');