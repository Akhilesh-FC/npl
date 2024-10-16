<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
@php
use App\Models\{PermissionsUser};
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
$role = $user->role_id;

$PermissionsUser = PermissionsUser::where('id',1)->first();

$permissionsData = json_decode($PermissionsUser->permissions_id, true);

if($role == '1'){
    $rolename = 'Admin';
}elseif ($role == '2') {
    $rolename = 'SuperStokez';
} elseif ($role == '3') {
    $rolename = 'Stokez';
} elseif ($role == '4') {
    $rolename = 'Agents';
} else {
    // You can handle other cases here, if needed.
}



             $a =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('super.stokez.index').'" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Super Stockz</span></a></li>';
             $b =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('stokez.index').'" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Stockz</span></a></li>';
             $c =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('agent.index').'" aria-expanded="false"><i class="mdi mdi-account-alert"></i><span class="hide-menu">Agents</span></a></li>';
             $d =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('player.index') .'" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Players</span></a></li>';
             $e =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('transfer.index') .'" aria-expanded="false"><i class="m-r-10 mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu">Transfer Points</span></a></li>';
             $f =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('adjust.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-yin-yang"></i><span class="hide-menu">Adjust Points</span></a></li>';
             $g =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('gameSummary.index').'" aria-expanded="false"><i class="m-r-10 mdi-ungroup"></i><span class="hide-menu">Game Summary</span></a></li>';
             $h =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('ChangePasswordIndex').'" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Change Password</span></a></li>';
             $i =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('setting.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-settings"></i><span class="hide-menu">Setting </span></a></li>';
             $j =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('gameHistory.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-battery-outline"></i><span class="hide-menu">Game History </span></a></li>';
             $k =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('turnOverReport.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-subdirectory-arrow-right"></i><span class="hide-menu">Turn Over Report</span></a></li>';
             $l =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('playerHistory.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-account-multiple"></i><span class="hide-menu">Player History</span></a></li>';
             $m =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('transactionReport.index').'" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Transaction Report</span></a></li>';
             $n =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('idPasswordChange.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-rotate-3d"></i><span class="hide-menu">ID/Password Change</span></a></li>';
             $o =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('blockUnblock.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-ungroup"></i><span class="hide-menu">Block/Unblock Chain</span></a></li>';
             $p =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('assignRole.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-recycle"></i><span class="hide-menu">Assign Role</span></a></li>';
             $q =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('resultHistory.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-gender-transgender"></i><span class="hide-menu">Result History</span></a></li>';
             $r =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('instantWin.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-trophy"></i><span class="hide-menu">Instant Win</span></a></li>';
             $s =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('security.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-access-point-network"></i><span class="hide-menu">Security</span></a></li>';
             $t =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('playerSecurity.index').'" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Player Security</span></a></li>';
             $u =  '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="'.route('stokezSetting.index').'" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Stokez Setting</span></a></li>';
             
              $v = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Andar Bahar</span></a><ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item"> <a href="'.route('andar_bahar.bets').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets History</span></a> </li>
                <li class="sidebar-item"><a href="'.route('andar_bahar.betresult').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i>  <span class="hide-menu">Bet Result</span></a></li>
                <li class="sidebar-item"><a href="'.route('andar_bahar.bet').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i>  <span class="hide-menu">Bet</span></a></li>
                </ul> 
            </li>';
        
        $w = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Lucky12</span></a>
        <ul aria-expanded="false" class="collapse first-level">
        
        <li class="sidebar-item"><a href="'.route('lucky12.bets').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i>  <span class="hide-menu">Bets History</span></a></li>
        <li class="sidebar-item"> <a href="'.route('lucky12.results').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets Results</span></a></li>
        <li class="sidebar-item"> <a href="'.route('lucky12.index').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets</span></a></li>
        </ul> 
        </li>';
        
         $x = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Lucky16</span></a>
        <ul aria-expanded="false" class="collapse first-level">
        <li class="sidebar-item"><a href="'.route('lucky16.bets').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i>  <span class="hide-menu">Bets History</span></a></li>
        <li class="sidebar-item"> <a href="'.route('lucky16.results').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets Results</span></a></li>
        <li class="sidebar-item"> <a href="'.route('lucky16.index').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets</span></a></li>
        </ul> 
        </li>';
        
        $y = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Spin</span></a>
        <ul aria-expanded="false" class="collapse first-level">
        <li class="sidebar-item"> <a href="'.route('spin.adminresults').'" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Admin Results</span></a></li>
        <li class="sidebar-item"><a href="'.route('spin.bets').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i>  <span class="hide-menu">Bets History</span></a></li>
        <li class="sidebar-item"> <a href="'.route('spin.results').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets Results</span></a></li>
        <li class="sidebar-item"> <a href="'.route('spin.bet').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i> <span class="hide-menu">Bets</span></a></li>
        </ul> 
        </li>';
        
        $z = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Timmer 36</span></a>
        <ul aria-expanded="false" class="collapse first-level">
        <li class="sidebar-item"> <a href="'.route('timmer36.bets').'" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets History</span></a></li>
        <li class="sidebar-item"> <a href="'.route('timmer36.results').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets Results</span></a></li>
        <li class="sidebar-item"> <a href="'.route('timmer36.bet').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets</span></a></li>
        </ul> 
        </li>';
        
         $a1 = '<li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Triple Chance</span></a>
        <ul aria-expanded="false" class="collapse first-level">
        <li class="sidebar-item"> <a href="'.route('triplechance.bets').'" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets History </span></a></li>
        <li class="sidebar-item"> <a href="'.route('triplechance.results').'" class="sidebar-link"> <i class="mdi mdi-emoticon"></i><span class="hide-menu">Bets Results</span></a></li>
        </ul> 
        </li>';


            
@endphp


        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {!! in_array(1, $permissionsData[$rolename]) ? $a : '' !!}
                {!! in_array(3, $permissionsData[$rolename]) ? $b : '' !!}
                {!! in_array(5, $permissionsData[$rolename]) ? $c : '' !!}
                {!! in_array(7, $permissionsData[$rolename]) ? $d : '' !!}
                {!! in_array(9, $permissionsData[$rolename]) ? $e : '' !!}
                {!! in_array(10, $permissionsData[$rolename]) ? $f : '' !!}
                {!! in_array(11, $permissionsData[$rolename]) ? $g : '' !!}
                {!! in_array(12, $permissionsData[$rolename]) ? $h : '' !!}
                {!! in_array(13, $permissionsData[$rolename]) ? $i : '' !!}
                {!! in_array(14, $permissionsData[$rolename]) ? $j : '' !!}
                {!! in_array(15, $permissionsData[$rolename]) ? $k : '' !!}
                {!! in_array(16, $permissionsData[$rolename]) ? $l : '' !!}
                {!! in_array(17, $permissionsData[$rolename]) ? $m : '' !!}
                {!! in_array(18, $permissionsData[$rolename]) ? $n : '' !!}
                {!! in_array(19, $permissionsData[$rolename]) ? $o : '' !!}
                {!! in_array(20, $permissionsData[$rolename]) ? $p : '' !!}
                {!! in_array(21, $permissionsData[$rolename]) ? $q : '' !!}
                {!! in_array(22, $permissionsData[$rolename]) ? $r : '' !!}
                {!! in_array(23, $permissionsData[$rolename]) ? $s : '' !!}
                {!! in_array(24, $permissionsData[$rolename]) ? $t : '' !!}
                {!! in_array(25, $permissionsData[$rolename]) ? $u : '' !!}
                {!! in_array(26, $permissionsData[$rolename]) ? $v : '' !!}
                {!! in_array(27, $permissionsData[$rolename]) ? $w : '' !!}
                {!! in_array(28, $permissionsData[$rolename]) ? $x : '' !!}
                {!! in_array(29, $permissionsData[$rolename]) ? $y : '' !!}
                {!! in_array(30, $permissionsData[$rolename]) ? $z : '' !!}
                {!! in_array(31, $permissionsData[$rolename]) ? $a1 : '' !!}
                
               

                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('super.stokez.index') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Super Stockz</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('stokez.index') }}" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Stockz</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('agent.index') }}" aria-expanded="false"><i class="mdi mdi-account-alert"></i><span class="hide-menu">Agents</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('player.index') }}" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Players</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('transfer.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-arrow-right-bold-circle"></i><span class="hide-menu">Transfer Points</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('adjust.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-yin-yang"></i><span class="hide-menu">Adjust Points</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('gameSummary.index') }}" aria-expanded="false"><i class="m-r-10 mdi-ungroup"></i><span class="hide-menu">Game Summary</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('changePassword.index') }}" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Change Password</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('setting.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-settings"></i><span class="hide-menu">Setting </span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('gameHistory.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-battery-outline"></i><span class="hide-menu">Game History </span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('turnOverReport.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-subdirectory-arrow-right"></i><span class="hide-menu">Turn Over Report</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('playerHistory.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-account-multiple"></i><span class="hide-menu">Player History</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('transactionReport.index') }}" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Transaction Report</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('idPasswordChange.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-rotate-3d"></i><span class="hide-menu">ID/Password Change</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('blockUnblock.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-ungroup"></i><span class="hide-menu">Block/Unblock Chain</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('assignRole.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-recycle"></i><span class="hide-menu">Assign Role</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('resultHistory.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-gender-transgender"></i><span class="hide-menu">Result History</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('instantWin.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-trophy"></i><span class="hide-menu">Instant Win</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('security.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-access-point-network"></i><span class="hide-menu">Security</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('playerSecurity.index') }}" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Player Security</span></a></li> --}}
                {{-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('stokezSetting.index') }}" aria-expanded="false"><i class="m-r-10 mdi mdi-settings-box"></i><span class="hide-menu">Stokez Setting</span></a></li> --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->



