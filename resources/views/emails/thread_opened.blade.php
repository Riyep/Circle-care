<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Thread Baru Dibuka</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

        <h2 style="color: #5cb85c;">🟢 Thread Baru Dibuka</h2>
        
        <p><strong>Judul:</strong> {{ $issue->issue_title }}</p>
        <p><strong>Deskripsi:</strong><br>{{ $issue->issue_description }}</p>
        <p><strong>Departemen:</strong> {{ $issue->department->mt_departements_name ?? '-' }}</p>
        <p><strong>Status:🟢 Open </strong> <span style="color: #5cb85c;">{{ ucfirst($issue->status) }}</span></p>
        <p><strong>Dibuat oleh:</strong> {{ $issue->user->mt_username }}</p>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #777;">Ini adalah email otomatis dari sistem Circle Care. Harap tidak membalas email ini.</p>
    </div>
</body>
</html>
