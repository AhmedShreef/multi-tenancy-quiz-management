<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use App\Http\Requests\TenantRequest;
use App\Services\EmailService;
class TenantController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService){
        $this->emailService = $emailService;
    }

    public function store(TenantRequest $request){
        // Create Tenant and Domain
        if ($tenant = $this->createTenant($request)) {
            // Use the tenant's database connection to Perform tenant-specific actions
            tenancy()->initialize($tenant);
            
            //Create Admin
            $this->createAdmin($request);

            // Assign Role Admin to created Admin
            $this->runRolePermissionSeeders($tenant);

            // Send Credentials Through Email 
            $this->sendCredentials($request);

            return view('tenants.thank-you');
        }else{
            return redirect()->back();
        }
    }

    public function createTenant($request){
        $tenant = Tenant::create([
            'id'=>remove_spaces($request['domain']),
        ]);
        $tenant->domains()->create([
            'domain' => remove_spaces($request['domain']).'.'.config('app.base_url'),
        ]);
        return $tenant;
    }

    public function createAdmin($request){
        \Artisan::call('make:filament-user', [
            '--name' => $request['name'],
            '--email'     => $request['email'],
            '--password'  => $request['password'],
        ]);
    }

    public function runRolePermissionSeeders($tenant){
        $tenant->run(function () {
            \Artisan::call('db:seed');
        });
    }

    public function sendCredentials($request){
        $activeTenant = tenancy()->tenant;
        if($activeTenant && !empty($activeTenant->domains)){
            $this->emailService->sendClientAdminLoginCredentials([
                'name'      => $request['name'],
                'email'     => $request['email'],
                'password'  => $request['password'],
                'domain'    => 'http://' . $activeTenant->domains->first()->domain . '/admin'
            ]);
        }
    }
}
