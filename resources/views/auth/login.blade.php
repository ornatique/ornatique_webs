<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ornatique - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #143632;
            --primary-light: #1f4f4a;
            --gold: #c9a96e;
            --light-gold: #e8d9b9;
            --cream: #fefdf8;
            --dark-charcoal: #2a2a2a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--cream);
            font-family: 'Playfair Display', 'Times New Roman', serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(201, 169, 110, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(20, 54, 50, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow:
                0 25px 50px -12px rgba(20, 54, 50, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            max-width: 440px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--primary-dark));
        }

        .login-header {
            padding: 3rem 2.5rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(20, 54, 50, 0.1);
        }

        .brand-logo {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--primary-dark);
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .brand-subtitle {
            color: var(--gold);
            font-size: 0.9rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 300;
        }

        .login-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-charcoal);
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid rgba(20, 54, 50, 0.15);
            border-radius: 8px;
            background: var(--cream);
            font-size: 1rem;
            transition: all 0.3s ease;
            color: var(--dark-charcoal);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.1);
            background: white;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-dark);
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-icon {
            color: var(--gold);
            opacity: 1;
        }

        .btn-login {
            width: 100%;
            padding: 1.1rem;
            background: var(--primary-dark);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(20, 54, 50, 0.2);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1.5rem 0;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 1px solid rgba(20, 54, 50, 0.3);
            border-radius: 3px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox.checked {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .checkbox.checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-password {
            color: var(--primary-dark);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--gold);
        }

        .forgot-password:hover::after {
            width: 100%;
        }

        .jewel-decoration {
            position: absolute;
            opacity: 0.03;
            z-index: -1;
        }

        .jewel-1 {
            top: 10%;
            left: 10%;
            font-size: 8rem;
            color: var(--primary-dark);
        }

        .jewel-2 {
            bottom: 10%;
            right: 10%;
            font-size: 6rem;
            color: var(--gold);
            transform: rotate(45deg);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 1rem;
            }

            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Decorative Elements -->
    <i class="fas fa-gem jewel-decoration jewel-1"></i>
    <i class="fas fa-crown jewel-decoration jewel-2"></i>

    <div class="login-container">
        <div class="login-header">
            <div class="brand-logo">ORNATIQUE</div>
            <div class="brand-subtitle">Premium Silver Jewelry 925</div>
        </div>

        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">EMAIL ADDRESS</label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="your@email.com">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <span class="error-message" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">PASSWORD</label>
                    <div class="input-wrapper">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password" placeholder="••••••••">
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                    @error('password')
                        <span class="error-message" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <div class="checkbox" id="rememberCheckbox"></div>
                        <span style="font-size: 0.9rem; color: var(--dark-charcoal);">Remember me</span>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                            style="display: none;">
                    </div>

                </div>

                <button type="submit" class="btn-login">
                    SIGN IN
                </button>
            </form>
        </div>
    </div>

    <script>
        // Custom checkbox functionality
        document.getElementById('rememberCheckbox').addEventListener('click', function() {
            const checkbox = document.getElementById('remember');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('checked', checkbox.checked);
        });

        // Initialize checkbox state
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('remember');
            const customCheckbox = document.getElementById('rememberCheckbox');
            customCheckbox.classList.toggle('checked', checkbox.checked);
        });

        // Add subtle animation to form elements on load
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    group.style.transition = 'all 0.5s ease';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>

</html>
