<?php
session_start();

// Initialize error or success notification holders
$error = '';
$success = '';

// If already authenticated, bypass registration and head straight home
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: index.html');
    exit;
}

// Simple request routing verification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username        = trim($_POST['username'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Simple UX/Security validation logic
    if (empty($username) || empty($password)) {
        $error = 'All fields are strictly required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password length must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passphrases do not match. Please verify.';
    } else {
        /* ===================================================================
           💡 ARCHITECTURE DEVELOPER NOTE:
           Right now your project uses flat variables inside login.php:
              if ($username === 'admin' && $password === 'password123')
           
           Since a dynamic file storage system or SQL database isn't fully 
           connected yet, we will simulate a successful temporary creation flow!
           ===================================================================
        */
        $success = 'Account created successfully! You can now log in.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | H.S. Kigome Album</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* =================================================================
           EXCLUSIVE REGISTRATION INTERFACE OVERLAYS
        ================================================================== */
        body {
            background: linear-gradient(135deg, #f1f2f6 0%, #dfe4ea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            width: 100%;
            max-width: 440px;
            border-radius: var(--radius);
            box-shadow: 0 15px 35px rgba(30, 30, 36, 0.12);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .register-brand-header {
            background: var(--primary-gradient);
            padding: 35px 30px;
            text-align: center;
            color: white;
        }

        .register-brand-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .register-brand-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .register-form-body {
            padding: 35px 30px;
        }

        /* Meaningful UX State Badges */
        .auth-error-alert {
            background-color: #ffeaa7;
            border-left: 4px solid #ffb8b8;
            color: #d63031;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .auth-success-alert {
            background-color: #dff9fb;
            border-left: 4px solid #22a6b3;
            color: #130f40;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .form-input-group {
            position: relative;
            margin-bottom: 20px;
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
            padding: 12px 16px;
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
            margin-top: 10px;
        }

        .submit-auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(253, 121, 168, 0.45);
        }

        .register-footer-hint {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .register-footer-hint a {
            color: #0984e3;
            font-weight: 600;
        }
        
        .register-footer-hint a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="register-brand-header">
            <h2>Join the Album</h2>
            <p>Sign up to start documenting your life milestones</p>
        </div>

        <div class="register-form-body">
            <?php if (!empty($error)): ?>
                <div class="auth-error-alert">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="auth-success-alert">
                    🎉 <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-input-group">
                    <label for="username">Choose Username</label>
                    <input type="text" id="username" name="username" placeholder="e.g., huseni_kigome" required autocomplete="off">
                </div>

                <div class="form-input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Min. 6 characters" required>
                </div>

                <div class="form-input-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>
                </div>

                <button type="submit" class="submit-auth-btn">Create Free Account</button>
            </form>

            <div class="register-footer-hint">
                <p>Already have an account? <a href="login.php">Log In here</a></p>
            </div>
        </div>
    </div>

</body>
</html>