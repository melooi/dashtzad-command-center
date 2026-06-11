{{--
    Top-level sidebar nav button (not expandable).
    Props:
      $tab  — optional JS tab id to switch to
      $id   — optional element id (defaults to "nav-$tab")
--}}
@props(['tab' => null])

<button
    @if($tab) onclick="navigateTo('{{ $tab }}')" id="nav-{{ $tab }}" @endif
    {{ $attributes->merge(['class' => 'nav-btn sb-nav-btn w-full flex items-center px-3 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors group']) }}
>
    {{ $slot }}
</button>
