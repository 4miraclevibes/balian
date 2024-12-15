@extends('layouts.landing.main')

@section('style')
<style>
    /* Header Section */
    .faq-header {
        background: #28a745;
        padding: 20px;
        color: white;
        border-radius: 0 0 20px 20px;
    }

    .faq-header h1 {
        font-size: 1.5rem;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .faq-header p {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    /* FAQ Section */
    .faq-container {
        padding: 16px;
    }
    
    .faq-item {
        background: white;
        border-radius: 12px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
    }
    
    .faq-question {
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        color: #333;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    /* Style untuk pertanyaan yang aktif */
    .faq-question.active {
        background-color: #28a745;
        color: white;
        border-radius: 12px 12px 0 0;
        font-weight: 600;
    }

    /* Style untuk icon saat aktif */
    .faq-question.active .faq-icon {
        transform: rotate(180deg);
        color: white;
    }
    
    .faq-answer {
        display: none;
        padding: 16px;
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        background-color: #f8f9fa;
        border-radius: 0 0 12px 12px;
    }
    
    .faq-question.active + .faq-answer {
        display: block;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .faq-icon {
        transition: transform 0.3s ease;
        font-size: 1.2rem;
        color: #28a745;
    }

    /* WhatsApp Section */
    .whatsapp-section {
        margin: 24px 16px;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        text-align: center;
    }
    
    .whatsapp-icon {
        color: #25d366;
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .whatsapp-section h4 {
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .whatsapp-section p {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 16px;
    }

    .whatsapp-section .btn-success {
        background: #25d366;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        width: 100%;
        max-width: 250px;
    }

    .phone-number {
        margin-top: 12px;
        font-size: 0.9rem;
        color: #666;
    }
</style>
@endsection

@section('content')
<div class="faq-header text-center">
    <h1>Pusat Bantuan</h1>
    <p>Temukan jawaban untuk pertanyaan Anda di sini</p>
</div>

<div class="faq-container">
    @foreach($faqs as $faq)
    <div class="faq-item">
        <div class="faq-question">
            <span>{{ $faq->question }}</span>
            <i class="bi bi-chevron-down faq-icon"></i>
        </div>
        <div class="faq-answer">
            {!! nl2br(e($faq->answer)) !!}
        </div>
    </div>
    @endforeach

    <div class="whatsapp-section">
        <i class="bi bi-whatsapp whatsapp-icon"></i>
        <h4>Masih Butuh Bantuan?</h4>
        <p>Tim kami siap membantu Anda</p>
        <a href="https://wa.me/6285171742037" 
           target="_blank" 
           class="btn btn-success">
            <i class="bi bi-whatsapp me-2"></i>
            Hubungi Kami
        </a>
        <div class="phone-number">
            <i class="bi bi-telephone-fill me-2"></i>
            0851-7174-2037
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const isActive = question.classList.contains('active');
            
            faqQuestions.forEach(q => {
                q.classList.remove('active');
            });
            
            if (!isActive) {
                question.classList.add('active');
            }
        });
    });
});
</script>
@endsection
