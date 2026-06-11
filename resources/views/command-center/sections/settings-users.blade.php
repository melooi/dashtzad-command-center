{{-- PAGE: کاربران و دسترسی‌ها (id=page-settings-users) --}}
@php
    $pendingUsers  = $pendingUsers  ?? collect();
    $approvedUsers = $approvedUsers ?? collect();
    $rejectedUsers = $rejectedUsers ?? collect();
    $blockedUsers  = $blockedUsers  ?? collect();
    $roles = \App\Models\PanelUser::ROLES;
@endphp

<div id="page-settings-users" class="max-w-5xl mx-auto hidden pb-10 space-y-5">

    {{-- Stats row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 text-center">
            <span class="text-2xl font-bold text-amber-400">{{ $pendingUsers->count() }}</span>
            <p class="text-xs text-amber-500/80 mt-0.5 font-bold">در انتظار تأیید</p>
        </div>
        <div class="bg-brand-primary/10 border border-brand-primary/20 rounded-xl p-4 text-center">
            <span class="text-2xl font-bold text-brand-primary">{{ $approvedUsers->count() }}</span>
            <p class="text-xs text-brand-primary/80 mt-0.5 font-bold">تأیید شده</p>
        </div>
        <div class="bg-rose-500/10 border border-rose-500/20 rounded-xl p-4 text-center">
            <span class="text-2xl font-bold text-rose-400">{{ $rejectedUsers->count() }}</span>
            <p class="text-xs text-rose-500/80 mt-0.5 font-bold">رد شده</p>
        </div>
        <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 text-center">
            <span class="text-2xl font-bold text-slate-300">{{ $blockedUsers->count() }}</span>
            <p class="text-xs text-slate-500 mt-0.5 font-bold">مسدود</p>
        </div>
    </div>

    {{-- ── Pending requests ────────────────────────────────────── --}}
    @if($pendingUsers->isNotEmpty())
    <div class="bg-slate-900 border border-amber-500/20 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-amber-500/10 flex items-center gap-2.5 bg-amber-500/5">
            <i class="fa-solid fa-bell text-amber-400 animate-pulse"></i>
            <h2 class="font-bold text-amber-400 text-sm">درخواست‌های جدید</h2>
            <span class="bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $pendingUsers->count() }}</span>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($pendingUsers as $user)
            <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                 id="user-row-{{ $user->id }}">
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                        {{ $user->initial() ?: '?' }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-200 text-sm">{{ $user->name ?: 'بدون نام' }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5" dir="ltr">{{ $user->phone }}</p>
                        @if($user->department || $user->position)
                        <p class="text-xs text-slate-500 mt-0.5">{{ implode(' — ', array_filter([$user->department, $user->position])) }}</p>
                        @endif
                        @if($user->access_reason)
                        <p class="text-xs text-slate-500 mt-1 italic">"{{ Str::limit($user->access_reason, 80) }}"</p>
                        @endif
                        @if($user->referrer)
                        <p class="text-[11px] text-slate-600 mt-0.5">معرف: {{ $user->referrer }}</p>
                        @endif
                        <p class="text-[11px] text-slate-600 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2 shrink-0 w-full sm:w-auto">
                    <select id="role-select-{{ $user->id }}"
                        class="bg-slate-800 border border-slate-700 text-slate-200 text-xs rounded-lg px-2 py-1.5 outline-none focus:border-brand-primary appearance-none cursor-pointer">
                        @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ $key === 'viewer' ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button onclick="adminApprove({{ $user->id }})"
                        class="px-3 py-1.5 bg-brand-primary hover:bg-brand-primary/90 text-white text-xs font-bold rounded-lg transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-check"></i> تأیید
                    </button>
                    <button onclick="adminReject({{ $user->id }})"
                        class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-bold rounded-lg border border-rose-500/20 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-xmark"></i> رد
                    </button>
                    <button onclick="adminBlock({{ $user->id }})"
                        class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-400 text-xs rounded-lg border border-slate-700 transition-colors flex items-center gap-1">
                        <i class="fa-solid fa-ban text-[10px]"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Approved users ──────────────────────────────────────── --}}
    @if($approvedUsers->isNotEmpty())
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2.5">
            <i class="fa-solid fa-users text-brand-primary"></i>
            <h2 class="font-bold text-slate-200 text-sm">کاربران فعال</h2>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($approvedUsers as $user)
            <div class="p-4 flex items-center justify-between gap-4" id="user-row-{{ $user->id }}">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-xs shrink-0">
                        {{ $user->initial() ?: '?' }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-200 text-sm truncate">{{ $user->name }}</h3>
                            <span class="shrink-0 text-[10px] px-1.5 py-0.5 rounded bg-brand-primary/10 text-brand-primary font-bold border border-brand-primary/20">
                                {{ $user->roleName() }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5" dir="ltr">{{ $user->phone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <select onchange="adminUpdateRole({{ $user->id }}, this.value)"
                        class="bg-slate-800 border border-slate-700 text-slate-300 text-xs rounded-lg px-2 py-1.5 outline-none focus:border-brand-primary appearance-none cursor-pointer">
                        @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ $user->role === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button onclick="adminBlock({{ $user->id }})"
                        class="p-1.5 text-slate-500 hover:text-rose-400 transition-colors" title="مسدود کردن">
                        <i class="fa-solid fa-ban text-sm"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Rejected / Blocked ──────────────────────────────────── --}}
    @if($rejectedUsers->isNotEmpty() || $blockedUsers->isNotEmpty())
    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-2.5">
            <i class="fa-solid fa-ban text-slate-500"></i>
            <h2 class="font-bold text-slate-400 text-sm">رد شده و مسدود</h2>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($rejectedUsers->merge($blockedUsers) as $user)
            <div class="p-4 flex items-center justify-between gap-4 opacity-70" id="user-row-{{ $user->id }}">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-xs shrink-0">
                        {{ $user->initial() ?: '?' }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-400 text-sm truncate">{{ $user->name }}</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded {{ $user->status === 'blocked' ? 'bg-slate-800 text-slate-500' : 'bg-rose-500/10 text-rose-400' }} font-bold">
                                {{ $user->statusName() }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 mt-0.5" dir="ltr">{{ $user->phone }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if($user->status === 'blocked')
                    <button onclick="adminUnblock({{ $user->id }})"
                        class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs rounded-lg border border-slate-700 transition-colors">
                        رفع انسداد
                    </button>
                    @else
                    <button onclick="adminApproveSimple({{ $user->id }})"
                        class="px-3 py-1.5 bg-slate-800 hover:bg-brand-primary/10 text-slate-300 hover:text-brand-primary text-xs rounded-lg border border-slate-700 transition-colors">
                        تأیید مجدد
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Empty state --}}
    @if($pendingUsers->isEmpty() && $approvedUsers->isEmpty() && $rejectedUsers->isEmpty() && $blockedUsers->isEmpty())
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-12 text-center">
        <i class="fa-solid fa-user-plus text-3xl text-slate-700 mb-3 block"></i>
        <p class="text-slate-500 text-sm">هنوز هیچ کاربری ثبت‌نام نکرده است.</p>
        <p class="text-slate-600 text-xs mt-1">پس از فعال‌سازی سیستم ورود، درخواست‌های کاربران اینجا نمایش داده می‌شوند.</p>
    </div>
    @endif

</div>

<script>
const _csrfUsers = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

async function _adminPost(url, body = {}) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': _csrfUsers },
        body: JSON.stringify(body),
    });
    return res.json();
}

function _removeRow(id) {
    const row = document.getElementById('user-row-' + id);
    if (row) { row.style.transition = 'opacity .3s'; row.style.opacity = '0'; setTimeout(() => row.remove(), 300); }
}

async function adminApprove(id) {
    const role = document.getElementById('role-select-' + id)?.value ?? 'viewer';
    const data = await _adminPost('/admin/users/' + id + '/approve', { role });
    if (data.ok) { _removeRow(id); _refreshUserCounts(); }
}

async function adminApproveSimple(id) {
    const data = await _adminPost('/admin/users/' + id + '/approve', { role: 'viewer' });
    if (data.ok) _removeRow(id);
}

async function adminReject(id) {
    const reason = prompt('دلیل رد درخواست (اختیاری):') ?? '';
    const data   = await _adminPost('/admin/users/' + id + '/reject', { reason });
    if (data.ok) _removeRow(id);
}

async function adminBlock(id) {
    if (!confirm('آیا مطمئن هستید؟')) return;
    const data = await _adminPost('/admin/users/' + id + '/block');
    if (data.ok) _removeRow(id);
}

async function adminUnblock(id) {
    const data = await _adminPost('/admin/users/' + id + '/unblock');
    if (data.ok) _removeRow(id);
}

async function adminUpdateRole(id, role) {
    await _adminPost('/admin/users/' + id + '/role', { role });
}

function _refreshUserCounts() {
    // Simple page reload to sync counts — can be made reactive in the future
    const pending = document.querySelectorAll('[id^="user-row-"]').length;
    const badge   = document.querySelector('[data-pending-badge]');
    if (badge) badge.textContent = pending;
}
</script>
