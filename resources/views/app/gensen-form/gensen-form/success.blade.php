@extends('app.layouts.public')

@section('title', 'Form Gensen')


@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <div class="success-card">
                <!-- Animated Success Icon -->
                <div class="success-icon-wrapper">
                    <div class="success-icon">
                    <div class="success-icon-circle">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"></circle>
                            <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
                        </svg>
                    </div>
                    </div>
                </div>
                <!-- Success Message -->
                <div class="success-content">
                    <h1 class="success-title">Pendaftaran Berhasil!</h1>
                    <p class="success-subtitle">Terima kasih telah mengisi formulir registrasi Exata Indonesia</p>
                    <div class="success-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div class="detail-text">
                            <h3>Data Tersimpan</h3>
                            <p>Informasi Anda telah berhasil disimpan di sistem kami</p>
                        </div>
                    </div>
                    <livewire:gensen-form.gensen-form.registered-list :token="$objId">
                    <livewire:gensen-form.gensen-form.whatsapp-pic :token="$objId" :phone="$phone">
                    </div>
                    <div class="success-info">
                    <div class="info-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <p>Jika ada pertanyaan, silakan hubungi tim support kami</p>
                    </div>
                    </div>
                    <div class="success-footer">
                    <p class="timestamp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Dikirim pada {{\Carbon\Carbon::now()->translatedFormat('d F Y, H:i');}} WIB
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
    @keyframes scaleIn {
    0% {
    transform: scale(0);
    opacity: 0;
    }
    50% {
    transform: scale(1.1);
    }
    100% {
    transform: scale(1);
    opacity: 1;
    }
    }
    @keyframes slideUp {
    0% {
    transform: translateY(30px);
    opacity: 0;
    }
    100% {
    transform: translateY(0);
    opacity: 1;
    }
    }
    @keyframes drawCircle {
    0% {
    stroke-dashoffset: 166;
    }
    100% {
    stroke-dashoffset: 0;
    }
    }
    @keyframes drawCheck {
    0% {
    stroke-dashoffset: 48;
    }
    100% {
    stroke-dashoffset: 0;
    }
    }
    @keyframes fadeIn {
        0% {
        opacity: 0;
        }
        100% {
        opacity: 1;
        }
    }
    body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    .success-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    padding: 60px 40px;
    animation: slideUp 0.6s ease-out;
    }
    .success-icon-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
    }
    .success-icon {
    position: relative;
    }
    .success-icon-circle {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.4);
    }
    .checkmark {
    width: 80px;
    height: 80px;
    }
    .checkmark-circle {
    stroke: white;
    stroke-width: 3;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: drawCircle 0.6s ease-out 0.3s forwards;
    }
    .checkmark-check {
    stroke: white;
    stroke-width: 3;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: drawCheck 0.4s ease-out 0.6s forwards;
    }
    .success-content {
    text-align: center;
    }
    .success-title {
    font-size: 42px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 16px;
    animation: fadeIn 0.6s ease-out 0.4s both;
    }
    .success-subtitle {
    font-size: 18px;
    color: #718096;
    margin-bottom: 48px;
    animation: fadeIn 0.6s ease-out 0.5s both;
    }
    .success-details {
    margin-bottom: 40px;
    }
    .detail-item {
    display: flex;
    align-items: flex-start;
    text-align: left;
    padding: 24px;
    margin-bottom: 16px;
    background: #f7fafc;
    border-radius: 16px;
    transition: all 0.3s ease;
    animation: fadeIn 0.6s ease-out both;
    }
    .detail-item:nth-child(1) {
    animation-delay: 0.6s;
    }
    .detail-item:nth-child(2) {
    animation-delay: 0.7s;
    }
    .detail-item:nth-child(3) {
    animation-delay: 0.8s;
    }
    .detail-item:hover {
    background: #edf2f7;
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .detail-icon {
    width: 48px;
    height: 48px;
    min-width: 48px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    }
    .detail-icon svg {
    color: white;
    }
    .detail-text h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 8px 0;
    }
    .detail-text p {
    font-size: 14px;
    color: #718096;
    margin: 0;
    line-height: 1.6;
    }
    .whatsapp-link {
    display: inline-block;
    font-size: 14px;
    color: #fff;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 0;
    line-height: 1.6;
    }
    .whatsapp-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    text-decoration: none;
    color: #fff;
    }
    .success-info {
    margin-bottom: 32px;
    animation: fadeIn 0.6s ease-out 0.9s both;
    }
    .info-box {
    background: linear-gradient(135deg, #fef5e7 0%, #fdebd0 100%);
    border-left: 4px solid #f39c12;
    padding: 20px 24px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 16px;
    }
    .info-box svg {
    color: #f39c12;
    min-width: 20px;
    }
    .info-box p {
    margin: 0;
    color: #7d6608;
    font-size: 14px;
    font-weight: 500;
    }
    .success-footer {
    padding-top: 32px;
    border-top: 2px solid #e2e8f0;
    animation: fadeIn 0.6s ease-out 1s both;
    }
    .timestamp {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: #a0aec0;
    font-size: 14px;
    margin: 0;
    }
    .timestamp svg {
    color: #cbd5e0;
    }
    @media (max-width: 768px) {
    .success-card {
    padding: 40px 24px;
    border-radius: 16px;
    }
    .success-title {
    font-size: 32px;
    }
    .success-subtitle {
    font-size: 16px;
    }
    .detail-item {
    padding: 20px;
    }
    .detail-icon {
    width: 40px;
    height: 40px;
    min-width: 40px;
    }
    .detail-text h3 {
    font-size: 16px;
    }
    .detail-text p {
    font-size: 13px;
    }
    .success-icon-circle {
    width: 100px;
    height: 100px;
    }
    .checkmark {
    width: 70px;
    height: 70px;
    }
    }
    @media (max-width: 480px) {
    .success-card {
    padding: 32px 20px;
    }
    .success-title {
    font-size: 28px;
    }
    .detail-item {
    flex-direction: column;
    text-align: center;
    }
    .detail-icon {
    margin: 0 auto 16px;
    }
    }
    </style>       
@endpush
