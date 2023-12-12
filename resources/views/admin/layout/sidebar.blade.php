<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a @if(Session::get('page')=="dashboard") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/dashboard')}}">
            <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a @if(Session::get('page')=="update_admin_password" || Session::get('page')=="update_admin_details") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <span class="menu-title">Perbarui Data Admin</span>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/update-admin-password') }}">Perbarui Password</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_details") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/update-admin-details') }}">Perbarui Data Admin</a></li>                    
                </ul>
            </div>
        </li>        
        
        @if(Auth::guard('admin')->user()->type=="Admin Utama")
        <li class="nav-item">
            <a @if(Session::get('page')=="view_all") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-admins">
            <span class="menu-title">Pengaturan Admin</span>
            </a>
            <div class="collapse" id="ui-admins">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="view_all") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/admins') }}">Daftar Admin</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
        <a @if(Session::get('page')=="users") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <span class="menu-title">Pengaturan Pengguna</span>
            </a>
            <div class="collapse" id="ui-users">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="users") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/users') }}">User</a></li> 
                </ul>
            </div>
        </li>        
        @endif
        @if(Auth::guard('admin')->user()->type=="Penjualan")
        <li class="nav-item">
            <a @if(Session::get('page')=="categories" || Session::get('page')=="products") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <span class="menu-title">Pengaturan Produk</span>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="categories") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/categories') }}">Kategori</a></li> 
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/products') }}">Produk</a></li>   
                </ul>
            </div>
        </li>    
        <li class="nav-item">
            <a @if(Session::get('page')=="orders") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <span class="menu-title">Kelola Transaksi</span>
            </a>
            <div class="collapse" id="ui-orders">
            <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a @if(Session::get('page')=="orders") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/orders') }}">Daftar Transaksi</a></li> 
            </ul>
            </div>
        </li>
        <li class="nav-item">
        <a @if(Session::get('page')=="coupons") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-coupons" aria-expanded="false" aria-controls="ui-coupons">
            <span class="menu-title">Kupon Transaksi</span>
            </a>
            <div class="collapse" id="ui-coupons">
            <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/coupons') }}">Pengaturan Kupon</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
        <a @if(Session::get('page')=="reviews") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-reviews" aria-expanded="false" aria-controls="ui-reviews">
            <span class="menu-title">Ulasan Produk</span>
            </a>
            <div class="collapse" id="ui-reviews">
            <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a @if(Session::get('page')=="reviews") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/reviews') }}">Lihat Ulasan</a></li>
            </ul>
            </div>
        </li>
        <li class="nav-item">
        <a @if( Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-reports" aria-expanded="false" aria-controls="ui-reports">
            <span class="menu-title">Laporan Pelanggan</span>
            </a>
            <div class="collapse" id="ui-reports">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/customer-reports') }}">Tampilkan Laporan</a></li> 
                </ul>
            </div>
        </li>      
        @endif
        @if(Auth::guard('admin')->user()->type=="Customer Service")     
        <li class="nav-item">
            <a @if(Session::get('page')=="banners") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <span class="menu-title">Pengaturan Banner</span>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="banners") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/banners') }}">Slide Banner</a></li> 
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="newsletters") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-newsletters" aria-expanded="false" aria-controls="ui-newsletters">
            <span class="menu-title">Kelola Newsletter</span>
            </a>
            <div class="collapse" id="ui-newsletters">
            <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a @if(Session::get('page')=="newsletters") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/newsletters') }}">Kirim Newsletter</a></li> 
            </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="chats") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-live-chats" aria-expanded="false" aria-controls="ui-live-chats">
            <span class="menu-title">Live Chat</span>
            </a>
            <div class="collapse" id="ui-live-chats">
            <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                <li class="nav-item"> <a @if(Session::get('page')=="chats") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/live-chats') }}">Kelola Live Chat</a></li> 
            </ul>
            </div>
        </li>
        <li class="nav-item">
        <a @if(Session::get('page')=="users") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <span class="menu-title">Pengaturan Pengguna</span>
            </a>
            <div class="collapse" id="ui-users">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="users") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/users') }}">Daftar Pengguna</a></li> 
                </ul>
            </div>
        </li>       
        <li class="nav-item">
        <a @if( Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-reports" aria-expanded="false" aria-controls="ui-reports">
            <span class="menu-title">Laporan Pelanggan</span>
            </a>
            <div class="collapse" id="ui-reports">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/customer-reports') }}">Tampilkan Laporan</a></li> 
                </ul>
            </div>
        </li>   
        @endif
        @if(Auth::guard('admin')->user()->type=="Manajer")     
        <li class="nav-item">
        <a @if(Session::get('page')=="transaction_reports" || Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-reports" aria-expanded="false" aria-controls="ui-reports">
            <span class="menu-title">Laporan</span>
            </a>
            <div class="collapse" id="ui-reports">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="transaction_reports") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/transaction-reports') }}">Laporan Transaksi</a></li> 
                    <li class="nav-item"> <a @if(Session::get('page')=="customer_reports") style="background:#4B49AC !important; color: #fff !important;" @else style="background:#fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/customer-reports') }}">Laporan Pelanggan</a></li> 
                </ul>
            </div>
        </li>        
        @endif                 
    </ul>
</nav>