<?php

$apiKey = 'f7127ee874914b34813a4e86b912272d'; 
$text = 'latest'; 
$sourceCountries = 'lk'; // Sri Lanka ISO code
$language = 'en'; // English language code
$endpoint = 'https://api.worldnewsapi.com/search-news';
$url = "$endpoint?text=" . urlencode($text) . 
       "&source-countries=" . urlencode($sourceCountries) . 
       "&language=" . urlencode($language) . 
       "&api-key=$apiKey";

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set timeout to 30 seconds

// Execute the request and fetch the response
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'cURL Error: ' . curl_error($ch);
    exit;
}

// Decode the JSON response
$data = json_decode($response, true);

// Close cURL session
curl_close($ch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>World News</title>
    <link href="NewsStyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <h1>World News</h1>
        <?php if (isset($data['news']) && is_array($data['news'])): ?>
            <?php foreach ($data['news'] as $news): ?>
                <div class="news-item">
                    <h2><?php echo htmlspecialchars($news['title']); ?></h2>
                    <div class="K2FeedImage">
                        <?php if (isset($news['image'])): ?>
                            <img src="<?php echo htmlspecialchars($news['image']); ?>" alt="News Image">
                        <?php endif; ?>
                    </div>
                    <div class="K2FeedIntroText">
                        <p><?php echo htmlspecialchars($news['text']); ?></p>
                    </div>
                    <div class="news-details">
                        <?php if (isset($news['publish_date'])): ?>
                            <p><strong>Published on:</strong> <?php echo htmlspecialchars($news['publish_date']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($news['author'])): ?>
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($news['author']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($news['catgory'])): ?>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($news['catgory']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No news found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
