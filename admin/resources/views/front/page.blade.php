@extends('front.layouts.app')

@section('title', ($page->meta_title ?? $page->name) . ' — NeoGTB')
@section('description', $page->meta_description ?? '')

@section('content')
    @foreach($bricks as $brick)
        @include('front.bricks.' . $brick->brick_type, ['brick' => $brick, 'content' => $brick->content ?? [], 'settings' => $brick->settings ?? []])
    @endforeach

@endsection
