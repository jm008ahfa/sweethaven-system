<?php
// Database configuration
$host = 'localhost';
$dbname = 'bakeshop_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>🔧 Login Test Script</h1>";
    
    // Check if admin exists
    $stmt = $pdo->query("SELECT * FROM users WHERE username = 'admin'");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "<p style='color:green'>✓ Admin user found in database</p>";
        echo "<pre>";
        print_r($admin);
        echo "</pre>";
        
        // Test password
        $test_password = 'admin123';
        if (password_verify($test_password, $admin['password'])) {
            echo "<p style='color:green'>✓ Password 'admin123' is CORRECT!</p>";
            echo "<p>You can login with: <strong>admin / admin123</strong></p>";
        } else {
            echo "<p style='color:red'>✗ Password 'admin123' is INCORRECT. Resetting password...</p>";
            
            // Reset password
            $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
            $update->execute([$new_hash]);
            
            echo "<p style='color:green'>✓ Password has been reset to 'admin123'</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Admin user NOT found. Creating now...</p>";
        
        // Create admin user
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (username, password, name, role) VALUES (?, ?, ?, ?)");
        $insert->execute(['admin', $hash, 'Administrator', 'admin']);
        
        echo "<p style='color:green'>✓ Admin user created with password 'admin123'</p>";
    }
    
    // List all users
    echo "<h2>All Users in Database:</h2>";
    $stmt = $pdo->query("SELECT id, username, name, role FROM users");
    $users = $stmt->fetchAll();
    
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>{$user['id']}</td>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><hr>";
    echo "<h3>📝 Instructions:</h3>";
    echo "<ol>";
    echo "<li>Go to <a href='/login'>Login Page</a></li>";
    echo "<li>Use username: <strong>admin</strong></li>";
    echo "<li>Use password: <strong>admin123</strong></li>";
    echo "</ol>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>