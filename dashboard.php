<?php
require_once 'config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | <?php echo htmlspecialchars($user['names']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-semibold">Dashboard</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="text-sm mr-2"><?php echo htmlspecialchars($user['email']); ?></span>
                        <div class="h-8 w-8 rounded-full bg-gray-600 flex items-center justify-center">
                            <span class="text-lg font-semibold"><?php echo strtoupper(substr($user['names'], 0, 1)); ?></span>
                        </div>
                    </div>
                    <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out flex items-center">
                        <i class="ri-logout-box-line mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold mb-2">
                Welcome back, <?php echo htmlspecialchars($user['names']); ?>!
            </h1>
            <p class="text-gray-400">
                <?php echo date('l, F j, Y'); ?>
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                        <i class="ri-user-line text-2xl text-blue-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-400">Profile Status</p>
                        <p class="text-lg font-semibold">Active</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                        <i class="ri-time-line text-2xl text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-400">Member Since</p>
                        <p class="text-lg font-semibold"><?php echo date('M Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                        <i class="ri-shield-check-line text-2xl text-purple-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-400">Security Status</p>
                        <p class="text-lg font-semibold">Protected</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                    <div class="bg-gray-700 rounded-md px-4 py-3">
                        <?php echo htmlspecialchars($user['names'] . ' ' . $user['surnames']); ?>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                    <div class="bg-gray-700 rounded-md px-4 py-3">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Account Created</label>
                    <div class="bg-gray-700 rounded-md px-4 py-3">
                        <?php echo date('F j, Y', strtotime($user['created_at'])); ?>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Account Status</label>
                    <div class="bg-gray-700 rounded-md px-4 py-3 flex items-center">
                        <span class="h-2 w-2 rounded-full bg-green-500 mr-2"></span>
                        Active
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-400 text-sm">
                © <?php echo date('Y'); ?> Leo Tech. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>