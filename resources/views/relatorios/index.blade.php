@extends('layouts.app')

@section('title', 'Relatórios')

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');
* {
    font-family: 'Ubuntu', Tahoma, Geneva, Verdana, sans-serif;
}
h2 {
    color: #1e3a5f;
    margin: 0;
}
.report-dashboard-container {
    max-width: 100%;
    padding: 24px 32px;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.report-dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(292px, 1fr));
    gap: 1rem;
}

.report-dashboard-card {
    min-height: 150px;
    border-radius: 5px;
    padding: 1rem;
    color: #fff;
    position: relative;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: flex-start;
    
}

.report-dashboard-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.report-dashboard-card .icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 60px;
    opacity: 0.22;
    pointer-events: none;
}
.report-dashboard-card .title {
    font-weight: 700;
    margin-bottom: 0.7rem;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}

.report-dashboard-card .btn {
    margin-top: 0.2rem;
    font-weight: 700;
    font-size: 15px;
    padding: 5px 10px;
    border-top-left-radius: 10px;
    border-bottom-right-radius: 10px;
    background: #fff;
    color: #1e3a8a;
    border: none;
    transition: background 0.2s, color 0.2s;
    cursor: pointer;
    outline: none;
}

.report-dashboard-card .btn:focus,
.report-dashboard-card .btn:hover {
    background: #a9c2e2ff;
    color: #174487;
}

.report-dashboard-card   {
    background: linear-gradient(135deg, #152b69, #061b53);
}
.report-dashboard-card .btn {
    color: #0056b3;
    border-top-right-radius: 0px;
    border-bottom-left-radius: 0px;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(22, 22, 22, 0.55);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.25s ease;
}
.modal-overlay.active {
    display: flex;
    animation: fadeIn 0.2s ease-in;
}
.modal {
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    border-radius: 0;
    width: 420px;
    max-width: 95%;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
}
.modal-header {
    background-color: #1e3a8a;
    color: #ffffff;
    padding: 10px 16px;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-body {
    padding: 16px 20px;
    background-color: #f9fafb;
}

.modal-body form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.modal-body form select{
    cursor: pointer;
}

.modal-body form div div {
    display: flex;
    gap: 10px;
}

.modal-footer {
    padding: 12px 16px;
    background-color: #f1f5f9;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: center;
    gap: 10px;
}
.btn-close-modal {
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.2s ease;
}
.btn-close-modal:hover {
    color: #dbeafe;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 0;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    width: 85px;
    height: 30px;
    text-align: center;
    border-radius: 3px;
}

.btn-primary {
    background-color: #1e3a8a;
    color: #fff;
    border-bottom: 1px solid #333 !important;
    border-right: 1px solid #333 !important;
    
}

.btn-primary:hover {
    background-color: #0f2665;
}

.btn-primary:active,
.btn-primary:focus {
    outline-offset: 2px;
    outline: 2px solid #0f2665;
}
.modal .form-control {
    border: 1px solid #cbd5e1;
    background-color: #f5f5f5;
    color: #2e3b4e;
    padding: 8px 10px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
}
.modal .form-control:focus {
    border-color: #2563eb;
    outline: none;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}

@media (max-width: 900px) {
    .report-dashboard-container { padding: 1rem 0.2rem; }
}
</style>
@endsection

@section('content')
<div class="report-dashboard-container">
    <h2>Relatórios</h2>
    <div class="report-dashboard-grid">
        <div class="report-dashboard-card blue">
            <span class="icon"><i class="fas fa-cubes"></i></span>
            <div class="title">Ativos</div>
            <button class="btn" data-modal-target="#modalAtivos">PDF</button>
        </div>
        <div class="report-dashboard-card green">
            <span class="icon"><i class="fas fa-key"></i></span>
            <div class="title">Licenças</div>
            <button class="btn" data-modal-target="#modalLicencas">PDF</button>
        </div>
        <div class="report-dashboard-card red">
            <span class="icon"><i class="fas fa-globe"></i></span>
            <div class="title">Domínios</div>
            <button class="btn" data-modal-target="#modalDominios">PDF</button>
        </div>
        <div class="report-dashboard-card yellow">
            <span class="icon"><i class="fas fa-wrench"></i></span>
            <div class="title">Manutenções</div>
            <button class="btn" data-modal-target="#modalManutencoes">PDF</button>
        </div>
    </div>

    @include('relatorios.partials.modal-ativos')
    @include('relatorios.partials.modal-dominios')
    @include('relatorios.partials.modal-licencas')
    @include('relatorios.partials.modal-manutencoes')
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalButtons = document.querySelectorAll('[data-modal-target]');
    const closeButtons = document.querySelectorAll('.btn-close-modal');
    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.modalTarget);
            if(target) target.classList.add('active');
        });
    });
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.closest('.modal-overlay').classList.remove('active');
        });
    });
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) overlay.classList.remove('active');
        });
    });
});
</script>
@endsection
