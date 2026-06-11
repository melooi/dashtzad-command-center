<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PanelUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PanelUserController extends Controller
{
    public function approve(int $id, Request $request): JsonResponse
    {
        $user = PanelUser::findOrFail($id);
        $role = $request->input('role', 'viewer');

        if (!array_key_exists($role, PanelUser::ROLES)) {
            return response()->json(['ok' => false, 'message' => 'نقش نامعتبر']);
        }

        $user->update([
            'status'      => 'approved',
            'role'        => $role,
            'approved_by' => session('panel_user_id'),
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        return response()->json(['ok' => true]);
    }

    public function reject(int $id, Request $request): JsonResponse
    {
        $user = PanelUser::findOrFail($id);
        $user->update([
            'status'           => 'rejected',
            'rejected_at'      => now(),
            'rejection_reason' => $request->input('reason', ''),
        ]);

        return response()->json(['ok' => true]);
    }

    public function block(int $id): JsonResponse
    {
        PanelUser::findOrFail($id)->update(['status' => 'blocked']);
        return response()->json(['ok' => true]);
    }

    public function unblock(int $id): JsonResponse
    {
        PanelUser::findOrFail($id)->update(['status' => 'approved']);
        return response()->json(['ok' => true]);
    }

    public function updateRole(int $id, Request $request): JsonResponse
    {
        $role = $request->input('role');
        if (!array_key_exists($role, PanelUser::ROLES)) {
            return response()->json(['ok' => false, 'message' => 'نقش نامعتبر']);
        }

        PanelUser::findOrFail($id)->update(['role' => $role]);
        return response()->json(['ok' => true]);
    }
}
