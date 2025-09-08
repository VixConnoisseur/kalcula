<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KALCULA - Secure Login</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="flex items-center justify-center h-screen bg-gradient-to-br from-[#1A4B6C] to-[#4AA3DF]">

<div class="glass-card p-10 w-full max-w-md shadow-lg">
    <h1 class="text-white text-3xl font-bold mb-6 text-center drop-shadow-lg">KALCULA Login</h1>

    <?php if($message): ?>
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded text-center animate-pulse"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div>
            <label class="block text-white mb-1">Username</label>
            <input type="text" name="username" required
                   class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1A4B6C] text-[#3D3B40]"/>
        </div>

        <div class="relative">
            <label class="block text-white mb-1">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-[#1A4B6C] text-[#3D3B40]"/>
            <button type="button" id="togglePassword" class="absolute right-3 top-3 text-[#1A4B6C] font-bold">Show</button>
        </div>

        <div class="flex justify-between items-center">
            <a href="#" class="text-white underline hover:text-gray-200 text-sm">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full bg-[#1A4B6C] text-white py-3 rounded-md hover:bg-[#163b53] transition-colors font-semibold">Login</button>
    </form>
</div>

<script src="assets/script.js"></script>
</body>
</html>
