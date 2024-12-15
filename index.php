<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBL TRPL-117</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('latar halaman.webp');
            background-size: cover;
            background-position: center;
            color: white;
            line-height: 1.6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .container {
            text-align: left;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 1200px;
        }

        .text h1 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .text h2 {
            font-size: 4.0rem;
            margin-bottom: 10px;
            line-height: 1.3;
            text-align: left;
        }

        .text p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-align: left;
        }

        .buttons {
            display: flex;
            gap: 20px;
        }

        .button {
            font-family: 'Poppins', sans-serif;
            padding: 5px 35px;
            border: none;
            background-color: #2d87f0;
            color: white;
            font-size: 0.9rem;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #1a5bb8;
        }

        .button.white {
            background-color: white;
            color: #000000;
        }

        .about-us, .pbl {
            position: absolute;
            top: 20px;
            font-size: 1.2rem;
            color: white;
            text-decoration: none;
        }

        .pbl {
            left: 20px;
        }

        .about-us {
            right: 20px;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 20px;
            }

            .text h1 {
                font-weight: bold;
                font-size: 1.5rem;
            }

            .text h2 {
                font-size: 2rem;
            }

            .about-us, .pbl {
                font-size: 1rem;
                position: relative;
                top: 0;
                left: 0;
                right: 0;
            }
        }
    </style>
</head>
<body>

    <a href="#" class="about-us">Tentang Kami</a>
    <a href="#" class="pbl">PBL TRPL-117</a>

    <div class="container">
        <div class="text">
            <h2>Aplikasi Pengajuan <br> Usulan MBKM</h2>
            <p>Merdeka Belajar Kampus Merdeka</p>

            <div class="buttons">
                <a href="./auth/register.php" class="button">
                    Daftar
                </a>
                <a href="./auth/login.php" class="button white">
                    Masuk
                </a>
            </div>
        </div>
    </div>

</body>
</html>
