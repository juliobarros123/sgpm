@extends('layouts.admin')
@section('title', 'Dashboard')
@section('conteudo')
    <div class="content">
        <div class="container-fluid">
            <livewire:admin.dashboard-component />
        </div>
    </div>
@endsection
