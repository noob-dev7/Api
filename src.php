<?php
$id = $_GET['id'] ?? '';
$apiKey = "iloveyou";
$apiUrl = "https://api-ccc0.onrender.com/api.php?id=$id&api_key=$apiKey";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Download</title>
    <style>
        #downloads { display: none; }
        .slider { width: 100%; }
    </style>
</head>
<body>
    <h2>Movie: <?= htmlspecialchars($data['data']['title'] ?? 'Unknown') ?></h2>
    <input type="range" min="0" max="100" value="0" class="slider" id="unlockSlider">
    <p>Slide to unlock download links</p>
    <div id="downloads">
        <?php foreach ($data['data']['downloads'] as $file): ?>
            <p><a href="<?= $file['url'] ?>" target="_blank">
                <?= $file['resolution'] . ' ' . $file['format'] ?> (<?= $file['size'] ?>)</a></p>
        <?php endforeach; ?>
        <?php if ($data['data']['subtitles']): ?>
            <h4>Subtitles:</h4>
            <a href="<?= $data['data']['subtitles'] ?>" target="_blank">Download Subtitles</a>
        <?php endif; ?>
    </div>

    <script>
    document.getElementById('unlockSlider').addEventListener('input', function () {
        if (this.value >= 100) {
            document.getElementById('downloads').style.display = 'block';
        }
    });
    </script>
</body>
</html>
