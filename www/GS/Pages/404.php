<?php

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Location: /GS/Pages/404.php");
    exit;
}

http_response_code(404);

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/GS/src/output.css" rel="stylesheet">
  <link rel="icon" type="Images/png" href="/Images/gsm-logo-icon.png">
  <title>Page Not Found - Kiosk</title>
  <style>
    .scrollable-box {
      scrollbar-width: thin;
      scrollbar-color: #cbd5e1 #f1f5f9;
    }
    .scrollable-box::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    .scrollable-box::-webkit-scrollbar-track {
      background: #f1f5f9;
    }
    .scrollable-box::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 8px;
    }
    .tab-active {
      background-color: #29842e;
      color: white;
      border-color: #29842e;
    }
    .tab-content {
      transition: opacity 0.2s ease-in-out;
      grid-area: tab;
    }
    .tab-inactive {
      opacity: 0;
      pointer-events: none;
    }
    .countdown {
      font-size: 1.2rem;
      font-weight: 600;
      color: #29842e;
    }
  </style>
  <script>
    let seconds = 3;
    function updateCountdown() {
      const countdownElement = document.getElementById('countdown');
      if (countdownElement) {
        countdownElement.textContent = seconds;
      }
      if (seconds <= 0) {
        window.location.href = '/GS/index.php';
      } else {
        seconds--;
        setTimeout(updateCountdown, 1000);
      }
    }
    setTimeout(updateCountdown, 1000);
  </script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

  <div style="background-color: #29842e" class="h-11 grid grid-cols-3">
    <div class="flex"></div>
    <div class="flex" style="background-color: #29842e"></div>
    <div class="flex"></div>
  </div>

  <div class="pl-3">
    <a href="/GS/index.php">
      <img src="/Images/gsmc-logo.png" alt="goodsamaritan-logo" class="h-28 max-w-full">
    </a>
  </div>

  <div class="flex-grow flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-md mx-auto">
      <div class="mb-6">
        <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      
      <h1 class="text-6xl font-bold text-gray-800 mb-2">404</h1>
      <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
      
      <p class="text-gray-600 mb-6">
        Oops! The page you're looking for doesn't exist or has been moved.
      </p>
      
      <div class="bg-gray-100 rounded-lg p-4 mb-6">
        <p class="text-gray-700">
          Redirecting you to the home page in 
          <span id="countdown" class="countdown">3</span> seconds...
        </p>
      </div>
      
      <a href="/GS/index.php" 
         class="inline-block bg-[#29842e] hover:bg-green-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200">
        Go to Home Page Now
      </a>
    </div>
  </div>

  <div style="background-color: #29842e" class="h-15 grid grid-cols-3 w-full">
    <div class="flex"></div>
    <div class="flex" style="background-color: #29842e">
      <div class="flex m-auto" style="color: white; font-size: 18px">Copyright 2025 - GoodSam Medical Center</div> 
    </div>
    <div class="flex"></div>
  </div>

</body>
</html>
