@extends('app.layouts.public')

@section('title', $title)

@section('content')

    <div class="w-full max-w-4xl bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-sm border border-outline-variant/15 mx-auto">
        <livewire:gensen-form.gensen-form.form :objId="$objId" />
    </div>
@stop
