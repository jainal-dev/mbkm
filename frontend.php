<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengajuan Usulan MBKM</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #F0F8FF;
            overflow-x: hidden;
        }

        .fade-in {
            opacity: 0;
            animation: fadeInAnimation ease 1.5s;
            animation-fill-mode: forwards;
        }

        @keyframes fadeInAnimation {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            background-color: #00C6FF;
            background-image: linear-gradient(90deg, #00C6FF 0%, #0072ff 100%);
            color: white;
            z-index: 1;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo span {
            font-size: 24px;
            font-weight: 700;
        }

        .nav {
            display: flex;
            align-items: center;
        }

        .nav a {
            margin: 0 10px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .nav a:hover {
            background-color: #0072ff;
            box-shadow: 0 4px 10px rgba(0, 114, 255, 0.3);
        }

        .content {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 50px 30px; 
            background: linear-gradient(90deg, #B2F9FC 0%, #EAFFFD 100%);
            min-height: auto;
        }

        .text-content {
            text-align: left; 
        }

        .text-content h1 {
            font-size: 32px;
            color: #2C3E50;
            margin-bottom: 15px; 
            animation: slideInLeft 1.5s ease-out;
        }

        .text-content p {
            font-size: 16px;
            color: #2C3E50;
            margin-bottom: 20px; 
        }

        .buttons {
            display: flex;
            justify-content: flex-start; 
            align-items: center;
        }

        .buttons a {
            text-decoration: none;
            padding: 8px 20px;
            border-radius: 30px;
            margin-right: 10px; 
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 114, 255, 0.3);
        }

        .buttons a.daftar {
            background-color: #00AEEF;
            color: white;
        }

        .buttons a.login {
            background-color: #ffffff;
            color: #2C3E50;
            border: 2px solid #00AEEF;
        }

        .buttons a:hover {
            transform: translateY(-5px);
        }


        .about-section {
            padding: 50px 30px;
            background-color: #E0F7FA;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .about-image {
            flex: 1;
            margin-right: 20px;
        }


        .about-image img {
            max-width: 82%; 
            height: auto;
            border-radius: 10px;
            transition: transform 0.5s;
        }

        .about-image img:hover {
            transform: scale(1.05);
        }

        .about-content {
            flex: 1;
            text-align: left; 
        }

        .about-content h2 {
            font-size: 28px;
            color: #2C3E50;
            margin-bottom: 10px;
        }

        .about-content p {
            font-size: 14px;
            color: #2C3E50;
        }


.features-section {
    padding: 50px 30px;
    display: flex;
    justify-content: space-between; 
    background-color: #ffffff;
}

    .feature-box {
    text-align: center;
    max-width: 28%;
    transition: transform 0.3s;
    }

    .feature-box:hover {
    transform: translateY(-10px);
    }

    .feature-box img {
    width: 450px;
    height: 250px;
    margin-bottom: 10px;
    }

    .feature-box h3 {
    font-size: 20px;
    color: #2C3E50;
    margin-bottom: 8px;
    }

    .feature-box p {
    font-size: 14px;
    color: #2C3E50;
    }


        /* Footer Section */
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #E0F7FA;
            font-size: 12px;
            color: #2C3E50;
        }

        @keyframes slideInLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                padding: 15px;
            }
            .about-section, .features-section {
                flex-direction: column;
                align-items: flex-start; 
                padding: 15px;
            }
            .about-image, .about-content, .feature-box {
                margin: 0;
            }
        }
    </style>
</head>
<body class="fade-in">
    <div class="container">
        <div class="logo">
            <span>PBLTRPL-117</span>
        </div>
        <div class="nav">
            <a href="#about-section">Tentang Kami</a>
            <a href="#">Fitur</a>
        </div>
    </div>
    <div class="content">
        <div class="text-content">
            <h1>Aplikasi Pengajuan Usulan MBKM</h1>
            <p>Merdeka Belajar Kampus Merdeka</p>
            <div class="buttons">
                <a class="daftar" href="register.php">Daftar</a>
                <a class="login" href="login.php">Login</a>
            </div>
        </div>
    </div>
    <div id="about-section" class="about-section">
        <div class="about-image">
            <img src="about.png" alt="About Us Image">
        </div>
        <div class="about-content">
            <h1>Tentang Kami</h2>
            <h3>
                Aplikasi ini dirancang untuk memfasilitasi pengajuan usulan Merdeka Belajar Kampus Merdeka (MBKM) oleh mahasiswa, sehingga proses pengajuan menjadi lebih mudah dan efisien.
                Dengan antarmuka yang ramah pengguna, aplikasi ini memungkinkan mahasiswa mengirimkan usulan program studi atau kegiatan MBKM dengan cepat dan transparan.
    </h3>
        </div>
    </div>
    <div class="features-section">
        <div class="feature-box">
            <img src="ilustrasi.jpg" alt="Feature 1">
            <h3>Pengajuan Usulan</h3>
            <p>Ajukan usulan program MBKM dengan mudah melalui aplikasi ini.</p>
        </div>
        <div class="feature-box">
            <img src="kuliah.jpg" alt="Feature 2">
            <h3>Monitoring Proses</h3>
            <p>Pantau status usulan Anda secara real-time di aplikasi ini.</p>
        </div>
        <div class="feature-box">
            <img src="kkn1.png" alt="Feature 3">
            <h3>Laporan Kegiatan</h3>
            <p>Lengkapi laporan kegiatan MBKM dan submit langsung melalui aplikasi ini.</p>
        </div>
    </div>
    <div class="footer">
        <p>Copyright 2024 By Tim PBL-117 TRPL 1-A Malam</p>
    </div>
    <script>
        function scrollToSection(event, sectionId) {
            event.preventDefault();
            document.getElementById(sectionId).scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>
