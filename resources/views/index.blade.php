<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoring Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Premium Header */
        .navbar {
            padding: 18px 0;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-size: 28px;
            font-weight: 700;
            color: #2563eb !important;
        }
        .nav-link {
            font-size: 16px;
            font-weight: 500;
            margin-left: 15px;
            color: #333 !important;
        }
        .nav-link:hover {
            color: #2563eb !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            padding: 100px 0;
            color: white;
        }
        .hero h1 {
            font-size: 48px;
            font-weight: 800;
        }
        .hero p {
            font-size: 18px;
            opacity: .9;
        }

        .btn-big {
            padding: 14px 30px;
            font-size: 18px;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 40px 0;
        }
        footer a {
            color: #93c5fd;
            text-decoration: none;
        }
        footer a:hover {
            color: white;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">TutorPro</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Find Tutors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Become Tutor</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Subjects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-3" href="#">Join Now</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero Area -->
    <section class="hero text-center">
        <div class="container">
            <h1>Find the Best Tutors for Any Subject</h1>
            <p class="mt-3">Top-rated tutors ready to help you learn faster and achieve your academic goals.</p>
            <a href="#" class="btn btn-light btn-big mt-3">Get Started</a>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-1">&copy; 2025 TutorPro. All Rights Reserved.</p>
            <p>
                <a href="#">Privacy Policy</a> | 
                <a href="#">Terms</a> | 
                <a href="#">Contact</a>
            </p>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
