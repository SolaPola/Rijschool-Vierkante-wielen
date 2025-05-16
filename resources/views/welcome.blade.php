<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rijschool Vierkant Wielen</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        
        <style>
            /* Base Styles */
            :root {
                --navy: #0a192f;
                --yellow: #ffd700;
                --white: #ffffff;
            }
            
            body {
                font-family: 'Nunito', sans-serif;
                background-color: var(--white);
                color: var(--navy);
                margin: 0;
                padding: 0;
            }
            
            /* Header */
            header {
                background-color: var(--navy);
                color: var(--white);
                padding: 20px 0;
            }
            
            .nav-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
            
            .logo {
                font-size: 24px;
                font-weight: bold;
                color: var(--yellow);
            }
            
            nav ul {
                display: flex;
                list-style: none;
                margin: 0;
                padding: 0;
            }
            
            nav ul li {
                margin-left: 30px;
            }
            
            nav ul li a {
                color: var(--white);
                text-decoration: none;
                transition: color 0.3s;
            }
            
            nav ul li a:hover {
                color: var(--yellow);
            }
            
            /* Hero Section */
            .hero {
                background-color: var(--navy);
                color: var(--white);
                padding: 100px 0;
                text-align: center;
            }
            
            .hero-content {
                max-width: 800px;
                margin: 0 auto;
                padding: 0 20px;
            }
            
            .hero h1 {
                font-size: 48px;
                margin-bottom: 20px;
            }
            
            .hero p {
                font-size: 20px;
                margin-bottom: 40px;
            }
            
            .cta-button {
                display: inline-block;
                background-color: var(--yellow);
                color: var(--navy);
                padding: 12px 30px;
                border-radius: 30px;
                text-decoration: none;
                font-weight: bold;
                transition: transform 0.3s;
            }
            
            .cta-button:hover {
                transform: translateY(-3px);
            }
            
            /* Features Section */
            .features {
                padding: 80px 0;
                background-color: var(--white);
            }
            
            .section-title {
                text-align: center;
                margin-bottom: 60px;
                color: var(--navy);
            }
            
            .features-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
            
            .feature-box {
                flex-basis: calc(33.333% - 30px);
                margin-bottom: 40px;
                text-align: center;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                transition: transform 0.3s;
            }
            
            .feature-box:hover {
                transform: translateY(-10px);
            }
            
            .feature-icon {
                font-size: 40px;
                color: var(--yellow);
                margin-bottom: 20px;
            }
            
            /* About Section */
            .about {
                padding: 80px 0;
                background-color: #f8f9fa;
            }
            
            .about-container {
                display: flex;
                align-items: center;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }
            
            .about-image {
                flex: 1;
                padding-right: 40px;
            }
            
            .about-image img {
                width: 100%;
                border-radius: 8px;
            }
            
            .about-content {
                flex: 1;
            }
            
            /* Footer */
            footer {
                background-color: var(--navy);
                color: var(--white);
                padding: 50px 0 20px;
            }
            
            .footer-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }
            
            .footer-section {
                flex-basis: calc(25% - 30px);
                margin-bottom: 30px;
            }
            
            .footer-section h3 {
                color: var(--yellow);
                margin-bottom: 20px;
            }
            
            .footer-links a {
                display: block;
                color: var(--white);
                margin-bottom: 10px;
                text-decoration: none;
            }
            
            .footer-links a:hover {
                color: var(--yellow);
            }
            
            .social-icons a {
                display: inline-block;
                margin-right: 15px;
                font-size: 20px;
                color: var(--white);
            }
            
            .social-icons a:hover {
                color: var(--yellow);
            }
            
            .copyright {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid rgba(255,255,255,0.1);
                width: 100%;
            }
            
            /* Responsive Design */
            @media (max-width: 992px) {
                .feature-box {
                    flex-basis: calc(50% - 30px);
                }
                
                .footer-section {
                    flex-basis: calc(50% - 30px);
                }
            }
            
            @media (max-width: 768px) {
                .about-container {
                    flex-direction: column;
                }
                
                .about-image {
                    padding-right: 0;
                    margin-bottom: 30px;
                }
                
                nav ul {
                    display: none;
                }
            }
            
            @media (max-width: 576px) {
                .feature-box {
                    flex-basis: 100%;
                }
                
                .footer-section {
                    flex-basis: 100%;
                }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="nav-container">
                <div class="logo">Rijschool Vierkant Wielen</div>
                <nav>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Lessen</a></li>
                        <li><a href="#">Prijzen</a></li>
                        <li><a href="#">Over Ons</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Rijbewijs Halen? <span style="color: var(--yellow);">Vierkant Wielen!</span></h1>
                <p>Professionele rijopleiding met persoonlijke aandacht. Hoog slagingspercentage en betaalbare lespakketten.</p>
                <a href="#" class="cta-button">Gratis Proefles</a>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="features">
            <div class="section-title">
                <h2>Waarom Kiezen voor Ons?</h2>
            </div>
            <div class="features-container">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Ervaren Instructeurs</h3>
                    <p>Onze instructeurs hebben jarenlange ervaring en zijn geduldig en professioneel.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Moderne Lesauto's</h3>
                    <p>Lessen in goed onderhouden en comfortabele lesauto's voorzien van de nieuwste technologie.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-thumbs-up"></i>
                    </div>
                    <h3>Hoog Slagingspercentage</h3>
                    <p>Wij zijn trots op ons slagingspercentage dat ver boven het landelijk gemiddelde ligt.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Scherpe Prijzen</h3>
                    <p>Betaalbare lespakketten zonder verborgen kosten of verrassingen.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Flexibele Planning</h3>
                    <p>Lessen op tijden die jou uitkomen, ook 's avonds en in het weekend.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Persoonlijke Aanpak</h3>
                    <p>Lessen aangepast aan jouw tempo en leerstijl voor optimaal resultaat.</p>
                </div>
            </div>
        </section>
        
        <!-- About Section -->
        <section class="about">
            <div class="about-container">
                <div class="about-image">
                    <img src="https://via.placeholder.com/600x400" alt="Rijschool Vierkant Wielen">
                </div>
                <div class="about-content">
                    <h2>Over Rijschool Vierkant Wielen</h2>
                    <p>Rijschool Vierkant Wielen is een professionele rijschool met meer dan 15 jaar ervaring in het opleiden van bestuurders. Onze focus ligt op kwaliteit, veiligheid en persoonlijke aandacht.</p>
                    <p>Bij ons leer je niet alleen voor je rijexamen, maar worden je echte rijvaardigheden bijgebracht die je je hele leven zullen helpen om een veilige weggebruiker te zijn.</p>
                    <p>Onze gediplomeerde instructeurs staan klaar om jou te begeleiden op weg naar je rijbewijs, of het nu gaat om auto, motor, of aanhangwagen.</p>
                    <a href="#" class="cta-button">Meer Over Ons</a>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h3>Rijschool Vierkant Wielen</h3>
                    <p>Professionele rijopleiding met persoonlijke aandacht en hoog slagingspercentage.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Voorbeeldstraat 123, Amsterdam</p>
                    <p><i class="fas fa-phone"></i> 020-1234567</p>
                    <p><i class="fas fa-envelope"></i> info@vierkantwielen.nl</p>
                </div>
                <div class="footer-section">
                    <h3>Lespakketten</h3>
                    <div class="footer-links">
                        <a href="#">Basispakket (30 lessen)</a>
                        <a href="#">Spoedcursus (15 lessen)</a>
                        <a href="#">Uitgebreid pakket (40 lessen)</a>
                        <a href="#">Opfriscursus</a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Snelle Links</h3>
                    <div class="footer-links">
                        <a href="#">Home</a>
                        <a href="#">Lessen</a>
                        <a href="#">Prijzen</a>
                        <a href="#">Over Ons</a>
                        <a href="#">Contact</a>
                    </div>
                </div>
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} Rijschool Vierkant Wielen. Alle rechten voorbehouden.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
