@props(['crumbs' => []])
<nav class="breadcrumbs site-shell">
    <a href="/">Home</a>
    @foreach($crumbs as $crumb)
        @php
            // Support both named keys {label,url} and legacy indexed [label,url]
            $label = $crumb['label'] ?? $crumb[0] ?? '';
            $url   = $crumb['url']   ?? $crumb[1] ?? null;
        @endphp
        <span>›</span>
        @if($url)
            <a href="{{ $url }}">{{ $label }}</a>
        @else
            <span>{{ $label }}</span>
        @endif
    @endforeach
</nav>
