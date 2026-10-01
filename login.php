<?php
session_start();

// Initialize error message
$error = '';

// If already authenticated, bypass login screen completely
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.html');
    exit;
}

// Simple credential authentication processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded credentials matching your project specifications
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        header('Location: index.html');
        exit;
    } else {
        $error = 'Invalid username or password configuration.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login | H.S. Kigome Album</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* =================================================================
           EXCLUSIVE SPLIT-SCREEN & LOCKING GLASS LOGIN DESIGN
        ================================================================== */
        body {
            background: linear-gradient(135deg, #f1f2f6 0%, #dfe4ea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: var(--radius);
            box-shadow: 0 15px 35px rgba(30, 30, 36, 0.12);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
            transition: transform 0.3s ease;
        }

        .login-brand-header {
            background: var(--primary-gradient);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-brand-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .login-brand-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .login-form-body {
            padding: 40px 30px;
        }

        /* Error warning badge */
        .auth-error-alert {
            background-color: #ffeaa7;
            border-left: 4px solid #ffb8b8;
            color: #d63031;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .form-input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input-group input {
            width: 100%;
            padding: 14px 16px;
            font-size: 1rem;
            border: 2px solid #edf2f7;
            border-radius: 8px;
            background-color: #fafafa;
            color: var(--text-main);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input-group input:focus {
            border-color: #74b9ff;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(116, 185, 255, 0.15);
        }

        .submit-auth-btn {
            width: 100%;
            padding: 14px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(253, 121, 168, 0.3);
            transition: all 0.3s ease;
        }

        .submit-auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(253, 121, 168, 0.45);
        }

        .submit-auth-btn:active {
            transform: translateY(0);
        }

        .login-footer-hint {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-brand-header">
            <h2>Album Authentication</h2>
            <p>Please log in to explore private family memories</p>
        </div>

        <div class="login-form-body">
            <?php if (!empty($error)): ?>
                <div class="auth-error-alert">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="e.g., admin" required autocomplete="off">
                </div>

                <div class="form-input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••••••" required>
                </div>

                <button type="submit" class="submit-auth-btn">Authorize Entry</button>
            </form>

            <div class="login-footer-hint">
                <p>Authorized access points only. Secured via PHP Session.</p>
            </div>
        </div>
    </div>

</body>
</html>