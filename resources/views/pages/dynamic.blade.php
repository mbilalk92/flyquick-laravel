@extends('layouts.app')

@section('meta_title', $metaTitle)
@section('meta_description', $metaDesc)
@section('canonical', '/' . ltrim($page->slug, '/'))

@section('content')
    @foreach($page->activeSections as $ps)
        @php $data = $ps->resolved_data; @endphp
        @switch($ps->section_type)
            @case('hero')         @include('sections.hero') @break
            @case('search')       @include('sections.search') @break
            @case('trust-row')    @include('sections.trust-row') @break
            @case('services')     @include('sections.services') @break
            @case('destinations') @include('sections.destinations') @break
            @case('offers')       @include('sections.offers') @break
            @case('support')      @include('sections.support') @break
            @case('payment')      @include('sections.payment') @break
            @case('reviews')      @include('sections.reviews') @break
            @case('blog-preview') @include('sections.blog-preview') @break
            @case('faq')          @include('sections.faq') @break
            @case('page-hero')    @include('sections.page-hero') @break
            @case('features')     @include('sections.features') @break
            @case('process')      @include('sections.process') @break
            @case('inner-search') @include('sections.inner-search') @break
            @case('journey-grid') @include('sections.journey-grid') @break
            @case('destinations-list') @include('sections.destinations-list') @break
            @case('location-intro')    @include('sections.location-intro') @break
            @case('packages')     @include('sections.packages') @break
            @case('rich-text')    @include('sections.rich-text') @break
            @case('contact')      @include('sections.contact') @break
            @case('about-story')  @include('sections.about-story') @break
            @case('breadcrumbs')
                <x-breadcrumbs :crumbs="$data['crumbs'] ?? []" />
            @break
        @endswitch
    @endforeach
@endsection
