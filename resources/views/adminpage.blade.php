<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: 500;
            color: #34495e;
        }

        input[type="file"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccd0d5;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="file"]:focus {
            border-color: #3b82f6;
            outline: none;
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
        }

        button:hover {
            background-color: #2563eb;
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
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="/home"><i class="fas fa-calendar-alt"></i>Rekap Jadwal</a>
        <a href="/nilai"><i class="fas fa-book"></i>Rekap Nilai</a>
        <a href="/"><i class="fas fa-sign-out-alt"></i>Log Out</a>
    </div>
    <div class="content">
        <div class="container">
            <h1>Rekap Jadwal</h1>
            <form action="{{ route('excel.merge') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="file1">Data Peserta</label>
                <input type="file" name="file1" id="file1" required>

                <label for="file2">Data Pewawancara</label>
                <input type="file" name="file2" id="file2" required>

                <label for="file3">Data Host Zoom</label>
                <input type="file" name="file3" id="file3" required>

                <button type="submit">Buat Jadwal</button>
            </form>
        </div>
        <div class="trademark">MyPPMB</div>
    </div>
</body>
</html>
