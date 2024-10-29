<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemantauan Progress Pengisian Nilai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f4f6f8;
            position: relative; 
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50; 
            color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            transition: width 0.3s;
        }

        .sidebar h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            text-align: center;
            color: #3b82f6; 
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            margin: 15px 0;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px; 
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e; 
            color: #3b82f6; 
        }

        .sidebar a i {
            margin-right: 10px; 
        }

        .content {
            margin-left: 240px; 
            padding: 40px;
            width: calc(100% - 240px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            padding: 40px; 
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        .progress-info {
            margin-bottom: 20px;
            text-align: center;
            color: #34495e;
        }

        .progress-info span {
            font-weight: bold;
            color: #3b82f6; 
        }

        button {
            padding: 12px;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 20px auto; 
        }

        button:hover {
            background-color: #2563eb;
        }

        canvas {
            max-width: 250px; 
            max-height: 250px; 
        }

        .trademark {
            position: absolute;
            bottom: 20px; 
            left: 240px; 
            font-size: 1.2rem;
            color: #2c3e50; 
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .sidebar {
                width: 100px;
            }

            .content {
                margin-left: 120px;
                width: calc(100% - 120px);
            }

            .container {
                max-width: 90%;
            }

            .trademark {
                left: 120px; 
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="/home"><i class="fas fa-calendar-alt"></i>Rekap Jadwal</a>
        <a href="/nilai"><i class="fas fa-book"></i>Rekap Nilai</a>
        <a href="/"><i class="fas fa-sign-out-alt"></i>Log Out</a> <!-- Upload Konten dan List Konten dihapus -->
    </div>
    <div class="content">
        <div class="container">
            <h1>Pemantauan Progress Pengisian Nilai</h1>
            <div class="progress-info">
                <p>Jumlah Nilai Sudah Dimasukkan: <span id="scores-entered">75</span></p>
                <p>Jumlah Nilai Belum Dimasukkan: <span id="scores-missing">25</span></p>
            </div>
            <canvas id="progressChart" width="250" height="250"></canvas> 
            <button onclick="recapScores()">Rekap Nilai</button>
        </div>
        <div class="trademark">MyPPMB</div> 
    </div>

    <script>
        const scoresEntered = 75;
        const scoresMissing = 25;

        const ctx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Sudah Dimasukkan', 'Belum Dimasukkan'],
                datasets: [{
                    data: [scoresEntered, scoresMissing],
                    backgroundColor: ['#3b82f6', '#f87171'],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        function recapScores() {
            alert('Rekap nilai telah dimulai!'); 
        }
    </script>
</body>
</html>
