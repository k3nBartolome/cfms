<?php

use App\Http\Controllers\ApplicantSiteController;
use App\Http\Controllers\ApplicantDataController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\User\PermissionController;
use App\Http\Controllers\API\User\RoleController;
use App\Http\Controllers\API\User\UserController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CapEmailController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassStaffingController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout/{id}', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/download-template', function () {
        $filePath = public_path('storage/template/template.xlsx'); // Path to the file
        if (file_exists($filePath)) {
            return response()->download($filePath); // Download the file
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    });
    // User Routes
    Route::post('/create_user', [UserController::class, 'store']);
    Route::put('/update_user/{id}', [UserController::class, 'update']);
    Route::delete('/delete_user/{id}', [UserController::class, 'destroy']);
    Route::get('/show_user/{id}', [UserController::class, 'show']);
    Route::get('/list_user', [UserController::class, 'index']);
    Route::get('/list_users', [UserController::class, 'indexUser']);
    Route::get('/added_users', [UserController::class, 'indexAdded']);
    Route::put('/update_user/profile/{id}/', [UserController::class, 'update_profile']);
    Route::post('users/{user}/sites', [UserController::class, 'assignSites']);
    Route::put('user/{user}/assign-sites', [UserController::class, 'assignSites']);

    // Role Routes
    Route::get('/list_role', [RoleController::class, 'index']);
    Route::post('/create_role', [RoleController::class, 'store']);
    Route::put('/update_role/{id}', [RoleController::class, 'update']);
    Route::delete('/delete_role/{id}', [RoleController::class, 'destroy']);
    Route::get('/show_role/{id}', [RoleController::class, 'show']);

    // Permission Routes
    Route::get('/list_permission', [PermissionController::class, 'index']);
    Route::post('/create_permission', [PermissionController::class, 'store']);
    Route::put('/update_permission/{id}', [PermissionController::class, 'update']);
    Route::delete('/delete_permission/{id}', [PermissionController::class, 'destroy']);
    Route::get('/show_permission/{id}', [PermissionController::class, 'show']);

    // Site Routes
    Route::get('sites', [SiteController::class, 'index']);
    Route::get('index_sites', [SiteController::class, 'indexSite']);
    Route::get('regions', [SiteController::class, 'getRegions']);
    Route::get('sites', [SiteController::class, 'index']);
    Route::get('sites2', [SiteController::class, 'index2']);
    Route::get('sites3', [SiteController::class, 'index3']);
    Route::get('sites4', [SiteController::class, 'index4']);
    Route::get('sites5', [SiteController::class, 'index5']);
    Route::get('sites6', [SiteController::class, 'index6']);
    Route::get('sites7', [SiteController::class, 'index7']);
    Route::get('sites8', [SiteController::class, 'index8']);
    Route::get('sites/{id}', [SiteController::class, 'show']);
    Route::post('sites', [SiteController::class, 'store']);
    Route::post('sites2', [SiteController::class, 'store2']);
    Route::post('sites3', [SiteController::class, 'store3']);
    Route::post('sites4', [SiteController::class, 'store4']);
    Route::put('sites/{id}', [SiteController::class, 'update']);
    Route::put('sites_activate/{id}', [SiteController::class, 'activate']);
    Route::put('sites_deactivate/{id}', [SiteController::class, 'deactivate']);
    Route::delete('sites/{id}', [SiteController::class, 'destroy']);

    // Program Routes
    Route::get('programs', [ProgramController::class, 'index']);
    Route::get('programs2', [ProgramController::class, 'index2']);
    Route::get('programs3', [ProgramController::class, 'index3']);
    Route::get('programs4', [ProgramController::class, 'index4']);
    Route::get('programs5', [ProgramController::class, 'index5']);
    Route::get('programs6', [ProgramController::class, 'index6']);
    Route::get('programs7', [ProgramController::class, 'index7']);
    Route::get('programs8', [ProgramController::class, 'index8']);
    Route::get('programs/{id}', [ProgramController::class, 'show']);
    Route::post('programsother', [ProgramController::class, 'store']);
    Route::put('programs/{id}', [ProgramController::class, 'update']);
    Route::post('programs', [ProgramController::class, 'storeother']);
    Route::put('programsother/{id}', [ProgramController::class, 'updateother']);
    Route::put('programs_activate/{id}', [ProgramController::class, 'activate']);
    Route::put('programs_deactivate/{id}', [ProgramController::class, 'deactivate']);
    Route::delete('programs/{id}', [ProgramController::class, 'destroy']);
    Route::get('programs_selected/{siteId}', [ProgramController::class, 'indexBySite']);
    Route::get('programs_select/{siteIds}', [ProgramController::class, 'perSite']);

    // Classes Routes
    Route::get('classes', [ClassesController::class, 'index']);
    Route::delete('classes/{id}', [ClassesController::class, 'destroy']);
    Route::get('classesall', [ClassesController::class, 'classesAll']);
    Route::get('cstat', [ClassesController::class, 'cstat']);

    Route::get('classesallindia', [ClassesController::class, 'classesAllInd']);
    Route::get('classesalljam', [ClassesController::class, 'classesallJam']);
    Route::get('classesallgua', [ClassesController::class, 'classesAllGua']);
    Route::put('classes/pushedback/{id}', [ClassesController::class, 'pushedback']);
    Route::put('classes/edit/{id}', [ClassesController::class, 'edit']);
    Route::put('classes/cancelled/edit/{id}', [ClassesController::class, 'editCancelled']);
    Route::put('classes/cancel/{id}', [ClassesController::class, 'cancel']);
    Route::post('classes', [ClassesController::class, 'store']);
    Route::get('check', [ClassesController::class, 'checkCombinationExistence']);
    Route::get('transaction/{id}', [ClassesController::class, 'transaction']);
    Route::get('perxfilter', [ClassesController::class, 'perxFilter']);
    Route::get('perxfilterv2', [ClassesController::class, 'perxFilterv2']);
    Route::get('sr_compliance', [ClassesController::class, 'srCompliance']);
    Route::get('sr_filter', [ClassesController::class, 'srFilter']);
    Route::get('sr_export', [ClassesController::class, 'srExport']);
    Route::get('sr_date', [ClassesController::class, 'srDate']);
    Route::get('perx_date', [ClassesController::class, 'perxDate']);
    Route::get('perx_datev2', [ClassesController::class, 'perxDatev2']);
    Route::get('sr_site', [ClassesController::class, 'srSite']);
    Route::get('perx_site', [ClassesController::class, 'perxSite']);
    Route::get('perx_sitev2', [ClassesController::class, 'perxSitev2']);
    Route::get('export', [ClassesController::class, 'exportFilteredData']);
    Route::get('exportv2', [ClassesController::class, 'exportFilteredDatav2']);
    Route::get('export2', [ClassesController::class, 'dashboardClassesExport']);
    Route::get('history_export', [ClassesController::class, 'dashboardClassesExport2']);
    Route::get('cancelled_export', [ClassesController::class, 'dashboardCancelledClassesExport']);
    Route::get('export3', [ClassesController::class, 'dashboardClassesExport3']);
    Route::get('export4', [ClassesController::class, 'dashboardClassesExport4']);
    Route::get('mps', [ClassStaffingController::class, 'mps']);

    Route::get('mpssite', [ClassStaffingController::class, 'mpsSite']);
    Route::get('programs_selected', [ProgramController::class, 'perSite']);
    Route::get('classesdashboard', [ClassesController::class, 'dashboardClasses']);
    Route::get('siteclasses', [ClassesController::class, 'dashboardSiteClasses']);

    Route::get('siteclassesmoved', [ClassesController::class, 'dashboardSiteClassesMoved']);
    Route::get('siteclassescancelled', [ClassesController::class, 'dashboardSiteClassesCancelled']);
    Route::get('classesdashboard2', [ClassesController::class, 'dashboardClasses2']);
    Route::get('classescancelled', [ClassesController::class, 'dashboardCancelledClasses']);
    Route::get('classesdashboard3', [ClassesController::class, 'dashboardClasses3']);
    Route::get('classesdashboard4', [ClassesController::class, 'dashboardClasses4']);
    Route::get('classesdashboardexternal', [ClassesController::class, 'dashboardExternalClasses']);
    Route::get('classesdashboardinternal', [ClassesController::class, 'dashboardInternalClasses']);
    Route::get('classesdashboardjamaica', [ClassesController::class, 'dashboardClassesJamaica']);
    Route::get('siteclassesjamaica', [ClassesController::class, 'dashboardSiteClassesJamaica']);
    Route::get('siteclassesjamaicamoved', [ClassesController::class, 'dashboardSiteClassesJamaicaMoved']);
    Route::get('siteclassesjamaicacancelled', [ClassesController::class, 'dashboardSiteClassesJamaicaCancelled']);
    Route::get('classesdashboardjamaica2', [ClassesController::class, 'dashboardClassesJamaica2']);
    Route::get('classesdashboardjamaica3', [ClassesController::class, 'dashboardClassesJamaica3']);
    Route::get('classesdashboardjamaica4', [ClassesController::class, 'dashboardClassesJamaica4']);
    Route::get('classesdashboardguatemala', [ClassesController::class, 'dashboardClassesGuatemala']);
    Route::get('siteclassesguatemala', [ClassesController::class, 'dashboardSiteClassesGuatemala']);
    Route::get('siteclassesguatemalamoved', [ClassesController::class, 'dashboardSiteClassesGuatemalaMoved']);
    Route::get('siteclassesguatemalacancelled', [ClassesController::class, 'dashboardSiteClassesGuatemalaCancelled']);
    Route::get('classesdashboardguatemala2', [ClassesController::class, 'dashboardClassesGuatemala2']);
    Route::get('classesdashboardguatemala3', [ClassesController::class, 'dashboardClassesGuatemala3']);
    Route::get('classesdashboardguatemala4', [ClassesController::class, 'dashboardClassesGuatemala4']);
    Route::get('applicants/{id}', [ClassesController::class, 'ApplicantsID']);
    Route::get('applicants', [ClassesController::class, 'Applicants']);
    Route::get('applicantsDate', [ClassesController::class, 'ApplicantsDate']);

    Route::get('applicantsExport', [ClassesController::class, 'ApplicantsExport']);
    Route::get('leads_date', [ClassesController::class, 'leadsDatev2']);
    Route::get('leads', [ClassesController::class, 'leads']);
    Route::get('leadsexport', [ClassesController::class, 'exportLeadsData']);
    Route::post('render', [CapEmailController::class, 'sendEmail']);
    Route::get('b2percentage', [ClassesController::class, 'retrieveB2DataForEmail']);
    Route::get('b2percentagejamaica', [ClassesController::class, 'retrieveB2DataForEmailJamaica']);
    Route::get('b2percentageguatemala', [ClassesController::class, 'retrieveB2DataForEmailGuatemala']);
    Route::get('no_srv2', [ClassesController::class, 'perxFilterNoSrv2']);
    Route::get('no_srv2_export', [ClassesController::class, 'perxFilterNoSrExportv2']);
    Route::get('get_payrate/{id}', [ClassesController::class, 'getPayRateByLob']);

    Route::get('classes_information', [ClassesController::class, 'classesInformation']);
    Route::get('classes_information_export', [ClassesController::class, 'classesInformationExport']);
    Route::get('sitev2', [ClassesController::class, 'siteV2']);
    Route::get('lobv2', [ClassesController::class, 'lobV2']);
    // chart
    Route::get('countstatus', [ClassesController::class, 'countStatus']);
    Route::get('class_exists', [ClassesController::class, 'classExists']);
    Route::get('class_exists2', [ClassesController::class, 'classExists2']);

    Route::get('referralsDate', [ClassesController::class, 'referralsDate']);
    Route::get('sourcing-item-history/{id}', [InventoryController::class, 'sourcingItemHistory']);
    Route::get('remx-item-history/{id}', [InventoryController::class, 'remxItemHistory']);
    Route::get('inventory/remxForTransfer', [InventoryController::class, 'remxForTransfer']);
    Route::post('inventory/transferremx/{id}', [InventoryController::class, 'receivedRemxTransfer']);
    // Class Staffing
    Route::post('classesstaffing', [ClassStaffingController::class, 'store']);
    Route::get('classesstaffing/{id}', [ClassStaffingController::class, 'show']);
    Route::put('updateclassesstaffing/{id}', [ClassStaffingController::class, 'update']);
    Route::get('classesstaffing', [ClassStaffingController::class, 'index']);
    Route::get('classesstaffing2', [ClassStaffingController::class, 'index2']);
    Route::get('classestransaction/{id}', [ClassStaffingController::class, 'transaction']);
    Route::get('export-to-excel', [ClassStaffingController::class, 'exportToExcel']);

    // DateRange
    Route::get('daterange', [DateRangeController::class, 'index']);
    Route::get('daterangeall', [DateRangeController::class, 'indexAll']);
    Route::get('daterange_selected/{monthId}', [DateRangeController::class, 'indexByMonth']);
    Route::get('daterange_select/{monthId}', [DateRangeController::class, 'byMonth']);
    Route::get('daterange_selected', [DateRangeController::class, 'perMonth']);
    Route::get('months', [DateRangeController::class, 'getMonth']);
    //Items
    Route::post('items', [ItemsController::class, 'store']);
    Route::post('items_site_supply', [ItemsController::class, 'storeSiteSupply']);
    Route::get('items', [ItemsController::class, 'index']);
    Route::get('itemsboth', [ItemsController::class, 'indexboth']);
    Route::get('itemsboth3', [ItemsController::class, 'indexboth3']);
    Route::get('itemsboth2', [ItemsController::class, 'indexboth2']);
    Route::get('itemseparate', [ItemsController::class, 'indexseparate']);
    Route::get('items2', [ItemsController::class, 'index2']);
    Route::get('siteinventory', [ItemsController::class, 'index3']);
    Route::get('siteinventoryall', [ItemsController::class, 'indexAllSite']);
    Route::get('items_selected/{siteId}', [ItemsController::class, 'index4']);
    Route::get('items_selected2/{siteId}', [ItemsController::class, 'index5']);
    //Inventory
    Route::post('inventory', [InventoryController::class, 'requestItem']);
    Route::post('transfer', [InventoryController::class, 'transferItem']);
    Route::post('transferremx', [InventoryController::class, 'transferRemxItem']);
    Route::put('inventory/cancel/{id}', [InventoryController::class, 'cancelledItem']);
    Route::put('inventory/denied/{id}', [InventoryController::class, 'deniedItem']);
    //Route::put('inventory/transfer/{id}', [InventoryController::class, 'transferItem']);
    Route::put('inventory/received/{id}', [InventoryController::class, 'receivedItem']);
    Route::post('inventory/transfer/{id}', [InventoryController::class, 'receivedTransfer']);
    Route::post('inventory/transferremx/{id}', [InventoryController::class, 'receivedRemxTransfer']);
    Route::put('inventory/approved/{id}', [InventoryController::class, 'approvedItem']);
    Route::get('inventory', [InventoryController::class, 'index']);
    Route::get('inventoryall', [InventoryController::class, 'indexAll']);
    Route::get('inventoryalltransaction', [InventoryController::class, 'indexAllTransaction']);
    Route::get('inventory/approved', [InventoryController::class, 'approved']);
    Route::get('inventory/approved/received', [InventoryController::class, 'approvedReceived']);
    Route::get('inventory/approved/pending', [InventoryController::class, 'approvedPending']);
    Route::get('inventory/denied', [InventoryController::class, 'denied']);
    Route::get('inventory/cancelled', [InventoryController::class, 'cancelled']);
    Route::get('inventory/allstatus', [InventoryController::class, 'allstatus']);
    Route::get('inventory/alltransfer', [InventoryController::class, 'alltransfer']);
    Route::get('inventory/sourcingForTransfer', [InventoryController::class, 'sourcingForTransfer']);
    Route::get('inventory/remxForTransfer', [InventoryController::class, 'remxForTransfer']);
    Route::get('inventory/allrequest', [InventoryController::class, 'request']);
    Route::post('award', [InventoryController::class, 'awardNormalItem']);
    Route::post('award2', [InventoryController::class, 'awardPremiumItem']);
    // Purchase Request
    Route::post('purchase', [PurchaseRequestController::class, 'store']);
    Route::get('purchase', [PurchaseRequestController::class, 'index']);
    Route::get('purchase2', [PurchaseRequestController::class, 'index2']);
    Route::get('purchase3', [PurchaseRequestController::class, 'index3']);
    Route::put('purchase/approved/{id}', [PurchaseRequestController::class, 'approvedPurchase']);
    Route::put('purchase/denied/{id}', [PurchaseRequestController::class, 'deniedPurchase']);
    // Awarded
    Route::get('awarded/normal', [AwardController::class, 'awardedNormal']);
    Route::get('awarded/premium', [AwardController::class, 'awardedPremium']);
    Route::get('awarded/both', [AwardController::class, 'awardedBoth']);
    Route::get('awarded/{id}', [AwardController::class, 'show']);
    Route::post('award/{id}', [AwardController::class, 'update']);
    //HNS
    Route::post('upload-leads-bulk', [LeadController::class, 'storeBulkLeads']);
    Route::post('upload_leads', [LeadController::class, 'storeLeads']);
    Route::post('upload_employees_bulk', [EmployeeController::class, 'storeBulkEmployees']);
    Route::post('upload_employees', [EmployeeController::class, 'storeEmployees']);
    Route::get('employees', [EmployeeController::class, 'index']);
    Route::get('employees_data/{site_id?}', [EmployeeController::class, 'indexEmployees']);
    Route::get('employees_modal_data/{site_id?}', [EmployeeController::class, 'indexModalEmployees']);
    Route::post('update/nbi/requirement/{id}', [EmployeeController::class, 'updateNbi']);
    Route::post('update/dt/requirement/{id}', [EmployeeController::class, 'updateDT']);
    Route::post('update/peme/requirement/{id}', [EmployeeController::class, 'updatePEME']);
    Route::post('update/sss/requirement/{id}', [EmployeeController::class, 'updateSSS']);
    Route::post('update/phic/requirement/{id}', [EmployeeController::class, 'updatePhic']);
    Route::post('update/pagibig/requirement/{id}', [EmployeeController::class, 'updatePagibig']);
    Route::post('update/tin/requirement/{id}', [EmployeeController::class, 'updateTin']);
    Route::post('update/health_certificate/requirement/{id}', [EmployeeController::class, 'updateHealthCertificate']);
    Route::post('update/occupational_permit/requirement/{id}', [EmployeeController::class, 'updateOccupationalPermit']);
    Route::post('update/ofac/requirement/{id}', [EmployeeController::class, 'updateOfac']);
    Route::post('update/sam/requirement/{id}', [EmployeeController::class, 'updateSam']);
    Route::post('update/oig/requirement/{id}', [EmployeeController::class, 'updateOig']);
    Route::post('update/cibi/requirement/{id}', [EmployeeController::class, 'updateCibi']);
    Route::post('update/bgc/requirement/{id}', [EmployeeController::class, 'updateBGC']);
    Route::post('update/birth_certificate/requirement/{id}', [EmployeeController::class, 'updateBirthCertificate']);
    Route::post('update/dependent_birth_certificate/requirement/{id}', [EmployeeController::class, 'updateDependentBirthCertificate']);
    Route::post('update/marriage_certificate/requirement/{id}', [EmployeeController::class, 'updateMarriageCertificate']);
    Route::post('update/scholastic_record/requirement/{id}', [EmployeeController::class, 'updateScholasticRecord']);
    Route::post('update/previous_employment/requirement/{id}', [EmployeeController::class, 'updatePreviousEmployment']);
    Route::post('update/supporting_documents/requirement/{id}', [EmployeeController::class, 'updateSupportingDocuments']);
    Route::post('update/employee_info/requirement/{id}', [EmployeeController::class, 'updateEmployeeInfo']);
    Route::post('update/workday/{id}', [EmployeeController::class, 'updateWorkday']);
    Route::post('/update/lob/{id}', [EmployeeController::class, 'updateLob']);
    Route::get('get/nbi/requirement/{id}', [EmployeeController::class, 'getNbi']);
    Route::get('get/dt/requirement/{id}', [EmployeeController::class, 'getDT']);
    Route::get('get/peme/requirement/{id}', [EmployeeController::class, 'getPEME']);
    Route::get('get/sss/requirement/{id}', [EmployeeController::class, 'getSSS']);
    Route::get('get/phic/requirement/{id}', [EmployeeController::class, 'getPhic']);
    Route::get('get/pagibig/requirement/{id}', [EmployeeController::class, 'getPagibig']);
    Route::get('get/tin/requirement/{id}', [EmployeeController::class, 'getTin']);
    Route::get('get/health_certificate/requirement/{id}', [EmployeeController::class, 'getHealthCertificate']);
    Route::get('get/occupational_permit/requirement/{id}', [EmployeeController::class, 'getOccupationalPermit']);
    Route::get('get/ofac/requirement/{id}', [EmployeeController::class, 'getOfac']);
    Route::get('get/sam/requirement/{id}', [EmployeeController::class, 'getSam']);
    Route::get('get/oig/requirement/{id}', [EmployeeController::class, 'getOig']);
    Route::get('get/cibi/requirement/{id}', [EmployeeController::class, 'getCibi']);
    Route::get('get/bgc/requirement/{id}', [EmployeeController::class, 'getBGC']);
    Route::get('get/birth_certificate/requirement/{id}', [EmployeeController::class, 'getBirthCertificate']);
    Route::get('get/dependent_birth_certificate/requirement/{id}', [EmployeeController::class, 'getDependentBirthCertificate']);
    Route::get('get/marriage_certificate/requirement/{id}', [EmployeeController::class, 'getMarriageCertificate']);
    Route::get('get/scholastic_record/requirement/{id}', [EmployeeController::class, 'getScholasticRecord']);
    Route::get('get/previous_employment/requirement/{id}', [EmployeeController::class, 'getPreviousEmployment']);
    Route::get('get/supporting_documents/requirement/{id}', [EmployeeController::class, 'getSupportingDocuments']);
    Route::get('get/workday/{id}', [EmployeeController::class, 'getWorkday']);
    Route::get('get/employee_info/requirement/{id}', [EmployeeController::class, 'getEmployeeInfo']);
    Route::get('get/lob/{id}', [EmployeeController::class, 'getLob']);
    Route::get('/employees/{id}', [EmployeeController::class, 'show']);
    Route::get('/employee_info/{id}', [EmployeeController::class, 'getEmployee']);
    Route::get('/show/employees/{id}', [EmployeeController::class, 'showEmployee']);
    Route::get('/get/employees/{id}', [EmployeeController::class, 'showUpdate']);
    Route::post('employees/{employeeId}/save-qr-code', [EmployeeController::class, 'saveQRCode']);
    Route::post('/employees/{employee_id}/generate-qr-code', [EmployeeController::class, 'generate']);
    Route::get('employees_export/{site_id?}', [EmployeeController::class, 'ExportEmployee']);
    Route::get('applicants_data', [ApplicantDataController::class, 'index']);
    Route::get('applicants_export_data', [ApplicantDataController::class, 'ExportAttendance']);
    Route::get('/getCreatedAtRange', [ApplicantDataController::class, 'getCreatedAtRange']);

    Route::get('/employees/{id}/download-images', [EmployeeController::class, 'downloadEmployeeImages']);
    Route::post('update/employee/{id}', [EmployeeController::class, 'updateEmployee']);
});
Route::get('out', [ClassesController::class, 'OutOfSla']);
Route::get('cancel', [ClassesController::class, 'Cancelled']);
Route::get('out/month', [ClassesController::class, 'OutOfSlaMonth']);
Route::get('cancel/month', [ClassesController::class, 'CancelledMonth']);
Route::get('data', [ClassesController::class, 'retrieveB2DataForEmail']);
Route::get('sr_compliance_export', [ClassesController::class, 'srComplianceExport']);
Route::get('mpsmonth', [ClassStaffingController::class, 'mpsMonth']);
Route::get('mpsweek', [ClassStaffingController::class, 'mpsWeek']);
Route::get('classes/{id}', [ClassesController::class, 'show']);
Route::get('programs_select/{siteIds}', [ProgramController::class, 'perSite']);
Route::get('oosclasses', [ClassesController::class, 'dashboardSiteOos']);
Route::get('ooscclasses', [ClassesController::class, 'dashboardSiteCancelledOos']);
Route::get('classesdashboard', [ClassesController::class, 'dashboardClasses']);
Route::get('ref_date', [ClassesController::class, 'referralsDatev1']);
Route::get('ref_site', [ClassesController::class, 'refSitev1']);
Route::get('prep_site', [ClassesController::class, 'prefSitev1']);
Route::get('ref_v1', [ClassesController::class, 'referralsDatev1']);
Route::get('ref_v1_export', [ClassesController::class, 'referralsDatev1']);
Route::get('/applicant-sites', [ApplicantSiteController::class, 'index']);
Route::get('/applicant-sites/{id}', [ApplicantSiteController::class, 'show']);
Route::post('/applicant/create', [ApplicantDataController::class, 'store']);
