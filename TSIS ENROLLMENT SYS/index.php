<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="overall style.css">
    <link rel="stylesheet" href="user-authentication.css">
    <link rel="stylesheet" href="index.css">
    <title>Main Website</title>
    <style>
       

        /* Media query for screens 1024px and above */
        @media (min-width: 1024px) {
           body{
            overflow: auto; /* Enables scrolling */
           }
        }
    </style>
</head>
<body>
    <div class="logo"></div>
    <header id="header">
        <nav class="nav-bar">
            <div class="burger-menu" onclick="toggleMenu()">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <ul class="nav-links" id="navLinks">
                <li><a onclick="window.location.href='index.php'">Home</a></li>
                <li><a href="#about-us">About</a></li>
                <li><a href="#links">Links</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <h1 id="h1">TANDANG SORA INTEGRATED SCHOOL</h1>
    </header>
    <main>
        <div class="typing-container">
            <p class="typing-text">BE ONE OF US, BE TSIS STUDENT!</p>
        </div>
        <div class="btn-container">
            <button class="button-89" role="button" id="enroll-now-btn" onclick="window.location.href='user_authentication.php'">Enter</button>
        </div>
    </main>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section about" id="about-us">
                <h2>About Us</h2>
                <p>Tandang Sora Integrated School is an 
                    educational institution dedicated to providing quality education to students from diverse backgrounds.</p>
            </div>
            <div class="footer-section links" id="links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="https://www.facebook.com/photo/?fbid=882320583911744&set=a.477455207731619">Enrollment Process</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="#faq">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-section contact" id="contact">
                <h2>Contact Info</h2>
                <p><i class="fas fa-map-marker-alt"></i> 7th Avenue East, near 10th St. Grace Park, Caloocan, Kalakhang Maynila</p>
                <p><i class="fas fa-phone"></i> 0926-898-4350</p>
                <p><i class="fas fa-envelope"></i> @tandangsoraintegratedschool.edu</p>
            </div>
            <div class="footer-section social">
                <h2>Follow Us</h2>
                <a href="https://www.facebook.com/tsisjhs"><i class="fab fa-facebook-f">fb</i></a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 TANDANG SORA INTEGRATED SCHOOL | All Rights Reserved
        </div>
    </footer>
    <script src="index.js"></script>
</body>
</html>

