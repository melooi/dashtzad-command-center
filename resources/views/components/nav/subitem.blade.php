{{--
    Sub-item inside a nav group.
    Props:
      $tab — optional JS tab id
--}}
@props(['tab' => null])

<button
    @if($tab) onclick="navigateTo('{{ $tab }}')" id="nav-{{ $tab }}" @endif
    class="nav-btn w-full text-right flex items-center gap-2 px-3 py-2 text-xs font-medium
           text-slate-400 hover:text-white hover:bg-slate-800/50 rounded-lg transition-colors"
>
    {{ $slot }}
</button>
