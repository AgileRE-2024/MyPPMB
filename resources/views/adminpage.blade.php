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
            max-width: 1500px;
            align-items: center;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
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

        button {
            padding: 12px;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 9px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2563eb;
        }

        .block {
            margin: 20px 0 20px 0;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .block-content {
            display: none;
        }

        .trademark {
            position: absolute;
            top: 50px;
            right: 60px;
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: bold;
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
                <button type="button" onclick="addFileBlock()">Tambah Jadwal</button>
                <div id="fileBlocks">
                    @foreach($gelombangData as $jadwal)
                        <div class="block">
                            <h3>{{ $jadwal->gelombang_name}} - {{ $jadwal->date }} - Gelombang {{ $jadwal->gelombang }} - Semester {{ $jadwal->semester }}</h3>
                            <form action="{{ route('delete.store', $jadwal->id_gelombang) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')">Hapus</button>
                            </form>  
                            <button type="button" onclick="toggleBlockContent(this)">Toggle</button>
                            <div class="block-content">
                            <form action="{{ route('excel.merge') }}" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_gelombang" value="{{ $jadwal->id_gelombang }}">
                                @csrf
                                    <div style="display: flex; flex-direction: row; gap: 10px;">
                                        <div>
                                            <label for="file1">Data Peserta</label>
                                            <input type="file" name="file1" id="file1" required>
                                        </div>
                                        <div>
                                            <label for="file2">Data Pewawancara</label>
                                            <input type="file" name="file2" id="file2" required>
                                        </div>
                                        <div>
                                            <label for="file3">Data Host Zoom</label>
                                            <input type="file" name="file3" id="file3" required>
                                        </div>
                                    </div>   
                                    <button type="submit">Buat Jadwal ini revisi</button>
                            </form>
                            </div>0
                        </div>
                    @endforeach
                </div>
                <div class="trademark">MyPPMB</div>                    
        </div>
    </div>

    <script>
    function addFileBlock() {
        document.getElementById('popup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    function confirmAddFileBlock() {
        const gelombangName = document.getElementById('gelombangName').value;
        const date = document.getElementById('date').value;
        const gelombang = document.getElementById('gelombang').value;
        const semester = document.getElementById('semester').value;


        if (!gelombangName || !date || !gelombang || !semester) {
            alert('semua kolom harus diisi');
            return;
        }

        document.getElementById('jadwalForm').submit();        
        closePopup();  
    }

    function toggleBlockContent(button) {
            const blockContent = button.nextElementSibling;
            if (blockContent.style.display === 'none' || blockContent.style.display === '') {
                blockContent.style.display = 'block';
            } else {
                blockContent.style.display = 'none';
            }
    }
    </script>
</body>
</html>

<div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; z-index: 1001;">
    <h2>Tambah Gelombang</h2>
    <form id="jadwalForm" action="{{ route('gelombang.store') }}" method="POST">
        @csrf <!-- Ensures CSRF token is included for security -->
        
        <label for="gelombangName">Nama Gelombang</label>
        <input type="text" id="gelombangName" name="gelombangName" required> <!-- Added name attribute -->
        
        <label for="date">Tanggal</label>
        <input type="date" id="date" name="date" required> <!-- Added name attribute -->
        
        <label for="gelombang">Gelombang</label>
        <select id="gelombang" name="gelombang" required> 
            <option value="1">Gelombang 1</option>
            <option value="2">Gelombang 2</option>
            <option value="3">Gelombang 3</option>
            <option value="4">Gelombang 4</option>
        </select>
        
        <label for="semester">Semester</label>
        <select id="semester" name="semester" required> <!-- Added name attribute -->
            <option value="ganjil">Ganjil</option>
            <option value="genap">Genap</option>
        </select>
        
        <label for="time">Jam</label>
        <input type="time" id="time" name="time" required> <!-- Added name attribute -->
        
        <button type="button" onclick="confirmAddFileBlock(event)">Tambah</button>
        <button type="button" onclick="closePopup()">Batal</button>
    </form>
</div>


