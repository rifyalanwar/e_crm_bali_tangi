<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        $pesanan_baru = \DB::table('orders')->where('order_status', '!=', 'Lunas')->count();
        $pelanggan_baru = \DB::table('users')->whereRaw("users.id not in(select o.user_id from orders o)")->count();
        $total_transaksi_perlu_lunas = \DB::table('orders')->where('order_status', 'Lunas')->count();
        $total_transaksi_berhasil = \DB::table('orders')->where('order_status', 'Selesai')->count();
        return view('admin.dashboard', compact('pesanan_baru', 'pelanggan_baru', 'total_transaksi_perlu_lunas', 'total_transaksi_berhasil'));
    }

    public function updateAdminPassword(Request $request)
    {
        Session::put('page', 'update_admin_password');
        if ($request->isMethod('post')) {
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            // Check if current password enterted by admin is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // Check if new password is matching with confirm password
                if ($data['confirm_password'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password berhasil diperbarui');
                } else {
                    return redirect()->back()->with('error_message', 'Password baru dan password konfirmasi tidak cocok');
                }
            } else {
                return redirect()->back()->with('error_message', 'Password sekarang yang dimasukkan salah');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        /*echo "<pre>"; print_r($data); die;*/
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'update_admin_details');
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];

            $customMessages = [
                'admin_name.required' => 'Nama harus dimasukkan',
                'admin_name.regex' => 'Nama yang dimasukkan harus valid',
                'admin_mobile.required' => 'Nomor telepon harus dimasukkan',
                'admin_mobile.numeric' => 'Nomor telepon yang dimasukkan harus valid',
            ];

            $this->validate($request, $rules, $customMessages);


            // Update Admin Details
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['email' => $data['email'], 'type' => $data['type'], 'name' => $data['admin_name'], 'mobile' => $data['admin_mobile']]);
            return redirect()->back()->with('success_message', 'Data admin berhasil diperbarui');
        }
        return view('admin.settings.update_admin_details');
    }

    public function addAdmin(Request $request)
    {
        Session::put('page', 'add_admin');
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'password' => 'required|min:8',
                'mobile' => 'required|numeric',
                'email' => 'required|email|max:150|unique:admins',
            ];

            $customMessages = [
                'email.required' => 'E-mail harus dimasukkan',
                'email.regex' => 'E-mail yang dimasukkan harus valid',
                'password.required' => 'Password harus dimasukkan',
                'name.required' => 'Nama harus dimasukkan',
                'name.regex' => 'Nama yang dimasukkan harus valid',
                'mobile.required' => 'Nomor telepon harus dimasukkan',
                'mobile.numeric' => 'Nomor telepon yang dimasukkan harus valid',
            ];

            $this->validate($request, $rules, $customMessages);

            // Add Admin to Table
            $admin = new Admin;
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->type = $data['type'];
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->status = 1;
            $admin->save();

            return redirect()->back()->with('success_message', 'Data admin berhasil ditambahkan');
        }
        return view('admin.admins.add_admin');
    }

    public function login(Request $request)
    {
        // echo $password = Hash::make('123456'); die;

        if ($request->isMethod('post')) {
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                // Add Custom Messages here
                'email.required' => 'E-mail harus dimasukkan',
                'email.email' => 'E-mail yang dimasukkan harus valid',
                'password.required' => 'Password harus dimasukkan',
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'E-mail atau password yang dimasukkan salah');
            }
        }
        return view('admin.login');
    }

    public function admins($type = null)
    {
        $admins = Admin::query();
        if (!empty($type)) {
            $admins = $admins->where('type', $type);
            $title = ucfirst($type) . "s";
            Session::put('page', 'view_' . strtolower($title));
        } else {
            $title = "All Admins/Subadmins/";
            Session::put('page', 'view_all');
        }
        $admins = $admins->get()->toArray();
        /*dd($admins);*/
        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }

    public function updateAdminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'admin_id' => $data['admin_id']]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
