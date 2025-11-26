<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorPro — Find Expert Tutors</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* Header */
        .navbar {
            padding: 18px 0;
            background: #ffffff;
            box-shadow: 0 5px 25px rgba(0,0,0,0.06);
        }
        .navbar-brand {
            font-size: 30px;
            font-weight: 800;
            color: #2563eb !important;
        }
        .nav-link {
            font-weight: 500;
            margin-left: 18px;
            color: #475569 !important;
        }
        .nav-link:hover {
            color: #2563eb !important;
        }

        /* Hero */
        .hero {
            background: linear-gradient(135deg,#1e40af,#2563eb);
            padding: 140px 0;
            color: white;
            text-align: center;
        }
        .hero h1 {
            font-size: 54px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .hero p {
            font-size: 20px;
            opacity: 0.9;
        }
        .search-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-top: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* Sections */
        .section-title {
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 25px;
        }

        /* Subjects Grid */
        .subject-box {
            border-radius: 14px;
            padding: 25px;
            background: #f8fafc;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            text-align: center;
            transition: .3s;
        }
        .subject-box:hover {
            transform: translateY(-6px);
            background: #2563eb;
            color: white;
        }

        /* Tutor Cards */
        .tutor-card {
            border-radius: 18px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 7px 25px rgba(0,0,0,0.08);
            transition: .3s;
        }
        .tutor-card:hover {
            transform: translateY(-8px);
        }
        .tutor-img {
            width: 100%;
            border-radius: 14px;
        }
        .tutor-name {
            font-size: 20px;
            font-weight: 700;
        }
        .rating {
            color: #fbbf24;
        }

        /* CTA */
        .cta {
            background: linear-gradient(135deg,#1e3a8a,#1d4ed8);
            padding: 80px 0;
            border-radius: 18px;
            color: white;
        }

        /* Footer */
        footer {
            background: #0f172a;
            padding: 40px 0;
            color: #cbd5e1;
        }
        footer a {
            color: #93c5fd;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">TutorPro</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Find Tutors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Subjects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Become Tutor</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-3" href="#">Join Now</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <h1>Find Expert Tutors for Any Subject</h1>
            <p>Book online lessons with professionals and achieve your academic goals faster.</p>

            <div class="container search-box">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-lg" placeholder="What do you want to learn? (Math, English)">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control form-control-lg" placeholder="City or Online">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-lg w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Subjects -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Popular Subjects</h2>
            <div class="row g-4">

                <div class="col-md-3">
                    <div class="subject-box">Mathematics</div>
                </div>
                <div class="col-md-3">
                    <div class="subject-box">English</div>
                </div>
                <div class="col-md-3">
                    <div class="subject-box">Science</div>
                </div>
                <div class="col-md-3">
                    <div class="subject-box">Computer</div>
                </div>

            </div>
        </div>
    </section>

    <!-- Tutors -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Top Rated Tutors</h2>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="tutor-card">
                        <img src="https://via.placeholder.com/350x250" class="tutor-img">
                        <p class="tutor-name mt-3">Ayesha Khan</p>
                        <p class="rating">★★★★★ 4.9</p>
                        <p>Expert in Mathematics (5+ years)</p>
                        <button class="btn btn-primary w-100 mt-2">View Profile</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tutor-card">
                        <img src="https://via.placeholder.com/350x250" class="tutor-img">
                        <p class="tutor-name mt-3">Ali Raza</p>
                        <p class="rating">★★★★★ 4.8</p>
                        <p>English & IELTS Specialist</p>
                        <button class="btn btn-primary w-100 mt-2">View Profile</button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="tutor-card">
                        <img src="https://via.placeholder.com/350x250" class="tutor-img">
                        <p class="tutor-name mt-3">Sana Fatima</p>
                        <p class="rating">★★★★★ 5.0</p>
                        <p>Science Teacher (7+ years)</p>
                        <button class="btn btn-primary w-100 mt-2">View Profile</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5">
        <div class="container">
            <div class="cta text-center">
                <h2 class="mb-3">Become a Tutor and Start Earning Today</h2>
                <p class="mb-4">Share your knowledge and help students achieve their goals.</p>
                <a href="#" class="btn btn-light btn-lg px-5">Join as Tutor</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <p class="mb-1">&copy; 2025 TutorPro. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms</a> |
            <a href="#">Contact</a>
        </p>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
