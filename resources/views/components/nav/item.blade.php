{{--
    Top-level sidebar nav button (not expandable).
    Props:
      $tab  — optional JS tab id to switch to
      $id   — optional element id (defaults to "nav-$tab")
--}}
@props(['tab' => null])

<button
    @if($tab) onclick="navigateTo('{{ $tab }}')" id="nav-{{ $tab }}" @endif
    {{ $attributes->merge(['class' => 'nav-btn sb-nav-btn w-full flex items-center px-3 py-2.5 rounded-xl text-text-muted hover:text-text-main hover:bg-border transition-colors group']) }}
>
    {{ $slot }}
</button>
