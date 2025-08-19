<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <h1><strong>{{ $title }}</strong></h1>
            <p>{{ $subtitle }}</p>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.hero {
    background: linear-gradient(135deg, #FAFAFA 0%, #F0F7F0 100%);
    padding: 20px 0px 20px 0px; /* Reduced height to 50% */
    padding-top: 40px;
    /* margin-top: 50px; */
    position: relative;
    overflow: hidden;
    background: #dbe797;
    /* border: 2px solid red; */
    min-height: 25vh; /* Ensure it takes at least 50% of viewport height */
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('data:image/svg+xml,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="none"/><path d="M0 0L100 100M100 0L0 100" stroke="%23E0E0E0" stroke-width="0.5" opacity="0.3"/></svg>');
    background-size: 40px 40px;
    opacity: 0.3;
    z-index: 0;
}

.hero-content {
    position: relative;
    /* background: #aef094; */
    z-index: 1;
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 20vh; /* Ensure content takes up the full height */
}

.hero-content h1 {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
    animation: fadeInDown 0.8s ease-out;
}

.hero-content p {
    font-size: 1.25rem;
    color: #555;
    margin-bottom: 2rem;
    animation: fadeInUp 0.8s ease-out;
}

/* Responsive Design */
@media (max-width: 992px) {
    .hero {
        padding: 60px 0 30px; /* Reduced height for medium screens */
    }

    .hero-content h1 {
        font-size: 2rem;
    }

    .hero-content p {
        font-size: 1.1rem;
    }
}

@media (max-width: 768px) {
    .hero {
        padding: 50px 0 25px; /* Reduced height for mobile */
    }

    .hero-content h1 {
        font-size: 1.75rem;
    }

    .hero-content p {
        font-size: 1rem;
    }
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
