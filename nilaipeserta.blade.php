<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f4f6f8;
            margin: 0;
            position: relative;
        }

        .sidebar {
            width: 210px;
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: width 0.3s;
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #3b82f6;
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            margin: 15px 0;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .sidebar a:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }

        .content {
            margin-left: 270px; 
            padding: 40px;
            width: calc(100% - 270px);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        .zoom-button {
            padding: 12px;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            display: block;
            width: 100%;
        }

        .zoom-button:hover {
            background-color: #2563eb;
        }

        .trademark {
            position: absolute;
            bottom: 20px;
            left: 270px;
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
        <h2>User Dashboard</h2>
        <a href="/userhome"><i class="fas fa-video"></i>Ruang Zoom</a>
        <a href="/nilai"><i class="fas fa-graduation-cap"></i>Nilai</a>
        <form action="{{ route(name: 'logout') }}" method="POST" style="display: inline;">
         @csrf
        <button type="submit">Logout</button>
        </form>    
    </div>
    <div class="content">
    <div class="container">
    @foreach($gelombangData as $jadwal)
    <div class="block">
        <h3>{{ $jadwal->no_peserta }}</h3>
    </div>
    @endforeach
    </div>
    </div>
</body>
</html>
