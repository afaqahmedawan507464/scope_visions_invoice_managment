<?php

namespace App\Http\Controllers\adminside;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\adminside\Admin;
use App\Models\adminside\client;
use App\Models\adminside\company;
use App\Models\adminside\expense;
use App\Models\adminside\invoice;
use Illuminate\Support\Facades\DB;
use App\Models\adminside\quotation;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\employeeside\employee;
use function Laravel\Prompts\confirm;
use App\Models\adminside\bank_expense;

use App\Models\adminside\notification;
use App\Models\adminside\stock_record;
use App\Models\adminside\leave_employee;
use App\Models\adminside\service_report;
use App\Models\adminside\deliever_challan;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\adminside\attendance_employee;
use App\Models\adminside\client_account_history;
use App\Models\adminside\outgoing_inspection_report;
use App\Models\adminside\stocks_disposibles_item_record;

class AdminController extends Controller
{
    //
    public function adminDashboardPage()
    {
        $selectTotalEmployees = employee::where('active_status', '=', 1)->count();
        $selectOnlineEmployees = employee::where('active_status', '=', 1)->where('online_status', '=', 1)->count();
        $selectOfflineEmployees = employee::where('active_status', '=', 1)->where('online_status', '=', 0)->count();
        $selectTotalClients = client::count();
        $notificationCount = notification::where('read_status', '=', 0)->where('readByAdmin', '=', Auth::guard('admin')->user()->id)->count();
        $notificationGet = notification::where('read_status', '=', 0)->where('readByAdmin', '=', Auth::guard('admin')->user()->id)->latest()->get();
        $notificationGet->transform(function ($notification) {
            $timestamp = Carbon::parse($notification->created_at);
            $timeAgo = $timestamp->shortRelativeDiffForHumans(); // Using shortRelativeDiffForHumans to get "0 sec ago" format
            $notification->relative_time = $timeAgo;
            return $notification;
        });
        $totalLeaveData = leave_employee::count();
        $readLeaveData = leave_employee::where('read_status', '=', 1)->count();
        $unreadLeaveData = leave_employee::where('read_status', '=', 0)->count();
        $approvedLeaveData = leave_employee::where('leave_status', '=', 1)->count();
        $rejectedLeaveData = leave_employee::where('leave_status', '=', 0)->count();
        $countStock = stock_record::count();
        $nearExpiryItems = DB::table('stock_records')
            ->whereDate('item_expDate', '<=', now()->addDays(30))
            ->count();

        $outOfStockItems = DB::table('stock_records')
            ->where('item_qtv', '=', 0)
            ->count();
        $todayCreated = stock_record::whereDate('created_at', today())->count();
        $countDeleiveryChallan = deliever_challan::count();
        $deleiveryTodayCreated = deliever_challan::whereDate('created_at', today())->count();
        $countServiceReport = service_report::count();
        $serviceTodayCreated = service_report::whereDate('created_at', today())->count();
        $countInvoices = invoice::count();
        $countTodayCreated = invoice::whereDate('created_at', today())->count();
        $countQuotation = quotation::count();
        $countTodayCreatedQuo = quotation::whereDate('created_at', today())->count();
        $companyCount = company::count();
        $selectClients = invoice::join('clients', 'invoices.invoice_client_id', '=', 'clients.id')->select('invoices.*', 'clients.client_name')->get();
        $selectEmployees = employee::where('active_status', '=', 1)->get();
        $activeEmployees = employee::where('online_status', '=', 1)->get();
        $deactiveEmployees = employee::where('online_status', '=', 0)->get();
        $serviceReport = service_report::count();
        $leaveEmployeez = leave_employee::all();
        return view('adminside.dashboard.adminDashboard', [
            'selectTotalEmployees'         => $selectTotalEmployees,
            'selectOnlineEmployees'        => $selectOnlineEmployees,
            'selectOfflineEmployees'       => $selectOfflineEmployees,
            'selectTotalClients'           => $selectTotalClients,
            'notificationCount'            => $notificationCount,
            'notifications'                => $notificationGet,
            'totalLeaveData'               => $totalLeaveData,
            'readLeaveData'                => $readLeaveData,
            'unreadLeaveData'              => $unreadLeaveData,
            'approvedLeaveData'            => $approvedLeaveData,
            'rejectedLeaveData'            => $rejectedLeaveData,
            'countStock'                   => $countStock,
            'nearExpiryItems'              => $nearExpiryItems,
            'outOfStockItems'              => $outOfStockItems,
            'todayCreated'                 => $todayCreated,
            'countDeleiveryChallan'        => $countDeleiveryChallan,
            'deleiveryTodayCreated'        => $deleiveryTodayCreated,
            'countServiceReport'           => $countServiceReport,
            'serviceTodayCreated'          => $serviceTodayCreated,
            'countInvoices'                => $countInvoices,
            'countTodayCreated'            => $countTodayCreated,
            'countQuotation'               => $countQuotation,
            'countTodayCreatedQuo'         => $countTodayCreatedQuo,
            'companyCount'                 => $companyCount,
            'selectClients'                => $selectClients,
            'selectEmployees'              => $selectEmployees,
            'activeEmployees'              => $activeEmployees,
            'deactiveEmployees'            => $deactiveEmployees,
            'serviceReport'                => $serviceReport,
            'leaveEmployeez'                => $leaveEmployeez,
        ]);
    }
    //
    public function loginOperation(Request $request)
    {
        $validationChecker = $request->validate([
            'loginEmailaddress' => 'required',
            'password'     => 'required',
        ]);
        $loginFormData = $request->all();
        if ($validationChecker != null) {
            
            if (Auth::guard('admin')->attempt([
                'adminemailaddress' => $loginFormData['loginEmailaddress'],
                'password'     => $loginFormData['password'],
            ])) {
                if (Auth::guard('admin')->user()->active_status == '1') {
                    return redirect()->route('adminDashboardPage');
                } else {
                    return redirect()->back()->with('error_message', 'Your Account Is Not Be Activated');
                }
            } else if (Auth::guard('employee')->attempt([
                'employeeemailaddress' => $loginFormData['loginEmailaddress'],
                'password'     => $loginFormData['password'],
            ])) {
                if (Auth::guard('employee')->user()->active_status == '1') {
                    if (Auth::guard('employee')->user()->user_type == 'computer operator') {
                        // echo "employee dashboard";
                        return redirect()->route('employeeDashboardPage');
                    } else {
                        return redirect()->back()->with('error_message', 'Only Allow Login Admin And Computer Operator');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'Your Account Is Not Be Activated');
                }
            } else {
                return redirect()->back()->with('error_message', 'Incorrect Username Or Password');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function logoutOperation()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('loginForm');
    }
    //
    public function companyNameList()
    {
        $selectCompanies = DB::table('companies')->get();
        return view('adminside.company.company-list', [
            'selectCompany' => $selectCompanies,
        ]);
    }
    //
    public function pageCreatingCompany()
    {
        return view('adminside.company.company-create');
    }
    //
    public function createComponyOperation(Request $request)
    {
        $validatorChecker = $request->validate([
            'companyName'            => 'required',
            'companyLogo'            => 'required|mimes:png,jpg,jpeg',
            'companyEmailAddress'    => 'required|email',
            'companyContactNumber'   => 'required|numeric',
            'companyOwnerName'       => 'required|min:4',
            'companyNTNNumber'       => 'required',
            'companyAddress'         => 'required|min:10',
            'companyWorkInformation' => 'required|min:10',
            'companyOpenTiming'      => 'required',
            'companyCloseTiming'     => 'required',
            'companyPhoneNumber'     => 'required',
        ]);
        $data = $request->all();
        $timeIn  = Carbon::parse($data['companyOpenTiming']);
        $timeOut = Carbon::parse($data['companyCloseTiming']);
        if ($validatorChecker == !null) {
            $selectCompanyName = DB::table('companies')
                ->get();
            if (count($selectCompanyName) > 0) {
                return redirect()->back()->with('error_message', 'this data is al-ready availible');
            } else {
                // ==================== Company Logo Uploading Operation  ==========================

                $companyLogo = time() . "-company logo." . $request->file('companyLogo')->getClientOriginalExtension();
                $request->file('companyLogo')->storeAs('public/company_image' . $companyLogo);
                $imageUrl = "/storage/company_image" . $companyLogo;

                // ==================== Company Logo Uploading Operation  ==========================
                $createNewCompany = DB::table('companies')
                    ->insertOrIgnore([
                        'company_name'           => $data['companyName'],
                        'company_logo'           => $imageUrl,
                        'company_emailaddress'   => $data['companyEmailAddress'],
                        'company_contactnumber'  => $data['companyContactNumber'],
                        'company_phonenumber'    => $data['companyPhoneNumber'],
                        'company_ownername'      => $data['companyOwnerName'],
                        'company_ntnnumber'      => $data['companyNTNNumber'],
                        'companyTimeIn'          => $timeIn,
                        'companyTimeOut'         => $timeOut,
                        'company_address'        => $data['companyAddress'],
                        'company_workDetails'    => $data['companyWorkInformation'],
                        'created_at'             => NOW(),
                        'updated_at'             => NOW(),
                    ]);
                if ($createNewCompany) {
                    return redirect()->back()->with('success_message', 'Company Creating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Company Creating Operation Is Un-Successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function removedCompanyInformation($id)
    {
        $selectCompany = DB::table('companies')->where('id', '=', $id)->get();
        if (count($selectCompany) > 0) {
            $removedRecord = DB::table('companies')->where('id', '=', $id)->delete();
            if ($removedRecord) {
                return redirect()->back()->with('success_message', 'deleted successfully');
            } else {
                return redirect()->back()->with('error_message', 'deleted un-successfully');
            }
        } else {
            echo "alert('Not Data Founded')";
        }
    }
    //
    public function searchCompany(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $selectCompany  = DB::table('companies')
                    ->where('id', 'like', '%' . $query . '%')
                    ->orWhere('company_name', 'like', '%' . $query . '%')
                    ->orWhere('company_emailaddress', 'like', '%' . $query . '%')
                    ->orWhere('company_contactnumber', 'like', '%' . $query . '%')
                    ->orWhere('company_ownername', 'like', '%' . $query . '%')
                    ->orWhere('company_ntnnumber', 'like', '%' . $query . '%')
                    ->orWhere('company_address', 'like', '%' . $query . '%')
                    ->orWhere('company_workDetails', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $selectCompany  = DB::table('companies')
                    ->get();
            }

            $total_row = $selectCompany->count();
            if ($total_row > 0) {
                foreach ($selectCompany  as $companyDetails) {
                    $output .= '
                    <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-body">
                                        <div class="row py-2">
                                            <div class="col-12" style="padding-left: 90%;">
                                                <a href="#" class="action-icon dropdown-toggle text-black"
                                                    data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                <div class="dropdown-menu dropdown-menu-right" style="">
                                                    <a class="dropdown-item"
                                                        href="/CompanyDetailsPage/' . $companyDetails->id . '"><i
                                                            class="fas fa-user mx-2"></i> View Detail</a>
                                                    <a class="dropdown-item"
                                                        href="/CompanyEditPage/' . $companyDetails->id . '"><i
                                                            class="fas fa-edit mx-2"></i> Edit</a>
                                                    <a class="dropdown-item"
                                                        href="/CompanyRemovedOperation/' . $companyDetails->id . '"><i
                                                            class="fas fa-trash mx-2"></i> Delete</a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <span
                                                    style="font-size: 20px;">' . $companyDetails->company_name . '</span>
                                                <br>
                                                <span style="font-size: 12px;"><i class="mx-2 fas fa-envelope"></i>
                                                    <span mx-2>' . $companyDetails->company_emailaddress . '</span></span>
                                                <br>
                                                <span style="font-size: 12px;"><i class="mx-2 fas fa-phone"></i>
                                                    <span
                                                        mx-2>' . $companyDetails->company_contactnumber . '</span></span>
                                                <br>
                                                <span style="font-size: 12px;"><i class="mx-2 fas fa-map"></i>
                                                    <span mx-2>' . $companyDetails->company_address . '</span></span>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    ';
                }
            } else {
                $output = '<span class="text-center">No Data Found</span>';
            }
            return response()->json(['table_data' => $output]);
        }
    }
    //
    function editPageCompany($id)
    {
        $selectCompanyes = DB::table('companies')
            ->where('id', '=', $id)
            ->get();
        if (count($selectCompanyes) > 0) {
            return view('adminside.company.company-edit', [
                'selectCompanyes' => $selectCompanyes,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    function updateCompanyOperation(Request $request, $id)
    {
        $validatorChecker = $request->validate([
            'companyName'            => 'required',
            // 'companyLogo'            => 'required|mimes:png,jpg,jpeg', 
            'companyEmailAddress'    => 'required|email',
            'companyContactNumber'   => 'required|numeric',
            'companyOwnerName'       => 'required|min:4',
            'companyNTNNumber'       => 'required',
            'companyAddress'         => 'required|min:10',
            'companyWorkInformation' => 'required|min:10',
            'companyOpenTiming'      => 'required',
            'companyCloseTiming'     => 'required',
            'companyPhoneNumber'     => 'required',
        ]);
        $data = $request->all();
        $timeIn  = Carbon::parse($data['companyOpenTiming']);
        $timeOut = Carbon::parse($data['companyCloseTiming']);
        if ($validatorChecker == !null) {
            if (!empty($data['companyLogo'])) {
                $selectCompanyName = DB::table('companies')
                    ->where('id', '=', $id)
                    ->get();
                if (count($selectCompanyName) == 0) {
                    return redirect()->back()->with('error_message', 'Not Data Founded');
                } else {
                    // ==================== Company Logo Uploading Operation  ==========================

                    $companyLogo = time() . "-company logo." . $request->file('companyLogo')->getClientOriginalExtension();
                    $request->file('companyLogo')->storeAs('public/company_image' . $companyLogo);
                    $imageUrl = "/storage/company_image" . $companyLogo;

                    // ==================== Company Logo Uploading Operation  ==========================
                    $createNewCompany = DB::table('companies')
                        ->where('id', '=', $id)
                        ->update([
                            'company_name'           => $data['companyName'],
                            'company_logo'           => $imageUrl,
                            'company_emailaddress'   => $data['companyEmailAddress'],
                            'company_contactnumber'  => $data['companyContactNumber'],
                            'company_phonenumber'    => $data['companyPhoneNumber'],
                            'company_ownername'      => $data['companyOwnerName'],
                            'company_ntnnumber'      => $data['companyNTNNumber'],
                            'companyTimeIn'          => $timeIn,
                            'companyTimeOut'         => $timeOut,
                            'company_address'        => $data['companyAddress'],
                            'company_workDetails'    => $data['companyWorkInformation'],
                            'updated_at'             => NOW(),
                        ]);
                    if ($createNewCompany) {
                        return redirect()->back()->with('success_message', 'Company Updated Operation Is Successfully');
                    } else {
                        return redirect()->back()->with('error_message', 'Company Updated Operation Is Un-Successfully');
                    }
                }
            } else {
                $selectCompanyName = DB::table('companies')
                    ->where('company_name', '=', $data['companyName'])
                    ->orWhere('company_emailaddress', '=', $data['companyEmailAddress'])
                    ->get();
                if (count($selectCompanyName) == 0) {
                    return redirect()->back()->with('error_message', 'Not Data Founded');
                } else {
                    // // ==================== Company Logo Uploading Operation  ==========================

                    // $companyLogo = time() . "-company logo." .$request->file('companyLogo')->getClientOriginalExtension();
                    // $request->file('companyLogo')->storeAs('public/company_image' . $companyLogo);
                    // $imageUrl = "/storage/company_image" . $companyLogo;

                    // // ==================== Company Logo Uploading Operation  ==========================
                    $createNewCompany = DB::table('companies')
                        ->where('id', '=', $id)
                        ->update([
                            'company_name'           => $data['companyName'],
                            // 'company_logo'           => $imageUrl,
                            'company_emailaddress'   => $data['companyEmailAddress'],
                            'company_contactnumber'  => $data['companyContactNumber'],
                            'company_phonenumber'    => $data['companyPhoneNumber'],
                            'company_ownername'      => $data['companyOwnerName'],
                            'company_ntnnumber'      => $data['companyNTNNumber'],
                            'companyTimeIn'          => $timeIn,
                            'companyTimeOut'         => $timeOut,
                            'company_address'        => $data['companyAddress'],
                            'company_workDetails'    => $data['companyWorkInformation'],
                            'created_at'             => NOW(),
                            'updated_at'             => NOW(),
                        ]);
                    if ($createNewCompany) {
                        return redirect()->back()->with('success_message', 'Company Updated Operation Is Successfully');
                    } else {
                        return redirect()->back()->with('error_message', 'Company Updated Operation Is Un-Successfully');
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    function detailsPageCompany($id)
    {
        $selectCompanyes = DB::table('companies')
            ->where('id', '=', $id)
            ->get();
        if (count($selectCompanyes) > 0) {
            return view('adminside.company.company-details', [
                'selectCompanyes' => $selectCompanyes,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function clientNameList()
    {
        $selectClientData = DB::table('clients')->get();
        return view('adminside.client.client-list', [
            'selectClients' => $selectClientData,
        ]);
    }
    //
    public function pageCreatingClient()
    {
        return view('adminside.client.client-create');
    }
    //
    public function clientCreationOperation(Request $request)
    {
        $validationChacker = $request->validate([
            'clientName'                => 'required',
            'clientEmailAddress'        => 'required|email|unique:clients,client_emailaddress',
            'clientContactNumber'       => 'required|numeric',
            'clientOrganizationName'    => 'required|min:4',
            'clientType'                => 'required',
            'clientAddress'             => 'required|min:10',
        ]);
        $clientdata = $request->all();
        if ($validationChacker != null) {
            $selectOldData = DB::table('clients')
                ->where('client_name', '=', $clientdata['clientName'])
                ->orWhere('client_emailaddress', '=', $clientdata['clientEmailAddress'])
                ->orWhere('client_contactinformation', '=', $clientdata['clientContactNumber'])
                ->get();
            if (count($selectOldData) > 0) {
                return redirect()->back()->with('error_message', 'this data is already availible');
            } else {
                $createNewClient = DB::table('clients')
                    ->insertOrIgnore([
                        'client_name'                => $clientdata['clientName'],
                        'client_emailaddress'        => $clientdata['clientEmailAddress'],
                        'client_organizationname'    => $clientdata['clientOrganizationName'],
                        'client_address'             => $clientdata['clientAddress'],
                        'client_contactinformation'  => $clientdata['clientContactNumber'],
                        'client_type'                => $clientdata['clientType'],
                        'created_at'                 => NOW(),
                        'updated_at'                 => NOW(),
                    ]);
                if ($createNewClient) {
                    return redirect()->back()->with('success_message', 'Client Creation Operation Is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Client Creation Operation Is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function searchClient(Request $request)
    {
        $query = $request->all();
        if ($query != '') {
            $selectClientData  = DB::table('clients')
                ->where('client_name', 'like', '%' . $query['searchClient'] . '%')
                ->orWhere('client_emailaddress', 'like', '%' . $query['searchClient'] . '%')
                ->orWhere('client_organizationname', 'like', '%' . $query['searchClient'] . '%')
                ->orWhere('client_contactinformation', 'like', '%' . $query['searchClient'] . '%')
                ->get();
        } else {
            $selectClientData  = DB::table('clients')
                ->get();
        }
        return view('adminside.client.client-list', [
            'selectClients' => $selectClientData,
        ]);
    }
    //
    public function removeClientInformationOperation($id)
    {
        $selectClient = DB::table('clients')
            ->where('id', '=', $id)
            ->get();
        if (count($selectClient) > 0) {
            $deletedClient = DB::table('clients')
                ->where('id', '=', $id)
                ->delete();
            if ($deletedClient) {
                return redirect()->back()->with('success_message', 'Client Removed Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Client Removed Is Un-Successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function editPageClient($id)
    {
        $selectClients = DB::table('clients')
            ->where('id', '=', $id)
            ->get();
        if (count($selectClients) > 0) {
            return view('adminside.client.client-edit', [
                'selectClients' => $selectClients,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function updateClientOperation(Request $request, $id)
    {
        $validationChacker = $request->validate([
            'clientName'                => 'required',
            'clientContactNumber'       => 'required|numeric',
            'clientOrganizationName'    => 'required|min:4',
            'clientType'                => 'required',
            'clientAddress'             => 'required|min:10',
        ]);
        $clientdata = $request->all();
        if ($validationChacker != null) {
            $selectOldData = DB::table('clients')
                ->where('id', '=', $id)
                ->get();
            if (count($selectOldData) == 0) {
                return redirect()->back()->with('error_message', 'this data is already availible');
            } else {
                $createNewClient = DB::table('clients')
                    ->where('id', '=', $id)
                    ->update([
                        'client_name'                => $clientdata['clientName'],
                        'client_emailaddress'        => $clientdata['clientEmailAddress'],
                        'client_organizationname'    => $clientdata['clientOrganizationName'],
                        'client_address'             => $clientdata['clientAddress'],
                        'client_contactinformation'  => $clientdata['clientContactNumber'],
                        'client_type'                => $clientdata['clientType'],
                        'updated_at'                 => NOW(),
                    ]);
                if ($createNewClient) {
                    return redirect()->back()->with('success_message', 'Client Updated Operation Is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Client Updated Operation Is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function detailClientPage($id)
    {
        $selectClientPage = DB::table('clients')
            ->where('id', '=', $id)
            ->get();
        if (count($selectClientPage) > 0) {
            return view('adminside.client.client-details', [
                'selectClients' => $selectClientPage,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function employeeNameList()
    {
        $selectEmployee = DB::table('employees')->get();
        return view('adminside.employee.employee-list', [
            'selectEmployee' => $selectEmployee,
        ]);
    }
    //
    public function pageCreatingEmployee()
    {
        return view('adminside.employee.employee-create');
    }
    //
    public function createOperationEmployee(Request $request)
    {
        $validationChaker = $request->validate([
            'employeeName'              => 'required',
            'employeeEmailAddress'      => 'required|email|unique:employees,employeeemailaddress',
            'password'                  => 'required|min:8|max:15|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'employeeConformPassword'   => 'required|same:password|min:8|max:15|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'employeeType'              => 'required',
        ]);
        $employeeFormData = $request->all();
        if ($validationChaker) {
            $selectEmployee = DB::table('employees')
                ->where('employeename', '=', $employeeFormData['employeeName'])
                ->orWhere('employeeemailaddress', '=', $employeeFormData['employeeEmailAddress'])
                ->get();
            if (count($selectEmployee) > 0) {
                return redirect()->back()->with('error_message', 'this data is already availible');
            } else {
                if ($employeeFormData['password'] == $employeeFormData['employeeConformPassword']) {
                    $createEmployee = DB::table('employees')
                        ->insertOrIgnore([
                            'user_type'              => $employeeFormData['employeeType'],
                            'employeename'           => $employeeFormData['employeeName'],
                            'employeeemailaddress'   => $employeeFormData['employeeEmailAddress'],
                            'password'               => Hash::make($employeeFormData['password']),
                            'active_status'          => 0,
                            'created_at'             => NOW(),
                            'updated_at'             => NOW(),
                        ]);
                    if ($createEmployee) {
                        return redirect()->back()->with('success_message', 'Employee Creating Operation Is Successfully');
                    } else {
                        return redirect()->back()->with('error_message', 'Employee Creating Operation Is Un-successfully');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'Password And Confirm Password Is Not Matched');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function searchEmployee(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $selectEmployee  = DB::table('employees')
                    ->where('user_type', 'like', '%' . $query . '%')
                    ->orWhere('employeename', 'like', '%' . $query . '%')
                    ->orWhere('employeeemailaddress', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $selectEmployee  = DB::table('employees')
                    ->get();
            }

            $total_row = $selectEmployee->count();
            if ($total_row > 0) {
                //     foreach ($selectEmployee as $selectEmployees) {
                //         if ($selectEmployees->active_status == 0) {
                //             $output .= '
                //         <tr>
                //         <th scope="row" style="width: 5%">' . $selectEmployees->id . '</th>
                //         <td style="width: 20%;text-align:center">' . $selectEmployees->user_type . '</td>
                //         <td  style="width: 40%;text-align:center">
                //             ' . $selectEmployees->employeename . '
                //         </td>
                //         <td  style="width: 30%;text-align:center">
                //             ' . $selectEmployees->employeeemailaddress . '
                //         </td>
                //         <td  style="width: 5%;text-align:center">
                //         <div class="d-flex justify-content-center">
                //                             <div class="row">
                //                                 <div class="col-12">
                //                                     <a href="#" class="action-icon dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>
                //                                     <div class="dropdown-menu dropdown-menu-right" style="">
                //                                       <a class="dropdown-item" href="/detailEmployeePage/' . $selectEmployees->id . '"><i class="fas fa-user mx-2"></i> View Detail</a>
                //                                       <a class="dropdown-item" href="/EditEmployeePages/' . $selectEmployees->id . '"><i class="fas fa-edit mx-2"></i> Edit</a>
                //                                       <a class="dropdown-item" href="/removeEmployeeOperation/' . $selectEmployees->id . '"><i class="fas fa-trash mx-2"></i> Delete</a>
                //                                       <a class="dropdown-item" href="/attendanceDetailsPage/' . $selectEmployees->id . '"><i class="fas fa-history mx-2"></i> Attendance</a>
                //                                       <a class="dropdown-item" href="/activeUser/' . $selectEmployees->id . '"><i class="fas fa-user-check mx-2"></i> Active</a>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                         </div>
                //         </tr>
                //         ';
                //         } else if ($selectEmployees->active_status == 1) {
                //             $output .= '
                //         <tr>
                //         <th scope="row" style="width: 5%">' . $selectEmployees->id . '</th>
                //         <td style="width: 20%;text-align:center">' . $selectEmployees->user_type . '</td>
                //         <td  style="width: 40%;text-align:center">
                //             ' . $selectEmployees->employeename . '
                //         </td>
                //         <td  style="width: 30%;text-align:center">
                //             ' . $selectEmployees->employeeemailaddress . '
                //         </td>
                //         <td  style="width: 5%;text-align:center">
                //         <div class="d-flex justify-content-center">
                //                             <div class="row">
                //                                 <div class="col-12">
                //                                     <a href="#" class="action-icon dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>
                //                                     <div class="dropdown-menu dropdown-menu-right" style="">
                //                                       <a class="dropdown-item" href="/detailEmployeePage/' . $selectEmployees->id . '"><i class="fas fa-user mx-2"></i> View Detail</a>
                //                                       <a class="dropdown-item" href="/EditEmployeePages/' . $selectEmployees->id . '"><i class="fas fa-edit mx-2"></i> Edit</a>
                //                                       <a class="dropdown-item" href="/removeEmployeeOperation/' . $selectEmployees->id . '"><i class="fas fa-trash mx-2"></i> Delete</a>
                //                                       <a class="dropdown-item" href="/attendanceDetailsPage/' . $selectEmployees->id . '"><i class="fas fa-history mx-2"></i> Attendance</a>
                //                                       <a class="dropdown-item" href="/deactiveUser/' . $selectEmployees->id . '"><i class="fas fa-user-times mx-2"></i> De-active</a>
                //                                     </div>
                //                                 </div>
                //                             </div>
                //                         </div>
                //         </tr>
                //         ';
                //         }
                //     }
                // } else {
                //     $output = '
                //     <tr>
                //         <td align="center" colspan="12">No Data Found</td>
                //     </tr>
                //     ';
                // }
                // $selectEmployee = array(
                //     'table_data'  => $output,
                // );
                // echo json_encode($selectEmployee);
                foreach ($selectEmployee as $selectEmployees) {
                    if ($selectEmployees->active_status == 0) {
                        $output .= '
                       <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-body">
                                            <div class="row py-2">
                                                <div class="col-12" style="padding-left: 90%;">
                                                    <a href="#" class="action-icon dropdown-toggle text-black"
                                                        data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item"
                                                            href="/detailEmployeePage/' . $selectEmployees->id . '"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                        <a class="dropdown-item"
                                                            href="/EditEmployeePages/' . $selectEmployees->id . '"><i
                                                                class="fas fa-edit mx-2"></i> Edit</a>
                                                        <a class="dropdown-item"
                                                            href="/removeEmployeeOperation/' . $selectEmployees->id . '"><i
                                                                class="fas fa-trash mx-2"></i> Delete</a>
                                                        <a class="dropdown-item"
                                                            href="/attendanceDetailsPage/' . $selectEmployees->id . '"><i
                                                                class="fas fa-history mx-2"></i> Attendance</a>
                                                            <a class="dropdown-item"
                                                                href="/activeUser/' . $selectEmployees->id . '"><i
                                                                    class="fas fa-user-check mx-2"></i> Active</a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 20px;">' . $selectEmployees->employeename . '</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i
                                                            class="mx-2 fas fa-envelope"></i>
                                                        <span
                                                            mx-2>' . $selectEmployees->employeeemailaddress . '</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-users"></i>
                                                        <span mx-2>' . $selectEmployees->user_type . '</span></span>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                       </div>
                    ';
                    } else {
                        $output .= '
                       <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-body">
                                            <div class="row py-2">
                                                <div class="col-12" style="padding-left: 90%;">
                                                    <a href="#" class="action-icon dropdown-toggle text-black"
                                                        data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item"
                                                            href="/detailEmployeePage/' . $selectEmployees->id . '"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                        <a class="dropdown-item"
                                                            href="/EditEmployeePages/' . $selectEmployees->id . '"><i
                                                                class="fas fa-edit mx-2"></i> Edit</a>
                                                        <a class="dropdown-item"
                                                            href="/removeEmployeeOperation/' . $selectEmployees->id . '"><i
                                                                class="fas fa-trash mx-2"></i> Delete</a>
                                                        <a class="dropdown-item"
                                                            href="/attendanceDetailsPage/' . $selectEmployees->id . '"><i
                                                                class="fas fa-history mx-2"></i> Attendance</a>
                                                            <a class="dropdown-item"
                                                                href="/deactiveUser/' . $selectEmployees->id . '"><i
                                                                    class="fas fa-user-times mx-2"></i> De-active</a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 20px;">' . $selectEmployees->employeename . '</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i
                                                            class="mx-2 fas fa-envelope"></i>
                                                        <span
                                                            mx-2>' . $selectEmployees->employeeemailaddress . '</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-users"></i>
                                                        <span mx-2>' . $selectEmployees->user_type . '</span></span>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                       </div>
                    ';
                    }
                }
            } else {
                $output = '<span class="text-center">No Data Found</span>';
            }
            return response()->json(['table_data' => $output]);
        }
    }
    // 
    public function deactiveUser($id)
    {
        $selectEmployeePage = DB::table('employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectEmployeePage) > 0) {
            $updateStatus = DB::table('employees')->where('id', '=', $id)->update([
                'active_status' => 0,
                'updated_at' => NOW(),
            ]);
            if ($updateStatus) {
                return redirect()->back()->with('success_message', 'Status Is Changed');
            } else {
                return redirect()->back()->with('error_message', 'Status Is UnChanged');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function activeUser($id)
    {
        $selectEmployeePage = DB::table('employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectEmployeePage) > 0) {
            $updateStatus = DB::table('employees')->where('id', '=', $id)->update([
                'active_status' => 1,
                'updated_at' => NOW(),
            ]);
            if ($updateStatus) {
                return redirect()->back()->with('success_message', 'Status Is Changed');
            } else {
                return redirect()->back()->with('error_message', 'Status Is UnChanged');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeOperationEmployee($id)
    {
        $selectEmployeeOperation = DB::table('employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectEmployeeOperation) > 0) {
            $removeEmployeeOperation = DB::table('employees')
                ->where('id', '=', $id)
                ->delete();
            if ($removeEmployeeOperation) {
                return redirect()->back()->with('success_message', 'Employee Removed Operation Is SuccessfullY');
            } else {
                return redirect()->back()->with('error_message', 'Employee Removed Operation Is Un-successfullY');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function editEmployeePage($id)
    {
        $selectEmployeePage = DB::table('employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectEmployeePage) > 0) {
            return view('adminside.employee.employee-edit', [
                'selectEmployee' => $selectEmployeePage,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function updateEmployeeOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'employeeName'              => 'required',
            'employeeType'              => 'required',
        ]);
        $employeeFormData = $request->all();
        if ($validationChaker) {
            $selectEmployee = DB::table('employees')
                ->where('id', '=', $id)
                ->get();
            if (count($selectEmployee) == 0) {
                return redirect()->back()->with('error_message', 'this data is already availible');
            } else {
                $createEmployee = DB::table('employees')
                    ->where('id', '=', $id)
                    ->update([
                        'user_type'              => $employeeFormData['employeeType'],
                        'employeename'           => $employeeFormData['employeeName'],
                        'employeeemailaddress'   => $employeeFormData['employeeEmailAddress'],
                        'active_status'          => 0,
                        'updated_at'             => NOW(),
                    ]);
                if ($createEmployee) {
                    return redirect()->back()->with('success_message', 'Employee Updating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Employee Updating Operation Is Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function detailEmployeePage($id)
    {
        $selectEmployeePage     = DB::table('employee_details')
            ->leftJoin('employees', 'employee_details.employee_id', '=', 'employees.id')
            ->select('employee_details.*', 'employees.employeename', 'employees.employeeemailaddress', 'employees.user_image', 'employees.user_type')
            ->where('employees.id', '=', $id)
            ->get();
        $selectSocials          = DB::table('employee_socials')->where('employee_id', '=', $id)->get();
        $educations             = DB::table('employee_education_informations')->where('employee_id', '=', $id)->get();
        $educationsAdditional   = DB::table('additional_cources')->where('employee_id', '=', $id)->get();
        if (count($selectEmployeePage) > 0) {
            return view('adminside.employee.employee-details', [
                'selectEmployeePage'       => $selectEmployeePage,
                'selectSocials'        => $selectSocials,
                'educations'           => $educations,
                'educationsAdditional' => $educationsAdditional,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function withoutTjfInspectionIncomingListPage()
    {
        $selectIncomingInspectionReport = DB::table('incoming_inspection_reports')->get();
        $selectOutgoingInspectionReport = DB::table('incoming_and_outgoings')->get();
        $selectStock                    = DB::table('stock_records')->get();
        return view('adminside.inspectionReports.withtjf.incoming.inspection-list', [
            'selectIncomingInspectionReport' => $selectIncomingInspectionReport,
            'selectOutgoingInspectionReport' => $selectOutgoingInspectionReport,
            'selectStock'                    => $selectStock,
        ]);
    }
    //
    public function withoutTjfInspectionIncomingCreatingPage()
    {
        $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
        $companySelect = DB::table('companies')->get();

        return view('adminside.inspectionReports.withtjf.incoming.inspection-create', [
            'selectEmployees' => $selectEmployees,
            'companySelect'   => $companySelect,
        ]);
    }
    //
    public function withoutTjfInspectionIncomingCreateOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $createIncomingReports = DB::table('incoming_inspection_reports')
                ->insertOrIgnore([
                    'scope_model'               => $incomingInsppectionFormData['scopeModel'],
                    'scope_incoming_date'       => $incomingInsppectionFormData['scopeIncomingDate'],
                    'scope_sr_number'           => $incomingInsppectionFormData['scopeSrNumber'],
                    'sender_name'               => $incomingInsppectionFormData['scopeSenderName'],
                    'scope_sending_with'        => $incomingInsppectionFormData['scopeReceivedWith'],
                    'scope_leakage'             => $incomingInsppectionFormData['scopeLeakage'],
                    'scope_view'                => $incomingInsppectionFormData['scopeView'],
                    'scope_lightguide'          => $incomingInsppectionFormData['scopeLightGuide'],
                    'scope_airwater'            => $incomingInsppectionFormData['scopeairwater'],
                    'scope_angulation'          => $incomingInsppectionFormData['scopeAngulation'],
                    'scope_lgtube'              => $incomingInsppectionFormData['scopeLgTube'],
                    'scope_insertiontube'       => $incomingInsppectionFormData['scopeInsertionTube'],
                    'scope_biopsychannel'       => $incomingInsppectionFormData['scopeBiopsyChannel'],
                    'scope_objectivelenz'       => $incomingInsppectionFormData['scopeObjectiveLenz'],
                    'scope_suction'             => $incomingInsppectionFormData['scopeSuction'],
                    'scope_angulation_lock'     => $incomingInsppectionFormData['scopeAngulationLock'],
                    'scope_freezing_buttons'    => $incomingInsppectionFormData['scopeFreezeButtons'],
                    'remarks'                   => $incomingInsppectionFormData['scopeRemarks'],
                    'inspectedby_id'            => $incomingInsppectionFormData['scopeInspectedBy'],
                    'company_id'                => $incomingInsppectionFormData['companyId'],
                    'created_at'                => NOW(),
                    'updated_at'                => NOW(),
                ]);
            if ($createIncomingReports) {
                return redirect()->back()->with('success_message', 'Inspection Report Is Creating Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Inspection Report Is Creating Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function searchIncomingGastroAndColonoScopeReport(Request $request)
    {
        $validationChaker = $request->validate([
            'searchIncomingInspectionReport' => 'required',
        ]);
        $query = $request->all();
        if ($validationChaker) {
            $selectIncomingInspectionReport  = DB::table('incoming_inspection_reports')
                ->where('id', 'like', '%' . $query['searchIncomingInspectionReport'] . '%')
                ->orWhere('scope_model', 'like', '%' . $query['searchIncomingInspectionReport'] . '%')
                ->orWhere('scope_sr_number', 'like', '%' . $query['searchIncomingInspectionReport'] . '%')
                ->orWhere('scope_incoming_date', 'like', '%' . $query['searchIncomingInspectionReport'] . '%')
                ->orWhere('sender_name', 'like', '%' . $query['searchIncomingInspectionReport'] . '%')
                ->get();
            if (count($selectIncomingInspectionReport) > 0) {
                $selectOutgoingInspectionReport = DB::table('outgoing_inspection_reports')->get();
                return view('adminside.inspectionReports.withtjf.incoming.inspection-list', [
                    'selectIncomingInspectionReport' => $selectIncomingInspectionReport,
                    'selectOutgoingInspectionReport' => $selectOutgoingInspectionReport,
                ]);
            } else {
                $selectIncomingInspectionReport  = DB::table('incoming_inspection_reports')->get();
                $selectOutgoingInspectionReport = DB::table('outgoing_inspection_reports')->get();
                return view('adminside.inspectionReports.withtjf.incoming.inspection-list', [
                    'selectIncomingInspectionReport' => $selectIncomingInspectionReport,
                    'selectOutgoingInspectionReport' => $selectOutgoingInspectionReport,
                ]);
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function detailsPageIncomingGastroAndColonoScope($id)
    {
        $selectIncomingReportInspection = DB::table('incoming_inspection_reports')
            ->join('employees', 'incoming_inspection_reports.inspectedby_id', '=', 'employees.id')
            ->select('incoming_inspection_reports.*', 'employees.employeename')
            ->where('incoming_inspection_reports.id', '=', $id)->get();
        $selectCompany = DB::table('companies')->get();
        return view('adminside.inspectionReports.withtjf.incoming.inspection-details', [
            'selectIncomingReportInspection' => $selectIncomingReportInspection,
            'selectCompany'                  => $selectCompany,
        ]);
    }
    //
    public function withoutTjfInspectionIncomingEditPage($id)
    {
        $selectIncomingInspectionReportsss = DB::table('incoming_inspection_reports')
            ->join('employees', 'incoming_inspection_reports.inspectedby_id', '=', 'employees.id')
            ->select('incoming_inspection_reports.*', 'employees.employeename')
            ->where('incoming_inspection_reports.id', '=', $id)->get();
        if (count($selectIncomingInspectionReportsss) > 0) {
            $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
            // $companySelect = DB::table('companies')->get();
            return view('adminside.inspectionReports.withtjf.incoming.inspection-edit', [
                'selectEmployees'                     => $selectEmployees,
                'selectIncomingInspectionReportsss'   => $selectIncomingInspectionReportsss,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function updateWithoutTjfInspectionIncomingReport(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $selectWithTjfIncomingInspectionReportData = DB::table('incoming_inspection_reports')
                ->where('id', '=', $id)
                ->get();
            if (count($selectWithTjfIncomingInspectionReportData) > 0) {
                $createIncomingReports = DB::table('incoming_inspection_reports')
                    ->where('id', '=', $id)
                    ->update([
                        'scope_model'               => $incomingInsppectionFormData['scopeModel'],
                        'scope_incoming_date'       => $incomingInsppectionFormData['scopeIncomingDate'],
                        'scope_sr_number'           => $incomingInsppectionFormData['scopeSrNumber'],
                        'sender_name'               => $incomingInsppectionFormData['scopeSenderName'],
                        'scope_sending_with'        => $incomingInsppectionFormData['scopeReceivedWith'],
                        'scope_leakage'             => $incomingInsppectionFormData['scopeLeakage'],
                        'scope_view'                => $incomingInsppectionFormData['scopeView'],
                        'scope_lightguide'          => $incomingInsppectionFormData['scopeLightGuide'],
                        'scope_airwater'            => $incomingInsppectionFormData['scopeairwater'],
                        'scope_angulation'          => $incomingInsppectionFormData['scopeAngulation'],
                        'scope_lgtube'              => $incomingInsppectionFormData['scopeLgTube'],
                        'scope_insertiontube'       => $incomingInsppectionFormData['scopeInsertionTube'],
                        'scope_biopsychannel'       => $incomingInsppectionFormData['scopeBiopsyChannel'],
                        'scope_objectivelenz'       => $incomingInsppectionFormData['scopeObjectiveLenz'],
                        'scope_suction'             => $incomingInsppectionFormData['scopeSuction'],
                        'scope_angulation_lock'     => $incomingInsppectionFormData['scopeAngulationLock'],
                        'scope_freezing_buttons'    => $incomingInsppectionFormData['scopeFreezeButtons'],
                        'remarks'                   => $incomingInsppectionFormData['scopeRemarks'],
                        'inspectedby_id'            => $incomingInsppectionFormData['scopeInspectedBy'],
                        'company_id'                => $incomingInsppectionFormData['companyId'],
                        'created_at'                => NOW(),
                        'updated_at'                => NOW(),
                    ]);
                if ($createIncomingReports) {
                    return redirect()->back()->with('success_message', 'Inspection Report Is Updating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Inspection Report Is Updating Operation Is Un-successfully');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function removeWithoutTjfInspectionIncomingReport($id)
    {
        $selectWithoutTjfInspectionIncomingReport = DB::table('incoming_inspection_reports')
            ->where('id', '=', $id)
            ->get();
        if (count($selectWithoutTjfInspectionIncomingReport) > 0) {
            $removetWithoutTjfInspectionIncomingReport = DB::table('incoming_inspection_reports')
                ->where('id', '=', $id)
                ->delete();
            if ($removetWithoutTjfInspectionIncomingReport) {
                return redirect()->back()->with('success_message', 'Remoed Operation Is SuccessfullY');
            } else {
                return redirect()->back()->with('error_message', 'Remoed Operation Is UnsuccessfullY');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function withoutTjfInspectionOutgoingListPage()
    {
        $selectOutGoingInspectionReports = DB::table('outgoing_inspection_reports')->get();
        return view('adminside.inspectionReports.withtjf.outgoing.inspection-list', [
            'selectOutGoingInspectionReports' => $selectOutGoingInspectionReports,
        ]);
    }
    //
    public function withoutTjfInspectionOutgoingCreatingPage($id)
    {
        $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
        $incomingInsppectionFormDatas = DB::table('incoming_inspection_reports')
            ->join('employees', 'incoming_inspection_reports.inspectedby_id', '=', 'employees.id')
            ->select('incoming_inspection_reports.*', 'employees.employeename')
            ->where('incoming_inspection_reports.id', '=', $id)->get();
        if (count($incomingInsppectionFormDatas) > 0) {
            return view('adminside.inspectionReports.withtjf.outgoing.inspection-create', [
                'selectEmployees'               => $selectEmployees,
                'incomingInsppectionFormDatas'  => $incomingInsppectionFormDatas,
            ]);
        }
    }
    //
    public function withoutTjfInspectionOutgoingCreatingOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $selectIncomingReports = DB::table('outgoing_inspection_reports')->where('incoming_report_id', '=', $incomingInsppectionFormData['incomingInspectionId'])->get();
            if (count($selectIncomingReports) > 0) {
                return redirect()->back()->with('error_message', 'this data already availible');
            } else {
                $createIncomingReports = DB::table('outgoing_inspection_reports')
                    ->insertOrIgnore([
                        'incoming_report_id'        => $incomingInsppectionFormData['incomingInspectionId'],
                        'scope_model'               => $incomingInsppectionFormData['scopeModel'],
                        'scope_incoming_date'       => $incomingInsppectionFormData['scopeIncomingDate'],
                        'scope_sr_number'           => $incomingInsppectionFormData['scopeSrNumber'],
                        'sender_name'               => $incomingInsppectionFormData['scopeSenderName'],
                        'scope_sending_with'        => $incomingInsppectionFormData['scopeReceivedWith'],
                        'scope_leakage'             => $incomingInsppectionFormData['scopeLeakage'],
                        'scope_view'                => $incomingInsppectionFormData['scopeView'],
                        'scope_lightguide'          => $incomingInsppectionFormData['scopeLightGuide'],
                        'scope_airwater'            => $incomingInsppectionFormData['scopeairwater'],
                        'scope_angulation'          => $incomingInsppectionFormData['scopeAngulation'],
                        'scope_lgtube'              => $incomingInsppectionFormData['scopeLgTube'],
                        'scope_insertiontube'       => $incomingInsppectionFormData['scopeInsertionTube'],
                        'scope_biopsychannel'       => $incomingInsppectionFormData['scopeBiopsyChannel'],
                        'scope_objectivelenz'       => $incomingInsppectionFormData['scopeObjectiveLenz'],
                        'scope_suction'             => $incomingInsppectionFormData['scopeSuction'],
                        'scope_angulation_lock'     => $incomingInsppectionFormData['scopeAngulationLock'],
                        'scope_freezing_buttons'    => $incomingInsppectionFormData['scopeFreezeButtons'],
                        'remarks'                   => $incomingInsppectionFormData['scopeRemarks'],
                        'inspectedby_id'            => $incomingInsppectionFormData['scopeInspectedBy'],
                        'company_id'                => $incomingInsppectionFormData['companyId'],
                        'created_at'                => NOW(),
                        'updated_at'                => NOW(),
                    ]);
                if ($createIncomingReports) {
                    return redirect()->back()->with('success_message', 'Inspection Report Is Creating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Inspection Report Is Creating Operation Is Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function searchOutgoingGastroAndColonoScopeReport(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $selectOutGoingInspectionReports  = DB::table('outgoing_inspection_reports')
                    ->where('id', 'like', '%' . $query . '%')
                    ->orWhere('scope_model', 'like', '%' . $query . '%')
                    ->orWhere('scope_sr_number', 'like', '%' . $query . '%')
                    ->orWhere('scope_incoming_date', 'like', '%' . $query . '%')
                    ->orWhere('sender_name', 'like', '%' . $query . '%')
                    ->get();
            } else {
                $selectOutGoingInspectionReports  = DB::table('outgoing_inspection_reports')
                    ->get();
            }

            $total_row = $selectOutGoingInspectionReports->count();
            if ($total_row > 0) {
                // foreach ($selectOutGoingInspectionReports as $selectOutGoingInspectionReport) {
                //     $output .= '
                //     <tr>
                //     <th scope="row" style="width: 10%;text-align:center">' . $selectOutGoingInspectionReport->id . '</th>
                //     <td style="width: 15%;text-align:center">' . $selectOutGoingInspectionReport->scope_model . '</td>
                //     <td  style="width: 15%;text-align:center">
                //         ' . $selectOutGoingInspectionReport->scope_sr_number . '
                //     </td>
                //     <td  style="width: 10%;text-align:center">
                //         ' . $selectOutGoingInspectionReport->scope_incoming_date . ' 
                //     </td>
                //     <td  style="width: 30%;text-align:center">
                //         ' . $selectOutGoingInspectionReport->sender_name . '
                //     </td>
                //     <td  style="width: 20%;text-align:center">
                //     <div class="d-flex justify-content-center">
                //                         <div class="row">
                //                             <div class="col-12">
                //                                 <a href="#" class="action-icon dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>
                //                                 <div class="dropdown-menu dropdown-menu-right" style="">
                //                                   <a class="dropdown-item" href="/detailsPageOutgoingGastroAndColonoScope/' . $selectOutGoingInspectionReport->id . '"><i class="fas fa-user mx-2"></i> View Detail</a>
                //                                   <a class="dropdown-item" href="/editPageOutgoingGastroAndColonoScope/' . $selectOutGoingInspectionReport->id . '"><i class="fas fa-edit mx-2"></i> Edit</a>
                //                                   <a class="dropdown-item" href="/removeWithoutTjfInspectionOutgoingReport/' . $selectOutGoingInspectionReport->id . '"><i class="fas fa-trash mx-2"></i> Delete</a>
                //                                 </div>
                //                             </div>
                //                         </div>
                //                     </div>
                //     </td>
                //     </tr>
                //     ';
                // }
                foreach ($selectOutGoingInspectionReports as $selectOutGoingInspectionReport) {
                    $output .= '
                                <div class="col-sm-6 col-md-3 d-flex align-items-stretch flex-column px-2 py-2">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-body">
                                            <div class="row py-2">
                                                <div class="col-12" style="padding-left: 90%;">
                                                    <a href="#" class="action-icon dropdown-toggle text-black"
                                                        data-bs-toggle="dropdown" aria-expanded="false"></a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                                        <a class="dropdown-item"
                                                            href="/detailsPageOutgoingGastroAndColonoScope/' . $selectOutGoingInspectionReport->id . '"><i
                                                                class="fas fa-user mx-2"></i> View Detail</a>
                                                        <a class="dropdown-item"
                                                            href="/editPageOutgoingGastroAndColonoScope/' . $selectOutGoingInspectionReport->id . '"><i
                                                                class="fas fa-edit mx-2"></i> Edit</a>
                                                        <a class="dropdown-item"
                                                            href="/removeWithoutTjfInspectionOutgoingReport/' . $selectOutGoingInspectionReport->id . '"><i
                                                                class="fas fa-trash mx-2"></i> Delete</a>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <span
                                                        style="font-size: 15px;">' . $selectOutGoingInspectionReport->sender_name . '</span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-box"></i>
                                                        <span
                                                            mx-2>' . $selectOutGoingInspectionReport->scope_model . '</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-barcode"></i>
                                                        <span
                                                            mx-2>' . $selectOutGoingInspectionReport->scope_sr_number . '</span></span>
                                                    <br>
                                                    <span style="font-size: 12px;"><i class="mx-2 fas fa-calendar"></i>
                                                        <span
                                                            mx-2>' . $selectOutGoingInspectionReport->scope_incoming_date . ' </span></span>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                ';
                }
            } else {
                $output = '<span class="text-center">No Data Found</span>';
            }
            $selectOutGoingInspectionReports = array(
                'table_data'  => $output,
            );
            echo json_encode($selectOutGoingInspectionReports);
        }
    }
    //
    public function detailsPageOutgoingGastroAndColonoScope($id)
    {
        $selectIncomingReportInspection = DB::table('outgoing_inspection_reports')
            ->join('employees', 'outgoing_inspection_reports.inspectedby_id', '=', 'employees.id')
            ->select('outgoing_inspection_reports.*', 'employees.employeename')
            ->where('outgoing_inspection_reports.id', '=', $id)->get();
        $selectCompany = DB::table('companies')->get();
        return view('adminside.inspectionReports.withtjf.outgoing.inspection-details', [
            'selectIncomingReportInspection' => $selectIncomingReportInspection,
            'selectCompany'                  => $selectCompany,
        ]);
    }
    //
    public function withoutTjfInspectionOutgoingEditPage($id)
    {
        $selectIncomingInspectionReportsss = DB::table('outgoing_inspection_reports')
            ->join('employees', 'outgoing_inspection_reports.inspectedby_id', '=', 'employees.id')
            ->select('outgoing_inspection_reports.*', 'employees.employeename')
            ->where('outgoing_inspection_reports.id', '=', $id)->get();
        if (count($selectIncomingInspectionReportsss) > 0) {
            $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
            // $companySelect = DB::table('companies')->get();
            return view('adminside.inspectionReports.withtjf.outgoing.inspection-edit', [
                'selectEmployees'                     => $selectEmployees,
                'selectIncomingInspectionReportsss'   => $selectIncomingInspectionReportsss,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function updateWithoutTjfInspectionOutgoingReport(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $selectWithTjfIncomingInspectionReportData = DB::table('outgoing_inspection_reports')
                ->where('id', '=', $id)
                ->get();
            if (count($selectWithTjfIncomingInspectionReportData) > 0) {
                $createIncomingReports = DB::table('outgoing_inspection_reports')
                    ->where('id', '=', $id)
                    ->update([
                        'scope_model'               => $incomingInsppectionFormData['scopeModel'],
                        'scope_incoming_date'       => $incomingInsppectionFormData['scopeIncomingDate'],
                        'scope_sr_number'           => $incomingInsppectionFormData['scopeSrNumber'],
                        'sender_name'               => $incomingInsppectionFormData['scopeSenderName'],
                        'scope_sending_with'        => $incomingInsppectionFormData['scopeReceivedWith'],
                        'scope_leakage'             => $incomingInsppectionFormData['scopeLeakage'],
                        'scope_view'                => $incomingInsppectionFormData['scopeView'],
                        'scope_lightguide'          => $incomingInsppectionFormData['scopeLightGuide'],
                        'scope_airwater'            => $incomingInsppectionFormData['scopeairwater'],
                        'scope_angulation'          => $incomingInsppectionFormData['scopeAngulation'],
                        'scope_lgtube'              => $incomingInsppectionFormData['scopeLgTube'],
                        'scope_insertiontube'       => $incomingInsppectionFormData['scopeInsertionTube'],
                        'scope_biopsychannel'       => $incomingInsppectionFormData['scopeBiopsyChannel'],
                        'scope_objectivelenz'       => $incomingInsppectionFormData['scopeObjectiveLenz'],
                        'scope_suction'             => $incomingInsppectionFormData['scopeSuction'],
                        'scope_angulation_lock'     => $incomingInsppectionFormData['scopeAngulationLock'],
                        'scope_freezing_buttons'    => $incomingInsppectionFormData['scopeFreezeButtons'],
                        'remarks'                   => $incomingInsppectionFormData['scopeRemarks'],
                        'inspectedby_id'            => $incomingInsppectionFormData['scopeInspectedBy'],
                        'company_id'                => $incomingInsppectionFormData['companyId'],
                        'created_at'                => NOW(),
                        'updated_at'                => NOW(),
                    ]);
                if ($createIncomingReports) {
                    return redirect()->back()->with('success_message', 'Inspection Report Is Updating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Inspection Report Is Updating Operation Is Un-successfully');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function removeWithoutTjfInspectionOutgoingReport($id)
    {
        $selectWithoutTjfInspectionIncomingReport = DB::table('outgoing_inspection_reports')
            ->where('id', '=', $id)
            ->get();
        if (count($selectWithoutTjfInspectionIncomingReport) > 0) {
            $removetWithoutTjfInspectionIncomingReport = DB::table('outgoing_inspection_reports')
                ->where('id', '=', $id)
                ->delete();
            if ($removetWithoutTjfInspectionIncomingReport) {
                return redirect()->back()->with('success_message', 'Removed Operation Is SuccessfullY');
            } else {
                return redirect()->back()->with('error_message', 'Removed Operation Is UnsuccessfullY');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function TjfInspectionIncomingCreatingPage()
    {
        $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
        $companySelect = DB::table('companies')->get();

        return view('adminside.inspectionReports.tjf.incoming.inspection-create', [
            'selectEmployees' => $selectEmployees,
            'companySelect'   => $companySelect,
        ]);
    }
    //
    public function TjfInspectionIncomingCreateOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeElevatorChannel'       => 'required',
            'scopeElevatorWire'          => 'required',
            'scopeElevatorAxel'          => 'required',
            'scopeTipCover'              => 'required',
            'scopeElevatorClinder'       => 'required',
            'scopeElevatorLiver'         => 'required',
            'scopeRemarks'               => 'required|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $createIncomingReports = DB::table('incoming_inspection_reports')
                ->insertOrIgnore([
                    'scope_model'                => $incomingInsppectionFormData['scopeModel'],
                    'scope_incoming_date'        => $incomingInsppectionFormData['scopeIncomingDate'],
                    'scope_sr_number'            => $incomingInsppectionFormData['scopeSrNumber'],
                    'sender_name'                => $incomingInsppectionFormData['scopeSenderName'],
                    'scope_sending_with'         => $incomingInsppectionFormData['scopeReceivedWith'],
                    'scope_leakage'              => $incomingInsppectionFormData['scopeLeakage'],
                    'scope_view'                 => $incomingInsppectionFormData['scopeView'],
                    'scope_lightguide'           => $incomingInsppectionFormData['scopeLightGuide'],
                    'scope_airwater'             => $incomingInsppectionFormData['scopeairwater'],
                    'scope_angulation'           => $incomingInsppectionFormData['scopeAngulation'],
                    'scope_lgtube'               => $incomingInsppectionFormData['scopeLgTube'],
                    'scope_insertiontube'        => $incomingInsppectionFormData['scopeInsertionTube'],
                    'scope_biopsychannel'        => $incomingInsppectionFormData['scopeBiopsyChannel'],
                    'scope_objectivelenz'        => $incomingInsppectionFormData['scopeObjectiveLenz'],
                    'scope_suction'              => $incomingInsppectionFormData['scopeSuction'],
                    'scope_angulation_lock'      => $incomingInsppectionFormData['scopeAngulationLock'],
                    'scope_freezing_buttons'     => $incomingInsppectionFormData['scopeFreezeButtons'],
                    'scope_tjf_elevator_channel' => $incomingInsppectionFormData['scopeElevatorChannel'],
                    'scope_tjf_elevator_wire'    => $incomingInsppectionFormData['scopeElevatorWire'],
                    'scope_tjf_elevator_axel'    => $incomingInsppectionFormData['scopeElevatorAxel'],
                    'scope_tjf_tip_cover'        => $incomingInsppectionFormData['scopeTipCover'],
                    'scope_tjf_elevator_clinder' => $incomingInsppectionFormData['scopeElevatorClinder'],
                    'scope_tjf_liver'            => $incomingInsppectionFormData['scopeElevatorLiver'],
                    'remarks'                    => $incomingInsppectionFormData['scopeRemarks'],
                    'inspectedby_id'             => $incomingInsppectionFormData['scopeInspectedBy'],
                    'company_id'                 => $incomingInsppectionFormData['companyId'],
                    'created_at'                 => NOW(),
                    'updated_at'                 => NOW(),
                ]);
            if ($createIncomingReports) {
                return redirect()->back()->with('success_message', 'Inspection Report Is Creating Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Inspection Report Is Creating Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function TjfInspectionIncomingReport(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|min:15|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {

            // TJF scope edit operation
            $selectWithTjfIncomingInspectionReportData = DB::table('incoming_inspection_reports')
                ->where('id', '=', $id)
                ->get();
            if (count($selectWithTjfIncomingInspectionReportData) > 0) {
                $createIncomingReports = DB::table('incoming_inspection_reports')
                    ->where('id', '=', $id)
                    ->update([
                        'scope_model'                => $incomingInsppectionFormData['scopeModel'],
                        'scope_incoming_date'        => $incomingInsppectionFormData['scopeIncomingDate'],
                        'scope_sr_number'            => $incomingInsppectionFormData['scopeSrNumber'],
                        'sender_name'                => $incomingInsppectionFormData['scopeSenderName'],
                        'scope_sending_with'         => $incomingInsppectionFormData['scopeReceivedWith'],
                        'scope_leakage'              => $incomingInsppectionFormData['scopeLeakage'],
                        'scope_view'                 => $incomingInsppectionFormData['scopeView'],
                        'scope_lightguide'           => $incomingInsppectionFormData['scopeLightGuide'],
                        'scope_airwater'             => $incomingInsppectionFormData['scopeairwater'],
                        'scope_angulation'           => $incomingInsppectionFormData['scopeAngulation'],
                        'scope_lgtube'               => $incomingInsppectionFormData['scopeLgTube'],
                        'scope_insertiontube'        => $incomingInsppectionFormData['scopeInsertionTube'],
                        'scope_biopsychannel'        => $incomingInsppectionFormData['scopeBiopsyChannel'],
                        'scope_objectivelenz'        => $incomingInsppectionFormData['scopeObjectiveLenz'],
                        'scope_suction'              => $incomingInsppectionFormData['scopeSuction'],
                        'scope_angulation_lock'      => $incomingInsppectionFormData['scopeAngulationLock'],
                        'scope_freezing_buttons'     => $incomingInsppectionFormData['scopeFreezeButtons'],
                        'scope_tjf_elevator_channel' => $incomingInsppectionFormData['scopeElevatorChannel'],
                        'scope_tjf_elevator_wire'    => $incomingInsppectionFormData['scopeElevatorWire'],
                        'scope_tjf_elevator_axel'    => $incomingInsppectionFormData['scopeElevatorAxel'],
                        'scope_tjf_tip_cover'        => $incomingInsppectionFormData['scopeTipCover'],
                        'scope_tjf_elevator_clinder' => $incomingInsppectionFormData['scopeElevatorClinder'],
                        'scope_tjf_liver'            => $incomingInsppectionFormData['scopeElevatorLiver'],
                        'remarks'                    => $incomingInsppectionFormData['scopeRemarks'],
                        'inspectedby_id'             => $incomingInsppectionFormData['scopeInspectedBy'],
                        'company_id'                 => $incomingInsppectionFormData['companyId'],
                        'updated_at'                 => NOW(),
                    ]);
                if ($createIncomingReports) {
                    return redirect()->back()->with('success_message', 'Inspection Report Is Updating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Inspection Report Is Updating Operation Is Un-successfully');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function TjfInspectionOutgoingCreatingOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|min:15|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $createIncomingReports = DB::table('outgoing_inspection_reports')
                ->insertOrIgnore([
                    'incoming_report_id'         => $incomingInsppectionFormData['incomingInspectionId'],
                    'scope_model'                => $incomingInsppectionFormData['scopeModel'],
                    'scope_incoming_date'        => $incomingInsppectionFormData['scopeIncomingDate'],
                    'scope_sr_number'            => $incomingInsppectionFormData['scopeSrNumber'],
                    'sender_name'                => $incomingInsppectionFormData['scopeSenderName'],
                    'scope_sending_with'         => $incomingInsppectionFormData['scopeReceivedWith'],
                    'scope_leakage'              => $incomingInsppectionFormData['scopeLeakage'],
                    'scope_view'                 => $incomingInsppectionFormData['scopeView'],
                    'scope_lightguide'           => $incomingInsppectionFormData['scopeLightGuide'],
                    'scope_airwater'             => $incomingInsppectionFormData['scopeairwater'],
                    'scope_angulation'           => $incomingInsppectionFormData['scopeAngulation'],
                    'scope_lgtube'               => $incomingInsppectionFormData['scopeLgTube'],
                    'scope_insertiontube'        => $incomingInsppectionFormData['scopeInsertionTube'],
                    'scope_biopsychannel'        => $incomingInsppectionFormData['scopeBiopsyChannel'],
                    'scope_objectivelenz'        => $incomingInsppectionFormData['scopeObjectiveLenz'],
                    'scope_suction'              => $incomingInsppectionFormData['scopeSuction'],
                    'scope_angulation_lock'      => $incomingInsppectionFormData['scopeAngulationLock'],
                    'scope_freezing_buttons'     => $incomingInsppectionFormData['scopeFreezeButtons'],
                    'scope_tjf_elevator_channel' => $incomingInsppectionFormData['scopeElevatorChannel'],
                    'scope_tjf_elevator_wire'    => $incomingInsppectionFormData['scopeElevatorWire'],
                    'scope_tjf_elevator_axel'    => $incomingInsppectionFormData['scopeElevatorAxel'],
                    'scope_tjf_tip_cover'        => $incomingInsppectionFormData['scopeTipCover'],
                    'scope_tjf_elevator_clinder' => $incomingInsppectionFormData['scopeElevatorClinder'],
                    'scope_tjf_liver'            => $incomingInsppectionFormData['scopeElevatorLiver'],
                    'remarks'                    => $incomingInsppectionFormData['scopeRemarks'],
                    'inspectedby_id'             => $incomingInsppectionFormData['scopeInspectedBy'],
                    'company_id'                 => $incomingInsppectionFormData['companyId'],
                    'created_at'                 => NOW(),
                    'updated_at'                 => NOW(),
                ]);
            if ($createIncomingReports) {
                return redirect()->back()->with('success_message', 'Inspection Report Is Creating Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Inspection Report Is Creating Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function updateTjfInspectionOutgoingCreatingOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'scopeModel'                 => 'required|min:2|max:15',
            'scopeIncomingDate'          => 'required|date',
            'scopeSrNumber'              => 'required',
            'scopeSenderName'            => 'required|min:3|max:25',
            'scopeReceivedWith'          => 'required|max:10000',
            'scopeLeakage'               => 'required',
            'scopeView'                  => 'required',
            'scopeLightGuide'            => 'required',
            'scopeairwater'              => 'required',
            'scopeAngulation'            => 'required',
            'scopeLgTube'                => 'required',
            'scopeInsertionTube'         => 'required',
            'scopeBiopsyChannel'         => 'required',
            'scopeObjectiveLenz'         => 'required',
            'scopeSuction'               => 'required',
            'scopeAngulationLock'        => 'required',
            'scopeFreezeButtons'         => 'required',
            'scopeRemarks'               => 'required|min:15|max:10000',
            'scopeInspectedBy'           => 'required',
        ]);
        $incomingInsppectionFormData = $request->all();
        if ($validationChaker) {
            $selectWithTjfIncomingInspectionReportData = DB::table('outgoing_inspection_reports')
                ->where('id', '=', $id)
                ->get();
            if (count($selectWithTjfIncomingInspectionReportData) > 0) {
                $createIncomingReports = DB::table('outgoing_inspection_reports')
                    ->where('id', '=', $id)
                    ->update([
                        // 'incoming_report_id'         => $incomingInsppectionFormData['incomingInspectionId'],
                        'scope_model'                => $incomingInsppectionFormData['scopeModel'],
                        'scope_incoming_date'        => $incomingInsppectionFormData['scopeIncomingDate'],
                        'scope_sr_number'            => $incomingInsppectionFormData['scopeSrNumber'],
                        'sender_name'                => $incomingInsppectionFormData['scopeSenderName'],
                        'scope_sending_with'         => $incomingInsppectionFormData['scopeReceivedWith'],
                        'scope_leakage'              => $incomingInsppectionFormData['scopeLeakage'],
                        'scope_view'                 => $incomingInsppectionFormData['scopeView'],
                        'scope_lightguide'           => $incomingInsppectionFormData['scopeLightGuide'],
                        'scope_airwater'             => $incomingInsppectionFormData['scopeairwater'],
                        'scope_angulation'           => $incomingInsppectionFormData['scopeAngulation'],
                        'scope_lgtube'               => $incomingInsppectionFormData['scopeLgTube'],
                        'scope_insertiontube'        => $incomingInsppectionFormData['scopeInsertionTube'],
                        'scope_biopsychannel'        => $incomingInsppectionFormData['scopeBiopsyChannel'],
                        'scope_objectivelenz'        => $incomingInsppectionFormData['scopeObjectiveLenz'],
                        'scope_suction'              => $incomingInsppectionFormData['scopeSuction'],
                        'scope_angulation_lock'      => $incomingInsppectionFormData['scopeAngulationLock'],
                        'scope_freezing_buttons'     => $incomingInsppectionFormData['scopeFreezeButtons'],
                        'scope_tjf_elevator_channel' => $incomingInsppectionFormData['scopeElevatorChannel'],
                        'scope_tjf_elevator_wire'    => $incomingInsppectionFormData['scopeElevatorWire'],
                        'scope_tjf_elevator_axel'    => $incomingInsppectionFormData['scopeElevatorAxel'],
                        'scope_tjf_tip_cover'        => $incomingInsppectionFormData['scopeTipCover'],
                        'scope_tjf_elevator_clinder' => $incomingInsppectionFormData['scopeElevatorClinder'],
                        'scope_tjf_liver'            => $incomingInsppectionFormData['scopeElevatorLiver'],
                        'remarks'                    => $incomingInsppectionFormData['scopeRemarks'],
                        'inspectedby_id'             => $incomingInsppectionFormData['scopeInspectedBy'],
                        'company_id'                 => $incomingInsppectionFormData['companyId'],
                        'created_at'                 => NOW(),
                        'updated_at'                 => NOW(),
                    ]);
                if ($createIncomingReports) {
                    return redirect()->back()->with('success_message', 'Inspection Report Is Updating Operation Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Inspection Report Is Updating Operation Is Un-successfully');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function createIncomingAndOutGoingDailyRecordPages($id)
    {
        $incomingInsppectionFormDatas = DB::table('incoming_inspection_reports')
            ->where('id', '=', $id)->get();
        if (count($incomingInsppectionFormDatas) > 0) {
            return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordCreatingPage', [
                'incomingInsppectionFormDatas'  => $incomingInsppectionFormDatas,
            ]);
        }
    }
    //
    public function createOperationIncomingAndOutgoingDailyRecord(Request $request)
    {
        $validationChaker = $request->validate([
            'incoming_report_id'   => 'required',
            'scopeIncomingDate'    => 'required|date',
            'scopeModel'           => 'required',
            'scopeSrNumber'        => 'required|numeric',
            'scopeSenderName'      => 'required',
            'incomingSlipNumber'   => 'required',
        ]);
        $requirData = $request->all();
        if ($validationChaker) {
            $createIncomingAndOutgoingRecords = DB::table('incoming_and_outgoings')
                ->insertOrIgnore([
                    'incoming_report_ids'    => $requirData['incoming_report_id'],
                    'model'                  => $requirData['scopeModel'],
                    'item_sr_no'             => $requirData['scopeSrNumber'],
                    'incoming_date'          => $requirData['scopeIncomingDate'],
                    'sender_name'            => $requirData['scopeSenderName'],
                    'incoming_slip_number'   => $requirData['incomingSlipNumber'],
                    'created_at'             => NOW(),
                    'updated_at'             => NOW(),
                ]);
            if ($createIncomingAndOutgoingRecords) {
                return redirect()->back()->with('success_message', 'Incoming Daily Records Creation Operation in successfullY');
            } else {
                return redirect()->back()->with('error_message', 'Incoming Daily Records Creation Operation in Un-successfullY');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function incomingAndOutGoingDailyRecordList()
    {
        $selectIncomingAndOutgoingDailyRecord = DB::table('incoming_and_outgoings')
            ->get();
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecord-list', [
            'selectIncomingAndOutgoingDailyRecord' => $selectIncomingAndOutgoingDailyRecord,
        ]);
    }
    //
    public function incomingAndOutGoingDailyRecordEditPage($id)
    {
        $selectincomingAndOutGoingDaily = DB::table('incoming_and_outgoings')
            ->where('id', '=', $id)
            ->get();
        if (count($selectincomingAndOutGoingDaily) > 0) {
            return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordEditPage', [
                'selectincomingAndOutGoingDaily'  => $selectincomingAndOutGoingDaily,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    //
    public function editOperationIncomingAndOutgoingDailyRecord(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'incoming_report_id'   => 'required',
            'scopeIncomingDate'    => 'required|date',
            'scopeModel'           => 'required',
            'scopeSrNumber'        => 'required|numeric',
            'scopeSenderName'      => 'required',
            'incomingSlipNumber'   => 'required',
            'outgoingDate'         => 'required|date',
            'outgoingSlipNumber'   => 'required',
        ]);
        $requirData = $request->all();
        if ($validationChaker) {
            $selectIncomingAndOutgoingRecords = DB::table('incoming_and_outgoings')
                ->where('id', '=', $id)
                ->get();
            if (count($selectIncomingAndOutgoingRecords) > 0) {
                // if ( $requirData['incomingSlipNumber'] == $requirData['outgoingSlipNumber'] ) {
                //     return redirect()->back()->with('error_message','Incomiing Slip Number And Outgoing Slip Number Are Same');
                // } else {
                $createIncomingAndOutgoingRecords = DB::table('incoming_and_outgoings')
                    ->where('id', '=', $id)
                    ->update([
                        // 'incoming_report_ids'       => $requirData['incoming_report_id'],
                        'model'                     => $requirData['scopeModel'],
                        'item_sr_no'                => $requirData['scopeSrNumber'],
                        'incoming_date'             => $requirData['scopeIncomingDate'],
                        'sender_name'               => $requirData['scopeSenderName'],
                        'incoming_slip_number'      => $requirData['incomingSlipNumber'],
                        'outgoing_date'             => $requirData['outgoingDate'],
                        'outgoing_slip_number'      => $requirData['outgoingSlipNumber'],
                        'updated_at'                => NOW(),
                    ]);
                if ($createIncomingAndOutgoingRecords) {
                    return redirect()->back()->with('success_message', 'Incoming Daily Records Updated Operation in SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'Incoming Daily Records Updated Operation in Un-successfullY');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function searchDataaa(Request $request)
    {
        $validationChaker = $request->validate([
            'searchOutGoingInspectionReport' => 'required',
        ]);
        $searchData = $request->all();
        if ($validationChaker) {
            $selectIncomingAndOutgoingDailyRecord = DB::table('incoming_and_outgoings')
                ->where('sender_name', 'like', '%' . $searchData['searchOutGoingInspectionReport'] . '%')
                ->orWhere('incoming_slip_number', 'like', '%' . $searchData['searchOutGoingInspectionReport'] . '%')
                ->orWhere('outgoing_slip_number', 'like', '%' . $searchData['searchOutGoingInspectionReport'] . '%')
                ->orWhere('incoming_date', 'like', '%' . $searchData['searchOutGoingInspectionReport'] . '%')
                ->orWhere('outgoing_date', 'like', '%' . $searchData['searchOutGoingInspectionReport'] . '%')
                ->get();
            if (count($selectIncomingAndOutgoingDailyRecord) > 0) {
                return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecord-list', [
                    'selectIncomingAndOutgoingDailyRecord' => $selectIncomingAndOutgoingDailyRecord,
                ]);
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function removeScopeDailyInomingAndOutgoingRecord($id)
    {
        $selectIncomingAndOutgoingRecords = DB::table('incoming_and_outgoings')
            ->where('id', '=', $id)
            ->get();
        if (count($selectIncomingAndOutgoingRecords) > 0) {
            $removeIncomingAndOutgoingRecords = DB::table('incoming_and_outgoings')
                ->where('id', '=', $id)
                ->delete();
            if ($removeIncomingAndOutgoingRecords) {
                return redirect()->back()->with('success_message', 'Record Removed Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Record Removed Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not data founded');
        }
    }
    // 
    public function createRepairingQuotationPage()
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->get();
        return view('adminside.quotations.quotationRepairingCreatingPage', [
            'selectClient' => $selectClient,
            'selectStock' => $selectStock,
        ]);
    }
    // 
    public function createQuotationRepairingOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('quotation_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this quotation number is al-ready availible');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'quotation_number'              => $data['quotationNumber'],
                            'client_id'                     => $data['quotationClient'],
                            'quotation_date'                => $data['quotationDate'],
                            //   'quotation_heading'             => $data['quotationHeading'],
                            'quotation_item_srNumber'       => $quotationItemSrNumber,
                            'quotation_item_decription'     => $quotationItemDescription,
                            'quotation_total_price'         => $quotationItemAmount,
                            'quotation_termAndConditions'   => $quotationTermAndConditions,
                            'created_at'                    => NOW(),
                            'updated_at'                    => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'quotation_number'              => $data['quotationNumber'],
                            'client_id'                     => $data['quotationClient'],
                            'quotation_date'                => $data['quotationDate'],
                            //   'quotation_heading'             => $data['quotationHeading'],
                            'quotation_item_srNumber'       => $quotationItemSrNumber,
                            'quotation_item_decription'     => $quotationItemDescription,
                            'quotation_total_price'         => $quotationItemAmount,
                            'quotation_gsttext'             => $data['quotationGstText'],
                            'quotation_termAndConditions'   => $quotationTermAndConditions,
                            'created_at'                    => NOW(),
                            'updated_at'                    => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createDisposibleQuotationPage()
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->whereNotNull('item_batchNo')->get();
        return view('adminside.quotations.quotationDisposibleCreatingPage', [
            'selectClient' => $selectClient,
            'selectStock'  => $selectStock,
        ]);
    }
    // 
    public function createQuotationDisposibleOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
        ]);
        $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('quotation_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this quotation number is al-ready availible');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
                $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
                $quotationItemQtv                = json_encode($data['quotationItemQtv']);
                $quotationItemPrice              = json_encode($data['quotationItemPrice']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'quotation_number'                       => $data['quotationNumber'],
                            'client_id'                              => $data['quotationClient'],
                            'quotation_date'                         => $data['quotationDate'],
                            //   'quotation_heading'                      => $data['quotationHeading'],
                            'quotation_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'quotation_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'quotation_item_disposible_expDate'      => $quotationItemExpireDate,
                            'quotation_item_disposible_qtv'          => $quotationItemQtv,
                            'quotation_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'quotation_total_price'                  => $quotationItemAmount,
                            'quotation_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'quotation_number'                       => $data['quotationNumber'],
                            'client_id'                              => $data['quotationClient'],
                            'quotation_date'                         => $data['quotationDate'],
                            //   'quotation_heading'                      => $data['quotationHeading'],
                            'quotation_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'quotation_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'quotation_item_disposible_expDate'      => $quotationItemExpireDate,
                            'quotation_item_disposible_qtv'          => $quotationItemQtv,
                            'quotation_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'quotation_total_price'                  => $quotationItemAmount,
                            'quotation_gsttext'                      => $data['quotationGstText'],
                            'quotation_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function quotationListPage()
    {
        $selectQuotations = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_name')
            ->get();
        return view('adminside.quotations.quotation-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function searchQuotations(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchQuotations'])) {
            $selectQuotations = DB::table('quotations')
                ->join('clients', 'quotations.client_id', '=', 'clients.id')
                ->select('quotations.*', 'clients.client_name')
                ->where('quotations.id', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('quotations.quotation_date', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('quotations.quotation_number', 'like', '%' . $query['searchQuotations'] . '%')
                ->get();
        } else {
            if ($query['searchstartingDate'] == $query['searchendingDate']) {
                return redirect()->back()->with('error_message', 'End ANd Starting Date Is Same');
            } else {
                $selectQuotations = DB::table('quotations')
                    ->join('clients', 'quotations.client_id', '=', 'clients.id')
                    ->select('quotations.*', 'clients.client_name')
                    ->whereBetween('quotation_date', [$query['searchstartingDate'], $query['searchendingDate']])
                    ->get();
            }
        }
        return view('adminside.quotations.quotation-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function editPageQuotation($id)
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_name')
            ->where('quotations.id', '=', $id)->get();
        if ($selectQuotation) {
            return view('adminside.quotations.quotation_editPage', [
                'selectClient' => $selectClient,
                'selectQuotation' => $selectQuotation,
                'selectStock'      => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function editQuotationDisposibleOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required|min:1|max:50',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
                $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
                $quotationItemQtv                = json_encode($data['quotationItemQtv']);
                $quotationItemPrice              = json_encode($data['quotationItemPrice']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'quotation_number'                       => $data['quotationNumber'],
                            //   'client_id'                              => $data['quotationClient'],
                            'quotation_date'                         => $data['quotationDate'],
                            //   'quotation_heading'                      => $data['quotationHeading'],
                            'quotation_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'quotation_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'quotation_item_disposible_expDate'      => $quotationItemExpireDate,
                            'quotation_item_disposible_qtv'          => $quotationItemQtv,
                            'quotation_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'quotation_total_price'                  => $quotationItemAmount,
                            'quotation_termAndConditions'            => $quotationTermAndConditions,
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'quotation_number'                       => $data['quotationNumber'],
                            //   'client_id'                              => $data['quotationClient'],
                            'quotation_date'                         => $data['quotationDate'],
                            //   'quotation_heading'                      => $data['quotationHeading'],
                            'quotation_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'quotation_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'quotation_item_disposible_expDate'      => $quotationItemExpireDate,
                            'quotation_item_disposible_qtv'          => $quotationItemQtv,
                            'quotation_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'quotation_total_price'                  => $quotationItemAmount,
                            'quotation_gsttext'                      => $data['quotationGstText'],
                            'quotation_termAndConditions'            => $quotationTermAndConditions,
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function editQuotationRepairingOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            //  'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'quotation_number'              => $data['quotationNumber'],
                            //    'client_id'                     => $data['quotationClient'],
                            'quotation_date'                => $data['quotationDate'],
                            //    'quotation_heading'             => $data['quotationHeading'],
                            'quotation_item_srNumber'       => $quotationItemSrNumber,
                            'quotation_item_decription'     => $quotationItemDescription,
                            'quotation_total_price'         => $quotationItemAmount,
                            'quotation_termAndConditions'   => $quotationTermAndConditions,
                            'created_at'                    => NOW(),
                            'updated_at'                    => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'quotation_number'              => $data['quotationNumber'],
                            //    'client_id'                     => $data['quotationClient'],
                            'quotation_date'                => $data['quotationDate'],
                            //    'quotation_heading'             => $data['quotationHeading'],
                            'quotation_item_srNumber'       => $quotationItemSrNumber,
                            'quotation_item_decription'     => $quotationItemDescription,
                            'quotation_total_price'         => $quotationItemAmount,
                            'quotation_gsttext'             => $data['quotationGstText'],
                            'quotation_termAndConditions'   => $quotationTermAndConditions,
                            'created_at'                    => NOW(),
                            'updated_at'                    => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation Updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation Updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function detailQuotationPage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_organizationname', 'clients.client_address')
            ->where('quotations.id', '=', $id)
            ->get();
        // $selectQuotation = DB::table('quotations')->sum('quotation_total_price');
        if ($selectQuotation) {
            return view('adminside.quotations.quotationDetailPage', [
                'selectQuotation' => $selectQuotation,
                'selectCompanies' => $selectCompanies,
                'selectStock'     => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeQuotationPage($id)
    {
        $selectQuotation = DB::table('quotations')
            ->where('quotations.id', '=', $id)->get();
        if ($selectQuotation) {
            $removeQuotation = DB::table('quotations')
                ->where('quotations.id', '=', $id)->delete();
            if ($removeQuotation) {
                return redirect()->back()->with('success_message', 'Quotation Removed Operation is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Quotation Removed Operation is in-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'not data founded');
        }
    }
    // 
    public function searchQuotationsWithOut(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchQuotations'])) {
            $selectQuotations = DB::table('quotations')
                ->join('clients', 'quotations.client_id', '=', 'clients.id')
                ->select('quotations.*', 'clients.client_name')
                ->where('quotations.id', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('quotations.quotation_date', 'like', '%' . $query['searchQuotations'] . '%')
                ->orWhere('quotations.quotation_number', 'like', '%' . $query['searchQuotations'] . '%')
                ->get();
        } else {
            if ($query['searchstartingDate'] == $query['searchendingDate']) {
                return redirect()->back()->with('error_message', 'End ANd Starting Date Is Same');
            } else {
                $selectQuotations = DB::table('quotations')
                    ->join('clients', 'quotations.client_id', '=', 'clients.id')
                    ->select('quotations.*', 'clients.client_name')
                    ->whereBetween('quotation_date', [$query['searchstartingDate'], $query['searchendingDate']])
                    ->get();
            }
        }
        return view('adminside.quotations.withoutLogoquotation-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    //
    public function quotationListWithOutLogoPage()
    {
        $selectQuotations = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_name')
            ->get();
        return view('adminside.quotations.withoutLogoquotation-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function detailWithOutLogoQuotationPage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_organizationname', 'clients.client_address')
            ->where('quotations.id', '=', $id)->get();
        // $selectQuotation = DB::table('quotations')->sum('quotation_total_price');
        if ($selectQuotation) {
            return view('adminside.quotations.quotationWithOutDetailPage', [
                'selectQuotation' => $selectQuotation,
                'selectCompanies' => $selectCompanies,
                'selectStock'     => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function createInvoicePage($id)
    {
        $selectClient = DB::table('clients')->get();
        $selectQuotation = DB::table('quotations')
            ->join('clients', 'quotations.client_id', '=', 'clients.id')
            ->select('quotations.*', 'clients.client_name')
            ->where('quotations.id', '=', $id)->get();
        $selectStock = DB::table('stock_records')->get();
        if ($selectQuotation) {
            return view('adminside.invoices.invoiceCreationPage', [
                'selectClient' => $selectClient,
                'selectQuotation' => $selectQuotation,
                'selectStock'  => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function createRepairingInvoicePage()
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->get();
        return view('adminside.invoices.invoiceRepairingCreatingPage', [
            'selectClient' => $selectClient,
            'selectStock' => $selectStock,
        ]);
    }
    // 
    public function createDisposibleInvoicePage()
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->whereNotNull('item_batchNo')->get();
        return view('adminside.invoices.invoiceDisposibleCreatingPage', [
            'selectClient' => $selectClient,
            'selectStock'  => $selectStock,
        ]);
    }
    // 
    public function createInvoiceDisposibleOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required|min:1|max:50',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
                $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
                $quotationItemQtv                = json_encode($data['quotationItemQtv']);
                $quotationItemPrice              = json_encode($data['quotationItemPrice']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                           => $data['quotationId'],
                            'invoice_client_id'                      => $data['quotationClient'],
                            'invoice_number'                         => $data['quotationNumber'],
                            'invoice_date'                           => $data['quotationDate'],
                            //   'invoice_heading'                        => $data['quotationHeading'],
                            'invoice_item_srNumber'                  => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'        => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'        => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'            => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit'   => $quotationItemPrice,
                            'invoice_total_price'                    => $quotationItemAmount,
                            'invoice_termAndConditions'              => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                           => $data['quotationId'],
                            'invoice_client_id'                      => $data['quotationClient'],
                            'invoice_number'                         => $data['quotationNumber'],
                            'invoice_date'                           => $data['quotationDate'],
                            //   'invoice_heading'                        => $data['quotationHeading'],
                            'invoice_item_srNumber'                  => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'        => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'        => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'            => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit'   => $quotationItemPrice,
                            'invoice_total_price'                    => $quotationItemAmount,
                            'invoice_gsttext'                        => $data['quotationGstText'],
                            'invoice_termAndConditions'              => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function createInvoiceDisposibleOperations(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required|min:1|max:50',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
                $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
                $quotationItemQtv                = json_encode($data['quotationItemQtv']);
                $quotationItemPrice              = json_encode($data['quotationItemPrice']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            //   'quotation_id'                           => $data['quotationId'],
                            'invoice_client_id'                      => $data['quotationClient'],
                            'invoice_number'                         => $data['quotationNumber'],
                            'invoice_date'                           => $data['quotationDate'],
                            //   'invoice_heading'                        => $data['quotationHeading'],
                            'invoice_item_srNumber'                  => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'        => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'        => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'            => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit'   => $quotationItemPrice,
                            'invoice_total_price'                    => $quotationItemAmount,
                            'invoice_termAndConditions'              => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            //   'quotation_id'                           => $data['quotationId'],
                            'invoice_client_id'                      => $data['quotationClient'],
                            'invoice_number'                         => $data['quotationNumber'],
                            'invoice_date'                           => $data['quotationDate'],
                            //   'invoice_heading'                        => $data['quotationHeading'],
                            'invoice_item_srNumber'                  => $quotationItemSrNumber,
                            'item_id'                                => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'        => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'        => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'            => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit'   => $quotationItemPrice,
                            'invoice_total_price'                    => $quotationItemAmount,
                            'invoice_gsttext'                        => $data['quotationGstText'],
                            'invoice_termAndConditions'              => $quotationTermAndConditions,
                            'created_at'                             => NOW(),
                            'updated_at'                             => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function createInvoiceRepairingOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                         => $data['quotationId'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //   'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                         => $data['quotationId'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //   'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_gsttext'                      => $data['quotationGstText'],
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createInvoiceRepairingOperations(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            //   'quotation_id'                         => $data['quotationId'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //   'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            //   'quotation_id'                         => $data['quotationId'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //   'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_gsttext'                      => $data['quotationGstText'],
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function invoiceListPage()
    {
        $selectQuotations = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->select('invoices.*', 'clients.client_name')
            ->get();
        return view('adminside.invoices.invoice-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function invoiceListWithOutLogoPage()
    {
        $selectQuotations = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->select('invoices.*', 'clients.client_name')
            ->get();
        return view('adminside.invoices.withoutLogoinvoice-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function searchInvoices(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchInvoice'])) {
            $selectQuotations = DB::table('invoices')
                ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
                ->select('invoices.*', 'clients.client_name')
                ->where('invoices.id', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('invoices.invoice_date', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('invoices.invoice_number', 'like', '%' . $query['searchInvoice'] . '%')
                ->get();
        } else {
            $selectQuotations = DB::table('invoices')
                ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
                ->select('invoices.*', 'clients.client_name')
                ->whereBetween('invoice_date', [$query['searchstartingDate'], $query['searchendingDate']])
                ->get();
        }
        return view('adminside.invoices.invoice-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function searchInvoicess(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchInvoice'])) {
            $selectQuotations = DB::table('invoices')
                ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
                ->select('invoices.*', 'clients.client_name')
                ->where('invoices.id', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('invoices.invoice_date', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('invoices.invoice_number', 'like', '%' . $query['searchInvoice'] . '%')
                ->get();
        } else {
            $selectQuotations = DB::table('invoices')
                ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
                ->select('invoices.*', 'clients.client_name')
                ->whereBetween('invoice_date', [$query['searchstartingDate'], $query['searchendingDate']])
                ->get();
        }
        return view('adminside.invoices.withoutLogoinvoice-list', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function editPageInvoice($id)
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->select('invoices.*', 'clients.client_name')
            ->where('invoices.id', '=', $id)->get();
        if ($selectQuotation) {
            return view('adminside.invoices.invoice_editPage', [
                'selectClient' => $selectClient,
                'selectQuotation' => $selectQuotation,
                'selectStock'  => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function editInvoiceDisposibleOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            //  'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required|min:1|max:50',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
                $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
                $quotationItemQtv                = json_encode($data['quotationItemQtv']);
                $quotationItemPrice              = json_encode($data['quotationItemPrice']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            //    'quotation_id'                         => $data['quotationId'],
                            //    'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //    'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                              => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'      => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'          => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            //    'quotation_id'                         => $data['quotationId'],
                            //    'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_date'                         => $data['quotationDate'],
                            //    'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'item_id'                              => $quotationItemDescription,
                            'invoice_item_disposible_batchNo'      => $quotationItemBatchNumber,
                            'invoice_item_disposible_expDate'      => $quotationItemExpireDate,
                            'invoice_item_disposible_qtv'          => $quotationItemQtv,
                            'invoice_item_disposible_pricePerUnit' => $quotationItemPrice,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_gsttext'                      => $data['quotationGstText'],
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function editInvoiceRepairingOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            //   'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemDescription        = json_encode($data['quotationItemDescription']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            // 'quotation_id'                         => $data['quotationId'],
                            // 'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_date'                         => $data['quotationDate'],
                            // 'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            // 'quotation_id'                         => $data['quotationId'],
                            // 'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_number'                       => $data['quotationNumber'],
                            'invoice_client_id'                    => $data['quotationClient'],
                            'invoice_date'                         => $data['quotationDate'],
                            // 'invoice_heading'                      => $data['quotationHeading'],
                            'invoice_item_srNumber'                => $quotationItemSrNumber,
                            'invoice_item_decription'              => $quotationItemDescription,
                            'invoice_total_price'                  => $quotationItemAmount,
                            'invoice_gsttext'                      => $data['quotationGstText'],
                            'invoice_termAndConditions'            => $quotationTermAndConditions,
                            'created_at'                           => NOW(),
                            'updated_at'                           => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoices Updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoices Updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function detailInvoicePage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->leftJoin('quotations', 'invoices.quotation_id', '=', "quotations.id")
            ->select('clients.client_organizationname', 'clients.client_address', 'invoices.*', 'quotations.quotation_date', 'quotations.quotation_date')
            // ->select('invoices.*','clients.client_organizationname','clients.client_address')
            ->where('invoices.id', '=', $id)->get();
        // $selectQuotation = DB::table('quotations')->sum('quotation_total_price');
        if ($selectQuotation) {
            return view('adminside.invoices.invoiceDetailPage', [
                'selectQuotation' => $selectQuotation,
                'selectCompanies' => $selectCompanies,
                'selectStock'     => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function detailWithOutLogoInvoicePage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectQuotation = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->leftJoin('quotations', 'invoices.quotation_id', '=', "quotations.id")
            ->select('clients.client_organizationname', 'clients.client_address', 'invoices.*', 'quotations.quotation_date', 'quotations.quotation_date')
            ->where('invoices.id', '=', $id)->get();
        // $selectQuotation = DB::table('quotations')->sum('quotation_total_price');
        if ($selectQuotation) {
            return view('adminside.invoices.invoiceWithOutDetailPage', [
                'selectQuotation' => $selectQuotation,
                'selectCompanies' => $selectCompanies,
                'selectStock'     => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeInvoicePage($id)
    {
        $selectQuotation = DB::table('invoices')
            ->where('invoices.id', '=', $id)->get();
        if ($selectQuotation) {
            $removeQuotation = DB::table('invoices')
                ->where('invoices.id', '=', $id)->delete();
            if ($removeQuotation) {
                return redirect()->back()->with('success_message', 'Invoice Removed Operation is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Invoice Removed Operation is in-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'not data founded');
        }
    }
    // 
    public function createDeliveryChallanPage($id)
    {
        $selectClient = DB::table('clients')->get();
        $selectInvoice = DB::table('invoices')
            ->join('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->select('invoices.*', 'clients.client_name')
            ->where('invoices.id', '=', $id)
            ->get();
        $selectStock = DB::table('stock_records')->get();
        if ($selectInvoice) {
            return view('adminside.deliveryChallan.deliveryChallanCreatingPage', [
                'selectClient' => $selectClient,
                'selectInvoice' => $selectInvoice,
                'selectStock'  => $selectStock,
            ]);
        }
    }
    // 
    public function createDeliveryChallanOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'deliveryChallanPoNumber'               => 'required',
            'deliveryChallanClient'                 => 'required',
            'DeliveryDate'                          => 'required|date',
            // 'deliveryChallanHeading'                => 'required|min:5|max:500',
            'deliveryChallanItemSrNumber'           => 'required',
            'deliveryChallanItemDescription'        => 'required|min:1|max:500',
            'deliveryChallanItemQtv'                => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('deliever_challans')
                ->where('delivery_challan_po_no', '=', $data['deliveryChallanPoNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this purchase order number is al-ready availible');
            } else {

                // ======================  =========================
                $deliveryChallanItemSrNumber           = json_encode($data['deliveryChallanItemSrNumber']);
                $deliveryChallanItemDescription        = json_encode($data['deliveryChallanItemDescription']);
                $deliveryChallanItemQtv                = json_encode($data['deliveryChallanItemQtv']);
                // ======================  =========================
                $createQuotaion = DB::table('deliever_challans')
                    ->insertOrIgnore([
                        'delivery_challan_po_no'             => $data['deliveryChallanPoNumber'],
                        'invoice_id'                         => $data['invoiceId'],
                        'invoice_client_id'                  => $data['deliveryChallanClient'],
                        'delivery_challan_date'              => $data['DeliveryDate'],
                        //   'delivery_challan'                   => $data['deliveryChallanHeading'],
                        'delivery_challan_item_srNumber'     => $deliveryChallanItemSrNumber,
                        'item_id'                            => $deliveryChallanItemDescription,
                        'delivery_challan_item_qtv'          => $deliveryChallanItemQtv,
                        'created_at'                         => NOW(),
                        'updated_at'                         => NOW(),
                    ]);
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Delivery Challan creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Delivery Challan creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createDeliveryChallanOperations(Request $request)
    {
        $validationChaker = $request->validate([
            'deliveryChallanPoNumber'               => 'required',
            'deliveryChallanClient'                 => 'required',
            'DeliveryDate'                          => 'required|date',
            // 'deliveryChallanHeading'                => 'required|min:5|max:500',
            'deliveryChallanItemSrNumber'           => 'required',
            'deliveryChallanItemDescription'        => 'required|min:1|max:500',
            'deliveryChallanItemQtv'                => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('deliever_challans')
                ->where('delivery_challan_po_no', '=', $data['deliveryChallanPoNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this purchase order number is al-ready availible');
            } else {

                // ======================  =========================
                $deliveryChallanItemSrNumber           = json_encode($data['deliveryChallanItemSrNumber']);
                $deliveryChallanItemDescription        = json_encode($data['deliveryChallanItemDescription']);
                $deliveryChallanItemQtv                = json_encode($data['deliveryChallanItemQtv']);
                // ======================  =========================
                $createQuotaion = DB::table('deliever_challans')
                    ->insertOrIgnore([
                        'delivery_challan_po_no'             => $data['deliveryChallanPoNumber'],
                        'invoice_id'                         => $data['invoiceId'],
                        'invoice_client_id'                  => $data['deliveryChallanClient'],
                        'delivery_challan_date'              => $data['DeliveryDate'],
                        //   'delivery_challan'                   => $data['deliveryChallanHeading'],
                        'delivery_challan_item_srNumber'     => $deliveryChallanItemSrNumber,
                        'item_id'                            => $deliveryChallanItemDescription,
                        'delivery_challan_item_qtv'          => $deliveryChallanItemQtv,
                        'created_at'                         => NOW(),
                        'updated_at'                         => NOW(),
                    ]);
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Delivery Challan creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Delivery Challan creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function deliveryChallanListPage()
    {
        $selectQuotations = DB::table('deliever_challans')
            ->join('clients', 'deliever_challans.invoice_client_id', '=', 'clients.id')
            ->select('deliever_challans.*', 'clients.client_name')
            ->paginate(10);
        return view('adminside.deliveryChallan.deliveryChallanlist', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function searchDeliveryChallan(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchInvoice'])) {
            $selectQuotations = DB::table('deliever_challans')
                ->join('clients', 'deliever_challans.invoice_client_id', '=', 'clients.id')
                ->select('deliever_challans.*', 'clients.client_name')
                ->where('deliever_challans.id', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('deliever_challans.delivery_challan_po_no', 'like', '%' . $query['searchInvoice'] . '%')
                ->orWhere('deliever_challans.delivery_challan_date', 'like', '%' . $query['searchInvoice'] . '%')
                ->paginate(10);
        } else {
            $selectQuotations = DB::table('deliever_challans')
                ->join('clients', 'deliever_challans.invoice_client_id', '=', 'clients.id')
                ->select('deliever_challans.*', 'clients.client_name')
                ->whereBetween('delivery_challan_date', [$query['searchstartingDate'], $query['searchendingDate']])
                ->paginate(10);
        }
        return view('adminside.deliveryChallan.deliveryChallanlist', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    //
    public function editPageDeliveryChallan($id)
    {
        $selectClient = DB::table('clients')->get();
        $selectStock = DB::table('stock_records')->get();
        $selectInvoice = DB::table('deliever_challans')
            ->join('clients', 'deliever_challans.invoice_client_id', '=', 'clients.id')
            // ->join('stock_records','deliever_challans.invoice_client_id','=','stock_records.id')
            ->select('deliever_challans.*', 'clients.client_name')
            ->where('deliever_challans.id', '=', $id)
            ->get();
        if ($selectInvoice) {
            return view('adminside.deliveryChallan.deliveryChallan_editPage', [
                'selectClient'     => $selectClient,
                'selectInvoice'    => $selectInvoice,
                'selectStock'  => $selectStock,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function editDeliveryChallanOperation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'deliveryChallanPoNumber'               => 'required',
            'DeliveryDate'                          => 'required|date',
            'deliveryChallanHeading'                => 'required|min:5|max:500',
            'deliveryChallanItemSrNumber'           => 'required',
            'deliveryChallanItemDescription'        => 'required|min:1|max:500',
            'deliveryChallanItemQtv'                => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('deliever_challans')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {

                // ======================  =========================
                $deliveryChallanItemSrNumber           = json_encode($data['deliveryChallanItemSrNumber']);
                $deliveryChallanItemDescription        = json_encode($data['deliveryChallanItemDescription']);
                $deliveryChallanItemQtv                = json_encode($data['deliveryChallanItemQtv']);
                // ======================  =========================
                $createQuotaion = DB::table('deliever_challans')->where('id', '=', $id)
                    ->update([
                        'delivery_challan_po_no'             => $data['deliveryChallanPoNumber'],
                        //   'invoice_id'                         => $data['invoiceId'],
                        'invoice_client_id'                  => $data['deliveryChallanClient'],
                        'delivery_challan_date'              => $data['DeliveryDate'],
                        'delivery_challan'                   => $data['deliveryChallanHeading'],
                        'delivery_challan_item_srNumber'     => $deliveryChallanItemSrNumber,
                        'item_id'                            => $deliveryChallanItemDescription,
                        'delivery_challan_item_qtv'          => $deliveryChallanItemQtv,
                        'updated_at'                         => NOW(),
                    ]);
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Delivery Challan updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Delivery Challan updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function detailDeleiveryChallanPage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectQuotation = DB::table('deliever_challans')
            ->join('clients', 'deliever_challans.invoice_client_id', '=', 'clients.id')
            ->select('deliever_challans.*', 'clients.client_address', 'clients.client_organizationname')
            ->where('deliever_challans.id', '=', $id)
            ->get();
        if ($selectQuotation) {
            return view('adminside.deliveryChallan.deliveryChallanDetailPage', [
                'selectQuotation' => $selectQuotation,
                'selectCompanies' => $selectCompanies,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeOperationDeliveryChallan($id)
    {
        $selectQuotation = DB::table('deliever_challans')
            ->where('id', '=', $id)
            ->get();
        if ($selectQuotation) {
            $removeQuotation = DB::table('deliever_challans')
                ->where('id', '=', $id)
                ->delete();
            if ($removeQuotation) {
                return redirect()->back()->with('success_message', 'deleivery challan removed operation is successfully');
            } else {
                return redirect()->back()->with('error_message', 'deleivery challan removed operation is un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function createServiceReportPage()
    {
        $selectClient = DB::table('clients')->get();
        return view('adminside.serviceReport.serviceReportCreatingPage', [
            'selectClient' => $selectClient,
        ]);
    }
    // 
    public function createServiceReportOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'deliveryChallanClient'               => 'required',
            'DeliveryDate'                        => 'required',
            'serviceReportequimentName'           => 'required',
            'serviceReportequimentModel'          => 'required',
            'serviceReportequimentSrNo'           => 'required',
            'serviceReportSrNumber'               => 'required',
            'serviceReportQuestion'               => 'required',
            'serviceReportanswer'                 => 'required',
            'serviceReportequimentComments'       => 'required',
            'serviceReportcheckerName'            => 'required',
            'serviceReportcheckerDate'            => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('service_reports')
                ->where('equiment_model', '=', $data['serviceReportequimentModel'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this equiment model is al-ready availible');
            } else {

                // ======================  =========================
                $serviceReportSrNumber               = json_encode($data['serviceReportSrNumber']);
                $serviceReportQuestion               = json_encode($data['serviceReportQuestion']);
                $serviceReportanswer                 = json_encode($data['serviceReportanswer']);
                // ======================  =========================
                $createQuotaion = DB::table('service_reports')
                    ->insertOrIgnore([
                        'invoice_client_id'                  => $data['deliveryChallanClient'],
                        'service_date'                       => $data['DeliveryDate'],
                        'equiment_name'                      => $data['serviceReportequimentName'],
                        'equiment_model'                     => $data['serviceReportequimentModel'],
                        'equiment_srNo'                      => $data['serviceReportequimentSrNo'],
                        'service_report_item_srNumber'       => $serviceReportSrNumber,
                        'service_report_item_question'       => $serviceReportQuestion,
                        'service_report_item_answer'         => $serviceReportanswer,
                        'service_report_anycomment'          => $data['serviceReportequimentComments'],
                        'service_report_name'                => $data['serviceReportcheckerName'],
                        'service_report_date'                => $data['serviceReportcheckerDate'],
                        'created_at'                         => NOW(),
                        'updated_at'                         => NOW(),
                    ]);
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Service Report creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Service Report creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function serviceReportListPage()
    {
        $selectQuotations = DB::table('service_reports')
            ->join('clients', 'service_reports.invoice_client_id', '=', 'clients.id')
            ->select('service_reports.*', 'clients.client_name')
            ->paginate(10);
        return view('adminside.serviceReport.serviceReportlist', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    // 
    public function searchServiceReport(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchServiceReportData'])) {
            $selectQuotations = DB::table('service_reports')
                ->join('clients', 'service_reports.invoice_client_id', '=', 'clients.id')
                ->select('service_reports.*', 'clients.client_name')
                ->where('service_reports.id', 'like', '%' . $query['searchServiceReportData'] . '%')
                ->orWhere('clients.client_name', 'like', '%' . $query['searchServiceReportData'] . '%')
                ->orWhere('service_reports.equiment_name', 'like', '%' . $query['searchServiceReportData'] . '%')
                ->orWhere('service_reports.service_date', 'like', '%' . $query['searchServiceReportData'] . '%')
                ->paginate(10);
        } else {
            $selectQuotations = DB::table('service_reports')
                ->join('clients', 'service_reports.invoice_client_id', '=', 'clients.id')
                ->select('service_reports.*', 'clients.client_name')
                ->whereBetween('service_date', [$query['searchstartingDate'], $query['searchendingDate']])
                ->paginate(10);
        }
        return view('adminside.serviceReport.serviceReportlist', [
            'selectQuotations' => $selectQuotations,
        ]);
    }
    //
    public function detailServiceReportPage($id)
    {
        $selectQuotation = DB::table('service_reports')
            ->join('clients', 'service_reports.invoice_client_id', '=', 'clients.id')
            ->select('service_reports.*', 'clients.client_address', 'clients.client_organizationname')
            ->where('service_reports.id', '=', $id)
            ->get();
        if ($selectQuotation) {
            return view('adminside.serviceReport.serviceReportDetailPage', [
                'selectQuotation' => $selectQuotation,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeServiceReport($id)
    {
        $selectQuotation = DB::table('service_reports')
            ->where('service_reports.id', '=', $id)
            ->get();
        if ($selectQuotation) {
            $removeQuotation = DB::table('service_reports')
                ->where('service_reports.id', '=', $id)->delete();
            if ($removeQuotation) {
                return redirect()->back()->with('success_message', 'remove operation is successfully');
            } else {
                return redirect()->back()->with('error_message', 'remove operation is un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function createRepairingDataSS()
    {
        $selectClient = DB::table('clients')->get();
        return view('adminside.quotations.quotationRepairCreatingPage', [
            'selectClient' => $selectClient,
        ]);
    }
    // 
    public function createQuotationRepairing_Operations(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('quotation_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this quotation number is al-ready availible');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
                $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
                $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationItemProblem            = json_encode($data['quotationItemProblem']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'client_id'                    => $data['quotationClient'],
                            'quotation_number'             => $data['quotationNumber'],
                            'quotation_date'               => $data['quotationDate'],
                            //   'quotation_heading'            => $data['quotationHeading'],
                            'quotation_item_srNumber'      => $quotationItemSrNumber,
                            'quotation_scope_model'        => $quotationItemScopeModel,
                            'quotation_scope_srno'         => $quotationItemScopeSrNumber,
                            'quotation_scope_problem'      => $quotationItemProblem,
                            'quotation_need_work'          => $quotationItemNeedWork,
                            'quotation_total_price'        => $quotationItemAmount,
                            'quotation_termAndConditions'  => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->insertOrIgnore([
                            'client_id'                    => $data['quotationClient'],
                            'quotation_number'             => $data['quotationNumber'],
                            'quotation_date'               => $data['quotationDate'],
                            // 'quotation_heading'            => $data['quotationHeading'],
                            'quotation_item_srNumber'      => $quotationItemSrNumber,
                            'quotation_scope_model'        => $quotationItemScopeModel,
                            'quotation_scope_srno'         => $quotationItemScopeSrNumber,
                            'quotation_scope_problem'      => $quotationItemProblem,
                            'quotation_need_work'          => $quotationItemNeedWork,
                            'quotation_total_price'        => $quotationItemAmount,
                            'quotation_gsttext'            => $data['quotationGstText'],
                            'quotation_termAndConditions'  => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function updateQuotationRepairing_Operations(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('quotations')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
                $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
                $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationItemProblem            = json_encode($data['quotationItemProblem']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'client_id'                    => $data['quotationClient'],
                            'quotation_number'             => $data['quotationNumber'],
                            'quotation_date'               => $data['quotationDate'],
                            //   'quotation_heading'            => $data['quotationHeading'],
                            'quotation_item_srNumber'      => $quotationItemSrNumber,
                            'quotation_scope_model'        => $quotationItemScopeModel,
                            'quotation_scope_srno'         => $quotationItemScopeSrNumber,
                            'quotation_scope_problem'      => $quotationItemProblem,
                            'quotation_need_work'          => $quotationItemNeedWork,
                            'quotation_total_price'        => $quotationItemAmount,
                            'quotation_termAndConditions'  => $quotationTermAndConditions,
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('quotations')
                        ->where('id', '=', $id)
                        ->update([
                            'client_id'                    => $data['quotationClient'],
                            'quotation_number'             => $data['quotationNumber'],
                            'quotation_date'               => $data['quotationDate'],
                            // 'quotation_heading'            => $data['quotationHeading'],
                            'quotation_item_srNumber'      => $quotationItemSrNumber,
                            'quotation_scope_model'        => $quotationItemScopeModel,
                            'quotation_scope_srno'         => $quotationItemScopeSrNumber,
                            'quotation_scope_problem'      => $quotationItemProblem,
                            'quotation_need_work'          => $quotationItemNeedWork,
                            'quotation_total_price'        => $quotationItemAmount,
                            'quotation_gsttext'            => $data['quotationGstText'],
                            'quotation_termAndConditions'  => $quotationTermAndConditions,
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Quotation updated operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Quotation updated operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createInvoiceRepairing_Operations(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            // 'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
                $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
                $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationItemProblem            = json_encode($data['quotationItemProblem']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'invoice_client_id'            => $data['quotationClient'],
                            'invoice_number'             => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            //   'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,

                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'invoice_client_id'            => $data['quotationClient'],
                            'invoice_number'             => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            //   'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,
                            'invoice_gsttext'              => $data['quotationGstText'],
                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createInvoiceRepairing_Operation(Request $request)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('invoice_number', '=', $data['quotationNumber'])
                ->get();
            if (count($selectQuotation) > 0) {
                return redirect()->back()->with('error_message', 'this invoice number is al-ready availible');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
                $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
                $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                $quotationItemProblem            = json_encode($data['quotationItemProblem']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                 => $data['quotationId'],
                            'invoice_client_id'            => $data['quotationClient'],
                            'invoice_number'               => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,

                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->insertOrIgnore([
                            'quotation_id'                   => $data['quotationId'],
                            'invoice_client_id'              => $data['quotationClient'],
                            'invoice_number'               => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,
                            'invoice_gsttext'              => $data['quotationGstText'],
                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createRepairingDataSSInvoice()
    {
        $selectClient = DB::table('clients')->get();
        return view('adminside.invoices.invoiceRepairCreatingPage', [
            'selectClient' => $selectClient,
        ]);
    }
    // 
    public function updateInvoiceRepairing_Operation(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'quotationNumber'               => 'required',
            'quotationClient'               => 'required',
            'quotationDate'                 => 'required|date',
            // 'quotationHeading'              => 'required|min:5|max:500',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            // 'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'quotationTermAndConditions'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            $selectQuotation = DB::table('invoices')
                ->where('id', '=', $id)
                ->get();
            if (count($selectQuotation) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {

                // ======================  =========================
                $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
                $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
                $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
                $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
                $quotationItemAmount             = json_encode($data['quotationItemAmount']);
                // $quotationItemProblem            = json_encode($data['quotationItemProblem']);
                $quotationTermAndConditions      = json_encode($data['quotationTermAndConditions']);
                // ======================  =========================
                if (empty($data['quotationGstText'])) {
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            //   'quotation_id'                 => $data['quotationId'],
                            'invoice_client_id'            => $data['quotationClient'],
                            'invoice_number'               => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            // 'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,
                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================  
                } else {
                    // ======================  =========================
                    $createQuotaion = DB::table('invoices')
                        ->where('id', '=', $id)
                        ->update([
                            // 'quotation_id'                   => $data['quotationId'],
                            'invoice_client_id'              => $data['quotationClient'],
                            'invoice_number'               => $data['quotationNumber'],
                            'invoice_date'                 => $data['quotationDate'],
                            //   'invoice_heading'              => $data['quotationHeading'],
                            'invoice_item_srNumber'        => $quotationItemSrNumber,
                            'invoice_scope_model'          => $quotationItemScopeModel,
                            'invoice_scope_srno'           => $quotationItemScopeSrNumber,
                            // 'invoice_scope_problem'        => $quotationItemProblem,
                            'invoice_need_work'            => $quotationItemNeedWork,
                            'invoice_total_price'          => $quotationItemAmount,
                            'invoice_gsttext'              => $data['quotationGstText'],
                            'invoice_termAndConditions'    => $quotationTermAndConditions,
                            'created_at'                   => NOW(),
                            'updated_at'                   => NOW(),
                        ]);
                    // ======================  =========================
                }
                // ======================  =========================
                if ($createQuotaion) {
                    return redirect()->back()->with('success_message', 'Invoice update operation is successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Invoice update operation is un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createIncomingAndOutgoingDisposibleDailyRecord()
    {
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDisposibleCreatingPage');
    }
    // 
    public function createOperationIncomingAndOutgoingDisposibleDailyRecord(Request $request)
    {
        $validationChaker = $request->validate([
            'senderName'                      => 'required',
            'scopeIncomingDate'               => 'required',
            'descriptionItem'                 => 'required',
            'incomingSlipNumber'              => 'required',
            'itemBatchNumber'                 => 'required',
            'itemExpireDate'                  => 'required',
            'itemQty'                         => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $createNewItems = DB::table('incoming_and_outgoing_disposibles')
                ->insertOrIgnore([
                    'item_incomingDate'       => $data['scopeIncomingDate'],
                    'item_sendername'         => $data['senderName'],
                    'incoming_type'           => $data['incomingSlipNumber'],
                    'incoming_description'    => $data['descriptionItem'],
                    'item_disposible_batchNo' => $data['itemBatchNumber'],
                    'item_disposible_expDate' => $data['itemExpireDate'],
                    'item_disposible_qtv'     => $data['itemQty'],
                    'created_at'              => NOW(),
                    'updated_at'              => NOW(),
                ]);
            if ($createNewItems) {
                return redirect()->back()->with('success_message', 'New Records Is Created Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'New Records Is Created Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createIncomingAndOutgoingDataDailyRecord()
    {
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDataCreatingPage');
    }
    // 
    public function createOperationIncomingAndOutgoingDataDailyRecord(Request $request)
    {
        $validationChaker = $request->validate([
            'senderName'                      => 'required',
            'scopeIncomingDate'               => 'required',
            'descriptionItem'                 => 'required',
            'incomingSlipNumber'              => 'required',
            'itemModel'                       => 'required',
            'itemSrNo'                        => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $createNewItems = DB::table('incoming_and_outgoing_disposibles')
                ->insertOrIgnore([
                    'item_incomingDate'       => $data['scopeIncomingDate'],
                    'item_sendername'         => $data['senderName'],
                    'incoming_type'           => $data['incomingSlipNumber'],
                    'incoming_description'    => $data['descriptionItem'],
                    'item_model'              => $data['itemModel'],
                    'item_srno'               => $data['itemSrNo'],
                    'created_at'              => NOW(),
                    'updated_at'              => NOW(),
                ]);
            if ($createNewItems) {
                return redirect()->back()->with('success_message', 'New Records Is Created Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'New Records Is Created Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function IncomingAndOutgoingDataDailyRecordList()
    {
        $selectIncomingAndOutgoingDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->get();
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyOtherRecord-list', [
            'selectIncomingAndOutgoingDailyRecord' => $selectIncomingAndOutgoingDailyRecord,
        ]);
    }
    // 
    public function searchOperationIncomingAndOutgoingDataDailyRecord(Request $request)
    {
        $query = $request->all();
        $selectIncomingAndOutgoingDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->where('item_incomingDate', 'like', '%' . $query['searchDailyRecord'] . '%')
            ->OrWhere('item_sendername', 'like', '%' . $query['searchDailyRecord'] . '%')
            ->OrWhere('incoming_type', 'like', '%' . $query['searchDailyRecord'] . '%')
            ->OrWhere('item_outgoing_date', 'like', '%' . $query['searchDailyRecord'] . '%')
            ->OrWhere('outgoing_type', 'like', '%' . $query['searchDailyRecord'] . '%')
            ->get();
        if ($selectIncomingAndOutgoingDailyRecord) {
            return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyOtherRecord-list', [
                'selectIncomingAndOutgoingDailyRecord' => $selectIncomingAndOutgoingDailyRecord,
            ]);
        }
    }
    // 
    public function editIncomingAndOutgoingDataDailyRecordPage($id)
    {
        $selectIncomingAndOutgoingDataDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->where('id', '=', $id)->get();
        if (count($selectIncomingAndOutgoingDataDailyRecord) > 0) {
            return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDataEditPage', [
                'selectIncomingAndOutgoingDataDailyRecord' => $selectIncomingAndOutgoingDataDailyRecord,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function updateOperationIncomingAndOutgoingDisposibleDailyRecord(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'senderName'                      => 'required',
            'scopeIncomingDate'               => 'required',
            'descriptionItem'                 => 'required',
            'incomingSlipNumber'              => 'required',
            'itemBatchNumber'                 => 'required',
            'itemExpireDate'                  => 'required',
            'itemQty'                         => 'required',
            'itemOutgoingSlipNumber'          => 'required',
            'itemOutgoingDate'                => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectRecord = DB::table('incoming_and_outgoing_disposibles')->where('id', '=', $id)->get();
            if (count($selectRecord) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                $createNewItems = DB::table('incoming_and_outgoing_disposibles')
                    ->where('id', '=', $id)
                    ->update([
                        'item_incomingDate'       => $data['scopeIncomingDate'],
                        'item_sendername'         => $data['senderName'],
                        'incoming_type'           => $data['incomingSlipNumber'],
                        'incoming_description'    => $data['descriptionItem'],
                        'item_disposible_batchNo' => $data['itemBatchNumber'],
                        'item_disposible_expDate' => $data['itemExpireDate'],
                        'item_disposible_qtv'     => $data['itemQty'],
                        'outgoing_type'           => $data['itemOutgoingSlipNumber'],
                        'item_outgoing_date'      => $data['itemOutgoingDate'],
                        'created_at'              => NOW(),
                        'updated_at'              => NOW(),
                    ]);
                if ($createNewItems) {
                    return redirect()->back()->with('success_message', 'Records Is Updated Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Records Is Updated Is Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function updateOperationIncomingAndOutgoingDataDailyRecord(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'senderName'                      => 'required',
            'scopeIncomingDate'               => 'required',
            'descriptionItem'                 => 'required',
            'incomingSlipNumber'              => 'required',
            'itemModel'                       => 'required',
            'itemSrNo'                        => 'required',
            'itemOutgoingSlipNumber'          => 'required',
            'itemOutgoingDate'                => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectRecord = DB::table('incoming_and_outgoing_disposibles')->where('id', '=', $id)->get();
            if (count($selectRecord) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                $createNewItems = DB::table('incoming_and_outgoing_disposibles')
                    ->where('id', '=', $id)
                    ->update([
                        'item_incomingDate'       => $data['scopeIncomingDate'],
                        'item_sendername'         => $data['senderName'],
                        'incoming_type'           => $data['incomingSlipNumber'],
                        'incoming_description'    => $data['descriptionItem'],
                        'item_model'              => $data['itemModel'],
                        'item_srno'               => $data['itemSrNo'],
                        'outgoing_type'           => $data['itemOutgoingSlipNumber'],
                        'item_outgoing_date'      => $data['itemOutgoingDate'],
                        'created_at'              => NOW(),
                        'updated_at'              => NOW(),
                    ]);
                if ($createNewItems) {
                    return redirect()->back()->with('success_message', 'Records Is Updated Is Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Records Is Updated Is Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function detailIncomingAndOutgoingDataDailyRecordPage($id)
    {
        $selectIncomingAndOutgoingDataDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->where('id', '=', $id)->get();
        if (count($selectIncomingAndOutgoingDataDailyRecord) > 0) {
            return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDataDetailPage', [
                'selectIncomingAndOutgoingDataDailyRecord' => $selectIncomingAndOutgoingDataDailyRecord,
            ]);
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function removeOperationIncomingAndOutgoingDataDailyRecord($id)
    {
        $selectIncomingAndOutgoingDataDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->where('id', '=', $id)->get();
        if (count($selectIncomingAndOutgoingDataDailyRecord) > 0) {
            $removeIncomingAndOutgoingDataDailyRecord = DB::table('incoming_and_outgoing_disposibles')
                ->where('id', '=', $id)->delete();
            if ($removeIncomingAndOutgoingDataDailyRecord) {
                return redirect()->back()->with('success_message', 'Record Remove Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Record Remove Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function getStockData()
    {
        // Fetch data from the Stock model or any other relevant model
        $selectStock = stock_record::whereNotNull('item_batchNo')->get();

        // Return the data as JSON response
        return response()->json($selectStock);
    }
    // 
    public function getStocksData()
    {
        // Fetch data from the Stock model or any other relevant model
        $selectStock = stock_record::get();
        //  $selectStock = stock_record::whereNotNull('item_scope_model')->orWhereNotNull('item_model')->get();

        // Return the data as JSON response
        return response()->json($selectStock);
    }
    // 
    public function createClientAccountHistoryPage($id)
    {
        $selectInvoices = DB::table('invoices')->where('id', '=', $id)->get();
        $selectStock = DB::table('stock_records')->get();
        return view('adminside.client.client-createAccountHistory', [
            'selectInvoices' => $selectInvoices,
            'selectStock'    => $selectStock,
        ]);
    }
    //                    
    public function createAccountHistoryRepairing_Operation(Request $request)
    {
        $validationChaker = $request->validate([
            'clientId'                      => 'required',
            'invoiceId'                     => 'required',
            'invoiceDate'                   => 'required',
            'clientNotes'                   => 'required',
            'clientPayementType'            => 'required',
            'totalAmount'                   => 'required',
            'previousAmount'                => 'required',
            'quotationItemSrNumber'         => 'required',
            'quotationItemScopeModel'       => 'required',
            'quotationItemScopeSrNumber'    => 'required',
            'quotationItemNeedWork'         => 'required',
            // 'quotationItemProblem'          => 'required',
            'quotationItemAmount'           => 'required',
            'gstText'                       => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            // ====================== Array to json =========================
            $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
            $quotationItemScopeSrNumber      = json_encode($data['quotationItemScopeSrNumber']);
            $quotationItemScopeModel         = json_encode($data['quotationItemScopeModel']);
            $quotationItemNeedWork           = json_encode($data['quotationItemNeedWork']);
            $quotationItemAmount             = json_encode($data['quotationItemAmount']);
            // $quotationItemProblem            = json_encode($data['quotationItemProblem']);
            // ====================== Array to json =========================
            // Calculate total amount
            $totalAmounts = $data['totalAmount'] + $data['gstText'];
            // $totalPre = 0;
            // if ($data['clientPayementType'] == '0') {
            //     $totalAmount = $data['totalAmount'] + $data['gstText'];
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // } else {
            //     $totalAmount = 0;
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // }
            // echo "<pre>";
            // print_r($pData);
            // echo "</pre>";
            // die();
            $createQuotaion = DB::table('client_account_historys')
                ->insertOrIgnore([
                    'account_name'                => $data['clientId'],
                    'invoice_id'                  => $data['invoiceId'],
                    'invoice_date'                => $data['invoiceDate'],
                    'invoice_item_srNumber'       => $quotationItemSrNumber,
                    'invoice_scope_model'         => $quotationItemScopeModel,
                    'invoice_scope_srno'          => $quotationItemScopeSrNumber,
                    // 'invoice_scope_problem'       => $quotationItemProblem,
                    'invoice_need_work'           => $quotationItemNeedWork,
                    'invoice_total_price'         => $quotationItemAmount,
                    'invoice_grant_total_amount'  => $totalAmounts,
                    'payment_type'                => $data['clientPayementType'],
                    'Notes'                       => $data['clientNotes'],
                    'Previous_amount'             => $data['previousAmount'],
                    'created_at'                  => NOW(),
                    'updated_at'                  => NOW(),
                ]);
            // ======================  =========================
            if ($createQuotaion) {
                return redirect()->back()->with('success_message', 'New Records creation operation is successfully');
            } else {
                return redirect()->back()->with('error_message', 'New Records creation operation is un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function createAccountHistorySystemOperation(Request $request)
    {
        $validationChaker = $request->validate([
            'clientId'                      => 'required',
            'invoiceId'                     => 'required',
            'invoiceDate'                   => 'required',
            'clientNotes'                   => 'required',
            'clientPayementType'            => 'required',
            'totalAmount'                   => 'required',
            'previousAmount'                => 'required',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            // 'gstTax'                        => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            // ======================  =========================
            $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
            $quotationItemDescription        = json_encode($data['quotationItemDescription']);
            $quotationItemAmount             = json_encode($data['quotationItemAmount']);
            // ======================  =========================
            $totalAmounts = $data['totalAmount'] + $data['gstText'];
            // $totalPre = 0;
            // if ($data['clientPayementType'] == '0') {
            //     $totalAmount = $data['totalAmount'] + $data['gstText'];
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // } else {
            //     $totalAmount = 0;
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // }
            $createQuotaion = DB::table('client_account_historys')
                ->insertOrIgnore([
                    'account_name'                => $data['clientId'],
                    'invoice_id'                  => $data['invoiceId'],
                    'invoice_date'                => $data['invoiceDate'],
                    'invoice_item_srNumber'       => $quotationItemSrNumber,
                    'invoice_item_decription'     => $quotationItemDescription,
                    'invoice_total_price'         => $quotationItemAmount,
                    'invoice_grant_total_amount'  => $totalAmounts,
                    'payment_type'                => $data['clientPayementType'],
                    'Notes'                       => $data['clientNotes'],
                    'previous_amount'             => $data['previousAmount'],
                    'created_at'                  => NOW(),
                    'updated_at'                  => NOW(),
                ]);
            // ======================  =========================
            if ($createQuotaion) {
                return redirect()->back()->with('success_message', 'Invoice creation operation is successfully');
            } else {
                return redirect()->back()->with('error_message', 'Invoice creation operation is un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createAccountHistoryDisposibleOperations(Request $request)
    {
        $validationChaker = $request->validate([
            'clientId'                      => 'required',
            'invoiceId'                     => 'required',
            'invoiceDate'                   => 'required',
            'clientNotes'                   => 'required',
            'clientPayementType'            => 'required',
            'totalAmount'                   => 'required',
            'quotationItemSrNumber'         => 'required',
            'quotationItemDescription'      => 'required',
            'quotationItemAmount'           => 'required',
            'quotationItemBatchNumber'      => 'required',
            'quotationItemExpireDate'       => 'required',
            'quotationItemQtv'              => 'required',
            'quotationItemPrice'            => 'required',
            // 'gstTax'                        => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker != null) {
            // ======================  =========================
            $quotationItemSrNumber           = json_encode($data['quotationItemSrNumber']);
            $quotationItemDescription        = json_encode($data['quotationItemDescription']);
            $quotationItemAmount             = json_encode($data['quotationItemAmount']);
            $quotationItemBatchNumber        = json_encode($data['quotationItemBatchNumber']);
            $quotationItemExpireDate         = json_encode($data['quotationItemExpireDate']);
            $quotationItemQtv                = json_encode($data['quotationItemQtv']);
            $quotationItemPrice              = json_encode($data['quotationItemPrice']);
            // ======================  =========================
            $totalAmounts = $data['totalAmount'] + $data['gstText'];
            // $totalPre = 0;
            // if ($data['clientPayementType'] == '0') {
            //     $totalAmount = $data['totalAmount'] + $data['gstText'];
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // } else {
            //     $totalAmount = 0;
            //     $preV_amount = $data['previousAmount'];
            //     $totalPre = $preV_amount + $totalAmount;
            // }

            $createQuotaion = DB::table('client_account_historys')
                ->insertOrIgnore([
                    'account_name'                          => $data['clientId'],
                    'invoice_id'                            => $data['invoiceId'],
                    'invoice_date'                          => $data['invoiceDate'],
                    'invoice_item_srNumber'                 => $quotationItemSrNumber,
                    'item_id'                               => $quotationItemDescription,
                    'invoice_item_disposible_batchNo'       => $quotationItemBatchNumber,
                    'invoice_item_disposible_expDate'       => $quotationItemExpireDate,
                    'invoice_item_disposible_qtv'           => $quotationItemQtv,
                    'invoice_item_disposible_pricePerUnit'  => $quotationItemPrice,
                    'invoice_total_price'                   => $quotationItemAmount,
                    'invoice_grant_total_amount'            => $totalAmounts,
                    'payment_type'                          => $data['clientPayementType'],
                    'Notes'                                 => $data['clientNotes'],
                    'previous_amount'                       => $data['previousAmount'],
                    'created_at'                            => NOW(),
                    'updated_at'                            => NOW(),
                ]);
            // ======================  =========================
            if ($createQuotaion) {
                return redirect()->back()->with('success_message', 'New Record creation operation is successfully');
            } else {
                return redirect()->back()->with('error_message', 'New Record creation operation is un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function viewClientAccountDetailsPage($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $selectClientAccountDetails = DB::table('client_account_historys')
            ->leftJoin('invoices', 'client_account_historys.invoice_id', '=', 'invoices.id')
            ->leftJoin('clients', 'client_account_historys.account_name', '=', 'clients.id')
            ->select('client_account_historys.*', 'clients.client_name', 'invoices.invoice_number', 'invoices.invoice_gsttext')
            ->where('client_account_historys.account_name', '=', $id)->get();
        return view('adminside.client.clientAccountDetailPage', [
            'selectCompanies' => $selectCompanies,
            'selectClientAccountDetails' => $selectClientAccountDetails,
        ]);
    }
    // 
    public function partListPage()
    {
        $selectParts = DB::table('stock_records')->get();
        return view('adminside.stocks.parts-list', [
            'selectParts'  => $selectParts,
        ]);
    }
    // 
    public function disposibleItemsListPage()
    {
        $selectParts = DB::table('stock_records')->get();
        return view('adminside.stocks.disposible-items-list', [
            'selectParts'  => $selectParts,
        ]);
    }
    // 
    public function createStockScopesPartsPage()
    {
        return view('adminside.stocks.parts-create');
    }
    // 
    public function createStockScopesParts(Request $request)
    {
        $validationChaker = $request->validate([
            'itemDescription'  => 'required',
            'itemQuantity'     => 'required',
            // 'itemSizes'        => 'required',
            'itemIncomingDate' => 'required',
            'itemCompanyPartName' => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            if (empty($data['itemSizes'])) {
                $createPartsStocks = DB::table('stock_records')
                    ->insertOrIgnore([
                        'item_incomingdate'  => $data['itemIncomingDate'],
                        'item_name'          => $data['itemDescription'],
                        'item_qtv'           => $data['itemQuantity'],
                        'part_companyname'   => $data['itemCompanyPartName'],
                        'created_at'         => NOW(),
                        'updated_at'         => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                }
            } else {
                $createPartsStocks = DB::table('stock_records')
                    ->insertOrIgnore([
                        'item_incomingdate'  => $data['itemIncomingDate'],
                        'item_name'          => $data['itemDescription'],
                        'item_qtv'           => $data['itemQuantity'],
                        'size'               => $data['itemSizes'],
                        'part_companyname'   => $data['itemCompanyPartName'],
                        'ratePerUnit'         => $data['itemPricePerUnit'],
                        'totalAmount'         => $data['itemTotalPrice'],
                        'created_at'         => NOW(),
                        'updated_at'         => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createStockScopesPage($id)
    {
        $selectInspectionReport = DB::table('incoming_inspection_reports')->where('id', '=', $id)->get();
        return view('adminside.stocks.scopesStock-create', [
            'selectInspectionReport' => $selectInspectionReport,
        ]);
    }
    // 
    public function createStockScopes(Request $request)
    {
        $validationChaker = $request->validate([
            'itemDetails'       => 'required',
            // 'inspectionId'     => 'required',
            'itemQuantity'      => 'required',
            'itemSerialNo'      => 'required',
            'itemModel'         => 'required',
            'itemIncomingDate'  => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
            'scopeCompanyName'  => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('item_srno', '=', $data['itemSerialNo'])->get();
            if (count($selectScopes) > 0) {
                return redirect()->back()->with('error_message', 'This Serial Number Is Al-ready Availible');
            } else {
                $createPartsStocks = DB::table('stock_records')
                    ->insertOrIgnore([
                        'incoming_report_ids' => $data['inspectionId'],
                        'item_incomingdate'   => $data['itemIncomingDate'],
                        'item_name'           => $data['itemDetails'],
                        'item_srno'           => $data['itemSerialNo'],
                        'item_companyname'    => $data['scopeCompanyName'],
                        'item_qtv'            => $data['itemQuantity'],
                        'item_scope_model'    => $data['itemModel'],
                        'ratePerUnit'         => $data['itemPricePerUnit'],
                        'totalAmount'         => $data['itemTotalPrice'],
                        'created_at'          => NOW(),
                        'updated_at'          => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createStockOtherPage()
    {
        return view('adminside.stocks.otherStock-create');
    }
    // 
    public function createStockOther(Request $request)
    {
        $validationChaker = $request->validate([
            'itemDetails'      => 'required',
            // 'inspectionId'     => 'required',
            'itemQuantity'     => 'required',
            'itemSerialNo'     => 'required',
            'itemModel'        => 'required',
            'itemIncomingDate' => 'required',
            'itemCompanyName'  => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('item_srno', '=', $data['itemSerialNo'])->get();
            if (count($selectScopes) > 0) {
                return redirect()->back()->with('error_message', 'This Serial Number Is Al-ready Availible');
            } else {
                $createPartsStocks = DB::table('stock_records')
                    ->insertOrIgnore([
                        'item_incomingdate'   => $data['itemIncomingDate'],
                        'item_name'           => $data['itemDetails'],
                        'item_model'          => $data['itemModel'],
                        'item_srno'           => $data['itemSerialNo'],
                        'item_companyname'    => $data['itemCompanyName'],
                        'item_qtv'            => $data['itemQuantity'],
                        'ratePerUnit'         => $data['itemPricePerUnit'],
                        'totalAmount'         => $data['itemTotalPrice'],
                        'created_at'          => NOW(),
                        'updated_at'          => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createStockDisposiblePage()
    {
        return view('adminside.stocks.disposible-create');
    }
    // 
    public function createStockDisposible(Request $request)
    {
        $validationChaker = $request->validate([
            'itemDescription'   => 'required',
            'itemQuantity'      => 'required',
            // 'itemSizes'         => 'required',
            'itemBatchNo'       => 'required',
            // 'itemExpDate'       => 'required',
            'itemIncomingDate'  => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('item_name', '=', $data['itemDescription'])->get();
            if (count($selectScopes) > 0) {
                return redirect()->back()->with('error_message', 'This Item Is Al-ready Availible');
            } else {
                if (empty($data['itemSizes'])) {
                    if (empty($data['itemExpDate'])) {
                        $createPartsStocks = DB::table('stock_records')
                            ->insertOrIgnore([
                                'item_incomingdate'   => $data['itemIncomingDate'],
                                'item_name'           => $data['itemDescription'],
                                'item_batchNo'        => $data['itemBatchNo'],
                                // 'item_expDate'        => $data['itemExpDate'],
                                'item_qtv'            => $data['itemQuantity'],
                                'ratePerUnit'         => $data['itemPricePerUnit'],
                                'totalAmount'         => $data['itemTotalPrice'],
                                'created_at'          => NOW(),
                                'updated_at'          => NOW(),
                            ]);
                        if ($createPartsStocks) {
                            return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    } else {
                        $createPartsStocks = DB::table('stock_records')
                            ->insertOrIgnore([
                                'item_incomingdate'   => $data['itemIncomingDate'],
                                'item_name'           => $data['itemDescription'],
                                'item_batchNo'        => $data['itemBatchNo'],
                                'item_expDate'        => $data['itemExpDate'],
                                'item_qtv'            => $data['itemQuantity'],
                                'ratePerUnit'         => $data['itemPricePerUnit'],
                                'totalAmount'         => $data['itemTotalPrice'],
                                'created_at'          => NOW(),
                                'updated_at'          => NOW(),
                            ]);
                        if ($createPartsStocks) {
                            return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    }
                } else {
                    if (empty($data['itemExpDate'])) {
                        $createPartsStocks = DB::table('stock_records')
                            ->insertOrIgnore([
                                'item_incomingdate'   => $data['itemIncomingDate'],
                                'item_name'           => $data['itemDescription'],
                                'item_batchNo'        => $data['itemBatchNo'],
                                //    'item_expDate'        => $data['itemExpDate'],
                                'item_qtv'            => $data['itemQuantity'],
                                'size'                => $data['itemSizes'],
                                'ratePerUnit'         => $data['itemPricePerUnit'],
                                'totalAmount'         => $data['itemTotalPrice'],
                                'created_at'          => NOW(),
                                'updated_at'          => NOW(),
                            ]);
                        if ($createPartsStocks) {
                            return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    } else {
                        $createPartsStocks = DB::table('stock_records')
                            ->insertOrIgnore([
                                'item_incomingdate'   => $data['itemIncomingDate'],
                                'item_name'           => $data['itemDescription'],
                                'item_batchNo'        => $data['itemBatchNo'],
                                'item_expDate'        => $data['itemExpDate'],
                                'item_qtv'            => $data['itemQuantity'],
                                'size'                => $data['itemSizes'],
                                'ratePerUnit'         => $data['itemPricePerUnit'],
                                'totalAmount'         => $data['itemTotalPrice'],
                                'created_at'          => NOW(),
                                'updated_at'          => NOW(),
                            ]);
                        if ($createPartsStocks) {
                            return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function searchOtherDatas(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchOtherStock'])) {
            $selectParts = DB::table('stock_records')
                ->where('id', 'like', '%' . $query['searchOtherStock'] . '%')
                ->orWhere('item_qtv', 'like', '%' . $query['searchOtherStock'] . '%')
                ->orWhere('item_name', 'like', '%' . $query['searchOtherStock'] . '%')
                ->orWhere('item_incomingdate', 'like', '%' . $query['searchOtherStock'] . '%')
                ->paginate(10);
        } else {
            $selectParts = DB::table('stock_records')
                ->whereBetween('item_incomingdate', [$query['searchstartingDate'], $query['searchendingDate']])
                ->paginate(10);
        }
        return view('adminside.stocks.parts-list', [
            'selectParts'  => $selectParts,
        ]);
    }
    //
    public function searchOtherDatass(Request $request)
    {
        $query = $request->all();
        if (!empty($query['searchOtherStocks'])) {
            $selectParts = DB::table('stock_records')
                ->where('item_name', 'like', '%' . $query['searchOtherStocks'] . '%')
                ->orWhere('item_batchNo', 'like', '%' . $query['searchOtherStocks'] . '%')
                ->orWhere('item_expDate', 'like', '%' . $query['searchOtherStocks'] . '%')
                ->paginate(10);
        } else {
            $selectParts = DB::table('stock_records')
                ->whereBetween('item_expDate', [$query['searchstartingDate'], $query['searchendingDate']])
                ->paginate(10);
        }
        return view('adminside.stocks.disposible-items-list', [
            'selectParts'  => $selectParts,
        ]);
    }
    //
    public function detailsProducts($id)
    {
        $selectData = DB::table('stock_records')->where('id', '=', $id)->get();
        return view('adminside.stocks.parts-detail', [
            'selectData' => $selectData,
        ]);
    }
    //
    public function editProducts($id)
    {
        $selectData = DB::table('stock_records')->where('id', '=', $id)->get();
        return view('adminside.stocks.parts-edit', [
            'selectData' => $selectData,
        ]);
    }
    //
    public function updateOperationStockDisposible(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'itemDescription'   => 'required',
            'itemQuantity'      => 'required',
            // 'itemSizes'         => 'required',
            'itemBatchNo'       => 'required',
            'itemExpDate'       => 'required',
            'itemIncomingDate'  => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('id', '=', $id)->get();
            if (count($selectScopes) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                if (empty($data['itemSizes'])) {
                    $createPartsStocks = DB::table('stock_records')
                        ->where('id', '=', $id)
                        ->update([
                            'item_incomingdate'   => $data['itemIncomingDate'],
                            'item_name'           => $data['itemDescription'],
                            'item_batchNo'        => $data['itemBatchNo'],
                            'item_expDate'        => $data['itemExpDate'],
                            'item_qtv'            => $data['itemQuantity'],
                            'ratePerUnit'         => $data['itemPricePerUnit'],
                            'totalAmount'         => $data['itemTotalPrice'],
                            'updated_at'          => NOW(),
                        ]);
                    if ($createPartsStocks) {
                        return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                    } else {
                        return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                    }
                } else {
                    $createPartsStocks = DB::table('stock_records')
                        ->where('id', '=', $id)
                        ->update([
                            'item_incomingdate'   => $data['itemIncomingDate'],
                            'item_name'           => $data['itemDescription'],
                            'item_batchNo'        => $data['itemBatchNo'],
                            'item_expDate'        => $data['itemExpDate'],
                            'item_qtv'            => $data['itemQuantity'],
                            'size'                => $data['itemSizes'],
                            'ratePerUnit'         => $data['itemPricePerUnit'],
                            'totalAmount'         => $data['itemTotalPrice'],
                            'updated_at'          => NOW(),
                        ]);
                    if ($createPartsStocks) {
                        return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                    } else {
                        return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //
    public function updateOperationStockOther(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'itemDetails'      => 'required',
            // 'inspectionId'     => 'required',
            'itemQuantity'     => 'required',
            'itemSerialNo'     => 'required',
            'itemModel'        => 'required',
            'itemIncomingDate' => 'required',
            'itemCompanyName'  => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('id', '=', $id)->get();
            if (count($selectScopes) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                $createPartsStocks = DB::table('stock_records')
                    ->where('id', '=', $id)
                    ->update([
                        'item_incomingdate'   => $data['itemIncomingDate'],
                        'item_name'           => $data['itemDetails'],
                        'item_model'          => $data['itemModel'],
                        'item_srno'           => $data['itemSerialNo'],
                        'item_companyname'    => $data['itemCompanyName'],
                        'item_qtv'            => $data['itemQuantity'],
                        'ratePerUnit'         => $data['itemPricePerUnit'],
                        'totalAmount'         => $data['itemTotalPrice'],
                        'updated_at'          => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function updateOperationStockScopes(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'itemDetails'      => 'required',
            // 'inspectionId'     => 'required',
            'itemQuantity'     => 'required',
            'itemSerialNo'     => 'required',
            'itemModel'        => 'required',
            'itemIncomingDate' => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectScopes =  DB::table('stock_records')->where('id', '=', $id)->get();
            if (count($selectScopes) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                $createPartsStocks = DB::table('stock_records')
                    ->where('id', '=', $id)
                    ->update([
                        'item_incomingdate'   => $data['itemIncomingDate'],
                        'item_name'           => $data['itemDetails'],
                        'item_srno'           => $data['itemSerialNo'],
                        'item_qtv'            => $data['itemQuantity'],
                        'item_scope_model'    => $data['itemModel'],
                        'ratePerUnit'         => $data['itemPricePerUnit'],
                        'totalAmount'         => $data['itemTotalPrice'],
                        'created_at'          => NOW(),
                        'updated_at'          => NOW(),
                    ]);
                if ($createPartsStocks) {
                    return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                } else {
                    return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function updateOperationStockScopesParts(Request $request, $id)
    {
        $validationChaker = $request->validate([
            'itemDescription'  => 'required',
            'itemQuantity'     => 'required',
            // 'itemSizes'        => 'required',
            'itemIncomingDate' => 'required',
            'itemCompanyPartName' => 'required',
            'itemPricePerUnit'  => 'required',
            'itemTotalPrice'    => 'required',
        ]);
        $data = $request->all();
        if ($validationChaker) {
            $selectDDData = DB::table('stock_records')->where('id', '=', $id)->get();
            if (count($selectDDData) == 0) {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            } else {
                if (empty($data['itemSizes'])) {
                    $createPartsStocks = DB::table('stock_records')
                        ->where('id', '=', $id)
                        ->update([
                            'item_incomingdate'  => $data['itemIncomingDate'],
                            'item_name'          => $data['itemDescription'],
                            'item_qtv'           => $data['itemQuantity'],
                            'part_companyname'   => $data['itemCompanyPartName'],
                            'ratePerUnit'         => $data['itemPricePerUnit'],
                            'totalAmount'         => $data['itemTotalPrice'],
                            'created_at'         => NOW(),
                            'updated_at'         => NOW(),
                        ]);
                    if ($createPartsStocks) {
                        return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                    } else {
                        return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                    }
                } else {
                    $createPartsStocks = DB::table('stock_records')
                        ->where('id', '=', $id)
                        ->update([
                            'item_incomingdate'  => $data['itemIncomingDate'],
                            'item_name'          => $data['itemDescription'],
                            'item_qtv'           => $data['itemQuantity'],
                            'size'               => $data['itemSizes'],
                            'part_companyname'   => $data['itemCompanyPartName'],
                            'ratePerUnit'         => $data['itemPricePerUnit'],
                            'totalAmount'         => $data['itemTotalPrice'],
                            'created_at'         => NOW(),
                            'updated_at'         => NOW(),
                        ]);
                    if ($createPartsStocks) {
                        return redirect()->back()->with('success_message', 'Record Is Updated SuccessfullY');
                    } else {
                        return redirect()->back()->with('error_message', 'Record Is Updated Un-successfullY');
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function outgoingDataStock($id)
    {
        $selectInvoiceDataa = DB::table('invoices')
            ->where('id', '=', $id)->get();
        if ($selectInvoiceDataa) {
            return view('adminside.stocks.outgoingStock-create', [
                'selectInvoiceDataa'  => $selectInvoiceDataa,
            ]);
        }
    }
    //
    public function outgoingSystemDataStock($id)
    {
        $selectInvoiceDataa = DB::table('deliever_challans')
            ->where('id', '=', $id)->get();
        if ($selectInvoiceDataa) {
            return view('adminside.stocks.outgoingStockSystem-create', [
                'selectInvoiceDataa'  => $selectInvoiceDataa,
            ]);
        }
    }
    //
    public function outgoingDisposibleItem(Request $request)
    {
        $validationChecker = $request->validate([
            'itemOutgoingDate' => 'required',
        ]);

        $data = $request->all();

        if ($validationChecker) {
            $itemId = json_decode($data['itemId']);
            $itemQtv = json_decode($data['itemQtv']);
            $checkingExistOrNot = DB::table('stock_records')->whereIn('id', $itemId)->get();

            if ($checkingExistOrNot->count() > 0) {
                foreach ($checkingExistOrNot as $record) {
                    $key = array_search($record->id, $itemId);
                    $dbQtv = $record->item_qtv; // Quantity from the database
                    $itemName = $record->item_name;
                    $itemRatePerUnit = json_decode($record->ratePerUnit);
                    // echo "<pre>";
                    //     print_r($itemRatePerUnit);
                    //     echo "</pre>";
                    //     die();
                    if ($itemQtv[$key] > $dbQtv) {
                        return redirect()->back()->with('error_message', 'Low Quantity for item: ' . $itemName);
                    } else {
                        // Proceed with your operation here
                        // echo "Operation is working";
                        $createNewEntry = DB::table('stock_outgoings')->insertOrIgnore([
                            'item_id'      => $record->id,
                            'invoice_id'   => $data['itemInvoiceId'],
                            'solid_qtv'    => $itemQtv[$key],
                            'solid_date'   => $data['itemOutgoingDate'],
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);

                        if ($createNewEntry) {
                            $newQtv = $record->item_qtv - $itemQtv[$key];
                            $newTotalAmount = $newQtv * $itemRatePerUnit;
                            // echo "<pre>";
                            // print_r($newTotalAmount);
                            // echo "</pre>";
                            // die();
                            // Ensure the quantity doesn't go below zero
                            $newQtv = max(0, $newQtv);

                            $update = DB::table('stock_records')->where('id', $record->id)->update([
                                'item_qtv'    => $newQtv,
                                'totalAmount' => $newTotalAmount,
                                'updated_at'  => now(),
                            ]);

                            if ($update) {
                                echo "<script>alert('New Record Is Created Successfully');</script>";
                            }
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Unsuccessfully');
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error_message', 'No Data Found');
            }
        } else {
            return redirect()->back()->with('error_message', 'Validation failed');
        }
    }
    // 
    public function outgoingSystemItem(Request $request)
    {
        $validationChecker = $request->validate([
            'itemOutgoingDate' => 'required',
        ]);

        $data = $request->all();

        if ($validationChecker) {
            $itemId = json_decode($data['itemId']);
            $itemQtv = json_decode($data['itemQtv']);
            $checkingExistOrNot = DB::table('stock_records')->whereIn('id', $itemId)->get();

            if ($checkingExistOrNot->count() > 0) {
                foreach ($checkingExistOrNot as $record) {
                    $key = array_search($record->id, $itemId);
                    $dbQtv = $record->item_qtv; // Quantity from the database
                    $itemName = $record->item_name;
                    $itemRatePerUnit = json_decode($record->ratePerUnit);
                    if ($itemQtv[$key] > $dbQtv) {
                        return redirect()->back()->with('error_message', 'Low Quantity for item: ' . $itemName);
                    } else {
                        $createNewEntry = DB::table('stock_outgoings')->insertOrIgnore([
                            'item_id'      => $record->id,
                            'invoice_id'   => $data['itemInvoiceId'],
                            'solid_qtv'    => $itemQtv[$key],
                            'solid_date'   => $data['itemOutgoingDate'],
                            'created_at'   => now(),
                            'updated_at'   => now(),
                        ]);

                        if ($createNewEntry) {
                            $newQtv = $record->item_qtv - $itemQtv[$key];
                            $newTotalAmount = $newQtv * $itemRatePerUnit;
                            // Ensure the quantity doesn't go below zero
                            $newQtv = max(0, $newQtv);

                            $update = DB::table('stock_records')->where('id', $record->id)->update([
                                'item_qtv'    => $newQtv,
                                'totalAmount' => $newTotalAmount,
                                'updated_at'  => now(),
                            ]);

                            if ($update) {
                                echo "<script>alert('New Record Is Created Successfully');</script>";
                            }
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Unsuccessfully');
                        }
                    }
                }
            } else {
                return redirect()->back()->with('error_message', 'No Data Found');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    // 
    public function outgoingDataStocks($id)
    {
        $selectInspectionId = DB::table('incoming_inspection_reports')->where('id', '=', $id)->get();
        $selectStockRecord = DB::table('stock_records')->whereNotNull('part_companyname')->where('item_qtv', '>', '0')->get();
        return view('adminside.stocks.outgoingStockParts-create', [
            'selectInspectionId' => $selectInspectionId,
            'selectStockRecord' => $selectStockRecord,
        ]);
    }
    // 
    // public function outgoingPartsItem(Request $request){
    //     $validationChecker = $request->validate([
    //         // 'inspectionId'        => 'required',
    //         'itemOutgoingDate'    => 'required',
    //         'outgoingPartsData'   => 'required',
    //         'outgoingQtv'         => 'required',
    //     ]);
    //     $data = $request->all();

    //     if ( $validationChecker ) {
    //         $selectStockQtv = DB::table('stock_records')->where('id','=',$data['outgoingPartsData'])->where('item_qtv','>','0')->first();
    //         $oddQtv = $selectStockQtv->item_qtv;
    //         $currentQtv = $data['outgoingQtv'];
    //         if ($oddQtv < $currentQtv){
    //             return redirect()->back()->with('error_message','Low Qtv');
    //         } else {
    //             $newStockData = DB::table('stock_outgoings')->insertOrIgnore([
    //                 'item_id'       => $data['outgoingPartsData'],
    //                 'inspection_id' => $data['inspectionId'],
    //                 'solid_qtv'     => $data['outgoingQtv'],
    //                 'solid_date'    => $data['itemOutgoingDate'],
    //                 'created_at'    => NOW(),
    //                 'updated_at'    => NOW(),
    //             ]);
    //             if ( $newStockData ) {
    //                 $newQtv = $selectStockQtv->item_qtv - $data['outgoingQtv'];
    //                 $updateStockRecord = DB::table('stock_records')->where('id','=',$data['outgoingPartsData'])->update([
    //                     'item_qtv'   => $newQtv,
    //                     'updated_at' => NOW(),
    //                 ]);
    //                 if ( $updateStockRecord ) {
    //                     return redirect()->back()->with('success_message','New Record Is Created Is Successfully');
    //                 }
    //             } else {
    //                 return redirect()->back()->with('error_message','New Record Is Created Is Un-successfully');
    //             }
    //         }
    //     } else {
    //         return redirect()->back()->with('error_message');
    //     }
    // }
    //
    public function outgoingPartsItem(Request $request)
    {
        $validationChecker = $request->validate([
            'itemOutgoingDate'    => 'required',
            'outgoingPartsData'   => 'required',
            'outgoingQtv'         => 'required',
        ]);
        $data = $request->all();

        if ($validationChecker) {
            $selectStockQtv = DB::table('stock_records')->where('id', '=', $data['outgoingPartsData'])->first();
            $oddQtv = $selectStockQtv->item_qtv;
            $currentQtv = $data['outgoingQtv'];
            $itemRatePerUnit = $selectStockQtv->ratePerUnit;
            // echo "<pre>";
            // print_r($itemRatePerUnit);
            // echo "</pre>";
            // die();
            if ($oddQtv < $currentQtv) {
                return redirect()->back()->with('error_message', 'Low Qtv');
            } else {
                $newStockData = DB::table('stock_outgoings')->insertOrIgnore([
                    'item_id'       => $data['outgoingPartsData'],
                    'inspection_id' => $data['inspectionId'],
                    'solid_qtv'     => $data['outgoingQtv'],
                    'solid_date'    => $data['itemOutgoingDate'],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
                if ($newStockData) {
                    $newQtv = $selectStockQtv->item_qtv - $data['outgoingQtv'];
                    $newTotalAmount = $newQtv * $itemRatePerUnit;
                    $updateStockRecord = DB::table('stock_records')->where('id', '=', $data['outgoingPartsData'])->update([
                        'item_qtv'   => $newQtv,
                        'totalAmount' => $newTotalAmount,
                        'updated_at' => now(),
                    ]);
                    if ($updateStockRecord) {
                        return redirect()->back()->with('success_message', 'New Record Is Created Is Successfully');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Is Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    //  
    public function stockHistory($id)
    {
        $selectCompanies = DB::table('companies')->get();
        $stockDetails = DB::table('stock_outgoings')
            ->Join('stock_records', 'stock_outgoings.item_id', '=', 'stock_records.id')
            ->leftJoin('invoices', 'stock_outgoings.invoice_id', '=', 'invoices.id')
            ->leftJoin('clients', 'invoices.invoice_client_id', '=', 'clients.id')
            ->leftJoin('incoming_inspection_reports', 'stock_outgoings.inspection_id', '=', 'incoming_inspection_reports.id')
            ->select('stock_outgoings.*', 'invoices.invoice_number', 'invoices.invoice_date', 'incoming_inspection_reports.scope_incoming_date', 'incoming_inspection_reports.sender_name', 'stock_records.item_name', 'stock_records.item_batchNo', 'stock_records.item_expDate', 'clients.client_name')
            ->where('stock_outgoings.item_id', '=', $id)->get();
        return view('adminside.stocks.stockHistoryDetailPage', [
            'selectCompanies' => $selectCompanies,
            'stockDetails'    => $stockDetails,
        ]);
    }
    // 
    public function removeOperationStocksData($id)
    {
        $stockDetails = DB::table('stock_records')->where('id', '=', $id)->get();
        if (count($stockDetails) > 0) {
            $deleteStockDetails = DB::table('stock_records')->where('id', '=', $id)->delete();
            if ($deleteStockDetails) {
                return redirect()->back()->with('success_message', 'Record Removed Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Record Removed Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function addNewAttendancePage()
    {
        $selectCompanyData = DB::table('companies')->get();
        $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
        return view('adminside.Attendance.attendance-create', [
            'selectEmployees' => $selectEmployees,
            'selectCompanyData' => $selectCompanyData,
        ]);
    }
    // 
    public function attendanceOperation(Request $request)
    {
        $validationChecker = $request->validate([
            'clockInDate' => 'required',
            'employeeId'  => 'required',
            'clockInTime' => 'required',
            'companyTimeIn' => 'required',
        ]);

        $data = $request->all();
        if ($validationChecker) {
            $selectData = DB::table('attendance_employees')
                ->where('employee_id', '=', $data['employeeId'])
                ->where('clockInDate', '=', $data['clockInDate'])
                ->get();
            if (count($selectData) > 0) {
                return redirect()->back()->with('error_message', 'please this employee is availible this date,please check date');
            } else {
                $currentTime = $data['clockInTime'];
                $datas = Carbon::parse($currentTime);
                $datasss = Carbon::parse($data['companyTimeIn']);
                $officeStartTime = $datasss; // Set office time to 9:00 AM
                $lateTime = null; // Initialize $lateTime here

                if ($datas < $officeStartTime) {
                    return redirect()->back()->with('error_message', 'Employees cannot clock in before office start time.');
                } else {
                    if ($datas > $officeStartTime) {
                        // Employee is late
                        $lateStatus = '1';
                        $timeIn = Carbon::parse($officeStartTime);
                        $timeOut = Carbon::parse($datas);
                        $difference = $timeIn->diff($timeOut);
                        $lateTime = $difference->format('%H:%I:%S');
                    } else if ($datas == $officeStartTime) {
                        $lateStatus = '0';
                        $timeIn = Carbon::parse($officeStartTime);
                        $timeOut = Carbon::parse($officeStartTime);
                        $difference = $timeIn->diff($timeOut);
                        $lateTime = $difference->format('%H:%I:%S');
                    }
                    if (empty($data['lateNotes'])) {
                        $createAttendance      = DB::table('attendance_employees')->insertOrIgnore([
                            'admin_user'        => Auth::guard('admin')->user()->id,
                            'employee_id'       => $data['employeeId'],
                            'clockInTime'       => $datas,
                            'clockInDate'       => $data['clockInDate'],
                            'lateTime'          => $lateTime,
                            'attendance_status' => 1,
                            'late_status'       => $lateStatus,
                            'created_at'        => NOW(),
                            'updated_at'        => NOW(),
                        ]);
                        if ($createAttendance) {
                            $updateStatus = DB::table('employees')->where('id', '=', $data['employeeId'])->update(['online_status' => 1]);
                            if ($updateStatus) {
                                return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                            }
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    } else {
                        $createAttendance      = DB::table('attendance_employees')->insertOrIgnore([
                            'admin_user'        => Auth::guard('admin')->user()->id,
                            'employee_id'       => $data['employeeId'],
                            'clockInTime'       => $datas,
                            'clockInDate'       => $data['clockInDate'],
                            'lateTime'          => $lateTime,
                            'attendance_status' => 1,
                            'late_status'       => $lateStatus,
                            'notes'             => $data['lateNotes'],
                            'created_at'        => NOW(),
                            'updated_at'        => NOW(),
                        ]);
                        if ($createAttendance) {
                            $updateStatus = DB::table('employees')->where('id', '=', $data['employeeId'])->update(['online_status' => 1]);
                            if ($updateStatus) {
                                return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                            }
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created Un-successfullY');
                        }
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function attendanceList()
    {
        $selectEmployees = DB::table('attendance_employees')
            ->join('employees', 'attendance_employees.employee_id', '=', 'employees.id')
            ->select('attendance_employees.*', 'employees.employeename')
            ->get();
        if ($selectEmployees) {
            return view('adminside.Attendance.attendance-list', [
                'selectEmployees' => $selectEmployees,
            ]);
        }
    }
    //
    public function attendanceEditPage($id)
    {
        $selectCompanyData = DB::table('companies')->get();
        $selectEmployees = DB::table('attendance_employees')
            ->join('employees', 'attendance_employees.employee_id', '=', 'employees.id')
            ->select('attendance_employees.*', 'employees.employeename')
            ->where('attendance_employees.id', '=', $id)
            ->get();
        return view('adminside.Attendance.attendance-edit', [
            'selectEmployees' => $selectEmployees,
            'selectCompanyData' => $selectCompanyData,
        ]);
    }
    // 
    public function attendanceUpdateOperation(Request $request, $id)
    {
        $validationChecker = $request->validate([
            'clockOutDate' => 'required',
            'clockOutTime' => 'required',
            'companyTimeOut' => 'required',
        ]);
        $data = $request->all();
        if ($validationChecker) {
            $selectAttendanceRecord = DB::table('attendance_employees')->where('id', '=', $id)->first();
            if ($selectAttendanceRecord) {
                $loginTime = $data['clockInTime'];
                $currentlogoutTime = Carbon::parse($data['clockOutTime']);
                $dataz = Carbon::parse($data['companyTimeOut']);
                $fixedOfficeLogoutTime = $dataz;
                $lateTime = Carbon::parse($data['lateTime']);
                $timeIn = Carbon::parse($loginTime);
                $timeOut = Carbon::parse($data['clockOutTime']);;
                $difference = $timeIn->diff($timeOut);
                $totalHours = $difference->format('%H:%I:%S');
                $totalHoursInVariable = Carbon::parse($totalHours);
                $lateTime = Carbon::parse($lateTime);
                $differenceBetweenLateTimeAndTotalHours = $lateTime->diff($totalHoursInVariable);
                $resultTotalHours = $differenceBetweenLateTimeAndTotalHours->format('%H:%I:%S');
                $overtimeIn = $currentlogoutTime > $fixedOfficeLogoutTime ? $fixedOfficeLogoutTime : $currentlogoutTime;
                $overtimeOut = $currentlogoutTime;
                $attendance_status = '';
                if ($currentlogoutTime < $fixedOfficeLogoutTime) {
                    $attendance_status = 1;
                } else if ($currentlogoutTime > $fixedOfficeLogoutTime) {
                    $attendance_status = 3;
                }
                $difference = $overtimeIn->diff($overtimeOut);
                $overTimeData = $difference->format('%H:%I:%S');
                $updateRecords = DB::table('attendance_employees')->where('id', '=', $id)->update([
                    'clockOutTime'      => $currentlogoutTime,
                    'clockOutDate'      => $data['clockOutDate'],
                    'overTime'          => $overTimeData,
                    'attendance_status' => $attendance_status,
                    'total_hours'       => $resultTotalHours,
                    'updated_at'        => NOW(),
                ]);
                if ($updateRecords) {
                    $updateStatus = DB::table('employees')->where('id', '=', $data['employeeId'])->update(['online_status' => 0]);
                    if ($updateStatus) {
                        return redirect()->back()->with('success_message', 'Record Updated Is Successfully');
                    }
                } else {
                    return redirect()->back()->with('error_message', 'Record Updated Is Un-successfully');
                }
            } else {
                return redirect()->back()->with('error_message', 'Not Data Founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    // public function checkEmployeePresentOrAbsent() {
    //     // Retrieve all employee IDs
    //     $employeeIds = DB::table('employees')->pluck('id');

    //     // Check each employee ID in the leave table
    //     $employeesOnLeave = DB::table('leave_employees')->whereIn('employee_id', $employeeIds)->pluck('employee_id');

    //     // Determine employees not on leave and not already marked in attendance
    //     $absentEmployeeIds = $employeeIds->diff($employeesOnLeave);
    //     $alreadyMarked = DB::table('attendance_employees')->whereDate('clockOutDate', Carbon::today())->whereIn('employee_id', $absentEmployeeIds)->pluck('employee_id');
    //     $absentEmployeeIds = $absentEmployeeIds->diff($alreadyMarked);

    //     // Mark absent employees in the attendance_employees table if it's after 15:00
    //             $lateTime = Carbon::make('00:00:00');
    //             $OverTime = Carbon::make('00:00:00');
    //             $lateTime = $lateTime->format('H:i:s');
    //             $OverTime = $OverTime->format('H:i:s');
    //             $clockOutDateTime = Carbon::now()->format('Y-m-d H:i:s');
    //     // 
    //     $absentRecords = [];

    //     $currentTime = Carbon::now();
    //     if ($currentTime->format('H:i') > '13:00') {
    //         foreach ($absentEmployeeIds as $id) {
    //             $absentRecords[] = [
    //                 'admin_user' => Auth::guard('admin')->user()->id,
    //                     'employee_id' => $id,
    //                     'clockInDate' => NOW(),
    //                     'clockOutTime' => $clockOutDateTime,
    //                     'clockOutDate' => NOW(),
    //                     'lateTime'     => $lateTime,
    //                     'overTime'     => $OverTime,
    //                     'notes'      => 'Absent',
    //                     'late_status' => 0,
    //                     'total_hours' => $OverTime,
    //                     'created_at'  => NOW(),
    //                     'updated_at'  => NOW(),
    //             ];
    //         }

    //         if (!empty($absentRecords)) {
    //             DB::table('attendance_employees')->insert($absentRecords);
    //             return back()->with('success_message', 'Absent employees marked successfully after 15:00.');
    //         } else {
    //             return back()->with('info_message', 'No absent employees to mark after 15:00.');
    //         }
    //     } else {
    //         return back()->with('info_message', 'It is not yet time to mark absent employees.');
    //     }
    // }
    // 
    public function checkEmployeePresentOrAbsent()
    {
        // Step 1: Retrieve all employee IDs
        $employeeIds = DB::table('employees')->pluck('id');

        // Step 2: Check each employee ID in the leave table
        $employeesOnLeave = DB::table('leave_employees')->whereIn('employee_id', $employeeIds)->pluck('employee_id');
        $selectEmpty = DB::table('attendance_employees')->get();
        if (count($selectEmpty) > 0) {
            // Step 3: Determine employees not on leave and not already marked in attendance
            $absentEmployeeIds = $employeeIds->diff($employeesOnLeave);
            $alreadyMarked = DB::table('attendance_employees')->whereDate('clockOutTime', Carbon::today())->whereIn('employee_id', $absentEmployeeIds)->pluck('employee_id');
            $absentEmployeeIds = $absentEmployeeIds->diff($alreadyMarked);

            // Step 4: Mark absent employees in the attendance_employees table if it's after 15:00
            $lateTime = Carbon::make('00:00:00');
            $OverTime = Carbon::make('00:00:00');
            $lateTime = $lateTime->format('H:i:s');
            $OverTime = $OverTime->format('H:i:s');
            $clockOutDateTime = Carbon::now()->format('Y-m-d H:i:s');
            $selectData = DB::table('attendance_employees')->get();
            $lastDate = $selectData->last();
            $date = $lastDate->clockOutDate;
            $absentRecords = [];

            $currentTime = Carbon::now();
            if ($currentTime->format('H:i') > '13:00') {
                foreach ($absentEmployeeIds as $id) {
                    $absentRecords[] = [
                        'admin_user' => Auth::guard('admin')->user()->id,
                        'employee_id' => $id,
                        'clockInDate' => $date,
                        'clockOutTime' => $clockOutDateTime,
                        'clockOutDate' => $date,
                        'lateTime' => $lateTime,
                        'overTime' => $OverTime,
                        'notes' => 'Absent',
                        'late_status' => 0,
                        'total_hours' => $OverTime,
                        'created_at' => NOW(),
                        'updated_at' => NOW(),
                    ];
                }

                if (!empty($absentRecords)) {
                    DB::table('attendance_employees')->insert($absentRecords);
                    return back()->with('success_message', 'Absent employees marked successfully after 13:00.');
                } else {
                    return back()->with('error_message', 'No absent employees to mark after 13:00.');
                }
            } else {
                return back()->with('error_message', 'this function is not working because table is empty');
            }
        } else {
            return back()->with('error_message', 'this function is not working because table is empty');
        }
    }
    // 
    public function attendanceDetailsPage($id)
    {
        $currentYears = '';
        $startMonth   = '';
        $endMonth     = '';
        $attendanceData = attendance_employee::all();
        $selectCompanies = DB::table('companies')->get();
        $latestRecord = DB::table('attendance_employees')->latest('clockOutTime')->first();

        if ($latestRecord) {
            // Parse the 'clockOutTime' field of the latest record to get the current month
            $created_at = \Carbon\Carbon::parse($latestRecord->clockOutTime);
            $startMonth = $created_at->startOfMonth()->month;
            $endMonth = $created_at->endOfMonth()->month;
            $currentYears = $created_at->year;
        } else {
            $startMonth = null;
            $endMonth = null;
        }

        $selectAttendanceDetails = DB::table('attendance_employees')
            ->join('employees', 'attendance_employees.employee_id', '=', 'employees.id')
            ->select('attendance_employees.*', 'employees.employeename', 'employees.user_type')
            ->where('attendance_employees.employee_id', '=', $id)
            ->whereBetween(DB::raw('MONTH(attendance_employees.clockOutTime)'), [$startMonth, $endMonth])
            ->whereYear('attendance_employees.clockOutTime', '=', $currentYears)
            ->get();

        return view('adminside.Attendance.attendance-details', [
            'selectAttendanceDetails' => $selectAttendanceDetails,
            'selectCompanies' => $selectCompanies,
            'attendanceData' => $attendanceData,
        ]);
    }
    // 
    public function createExpensesCategoryPage()
    {
        return view('adminside.expenses.expenses-category-create');
    }
    // 
    public function createExpensesCategoryOperation(Request $request)
    {
        $validationChecker = $request->validate([
            'categoryName' => 'required',
        ]);
        $data = $request->all();
        if ($validationChecker) {
            $selectCategory = DB::table('expense_categories')->where('expense_category_name', '=', $data['categoryName'])->get();
            if (count($selectCategory) > 0) {
                return redirect()->back()->with('error_message', 'this data is al-ready availible');
            } else {
                $createCategory = DB::table('expense_categories')->insertOrIgnore([
                    'expense_category_name' => $data['categoryName'],
                    'created_at'            => NOW(),
                    'updated_at'            => NOW(),
                ]);
                if ($createCategory) {
                    return redirect()->back()->with('success_message', 'New Record Is Created Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'New Record Is Created Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function createExpensesPage()
    {
        return view('adminside.expenses.office-expenses-create');
    }
    // 
    public function categoryExpenses()
    {
        $selectCategoryData = DB::table('expense_categories')->get();
        return response()->json($selectCategoryData);
    }
    // 
    public function createExpensesOperation(Request $request)
    {
        $validationChecker = $request->validate([
            'expenseDate'          => 'required',
            // 'patticashAmount'   =>  'required',
            'expenseType'          => 'required',
            'expenseAmount'        => 'required',
            'expensePaymentType'   => 'required',
            'expenseVoucherNumber' => 'required',
            'expenseDetails'       => 'required',
        ]);
        $data = $request->all();
        if ($validationChecker) {
            $selectExpenses = DB::table('expenses')->where('expense_date', '=', $data['expenseDate'])->get();
            if (count($selectExpenses) > 0) {
                return redirect()->back()->with('error_message', 'this date data is al-ready availible');
            } else {
                // ======================  =========================
                $expenseType            = json_encode($data['expenseType']);
                $expenseAmount          = json_encode($data['expenseAmount']);
                $expensePaymentType     = json_encode($data['expensePaymentType']);
                $expenseVoucherNumber   = json_encode($data['expenseVoucherNumber']);
                $expenseDetails         = json_encode($data['expenseDetails']);
                // ======================  =========================
                $useAmountIntoday = 0;
                $remainingPatticash = 0;

                $expenseAmountAdd = isset($expenseAmount) ? json_decode($expenseAmount, true) : [];
                foreach ($expenseAmountAdd as $key => $expenseAmountAdds) {
                    $useAmountIntoday += $expenseAmountAdds;
                }
                // 
                $lastExpense = DB::table('expenses')->get();
                $datassss = $lastExpense->last();
                // 
                if (!empty($data['patticashAmount'])) {
                    // patticash field is not empty
                    if ($datassss) {
                        $tableRemainingPatti = $datassss->remaining_patticash_this_month;
                        $receivedPatticash = $tableRemainingPatti + $data['patticashAmount'];
                    } else {
                        $receivedPatticash = $data['patticashAmount'] + 0;
                    }
                    $remainingPatticash = $receivedPatticash - $useAmountIntoday;
                    $createRecordData = DB::table('expenses')->insertOrIgnore([
                        'expense_date'                   => $data['expenseDate'],
                        'expense_category_type'          => $expenseType,
                        'slip_number'                    => $expenseVoucherNumber,
                        'expense_detail'                 => $expenseDetails,
                        'expense_amount'                 => $expenseAmount,
                        'expense_payment_method'         => $expensePaymentType,
                        'expense_patticash_amount'       => $data['patticashAmount'],
                        'remaining_patticash_this_month' => $remainingPatticash,
                        'total_received_patticash'       => $data['patticashAmount'],
                        'total_use_amount'               => $useAmountIntoday,
                        'created_at'                     => NOW(),
                        'updated_at'                     => NOW(),
                    ]);
                    if ($createRecordData) {
                        return redirect()->back()->with('success_message', 'New Record Is created successfully');
                    } else {
                        return redirect()->back()->with('error_message', 'New Record Is created unsuccessfully');
                    }
                } else {
                    // patticash field is empty
                    if ($datassss) {
                        $tableRemainingPatti = $datassss->remaining_patticash_this_month;
                        $receivedPatticash = $tableRemainingPatti;
                    } else {
                        $receivedPatticash = 0;
                    }
                    $remainingPatticash = $receivedPatticash - $useAmountIntoday;
                    $createRecordData = DB::table('expenses')->insertOrIgnore([
                        'expense_date'                   => $data['expenseDate'],
                        'expense_category_type'          => $expenseType,
                        'slip_number'                    => $expenseVoucherNumber,
                        'expense_detail'                 => $expenseDetails,
                        'expense_amount'                 => $expenseAmount,
                        'expense_payment_method'         => $expensePaymentType,
                        'remaining_patticash_this_month' => $remainingPatticash,
                        'total_received_patticash'       => $data['patticashAmount'],
                        'total_use_amount'               => $useAmountIntoday,
                        'created_at'                     => NOW(),
                        'updated_at'                     => NOW(),
                    ]);
                    if ($createRecordData) {
                        return redirect()->back()->with('success_message', 'New Record Is created successfully');
                    } else {
                        return redirect()->back()->with('error_message', 'New Record Is created unsuccessfully');
                    }
                }
            }
            // echo "<pre>";
            // print_r($remainingPatticash);
            // echo "</pre>";
            // die();
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function expenseCategoryListPage()
    {
        $selectExpensesCategorys = DB::table('expense_categories')->get();
        return view('adminside.expenses.exp-category-list', [
            'selectExpensesCategorys' => $selectExpensesCategorys,
        ]);
    }
    // 
    public function editExpensesCategoryPage($id)
    {
        $selectExpensesCategorys = DB::table('expense_categories')->where('id', '=', $id)->get();
        return view('adminside.expenses.expenses-category-edit', [
            'selectExpensesCategorys' => $selectExpensesCategorys,
        ]);
    }
    // 
    public function updateExpensesCategoryOperation(Request $request, $id)
    {
        $validationChecker = $request->validate([
            'categoryName' => 'required',
        ]);
        $data = $request->all();
        if ($validationChecker) {
            $selectCategory = DB::table('expense_categories')->where('id', '=', $id)->get();
            if (count($selectCategory) == 0) {
                return redirect()->back()->with('error_message', 'this data is al-ready availible');
            } else {
                $createCategory = DB::table('expense_categories')->where('id', '=', $id)->update([
                    'expense_category_name' => $data['categoryName'],
                    'updated_at'            => NOW(),
                ]);
                if ($createCategory) {
                    return redirect()->back()->with('success_message', 'Record Update Is Created Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Record Update Is Created Un-successfully');
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function removeExpensesCategoryPage($id)
    {
        $selectExpensesCategorys = DB::table('expense_categories')->where('id', '=', $id)->get();
        if (count($selectExpensesCategorys) > 0) {
            $removeExpensesCategorys = DB::table('expense_categories')->where('id', '=', $id)->delete();
            if ($removeExpensesCategorys) {
                return redirect()->back()->with('success_message', 'Record Is Removed Successfully');
            } else {
                return redirect()->back()->with('error_message', 'Record Is Removed Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function detailExpensesPage()
    {
        $selectAll = expense::all();
        $latestRecord = DB::table('expenses')->latest('expense_date')->first();
        $currentYear = '';
        $currentMonth = '';

        if ($latestRecord) {
            // Parse the 'clockOutTime' field of the latest record to get the current month
            $created_at = \Carbon\Carbon::parse($latestRecord->expense_date);
            $currentYear = $created_at->year;
            $currentMonth = $created_at->month;
        }
        $selectExpenses = DB::table('expenses')
            ->whereYear('expense_date', $currentYear)
            ->whereMonth('expense_date', $currentMonth)
            ->get();
        return view('adminside.expenses.expense-details', [
            'selectExpenses'  => $selectExpenses,
            'selectAll' => $selectAll,
        ]);
    }
    // 
    public function createExpensesBankPage()
    {
        return view('adminside.expenses.bank-expenses-create');
    }
    // 
    public function createExpensesBankOperation(Request $request)
    {
        $validationChecker = $request->validate([
            'expenseDate'           => 'required',
            'expensePersonName'     => 'required',
            'expenseAmount'         => 'required',
            'expenseType'           => 'required',
            'expensePaymentType'    => 'required',
            'expenseTransectionId'  => 'required',
            // 'expenseBankName'
            // 'expenseBankAccountNumber'
            // 'expenseCheckNumber'
        ]);
        $data = $request->all();
        if ($validationChecker) {
            $selectExpenses = DB::table('bank_expenses')->where('payment_date', '=', $data['expenseDate'])->get();
            if (count($selectExpenses) > 0) {
                return redirect()->back()->with('error_message', 'this date data is al-ready availible');
            } else {
                // ======================  =========================
                $expenseType                         = json_encode($data['expenseType']);
                $expensePersonName                   = json_encode($data['expensePersonName']);
                $expenseAmount                       = json_encode($data['expenseAmount']);
                $expensePaymentType                  = json_encode($data['expensePaymentType']);
                $expenseBankName                     = json_encode($data['expenseBankName']);
                $expenseBankAccountNumber            = json_encode($data['expenseBankAccountNumber']);
                $expenseCheckNumber                  = json_encode($data['expenseCheckNumber']);
                $expenseTransectionId                = json_encode($data['expenseTransectionId']);
                // ======================  =========================
                $paymentSendAmountTotal              = 0;
                $paymentReceivedAmountTotal          = 0;
                $paymentTotalSendAmountTotal         = 0;
                $paymentTotalReceivedAmountTotal     = 0;
                $tableDaataSend                      = 0;
                $tableDaataReceived                  = 0;
                $expenseAmountAdd                    = isset($expenseAmount) ? json_decode($expenseAmount, true) : [];
                $expenseTransectionIdss              = isset($expenseTransectionId) ? json_decode($expenseTransectionId, true) : [];
                $expenseTypess                       = isset($expenseType) ? json_decode($expenseType, true) : [];
                foreach ($expenseTransectionIdss as $key => $expenseTransectionIdssss) {
                    if ($expenseTypess[$key] == 1) {
                        $paymentSendAmountTotal += $expenseAmountAdd[$key];
                    } else if ($expenseTypess[$key] == 2) {
                        $paymentReceivedAmountTotal += $expenseAmountAdd[$key];
                    }
                }
                $lastExpense = DB::table('bank_expenses')->get();
                $datassss = $lastExpense->last();
                if ($datassss) {
                    $tableDaataReceived              = $datassss->remaining_amount;
                    $remianifnData                   = $paymentSendAmountTotal - $paymentReceivedAmountTotal;
                    $remainingAmount                 = $tableDaataReceived - $remianifnData;
                } else {
                    $tableDaataSend                  = 0;
                    $tableDaataReceived              = 0;
                    $paymentTotalSendAmountTotal     = $tableDaataSend + $paymentSendAmountTotal;
                    $paymentTotalReceivedAmountTotal = $tableDaataReceived + $paymentReceivedAmountTotal;
                    $remainingAmount                 = $paymentTotalReceivedAmountTotal - $paymentTotalSendAmountTotal;
                }

                // echo "<pre>";
                // print_r($remainingAmount);
                // echo "</pre>";
                // die();
                // ======================  =========================
                $selectBankExpenses = DB::table('bank_expenses')->where('slip_number', '=', $expenseTransectionId)->get();
                if (count($selectBankExpenses) > 0) {
                    return redirect()->back()->with('error_message', 'this data is al-ready availible');
                } else {
                    if (!empty($data['expenseBankName']) && !empty($data['expenseBankAccountNumber'])) {
                        $createRecordData = DB::table('bank_expenses')->insertOrIgnore([
                            'payment_date'             => $data['expenseDate'],
                            'name'                     => $expensePersonName,
                            'payment_category_type'    => $expenseType,
                            'slip_number'              => $expenseTransectionId,
                            'payment_amount'           => $expenseAmount,
                            'payment_method'           => $expensePaymentType,
                            'bank_name'                => $expenseBankName,
                            'bank_account_number'      => $expenseBankAccountNumber,
                            'total_send_amount'        => $paymentSendAmountTotal,
                            'total_received_amount'    => $paymentReceivedAmountTotal,
                            'remaining_amount'         => $remainingAmount,
                            'created_at'               => NOW(),
                            'updated_at'               => NOW(),
                        ]);
                        if ($createRecordData) {
                            return redirect()->back()->with('success_message', 'New Record Is created successfully');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is created unsuccessfully');
                        }
                    } else {
                        if (empty($data['expenseCheckNumber'])) {
                            $createRecordData = DB::table('bank_expenses')->insertOrIgnore([
                                'payment_date'             => $data['expenseDate'],
                                'name'                     => $expensePersonName,
                                'payment_category_type'    => $expenseType,
                                'slip_number'              => $expenseTransectionId,
                                'payment_amount'           => $expenseAmount,
                                'payment_method'           => $expensePaymentType,
                                // 'check_number'             => $expenseCheckNumber,
                                'total_send_amount'        => $paymentSendAmountTotal,
                                'total_received_amount'    => $paymentReceivedAmountTotal,
                                'remaining_amount'         => $remainingAmount,
                                'created_at'               => NOW(),
                                'updated_at'               => NOW(),
                            ]);
                            if ($createRecordData) {
                                return redirect()->back()->with('success_message', 'New Record Is created successfully');
                            } else {
                                return redirect()->back()->with('error_message', 'New Record Is created unsuccessfully');
                            }
                        } else {
                            $createRecordData = DB::table('bank_expenses')->insertOrIgnore([
                                'payment_date'             => $data['expenseDate'],
                                'name'                     => $expensePersonName,
                                'payment_category_type'    => $expenseType,
                                'slip_number'              => $expenseTransectionId,
                                'payment_amount'           => $expenseAmount,
                                'payment_method'           => $expensePaymentType,
                                'check_number'             => $expenseCheckNumber,
                                'total_send_amount'        => $paymentSendAmountTotal,
                                'total_received_amount'    => $paymentReceivedAmountTotal,
                                'remaining_amount'         => $remainingAmount,
                                'created_at'               => NOW(),
                                'updated_at'               => NOW(),
                            ]);
                            if ($createRecordData) {
                                return redirect()->back()->with('success_message', 'New Record Is created successfully');
                            } else {
                                return redirect()->back()->with('error_message', 'New Record Is created unsuccessfully');
                            }
                        }
                    }
                }
                // ======================  =========================

            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function detailExpensesBanksPage()
    {
        $bankDetails = DB::table('bank_expenses')->get();
        $latestRecord = DB::table('bank_expenses')->latest('payment_date')->first();
        $startWeek = '';
        $endWeek = '';
        $year = '';
        if ($latestRecord) {
            // Parse the 'clockOutTime' field of the latest record to get the current month
            $created_at = \Carbon\Carbon::parse($latestRecord->payment_date);
            $startWeek = $created_at->startOfMonth()->month;
            $endWeek = $created_at->endOfMonth()->month;
            $year = $created_at->year;
        }
        $selectBankExpenses = DB::table('bank_expenses')
            ->whereBetween(DB::raw('MONTH(bank_expenses.payment_date)'), [$startWeek, $endWeek])
            ->whereYear('bank_expenses.payment_date', $year)
            ->get();
        return view('adminside.expenses.bank-expense-details', [
            'selectBankExpenses' => $selectBankExpenses,
            'bankDetails' => $bankDetails,
        ]);
    }
    // 
    public function createDataIncomingAndOutgoingDailyCreatingPage()
    {
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDataCreatingPage');
    }
    // 
    public function createPageDisposibleIncomingAndOutgoingDaily()
    {
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyRecordDisposibleCreatingPage');
    }
    // 
    public function incomingAndOutgoingDailyRecordDataList()
    {
        $selectIncomingAndOutgoingDailyRecord = DB::table('incoming_and_outgoing_disposibles')
            ->get();
        return view('adminside.incomingAndOutgoingDailyRecords.incomingAndOutgoingDailyOtherRecord-list', [
            'selectIncomingAndOutgoingDailyRecord' => $selectIncomingAndOutgoingDailyRecord,
        ]);
    }
    // 
    public function createAdminProfilePage()
    {
        $createAdminProfileDetails = DB::table('admin_details')->where('admin_id', '=', Auth::guard('admin')->user()->id)->get();
        return view('adminside.Account.account-setting', [
            'createAdminProfileDetails' => $createAdminProfileDetails,
        ]);
    }
    // 
    public function changerUserPassword(Request $request)
    {
        $validation_chkr = $request->validate([
            'old_password'     => 'required|min:8',
            'new_password'     => 'required|min:8|max:15|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            // string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/
            'conform_password' => 'required|min:8|max:15|same:new_password|string|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
        ]);
        $changePasswordFormData = $request->all();
        if ($validation_chkr != null) {
            // check old password is correct or not
            if (Hash::check($changePasswordFormData['old_password'], Auth::guard('admin')->user()->password)) {
                // check old and new password are same or not
                if ($changePasswordFormData['old_password'] == $changePasswordFormData['new_password']) {
                    return redirect()->back()->with('error_message', 'Old And New Password Are Same , Try Other Password.');
                } else {
                    //check new and conform password are some and not
                    if ($changePasswordFormData['new_password'] == $changePasswordFormData['conform_password']) {
                        // apply limitation user can change password in minumum 1 time in week

                        //change password operation
                        $changePassword = DB::table('admins')
                            ->where('id', '=', Auth::guard('admin')->user()->id)
                            ->update([
                                'password' => Hash::make($changePasswordFormData['new_password'])
                            ]);
                        //check operation true or false
                        if ($changePassword) {
                            return redirect()->back()->with('success_message', 'Password is updated successfully.');
                        } else {
                            return redirect()->back()->with('error_message', 'Password is not updated.');
                        }
                    } else {
                        return redirect()->back()->with('error_message', 'Old And New Password Are Same , New And Conform Password Is Not Match,Try Again.');
                    }
                }
            } else {
                return redirect()->back()->with('error_message', 'Invalid Old Password');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function personalinformation(Request $request)
    {
        // Validation check
        $validation_check = $request->validate([
            'userimage'          => 'required|mimes:jpg,jpeg,png|image',
            'username'           => 'required|min:4|max:15',
            'officenumber'       => 'required|numeric|min:5',
            'mobilenumber'       => 'required|numeric|min:8',
            'salutions'          => 'required',
            'nationality'        => 'required',
            'dateofbirth'        => 'required',
            'matrialstatus'      => 'required',
            'bloodgroup'         => 'required',
            'cnicnumber'         => 'required|numeric|min:10',
            'fathername'         => 'required',
            'address'            => 'required',
            'city'               => 'required',
            'state'              => 'required',
            'postalcode'         => 'required|numeric|min:6',
            'country'            => 'required',
            'contactnumber'      => 'required|numeric|min:8',
            'econtactperson'     => 'required|min:4|max:8',
            'relationship'       => 'required',
            'epersonphonenumber' => 'required|numeric|min:8',
            'placeofbirth'       => 'required',
            'subdepartment'      => 'required',
        ]);

        $receivedData = $request->all();

        // Conditions
        if ($validation_check != null) {
            // Check availability or not

            // INSERT OPERATION
            // Working with image
            $imageName = time() . "-userImages." . $request->file('userimage')->getClientOriginalExtension();
            $request->file('userimage')->storeAs('public/user_image/profile_image/' . $imageName);
            $imageUrl = "/storage/user_image/profile_image/" . $imageName;

            // Working on other fields
            $addAboutSetting = DB::table('admin_details')->insertOrIgnore([
                'admin_id'              => Auth::guard('admin')->user()->id,
                'first_name'               => $receivedData['username'],
                'user_image'               => $imageUrl,
                'email_address'            => $receivedData['emailaddress'],
                'office_number'            => $receivedData['officenumber'],
                'mobile_number'            => $receivedData['mobilenumber'],
                'salutation'               => $receivedData['salutions'],
                'nationality'              => $receivedData['nationality'],
                'date_of_birth'            => $receivedData['dateofbirth'],
                'marred_status'            => $receivedData['matrialstatus'],
                'blood_group'              => $receivedData['bloodgroup'],
                'cnic_number'              => $receivedData['cnicnumber'],
                'father_name'              => $receivedData['fathername'],
                'address'                  => $receivedData['address'],
                'city'                     => $receivedData['city'],
                'province'                 => $receivedData['state'],
                'postal_code'              => $receivedData['postalcode'],
                'country'                  => $receivedData['country'],
                'contact_number'           => $receivedData['contactnumber'],
                'emergency_contact_person' => $receivedData['econtactperson'],
                'relationship'             => $receivedData['relationship'],
                'person_contact'           => $receivedData['epersonphonenumber'],
                'place_of_birth'           => $receivedData['placeofbirth'],
                'sub_department'           => $receivedData['subdepartment'],
                'end_date'                 => $receivedData['prcbationenddate'],
                'created_at'               => NOW(),
                'updated_at'               => NOW()
            ]);

            // Conditions
            if ($addAboutSetting != null) {
                // Update employee table
                $updateFormData = DB::table('admins')
                    ->where('id', '=', Auth::guard('admin')->user()->id)
                    ->update([
                        'adminname' => $receivedData['username'],
                        'adminemailaddress' => $receivedData['emailaddress'],
                        'user_image'         => $imageUrl
                    ]);

                if ($updateFormData != null) {
                    return redirect()->back()->with('success_message', 'Saved Successfully');
                } else {
                    return redirect()->back()->with('error_message', 'Saved Un-Successfully, because this allows only 1-time add data. If you want to change data, then go to the edit form.');
                }
            } else {
                return redirect()->back()->with('error_message', 'Saved Un-Successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function editPersonalInformation(Request $request)
    {
        // Validation check
        $validation_check = $request->validate([
            'username'           => 'required|min:4|max:15',
            'officenumber'       => 'required|numeric|min:5',
            'mobilenumber'       => 'required|numeric|min:8',
            'salutions'          => 'required',
            'nationality'        => 'required',
            'dateofbirth'        => 'required',
            'matrialstatus'      => 'required',
            'bloodgroup'         => 'required',
            'cnicnumber'         => 'required|numeric|min:10',
            'fathername'         => 'required',
            'address'            => 'required',
            'city'               => 'required',
            'state'              => 'required',
            'postalcode'         => 'required|numeric|min:6',
            'country'            => 'required',
            'contactnumber'      => 'required|numeric|min:8',
            'econtactperson'     => 'required|min:4|max:8',
            'relationship'       => 'required',
            'epersonphonenumber' => 'required|numeric|min:8',
            'placeofbirth'       => 'required',
            'subdepartment'      => 'required',
        ]);

        $receivedData = $request->all();
        if ($validation_check != null) {
            $select_infor = DB::table('admin_details')
                ->where('admin_id', '=', Auth::guard('admin')->user()->id)
                ->count();
            if ($select_infor > 0) {
                // working with images
                if (!empty($receivedData['userimage'])) {
                    $imageName = time() . "-userImages." . $request->file('userimage')->getClientOriginalExtension();
                    $request->file('userimage')->storeAs('public/user_image/profile_image/' . $imageName);
                    $imageUrl = "/storage/user_image/profile_image/" . $imageName;

                    // Working on other fields
                    $addAboutSetting = DB::table('admin_details')
                        ->where('admin_id', '=', Auth::guard('admin')
                            ->user()->id)->update([
                            'admin_id'              => Auth::guard('admin')->user()->id,
                            'first_name'               => $receivedData['username'],
                            'user_image'               => $imageUrl,
                            'email_address'            => $receivedData['emailaddress'],
                            'office_number'            => $receivedData['officenumber'],
                            'mobile_number'            => $receivedData['mobilenumber'],
                            'salutation'               => $receivedData['salutions'],
                            'nationality'              => $receivedData['nationality'],
                            'date_of_birth'            => $receivedData['dateofbirth'],
                            'marred_status'            => $receivedData['matrialstatus'],
                            'blood_group'              => $receivedData['bloodgroup'],
                            'cnic_number'              => $receivedData['cnicnumber'],
                            'father_name'              => $receivedData['fathername'],
                            'address'                  => $receivedData['address'],
                            'city'                     => $receivedData['city'],
                            'province'                 => $receivedData['state'],
                            'postal_code'              => $receivedData['postalcode'],
                            'country'                  => $receivedData['country'],
                            'contact_number'           => $receivedData['contactnumber'],
                            'emergency_contact_person' => $receivedData['econtactperson'],
                            'relationship'             => $receivedData['relationship'],
                            'person_contact'           => $receivedData['epersonphonenumber'],
                            'place_of_birth'           => $receivedData['placeofbirth'],
                            'sub_department'           => $receivedData['subdepartment'],
                            // 'end_date'                 => $receivedData['prcbationenddate'],
                            // 'created_at'               => NOW(),
                            'updated_at'               => NOW()
                        ]);

                    // Conditions
                    if ($addAboutSetting) {
                        // Update employee table
                        $updateFormData = DB::table('admins')
                            ->where('id', '=', Auth::guard('admin')->user()->id)
                            ->update([
                                'adminname' => $receivedData['username'],
                                'adminemailaddress' => $receivedData['emailaddress'],
                                'user_image'         => $imageUrl
                            ]);

                        if ($updateFormData != null) {
                            return redirect()->back()->with('success_message', 'Update Successfully');
                        } else {
                            return redirect()->back()->with('error_message', 'Update Un-Successfully, because this allows only 1-time add data. If you want to change data, then go to the edit form.');
                        }
                    } else {
                        return redirect()->back()->with('error_message', 'Update Un-Successfully');
                    }
                    // without image working
                } else {
                    // Working on other fields
                    $addAboutSetting = DB::table('admin_details')
                        ->where('admin_id', '=', Auth::guard('admin')
                            ->user()->id)->update([
                            'admin_id'              => Auth::guard('admin')->user()->id,
                            'first_name'               => $receivedData['username'],
                            'email_address'            => $receivedData['emailaddress'],
                            'office_number'            => $receivedData['officenumber'],
                            'mobile_number'            => $receivedData['mobilenumber'],
                            'salutation'               => $receivedData['salutions'],
                            'nationality'              => $receivedData['nationality'],
                            'date_of_birth'            => $receivedData['dateofbirth'],
                            'marred_status'            => $receivedData['matrialstatus'],
                            'blood_group'              => $receivedData['bloodgroup'],
                            'cnic_number'              => $receivedData['cnicnumber'],
                            'father_name'              => $receivedData['fathername'],
                            'address'                  => $receivedData['address'],
                            'city'                     => $receivedData['city'],
                            'province'                 => $receivedData['state'],
                            'postal_code'              => $receivedData['postalcode'],
                            'country'                  => $receivedData['country'],
                            'contact_number'           => $receivedData['contactnumber'],
                            'emergency_contact_person' => $receivedData['econtactperson'],
                            'relationship'             => $receivedData['relationship'],
                            'person_contact'           => $receivedData['epersonphonenumber'],
                            'place_of_birth'           => $receivedData['placeofbirth'],
                            'sub_department'           => $receivedData['subdepartment'],
                            // 'end_date'                 => $receivedData['prcbationenddate'],
                            // 'created_at'               => NOW(),
                            'updated_at'               => NOW()
                        ]);

                    // Conditions
                    if ($addAboutSetting) {
                        // Update employee table
                        $updateFormData = DB::table('admins')
                            ->where('id', '=', Auth::guard('admin')->user()->id)
                            ->update([
                                'adminname' => $receivedData['username'],
                                'adminemailaddress' => $receivedData['emailaddress'],
                                // 'user_image'         => $imageUrl
                            ]);

                        if ($updateFormData) {
                            return redirect()->back()->with('success_message', 'update Successfully.');
                        } else {
                            return redirect()->back()->with('error_message', 'update Un-Successfullys.');
                        }
                    } else {
                        return redirect()->back()->with('error_message', 'update Un-Successfully');
                    }
                }
            } else {
                return redirect()->back()->with('error_message', 'this partical user is not founded');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function notificationReadStatus($id)
    {
        $selectNotification = notification::where('id', '=', $id)->get();
        if (count($selectNotification) > 0) {
            $updateNotificationStatus = notification::where('id', '=', $id)->update([
                'read_status' => 1,
                'readByAdmin' => Auth::guard('admin')->user()->id,
                'updated_at' => NOW(),
            ]);
            if ($updateNotificationStatus) {
                return redirect()->back()->with('success_message', 'Notification is read');
            } else {
                return redirect()->back()->with('error_message', 'Notification is not read');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function createLeavePage()
    {
        $selectEmployees = DB::table('employees')->where('active_status', '=', 1)->get();
        return view('adminside.Attendance.leave-create', [
            'selectEmployees' => $selectEmployees,
        ]);
    }
    // 
    public function createOperationLeavePage(Request $request)
    {
        $validatorChecker = $request->validate([
            'leaveDate'            => 'required',
            'employeeId'           => 'required',
            'leaveDuration'        => 'required',
            'leaveStartDate'       => 'required',
            'leaveEndingDate'      => 'required',
            'reasonLeave'          => 'required',
        ]);
        $data = $request->all();
        $startingDate = $data['leaveStartDate'];
        $endingDate = $data['leaveEndingDate'];
        if ($validatorChecker) {
            $checkOldData = DB::table('leave_employees')->where('leaveDate', '=', $data['leaveDate'])->where('employee_id', '=', $data['employeeId'])->get();
            if (count($checkOldData) > 0) {
                return redirect()->back()->with('error_message', 'this data is al-ready availible');
            } else {
                if ($data['leaveStartDate'] == 'leaveEndingDate') {
                    return redirect()->back()->with('error_message', 'minimum 1 day leave is allow');
                } else {
                    if ($startingDate > $endingDate) {
                        return redirect()->back()->with('error_message', 'leave starting date is greater than ending date');
                    } else {
                        $insertOperationData = DB::table('leave_employees')->insertOrIgnore([
                            'admin_user'           => Auth::guard('admin')->user()->id,
                            'employee_id'          => $data['employeeId'],
                            'reason'               => $data['reasonLeave'],
                            'leave_duration'       => $data['leaveDuration'],
                            'leave_starting_date'  => $data['leaveStartDate'],
                            'leave_ending_date'    => $data['leaveEndingDate'],
                            'leave_status'         => 0,
                            'read_status'          => 0,
                            'leaveDate'            => $data['leaveDate'],
                            'created_at'           => NOW(),
                            'updated_at'           => NOW(),
                        ]);
                        if ($insertOperationData) {
                            return redirect()->back()->with('success_message', 'New Record Is Created SuccessfullY');
                        } else {
                            return redirect()->back()->with('error_message', 'New Record Is Created un-successfullY');
                        }
                    }
                }
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function leaveListPage()
    {
        $selectLeaveData = DB::table('leave_employees')
            ->join('employees', 'leave_employees.employee_id', '=', 'employees.id')
            ->select('leave_employees.*', 'employees.employeename')
            ->get();
        return view('adminside.Attendance.leave-list', [
            'selectLeaveData' => $selectLeaveData,
        ]);
    }
    // 
    public function leaveDetails($id)
    {
        $selectLeaveData = DB::table('leave_employees')
            ->join('employees', 'leave_employees.employee_id', '=', 'employees.id')
            ->select('leave_employees.*', 'employees.employeename')
            ->where('leave_employees.id', '=', $id)
            ->get();
        $approvedLeaveData = DB::table('leave_employees')
            ->where('id', '=', $id)
            ->update([
                'read_status' => 1,
                'updated_at' => NOW(),
            ]);
        if ($approvedLeaveData) {
            return view('adminside.Attendance.leave-detail', [
                'selectLeaveData' => $selectLeaveData,
            ]);
        }
    }
    // 
    public function removeLeaveOperation($id)
    {
        $selectLeaveData = DB::table('leave_employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectLeaveData) > 0) {
            $removeLeaveData = DB::table('leave_employees')
                ->where('id', '=', $id)
                ->delete();
            if ($removeLeaveData) {
                return redirect()->back()->with('success_message', "Can not delete this data");
            } else {
                return redirect()->back()->with('error_message', "Can not delete this data");
            }
        }
    }
    // 
    public function approveLeave($id)
    {
        $selectLeaveData = DB::table('leave_employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectLeaveData) > 0) {
            $approvedLeaveData = DB::table('leave_employees')
                ->where('id', '=', $id)
                ->update([
                    'leave_status' => 1,
                    'approved_by' => Auth::guard('admin')->user()->id,
                    'updated_at' => NOW(),
                ]);
            if ($approvedLeaveData) {
                $selectLeaveData = $selectLeaveData->first();
                $startingDate = $selectLeaveData->leave_starting_date;
                $endingDate = $selectLeaveData->leave_ending_date;
                $employeeId = $selectLeaveData->employee_id;
                $lateTime = Carbon::make('00:00:00');
                $OverTime = Carbon::make('00:00:00');
                $lateTime = $lateTime->format('H:i:s');
                $OverTime = $OverTime->format('H:i:s');
                $clockOutDateTime = Carbon::now()->format('Y-m-d H:i:s');
                $period = Carbon::parse($startingDate)->daysUntil($endingDate);
                foreach ($period as $date) {
                    $leaveEntery = DB::table('attendance_employees')->insert([
                        'admin_user' => Auth::guard('admin')->user()->id,
                        'employee_id' => $employeeId,
                        'clockInDate' => $date->format('Y-m-d'),
                        'clockOutTime' => $clockOutDateTime,
                        'clockOutDate' => $date->format('Y-m-d'),
                        'lateTime'     => $lateTime,
                        'overTime'     => $OverTime,
                        'notes'      => 'leave approved',
                        'late_status' => 0,
                        'total_hours' => $OverTime,
                        'created_at'  => NOW(),
                        'updated_at'  => NOW(),
                    ]);
                }
                if ($leaveEntery) {
                    return redirect()->back()->with('success_message', 'Leave Approved Is Successfully');
                }
                // notification system bd me lgana h
            } else {
                return redirect()->back()->with('error_message', 'Leave Approved Is Unsuccessfully');
            }
        }
    }
    // 
    public function rejectedLeave($id)
    {
        $selectLeaveData = DB::table('leave_employees')
            ->where('id', '=', $id)
            ->get();
        if (count($selectLeaveData) > 0) {
            $approvedLeaveData = DB::table('leave_employees')
                ->where('id', '=', $id)
                ->update([
                    'leave_status' => 0,
                    'approved_by' => Auth::guard('admin')->user()->id,
                    'updated_at' => NOW(),
                ]);
            if ($approvedLeaveData) {
                return redirect()->back()->with('success_message', 'Leave Rejected Is Successfully');
                // notification system bd me lgana h
            } else {
                return redirect()->back()->with('error_message', 'Leave Rejected Is Unsuccessfully');
            }
        }
    }
    // 
    public function allLeaveListPage()
    {
        $selectLeaveData = DB::table('leave_employees')
            ->join('employees', 'leave_employees.employee_id', '=', 'employees.id')
            ->select('leave_employees.*', 'employees.employeename')
            ->where('leave_employees.leave_status', '=', 0)
            ->get();
        return view('adminside.Attendance.resquest-leave-list', [
            'selectLeaveData' => $selectLeaveData,
        ]);
    }
    // 
    // public function checkEmployeePresentOrAbsent (){
    //         $dataRecordCompany = DB::table('attendance_employees')->select('clockInDate')->first();
    //         $currentDate = $dataRecordCompany->format('Y-m-d');
    //         $employees = DB::table('employees')->select('id')->get();
    //         $lateTime = Carbon::make('00:00:00');
    //         $OverTime = Carbon::make('00:00:00');
    //         $lateTime = $lateTime->format('H:i:s');
    //         $OverTime = $OverTime->format('H:i:s');
    //         $clockOutDateTime = Carbon::now()->format('Y-m-d H:i:s');
    //         foreach ($employees as $employee) {
    //             $attendanceEntryExists = DB::table('attendance_employees')
    //                 ->where('employee_id', $employee->id)
    //                 ->whereDate('created_at', $currentDate)
    //                 ->exists();
    //             if (!$attendanceEntryExists) {
    //                 $dataRecord = DB::table('attendance_employees')->insert([
    //                     'admin_user' => Auth::guard('admin')->user()->id,
    //                     'employee_id' => $employee->id,
    //                     'clockInDate' => $currentDate,
    //                     'clockOutTime' => $clockOutDateTime,
    //                     'clockOutDate' => $currentDate,
    //                     'lateTime'     => $lateTime,
    //                     'overTime'     => $OverTime,
    //                     'notes'        => 'Absent Mark',
    //                     'late_status'  => 0,
    //                     'total_hours'  => $OverTime,
    //                     'created_at' => NOW(),
    //                     'updated_at' => NOW(),
    //                 ]);
    //                 if ($dataRecord) {
    //                     return redirect()->back()->with('success_message','Operation Performed');
    //                 } else {
    //                     return redirect()->back()->with('error_message','Operation Failed');
    //                 }
    //             }
    //         }
    // }
    // 
    public function createNotificationQtvChecker()
    {
        //
        $selectAdmin = DB::table('admins')->get();

        foreach ($selectAdmin as $admin) {

            $nearExpiryItems = DB::table('stock_records')
                ->whereDate('item_expDate', '<=', now()->addDays(30))
                ->get();

            $outOfStockItems = DB::table('stock_records')
                ->where('item_qtv', '=', 0)
                ->get();

            $notifications = [];

            if (!$outOfStockItems->isEmpty()) {
                foreach ($outOfStockItems as $item) {
                    array_push($notifications, "Out of stock: " . $item->item_name);
                }
            }

            if (!$nearExpiryItems->isEmpty()) {
                foreach ($nearExpiryItems as $item) {
                    array_push($notifications, "This item is near by expire: " . $item->item_name . "Expire Date is: " .  \Carbon\Carbon::parse($item->item_expDate)->format('M d, Y'));
                }
            }

            foreach ($notifications as $notification) {
                DB::table('notifications')->insert([
                    'message'     => $notification,
                    'read_status' => 0,
                    'readByAdmin' => $admin->id,
                    'created_at'  => NOW(),
                    'updated_at'  => NOW(),
                ]);
            }
        }
        //
        $selectEmployee = DB::table('employees')->get();

        foreach ($selectEmployee as $selectEmployees) {

            $nearExpiryItems = DB::table('stock_records')
                ->whereDate('item_expDate', '<=', now()->addDays(30))
                ->get();

            $outOfStockItems = DB::table('stock_records')
                ->where('item_qtv', '=', 0)
                ->get();

            $notifications = [];

            if (!$outOfStockItems->isEmpty()) {
                foreach ($outOfStockItems as $item) {
                    array_push($notifications, "Out of stock: " . $item->item_name);
                }
            }

            if (!$nearExpiryItems->isEmpty()) {
                foreach ($nearExpiryItems as $item) {
                    array_push($notifications, "This item is near by expire: " . $item->item_name . "Expire Date is: " . \Carbon\Carbon::parse($item->item_expDate)->format('M d, Y'));
                }
            }

            foreach ($notifications as $notification) {
                DB::table('notifications')->insert([
                    'message'     => $notification,
                    'read_status' => 0,
                    'readByEmployee' => $selectEmployees->id,
                    'created_at'  => NOW(),
                    'updated_at'  => NOW(),
                ]);
            }
        }
    }
    // 
    public function removeAttendanceDetails($id)
    {
        $selectAttendanceDetails = DB::table('attendance_employees')->where('id', '=', $id)->get();
        if (count($selectAttendanceDetails) > 0) {
            $removeAttendanceDetails = DB::table('attendance_employees')->where('id', '=', $id)->delete();
            if ($removeAttendanceDetails) {
                return redirect()->back()->with('success_message', 'Remove Operation Is SuccessfullY');
            } else {
                return redirect()->back()->with('error_message', 'Remove Operation Is Un-successfullY');
            }
        } else {
            return redirect()->back()->with('error_message', 'Not Data Founded');
        }
    }
    // 
    public function clientPaymentReceivedPage($id)
    {
        $selectClientData = DB::table('clients')->where('id', '=', $id)->get();
        return view('adminside.client.client-paymentReceived', [
            'selectClientData' => $selectClientData,
        ]);
    }
    // 
    public function clientPaymentReceivedOperation(Request $request)
    {
        $validatorChecker = $request->validate([
            'paymentReceivedDate'    => 'required',
            'paymentReceivedAmount'  => 'required',
            'clientNotes'            => 'required',
            'previousAmount'         => 'required',
            'clientId'               => 'required',
        ]);
        $data = $request->all();
        if ($validatorChecker) {
            $previousAmount        = $data['previousAmount'];
            $paymentReceivedAmount = $data['paymentReceivedAmount'];
            $totalRemainingAmount = $previousAmount - $paymentReceivedAmount;
            // echo "<pre>";
            // print_r($totalRemainingAmount);
            // echo "</pre>";
            // die();
            $insertOperation = DB::table('client_account_historys')->insertOrIgnore([
                'invoice_date'               => $data['paymentReceivedDate'],
                'account_name'               => $data['clientId'],
                'invoice_grant_total_amount' => $paymentReceivedAmount,
                'payment_type'               => 1,
                'Notes'                      => $data['clientNotes'],
                'Previous_amount'            => $totalRemainingAmount,
                'created_at'                 => NOW(),
                'updated_at'                 => NOW(),
            ]);
            if ($insertOperation) {
                return redirect()->back()->with('success_message', 'New Record Insert Operation Is Successfully');
            } else {
                return redirect()->back()->with('error_message', 'New Record Insert Operation Is Un-successfully');
            }
        } else {
            return redirect()->back()->with('error_message');
        }
    }
    // 
    public function reportClientReportingSystem()
    {
        $selectClients = invoice::join('clients', 'invoices.invoice_client_id', '=', 'clients.id')->select('invoices.*', 'clients.client_name')->get();
        return view('adminside.reporting.clients_report', [
            'selectClients' => $selectClients,
        ]);
    }
    // 

    public function reportMonthlyExpenseReportingSystem()
    {
        $expense = expense::all();
        $exPensee = $expense->last();
        $currentMonth = $exPensee->expense_date;
        $selectExpense = expense::whereYear('expense_date', Carbon::parse($currentMonth)->year)
            ->whereMonth('expense_date', Carbon::parse($currentMonth)->month)
            ->get();
        return view('adminside.reporting.expense_reports', [
            'selectExpense' => $selectExpense,
            'expense' => $expense,
        ]);
    }
    // 
    public function getDataForMonthWiseExpenseReport(Request $request)
    {
        $expense = expense::all();
        $selectedMonth = $request->input('searchByMonth');
        $expenseDetails = expense::whereYear('expense_date', Carbon::parse($selectedMonth)->year)
            ->whereMonth('expense_date', Carbon::parse($selectedMonth)->month)
            ->get();
        return view('adminside.reporting.expense_reports', [
            'selectExpense' => $expenseDetails,
            'expense' => $expense,
        ]);
    }
    // 
    public function reportMonthBankStatementReportingSystem()
    {
        $expense = bank_expense::all();
        $exPensee = $expense->last();
        $currentMonth = $exPensee->payment_date;
        $selectExpense = bank_expense::whereYear('payment_date', Carbon::parse($currentMonth)->year)
            ->whereMonth('payment_date', Carbon::parse($currentMonth)->month)
            ->get();
        return view('adminside.reporting.bank_reports', [
            'selectExpense' => $selectExpense,
            'expense' => $expense,
        ]);
    }
    // 
    public function getDataForMonthWiseBankReport(Request $request)
    {
        $selectedMonth = $request->input('searchByMonthYear');
        $expense = bank_expense::all();
        $expenseDetails = bank_expense::whereYear('payment_date', Carbon::parse($selectedMonth)->year)
            ->whereMonth('payment_date', Carbon::parse($selectedMonth)->month)
            ->get();
        return view('adminside.reporting.bank_reports', [
            'selectExpense' => $expenseDetails,
            'expense' => $expense,
        ]);
    }
    // 
    public function getDataForMonthAttendanceDetailsPage(Request $request, $id)
    {
        $selectedMonth = $request->input('searchByYearMonth');
        $attendanceData = attendance_employee::all();
        $selectCompanies = DB::table('companies')->get();
        $selectAttendanceDetails = DB::table('attendance_employees')
            ->join('employees', 'attendance_employees.employee_id', '=', 'employees.id')
            ->select('attendance_employees.*', 'employees.employeename', 'employees.user_type')
            ->where('attendance_employees.employee_id', '=', $id)
            ->whereYear('attendance_employees.clockOutTime', Carbon::parse($selectedMonth)->year)
            ->whereMonth('attendance_employees.clockOutTime', Carbon::parse($selectedMonth)->month)
            ->get();

        return view('adminside.Attendance.attendance-details', [
            'selectAttendanceDetails' => $selectAttendanceDetails,
            'selectCompanies' => $selectCompanies,
            'attendanceData' => $attendanceData,
        ]);
    }
    // 
    public function getDataForMonthdetailExpensesPage(Request $request)
    {
        $selectedMonth = $request->input('searchByYearMonth');
        $selectAll = expense::all();
        $selectExpenses = DB::table('expenses')
            ->whereYear('expense_date', Carbon::parse($selectedMonth)->year)
            ->whereMonth('expense_date', Carbon::parse($selectedMonth)->month)
            ->get();
        return view('adminside.dashboard.adminDashboard', [
            'selectExpenses'  => $selectExpenses,
            'selectAll' => $selectAll,
        ]);
    }
    //
    public function getDataForMonthdetailExpensesBanksPage(Request $request)
    {
        $selectedMonth = $request->input('searchByYearMonth');
        $bankDetails = DB::table('bank_expenses')->get();
        $selectBankExpenses = DB::table('bank_expenses')
            ->whereYear('payment_date', Carbon::parse($selectedMonth)->year)
            ->whereMonth('payment_date', Carbon::parse($selectedMonth)->month)
            ->get();
        return view('adminside.expenses.bank-expense-details', [
            'selectBankExpenses' => $selectBankExpenses,
            'bankDetails' => $bankDetails,
        ]);
    }
    // 
    public function viewStockDetailsPage()
    {
        $selectCompanies = DB::table('companies')->get();
        $selectStocks = DB::table('stock_records')->get();
        return view('adminside.reporting.stocks_acids', [
            'selectCompanies' => $selectCompanies,
            'selectStocks' => $selectStocks,
        ]);
    }
    // 
    public function updateOperationStatus()
    {
        Admin::query()->update(['active_status' => 0]);
        employee::query()->update(['active_status' => 0]);
        $this->info('User Statuses Updated Successfully.');
    }
}
