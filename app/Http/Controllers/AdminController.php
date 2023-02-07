<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{
    public function admin() {
        if(!Session::has('adminAccount')) {
            return view('admin.admin_login');
        }
        return view('admin.dashboard');
    }

    public function admin_signup() {
        return view('admin.admin_signup');
    }

    public function admin_login() {
        return view('admin.admin_login');
    }

    public function create_admin_account(Request $request) {
        $this->validate($request, ['admin_name' => 'required',
                                   'email' => 'email|required|unique:clients',
                                   'password' => 'required|min:5' ]);
        $admin = new AdminAccount();
        $admin->email = $request->email;
        $admin->admin_name = $request->admin_name;
        $admin->password = bcrypt($request->password);
        $admin->status = 1;

        $admin->save();

        return redirect('/admin_login')->with('status', 'Your account has been successfully created...!!');
    }

    public function access_admin_account(Request $request) {
        $this->validate($request, ['email' => 'email|required',
                                    'password' => 'required' ]);
        $adminAccount = AdminAccount::where('status', 1)->where('email', $request->email)->first();
        
        if($adminAccount) {
            if(Hash::check($request->password, $adminAccount->password)) {
                Session::put('adminAccount', $adminAccount);
                return redirect('/admin');
            } else {
                return back()->with('status', 'Wrong email or password');
            }
        } else {
            return back()->with('status', 'You do not have an account with this email');
        } 
    }

    public function admin_logout() {
        Session::forget('adminAccount');

        return redirect('/admin_login');
    }

    public function admin_accounts_view() {
        $adminViews = AdminAccount::All();

        return view('admin.admin_accounts_view')->with('adminViews', $adminViews);
    }

    public function delete_admin($id) {
        $adminViews = AdminAccount::find($id);

        $deleted = $adminViews->delete();

        if($deleted) {
            Session::forget('adminAccount');

            return redirect('/admin_login');
        } else {
            return back()->with('status', 'The account has been successfully deleted..!!');
        }
    }

    public function activate_account($id) {
        $adminViews = AdminAccount::find($id);

        $adminViews->status = 1;
        $adminViews->update();

        return back()->with('status', 'The account has been successfully activated..!!');
    }

    public function unactivate_account($id) {
        $adminViews = AdminAccount::find($id);

        $adminViews->status = 0;
        $adminViews->update();

        if($adminViews) {
            Session::forget('adminAccount');

            return redirect('/admin_login');
        } else {
            return back()->with('status', 'The account has not been unactivated..!!');
        }
    }
}
