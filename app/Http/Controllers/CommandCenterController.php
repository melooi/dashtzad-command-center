<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\PanelUser;
use Illuminate\View\View;

class CommandCenterController extends Controller
{
    public function index(): View
    {
        try {
            $grouped      = PanelUser::latest()->get()->groupBy('status');
            $authEnabled  = AppSetting::get('panel_auth_enabled', '0') === '1';
            $currentUser  = PanelUser::find(session('panel_user_id'));
        } catch (\Throwable) {
            $grouped     = collect();
            $authEnabled = false;
            $currentUser = null;
        }

        return view('command-center', [
            'pendingUsers'  => $grouped->get('pending_approval', collect()),
            'approvedUsers' => $grouped->get('approved', collect()),
            'rejectedUsers' => $grouped->get('rejected', collect()),
            'blockedUsers'  => $grouped->get('blocked', collect()),
            'authEnabled'   => $authEnabled,
            'currentUser'   => $currentUser,
        ]);
    }
}
