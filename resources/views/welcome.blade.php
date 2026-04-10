<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSys - Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chat-bot.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">
</head>
<body>
    <!-- Language Selector -->
    <div class="language-selector">
        <img src="https://flagcdn.com/w20/fr.png" alt="Français" onclick="changeLanguage('fr')">
        <img src="https://flagcdn.com/w20/ar.png" alt="العربية" onclick="changeLanguage('ar')">
        <span class="ms-2" id="langText">Français</span>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                Health<span>Sys</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil" data-lang-key="nav_home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services" data-lang-key="nav_services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" data-lang-key="nav_about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact" data-lang-key="nav_contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-custom-outline ms-3" href="{{ route('login') }}" style="border-color: var(--secondary-color); color: var(--secondary-color);">
                            <i class="fas fa-sign-in-alt"></i> <span data-lang-key="login">Se connecter</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="accueil">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 animate" data-aos="fade-right" data-aos-duration="1000">
                    <h1 data-lang-key="hero_title">Bienvenue sur <span style="color: var(--secondary-color);">HealthSys</span></h1>
                    <p data-lang-key="hero_desc">Système intelligent de gestion de cabinet médical. Simple, rapide et efficace pour la gestion des patients, rendez-vous et dossiers médicaux.</p>
                    <div>
                        <a href="{{ route('login') }}" class="btn btn-custom-primary">
                            <i class="fas fa-sign-in-alt"></i> <span data-lang-key="login_btn">Se connecter</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-custom-outline">
                            <i class="fas fa-user-plus"></i> <span data-lang-key="register_btn">S'inscrire (Patient)</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 text-center animate" data-aos="fade-left" data-aos-duration="1000">
                    <img src="https://www.vudailleurs.com/wp-content/uploads/2016/11/dididi-e1478470996278.jpg" alt="Doctors" class="img-fluid" style="max-height: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- About Home Section -->
    <section id="about-home" class="about-home section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-center">
                <!-- About Images -->
                <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="about-images">
                        <div class="image-stack">
                            <div class="image-main">
                                <img src="{{ asset('assets/img/img1.jpg') }}" alt="Consultation médicale" class="img-fluid">
                            </div>
                            <div class="image-overlay">
                                <img src="{{ asset('assets/img/img6.jpg') }}" alt="Suivi santé numérique" class="img-fluid">
                            </div>
                        </div>
                        <div class="floating-badge">
                            <div class="badge-icon">
                                <i class="fa-solid fa-heart-pulse"></i>
                            </div>
                            <div class="badge-info">
                                <span class="badge-title" data-lang-key="about_badge_title">Expertise Médicale</span>
                                <span class="badge-subtitle" data-lang-key="about_badge_subtitle">Soins Numériques</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- About Content -->
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                    <div class="about-content">
                        <div class="section-header">
                            <span class="subtitle" data-lang-key="about_subtitle">Plateforme de Santé Nouvelle Génération</span>
                            <h2 data-lang-key="about_title">Transformer les Soins avec la Médecine Digitale</h2>
                        </div>

                        <p data-lang-key="about_p1">HealthSys offre aux patients et aux professionnels de santé une plateforme complète de télémedecine, de dossiers médicaux sécurisés et de suivi personnalisé. Notre solution vous permet de prendre rendez-vous instantanément, de suivre vos indicateurs de santé et de connecter avec des spécialistes de confiance.</p>

                        <p data-lang-key="about_p2">Rejoignez des milliers de patients et de professionnels de santé qui font confiance à HealthSys pour simplifier les soins, améliorer les résultats et rendre la santé de qualité accessible partout, à tout moment.</p>

                        <div class="features-grid">
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-video"></i>
                                </div>
                                <div class="feature-content">
                                    <h4 data-lang-key="feature_telemedicine_title">Télémedecine & Rendez-vous</h4>
                                    <p data-lang-key="feature_telemedicine_desc">Consultez des médecins certifiés en visio ou en présentiel sans temps d'attente prolongés</p>
                                </div>
                            </div>
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-file-medical"></i>
                                </div>
                                <div class="feature-content">
                                    <h4 data-lang-key="feature_records_title">Dossiers Médicaux Sécurisés</h4>
                                    <p data-lang-key="feature_records_desc">Stockez, accédez et partagez votre historique médical en toute sécurité entre professionnels</p>
                                </div>
                            </div>
                            <div class="feature-item" data-aos="fade-up" data-aos-delay="600">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </div>
                                <div class="feature-content">
                                    <h4 data-lang-key="feature_specialists_title">Réseau de Spécialistes</h4>
                                    <p data-lang-key="feature_specialists_desc">Connectez-vous avec des médecins, nutritionnistes et professionnels de santé vérifiés</p>
                                </div>
                            </div>
                        </div>

                        <div class="about-actions">
                            <a href="#" class="btn-discover">
                                <span data-lang-key="about_discover_btn">Découvrir HealthSys</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-box">
                        <div class="stat-number purecounter" 
                            data-purecounter-start="0" 
                            data-purecounter-end="500" 
                            data-purecounter-duration="2">0</div>
                        <p data-lang-key="stat_patients">Patients satisfaits</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-box">
                        <div class="stat-number purecounter" 
                            data-purecounter-start="0" 
                            data-purecounter-end="20" 
                            data-purecounter-duration="2">0</div>
                        <p data-lang-key="stat_doctors">Médecins experts</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-box">
                        <div class="stat-number purecounter" 
                            data-purecounter-start="0" 
                            data-purecounter-end="1000" 
                            data-purecounter-duration="2">0</div>
                        <p data-lang-key="stat_appointments">Rendez-vous traités</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="400">
                    <div class="stat-box">
                        <div class="stat-number">24/7</div>
                        <p data-lang-key="stat_support">Support disponible</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="services">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold" data-lang-key="services_title">Nos Services</h2>
                <p class="text-muted" data-lang-key="services_desc">Une solution complète pour la gestion de votre cabinet médical</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4 data-lang-key="service1_title">Gestion des rendez-vous</h4>
                        <p data-lang-key="service1_desc">Planification et suivi des consultations facilement</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 data-lang-key="service2_title">Dossiers patients</h4>
                        <p data-lang-key="service2_desc">Historique médical, ordonnances, examens</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h4 data-lang-key="service3_title">Facturation</h4>
                        <p data-lang-key="service3_desc">Gestion des paiements et factures</p>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 data-lang-key="service4_title">Statistiques</h4>
                        <p data-lang-key="service4_desc">Analyses et rapports détaillés</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alt Services Section -->
    <section id="alt-services" class="alt-services section my-5">
        <div class="container">
            <div class="row justify-content-around gy-4">
                <!-- Services Image -->
                <div class="features-image col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <img src="{{ asset('assets/img/img5.jpg') }}" alt="Services de Santé HealthSys">
                </div>

                <!-- Services Content -->
                <div class="col-lg-5 d-flex flex-column justify-content-center" data-aos="fade-left" data-aos-delay="200">
                    <h3 data-lang-key="alt_services_title">Engagés pour l'Excellence et l'Innovation Médicale</h3>
                    <p data-lang-key="about_desc1">HealthSys est une plateforme moderne de gestion de cabinet médical conçue pour optimiser le travail des professionnels de santé.</p>
                    <p data-lang-key="about_desc2">Notre solution permet de centraliser toutes les opérations : gestion des patients, rendez-vous, facturation, dossiers médicaux et rapports statistiques.</p>
                    
                    <!-- Icon Box 1 -->
                    <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="300">
                        <i class="fa-solid fa-video flex-shrink-0"></i>
                        <div>
                            <h4><a href="#" class="stretched-link" data-lang-key="alt_service1_title">Télémedecine & Consultations Virtuelles</a></h4>
                            <p data-lang-key="alt_service1_desc">Consultez des médecins certifiés depuis chez vous. Notre plateforme de télémedecine vous permet d'obtenir des conseils médicaux professionnels sans déplacement, 24h/24 et 7j/7.</p>
                        </div>
                    </div>

                    <!-- Icon Box 2 (REPLACED: Removed AI Diagnostics) -->
                    <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="400">
                        <i class="fa-solid fa-heart-pulse flex-shrink-0"></i>
                        <div>
                            <h4><a href="#" class="stretched-link" data-lang-key="alt_service2_title">Suivi Santé Personnalisé</a></h4>
                            <p data-lang-key="alt_service2_desc">Suivez vos indicateurs de santé, recevez des rappels de médicaments et des conseils personnalisés pour mieux gérer votre bien-être au quotidien.</p>
                        </div>
                    </div>

                    <!-- Icon Box 3 -->
                    <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="500">
                        <i class="fa-solid fa-file-medical-alt flex-shrink-0"></i>
                        <div>
                            <h4><a href="#" class="stretched-link" data-lang-key="alt_service3_title">Dossiers Médicaux Sécurisés</a></h4>
                            <p data-lang-key="alt_service3_desc">Accédez à vos dossiers médicaux en toute sécurité, partagez-les avec vos médecins et gardez un historique complet de votre santé dans un environnement crypté et conforme aux normes.</p>
                        </div>
                    </div>

                    <!-- Icon Box 4 -->
                    <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="600">
                        <i class="fa-solid fa-user-md flex-shrink-0"></i>
                        <div>
                            <h4><a href="#" class="stretched-link" data-lang-key="alt_service4_title">Réseau de Spécialistes Certifiés</a></h4>
                            <p data-lang-key="alt_service4_desc">Connectez-vous avec des médecins spécialistes, nutritionnistes, psychologues et autres professionnels de santé vérifiés pour un accompagnement complet de votre bien-être.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section my-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold" data-lang-key="contact_title">Contactez-nous</h2>
                <p class="text-muted" data-lang-key="contact_desc">Une question ? Besoin d'assistance ? Notre équipe est à votre disposition.</p>
            </div>

            <!-- Contact Info Cards -->
            <div class="row gy-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="fa-solid fa-location-dot"></i>
                        <h3 data-lang-key="contact_address_title">Adresse</h3>
                        <p data-lang-key="contact_address">Sidi Bouzid</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="fa-solid fa-phone"></i>
                        <h3 data-lang-key="contact_phone_title">Nous Appeler</h3>
                        <p>+216 12 345 678</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="info-item d-flex flex-column justify-content-center align-items-center">
                        <i class="fa-solid fa-envelope"></i>
                        <h3 data-lang-key="contact_email_title">Nous Écrire</h3>
                        <p>Anissa@healthsys.com</p>
                    </div>
                </div>
            </div>

            <!-- Map + Form -->
            <div class="row gy-4 mt-1">
                <!-- Google Maps -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="300">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1896.3805312011064!2d9.46706234722569!3d35.024081295629266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fec3525b2b3c7d%3A0x1c99943b56c7f740!2z2KfZhNmF2LPYqti02YHZiSDYp9mE2KzZh9mI2Yog2KjYs9mK2K_ZiiDYqNmI2LLZitiv!5e1!3m2!1sar!2stn!4v1775197776866!5m2!1sar!2stn"
                        width="100%" 
                        height="450" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="400">
                    <form class="php-email-form" action="https://formspree.io/f/your-form-id" method="POST">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Votre Nom" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control" placeholder="Votre Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="subject" class="form-control" placeholder="Sujet" required>
                            </div>
                            <div class="col-md-12">
                                <textarea name="message" class="form-control" rows="6" placeholder="Votre Message" required></textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn-submit" style="background: var(--secondary-color)" data-lang-key="contact_send_btn">Envoyer le Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Health<span style="color: var(--secondary-color);">Sys</span></h4>
                    <p data-lang-key="footer_desc">Système innovant pour la gestion des cabinets médicaux.</p>
                </div>
                <div class="col-md-4">
                    <h5 data-lang-key="footer_links">Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#accueil" class="text-white text-decoration-none">Accueil</a></li>
                        <li><a href="#services" class="text-white text-decoration-none">Services</a></li>
                        <li><a href="#about" class="text-white text-decoration-none">À propos</a></li>
                        <li><a href="#contact" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 data-lang-key="footer_support">Support</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone-alt me-2"></i> +216 27 348 607</li>
                        <li><i class="fas fa-envelope me-2"></i> Anissa@healthsys.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2026 HealthSys. <span data-lang-key="footer_copyright">Tous droits réservés.</span></p>
            </div>
        </div>
    </footer>

    <!-- 🔽 DROP THIS INTO YOUR HTML (replaces Angular chatbot) 🔽 -->
    <!-- Chatbot Container -->
<div class="ask-ai" id="chatbot">
  
  <!-- Header (Hidden until .open class is added) -->
  <div class="header-bar">
    <button id="closeBtn"><i class="fa fa-arrow-left"></i></button>
    <img src="{{ asset('assets/img/ia_icon.png') }}" alt="ai-icon">
    <div>
      <h4>HealthSys IA</h4>
      <p><i class="fa-solid fa-circle"></i> Online</p>
    </div>
  </div>

  <div class="messages-section">
    <div class="messages">
      <img src="{{ asset('assets/img/chatbot2.png') }}" alt="chatbot" class="chatbot-img" id="botImage">
      
      <div class="conversations" id="conversationContainer">
        
      </div>
      
      <!-- Typing Indicator -->
      <div class="typing-indicator left hide" id="typing">
        <span></span><span></span><span></span>
      </div>
    </div>

    <!-- Input Area -->
    <div class="chat-input">
      
      <!-- 1. The AI Icon (Visible when input is empty) -->
      <img src="{{ asset('assets/img/ia_icon.png') }}" alt="ai-icon" class="ia-btn" id="halfCloseBtn" title="Minimize">
      
      <!-- 2. The Send Icon (Hidden by default, visible when typing) -->
      <i class="fa fa-paper-plane" id="sendBtn" style="display: none;"></i>
      
      <!-- 3. The Input Field -->
      <input type="text" id="userInput" placeholder="Ask AI anything..." autocomplete="off">
    </div>
  </div>
</div>



    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/chat-bot.js') }}"></script>

  
</body>
</html>