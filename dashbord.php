<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard for data insertion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
    
    <!-- Sidebar -->
    <div class="bg-gray-800 text-white p-4 w-64">
        <h4 class="text-xl font-bold mb-4">Dashboard</h4>
        <ul class="space-y-2">
            <li><a href="insert.php" class="block text-white hover:text-gray-300 py-2 px-3 rounded">Add Product</a></li>
            <li><a href="view.php" class="block text-white hover:text-gray-300 py-2 px-3 rounded">View Product</a></li>
            <li><a href="update.php" class="block text-white hover:text-gray-300 py-2 px-3 rounded">Update Product</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        
        <!-- Search Bar -->
        <form class="mb-6">
            <input type="text" placeholder="Search product..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>

        <h3 class="text-2xl font-semibold text-gray-800">Welcome to Dashboard</h3>

    </div>

    </div>
</body>
</html>