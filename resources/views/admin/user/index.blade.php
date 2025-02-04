@extends('layouts.admin')
@section('title', 'Usuários')
@section('conteudo')
    <div class="content">
        <div class="container-fluid">
            <livewire:admin.user-component />
        </div>
    </div>
@endsection
