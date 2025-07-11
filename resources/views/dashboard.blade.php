@extends('layouts.app')

@section('title', 'Dashboard')

@section('action-text', 'Adicionar Usuário')
@section('action-link', route('dashboard'))
@section('search-placeholder', 'Pesquisar usuário...')
@section('search-action', route('dashboard'))

@section('content')

<div class="card">
    <h1>Gerenciamento de viagens - Coinpel</h1>
    <p>Este é o conteúdo principal do seu dashboard.</p>
    <p>Aqui você pode adicionar os widgets, gráficos e tabelas.</p>
</div>

@endsection