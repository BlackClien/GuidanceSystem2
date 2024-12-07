<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cedar Guidance Counseling - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #f9f871, #ffffff); /* Yellow-to-white gradient */
        }

        /* Navigation Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #228b22; /* Green navbar */
            padding: 10px 20px;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-right: 20px;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        /* Hero Section */
        .hero {
            background-color: #006400;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .hero a {
            background-color: #2ecc71;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .hero a:hover {
            background-color: #27ae60;
        }

        /* About Section */
        .about {
            padding: 0px 20px;
            text-align: center;
        }

        .about h2 {
            color: #006400;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .about p {
            font-size: 20px;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer */
        footer {
            background-color: #228b22;
            color: white;
            text-align: center;
            padding: 5px;
            font-size: 16px;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <a href="index.php">Cedar Guidance</a>
        </div>
        <div class="menu">
            <a href="login.php">Login</a>
            <a href="#about">About</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to Cedar Web-Based Computerized Guidance Records Management System</h1>
        <p>Your trusted partner in student guidance and appointment scheduling.</p>
        <a href="login.php">Log In to Manage Appointments</a>
    </div>

    <!-- About Section -->
    <div class="about" id="about">
        <h2>About Cedar Guidance Counseling</h2>
        <p>We are dedicated to providing students with personalized counseling and guidance through one-on-one sessions. Our system allows easy appointment scheduling with our qualified counselors, ensuring you receive the support you need for your academic and personal growth.</p>
        <p>Whether you're seeking advice on your career path, personal development, or academic performance, Cedar Guidance is here to assist you every step of the way.</p>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Cedar Guidance Counseling | <a href="privacy_policy.php">Privacy Policy</a> | <a href="terms_of_service.php">Terms of Service</a></p>
        <p>Follow us: 
            <a href="https://web.facebook.com/search/top?q=cedar%20college%2C%20inc." target="_blank">Facebook</a>
        </p>
    </footer>

</body>
</html>
