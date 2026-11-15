@extends('layouts.app')

@section('meta_title', 'Page not found | ' . config('site.name', 'Fly Quick'))
@section('meta_description', 'The page you were looking for could not be found.')

@section('content')
<section class="not-found-page">
    <div class="site-shell not-found-inner">
        <p class="eyebrow eyebrow-light">Error 404</p>
        <h1>We couldn't find that page.</h1>
        <p>The link may be broken, or the page may have moved. Try heading back to the homepage, or get in touch if you were trying to find something specific.</p>
        <div class="hero-actions">
            <a class="button button-bright" href="{{ url('/') }}">Back to homepage</a>
            <a class="button button-ghost" href="{{ config('site.phone_href') }}">Call {{ config('site.phone') }}</a>
        </div>
    </div>
</section>
@endsection
