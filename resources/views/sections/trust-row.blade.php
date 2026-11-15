@php $items = $data['items'] ?? [
    ['icon'=>'fa-solid fa-circle-check','title'=>'IATA accredited','text'=>'Professional travel support'],
    ['icon'=>'fa-solid fa-flag','title'=>'Australian owned','text'=>'Serving travellers since 2021'],
    ['icon'=>'fa-solid fa-clock','title'=>'Extended hours','text'=>'Help across seven days'],
    ['icon'=>'fa-solid fa-credit-card','title'=>'Flexible ways to pay','text'=>'Options for eligible customers'],
]; @endphp
<section class="trust-row">
    <div class="site-shell trust-grid">
        @foreach($items as $item)
        <div><span><i class="{{ $item['icon'] ?? 'fa-solid fa-circle-check' }}" aria-hidden="true"></i></span><p><strong>{{ $item['title'] }}</strong>{{ $item['text'] }}</p></div>
        @endforeach
    </div>
</section>
