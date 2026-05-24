<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'مارکێتی کوردستان')); ?> - چوونەژوورەوە</title>

    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        :root {
            --primary: #4a6491;
            --secondary: #2c3e50;
            --secondary: #2c3e50;
            --accent: #C084FC;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --glass: rgba(255, 255, 255, 0.95);
            --border: rgba(255, 255, 255, 0.3);
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -2;
            opacity: 0.6;
            animation: float 25s infinite alternate ease-in-out;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, var(--primary), #4f46e5);
            bottom: -150px;
            right: -150px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #10b981, #0ea5e9);
            top: 50%;
            left: 80%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, 50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, -30px) scale(0.9);
            }
        }

        /* Floating elements */
        .float-element {
            animation: float-simple 20s infinite linear;
            pointer-events: none;
        }

        @keyframes float-simple {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(10px, 20px) rotate(90deg);
            }
            50% {
                transform: translate(0, 40px) rotate(180deg);
            }
            75% {
                transform: translate(-10px, 20px) rotate(270deg);
            }
        }

        /* Login Card */
        .login-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 24px;
            padding: 40px 35px;
            width: 100%;
            max-width: 450px;
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 8px 32px rgba(31, 38, 135, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 12px 40px rgba(31, 38, 135, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        /* Form Header */
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(74, 100, 145, 0.3);
            transform: rotate(0deg);
            transition: transform 0.5s ease;
        }

        .logo-container:hover {
            transform: rotate(15deg);
        }

        .logo-container i {
            font-size: 2.2rem;
            color: white;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-header p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Form Elements */
        .input-group-custom {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group-custom i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-control-custom {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            font-weight: 500;
            color: var(--text-primary);
            transition: all 0.3s ease;
            outline: none;
            position: relative;
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(74, 100, 145, 0.15);
            padding-right: 55px;
        }

        .form-control-custom:focus + i {
            color: var(--accent);
            transform: translateY(-50%) scale(1.1);
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 5px;
            background: #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .strength-text {
            font-size: 0.8rem;
            margin-top: 2px;
            text-align: left;
            transition: all 0.3s ease;
        }

        .strength-weak .strength-bar { background: var(--danger); width: 25%; }
        .strength-medium .strength-bar { background: var(--warning); width: 50%; }
        .strength-strong .strength-bar { background: var(--success); width: 75%; }
        .strength-very-strong .strength-bar { background: var(--success); width: 100%; }

        .strength-weak .strength-text { color: var(--danger); }
        .strength-medium .strength-text { color: var(--warning); }
        .strength-strong .strength-text,
        .strength-very-strong .strength-text { color: var(--success); }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 5px;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Remember & Forgot */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .remember-me input[type="checkbox"]:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .remember-me label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            font-size: 0.9rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--accent);
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        /* Session Info */
        .session-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 12px;
            padding: 10px 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .session-info i {
            color: var(--primary);
            font-size: 1rem;
        }

        .session-info small {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* CAPTCHA Container */
        .captcha-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        /* Social Login */
        .social-login {
            margin: 25px 0;
        }

        .social-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .social-divider span {
            padding: 0 15px;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .social-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background: white;
            color: var(--text-primary);
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn.google:hover {
            border-color: #ea4335;
            color: #ea4335;
        }

        .social-btn.facebook:hover {
            border-color: #1877f2;
            color: #1877f2;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 20px rgba(74, 100, 145, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(74, 100, 145, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(-1px);
        }

        /* Footer Links */
        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .login-footer p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .register-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Error Messages */
        .alert-error {
            background: linear-gradient(135deg, #fee, #fff5f5);
            border: 2px solid #fecaca;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #dc2626;
            font-size: 0.9rem;
            display: none;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Success Messages */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            border: 2px solid #a7f3d0;
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #065f46;
            font-size: 0.9rem;
            display: none;
            animation: slideDown 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
                border-radius: 20px;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .form-header h1 {
                font-size: 1.5rem;
            }

            .form-control-custom {
                padding: 14px 45px 14px 18px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .social-buttons {
                flex-direction: column;
            }
        }

        /* Loading Animation */
        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-submit.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Security Lock Indicator */
        .security-info {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .security-info i {
            color: var(--success);
            margin-left: 5px;
        }
    </style>
</head>
<body>


    <!-- Floating Elements -->
    <div class="position-fixed top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: -1; pointer-events: none;">
        <div class="position-absolute rounded-circle bg-white opacity-10 float-element" style="width: 80px; height: 80px; top: 10%; left: 10%;"></div>
        <div class="position-absolute rounded-circle bg-white opacity-10 float-element" style="width: 120px; height: 120px; top: 70%; left: 80%; animation-delay: 2s;"></div>
        <div class="position-absolute rounded-circle bg-white opacity-10 float-element" style="width: 60px; height: 60px; top: 40%; left: 85%; animation-delay: 4s;"></div>
        <div class="position-absolute rounded-circle bg-white opacity-10 float-element" style="width: 100px; height: 100px; top: 80%; left: 20%; animation-delay: 6s;"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="form-header">
            <div class="logo-container">
                <i class="fas fa-store"></i>
            </div>
            <h1>چوونەژوورەوە</h1>
            <p>تکایە زانیارییەکانت بنووسە بۆ چوونەژوورەوە</p>
        </div>

        <!-- Error Display -->
        <div class="alert-error" id="error-message"></div>

        <!-- Success Message (for password reset confirmation, etc.) -->
        <div class="alert-success" id="success-message"></div>

        <form method="POST" action="<?php echo e(route('login')); ?>" id="login-form">
            <?php echo csrf_field(); ?>

            <!-- Email Input -->
            <div class="input-group-custom">
                <input type="email" name="email" id="email" class="form-control-custom" placeholder="ئیمەیڵەکەت بنووسە" required autofocus>
                <i class="fas fa-envelope"></i>
            </div>

            <!-- Password Input with Strength Indicator -->
            <div class="input-group-custom">
                <input type="password" name="password" class="form-control-custom" id="password" placeholder="تێپەڕەوشەکەت بنووسە" required>
                <i class="fas fa-lock"></i>
                <button type="button" class="password-toggle" id="toggle-password">
                    <i class="far fa-eye"></i>
                </button>
            </div>



            <!-- Form Options -->
            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">لەبیرم مەکە</label>
                </div>
                <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">تێپەڕەوشەت لەبیرکردووە؟</a>
            </div>

            <!-- Session Info -->




            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submit-btn">
                چوونەژوورەوە <i class="fas fa-sign-in-alt ms-2"></i>
            </button>
        </form>




    </div>

    <script>
        // Security: Rate limiting
        let loginAttempts = 0;
        const maxAttempts = 5;
        const lockoutTime = 300000; // 5 minutes in milliseconds
        let lockedUntil = 0;

        // Password toggle functionality
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });



        // Update password strength indicator
 

        // Form submission with validation
        const loginForm = document.getElementById('login-form');
        const submitBtn = document.getElementById('submit-btn');
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        loginForm.addEventListener('submit', function(e) {
            // Check if account is locked
            if (Date.now() < lockedUntil) {
                e.preventDefault();
                const minutesLeft = Math.ceil((lockedUntil - Date.now()) / 60000);
                showError(`هەژمارەکەت قوفڵ کراوە. تکایە دوای ${minutesLeft} خولەک دووبارە هەوڵ بدەوە`);
                return;
            }

            // Check rate limiting
            if (loginAttempts >= maxAttempts) {
                e.preventDefault();
                lockedUntil = Date.now() + lockoutTime;
                showError('هەوڵی زۆرتدا بۆ چوونەژوورەوە. تکایە دوای ٥ خولەک دووبارە هەوڵ بدەوە');
                return;
            }

            // Get form values
            const email = this.email.value;
            const password = this.password.value;

            // Basic validation
            if (!email || !password) {
                e.preventDefault();
                showError('تکایە هەموو خانەکان پڕ بکەوە');
                loginAttempts++;
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showError('تکایە ئیمەیڵێکی دروست بنووسە');
                loginAttempts++;
                return;
            }

            // CAPTCHA validation (if implemented)
          
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.innerHTML = 'چوونەژوورەوە <i class="fas fa-spinner ms-2"></i>';

            // Simulate API delay for demo (remove in production)
            setTimeout(() => {
                // In production, remove this timeout and let form submit naturally
            }, 1500);
        });

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';

            // Hide error after 5 seconds
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }

        function showSuccess(message) {
            successMessage.textContent = message;
            successMessage.style.display = 'block';
            errorMessage.style.display = 'none';

            // Hide success after 5 seconds
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }

        // Clear errors on input focus
        const inputs = document.querySelectorAll('.form-control-custom');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                errorMessage.style.display = 'none';
                successMessage.style.display = 'none';
            });
        });

  


        // Check for success messages in URL (for password reset redirects)
        function checkUrlForMessages() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            const status = urlParams.get('status');

            if (message && status === 'success') {
                showSuccess(decodeURIComponent(message));

                // Clean URL without page reload
                const cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
            }
        }

        // Add subtle floating animation to card on load
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.querySelector('.login-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);

            // Check for URL messages
            checkUrlForMessages();

            // Auto-focus email field
            document.getElementById('email').focus();

            // Check if there are any stored login attempts
            const storedAttempts = localStorage.getItem('loginAttempts');
            const storedLockTime = localStorage.getItem('lockedUntil');

            if (storedAttempts) {
                loginAttempts = parseInt(storedAttempts);
            }

            if (storedLockTime && parseInt(storedLockTime) > Date.now()) {
                lockedUntil = parseInt(storedLockTime);
                const minutesLeft = Math.ceil((lockedUntil - Date.now()) / 60000);
                showError(`هەژمارەکەت قوفڵ کراوە. تکایە دوای ${minutesLeft} خولەک دووبارە هەوڵ بدەوە`);
            }
        });

        // Store login attempts in localStorage (optional)
        function storeLoginAttempts() {
            localStorage.setItem('loginAttempts', loginAttempts.toString());
            if (lockedUntil > 0) {
                localStorage.setItem('lockedUntil', lockedUntil.toString());
            }
        }

        // Store attempts on page unload
        window.addEventListener('beforeunload', storeLoginAttempts);

        // Reset attempts after successful login (this would be called from backend)
        function resetLoginAttempts() {
            loginAttempts = 0;
            lockedUntil = 0;
            localStorage.removeItem('loginAttempts');
            localStorage.removeItem('lockedUntil');
        }

        // Demo: Simulate successful login (remove in production)
        // This is just for demonstration purposes
        window.demoLoginSuccess = function() {
            resetLoginAttempts();
            showSuccess('بە سەرکەوتوویی چوویتە ژوورەوە!');
            submitBtn.classList.remove('loading');
            submitBtn.innerHTML = 'چوونەژوورەوە <i class="fas fa-sign-in-alt ms-2"></i>';
        };

        // Demo: Simulate failed login (remove in production)
        window.demoLoginFailed = function() {
            loginAttempts++;
            showError('ئیمەیڵ یان تێپەڕەوشە هەڵەیە');
            submitBtn.classList.remove('loading');
            submitBtn.innerHTML = 'چوونەژوورەوە <i class="fas fa-sign-in-alt ms-2"></i>';
            storeLoginAttempts();
        };
    </script>
</body>
</html>
<?php /**PATH C:\wamnp64\www\mobileHardy\resources\views/auth/login.blade.php ENDPATH**/ ?>