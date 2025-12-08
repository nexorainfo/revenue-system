<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta
        content="A complete solution for digital palika."
        name="description"
    />
    <meta content="Nexora Info Pvt. Ltd." name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/np.png')}}"/>

    <!-- Bootstrap css -->
    <link
        href="{{asset('assets/backend/css/bootstrap.min.css')}}"
        rel="stylesheet"
        type="text/css"
    />
    <!-- App css -->
    <link
        href="{{asset('assets/backend/css/app.min.css')}}"
        rel="stylesheet"
        type="text/css"
        id="app-style"
    />
    <!-- icons -->
    <link href="{{asset('assets/backend/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Enhanced custom styles for better UI -->
    <style>
        .auth-page {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
        }

        .auth-overlay {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
        }

        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 2rem 0;
        }

        .auth-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: #fff;
        }

        .auth-card-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            text-align: center;
            min-height: 100%;
        }

        .auth-card-left .logo {
            margin-bottom: 2rem;
            animation: slideInLeft 0.6s ease-out;
        }

        .auth-card-left .logo img {
            max-width: 100px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .auth-card-left h3,
        .auth-card-left h4 {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }

        .auth-card-left h3 {
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }

        .auth-card-left h4 {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        .auth-card-right {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-form-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-form-title i {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
            display: block;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control,
        .input-group-text {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f8faff;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .input-group-merge {
            border-radius: 8px;
            overflow: hidden;
        }

        .input-group-text {
            background: #f8faff;
            border-left: none;
            cursor: pointer;
        }

        .form-group-spacing {
            margin-bottom: 1.5rem;
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.4rem;
            display: block;
        }

        .btn-group-custom {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-success,
        .btn-danger {
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-success {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
            transform: translateY(-2px);
        }

        .forgot-password {
            text-align: right;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .support-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .support-section h4 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .support-section p {
            color: #4a5568;
            margin: 0.5rem 0;
        }

        .support-section i {
            color: #667eea;
            margin-right: 0.5rem;
        }

        .footer-login {
            text-align: center;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.5);
            color: #e2e8f0;
            font-size: 0.9rem;
            width: 100%;
        }

        .footer-login a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-login a:hover {
            color: #667eea;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            .auth-card-left {
                padding: 2rem 1.5rem;
            }

            .auth-card-right {
                padding: 2rem 1.5rem;
            }

            .auth-card-left .logo img {
                max-width: 70px;
            }

            .btn-group-custom {
                flex-direction: column;
            }

            .btn-success,
            .btn-danger {
                width: 100%;
            }
        }
    </style>
</head>

<body class="auth-page" style="background-image: url({{asset('images/mountain_photo.jpg')}})">
<div class="auth-overlay" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
    <!-- Restructured layout with better spacing and structure -->
    <div class="auth-container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="auth-card">
                        <div class="row g-0">
                            <!-- Left Section - Branding -->
                            <div class="col-md-5 auth-card-left">
                                <div class="logo">
                                    <img src="{{asset('images/np.png')}}" alt="Logo">
                                </div>
                                <div>
                                    <h3 class="text-white">{{$officeSetting?->localBody?->local_body??''}}</h3>
                                    <h4 class="text-white pt-2">{{config('app.name')}}</h4>
                                </div>
                            </div>

                            <!-- Right Section - Form -->
                            <div class="col-md-7 auth-card-right">
                                <div class="auth-form-title">
                                    <i class="fa fa-lock"></i>
                                    <h2 class="text-dark fw-bold">{{__("Login")}}</h2>
                                </div>

                                <form class="auth-form" action="{{route('login')}}" method="post">
                                    @csrf

                                    <!-- Email Field -->
                                    <div class="form-group-spacing">
                                        <label for="email" class="form-label">
                                            {{__("Email")}}
                                            <span class="text-danger fw-bold">*</span>
                                        </label>
                                        <input
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            type="email"
                                            value="{{old('email')}}"
                                            id="email"
                                            placeholder="{{__("Please Enter your email address to login")}}"
                                            required
                                        />
                                        @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Field -->
                                    <div class="form-group-spacing">
                                        <label for="password" class="form-label">
                                            {{__("Password")}} <span class="text-danger fw-bold">*</span>
                                        </label>
                                        <div class="input-group input-group-merge">
                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="{{__('Please Enter your password')}}"
                                                required
                                            />
                                            <div class="input-group-text"
                                                 data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="btn-group-custom mt-3">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            <i class="fa fa-sign-in me-2"></i>{{__("Login")}}
                                        </button>
                                        <button type="reset" class="btn btn-danger waves-effect">
                                            <i class="fa fa-times-circle me-2"></i>{{__("Reset")}}
                                        </button>
                                    </div>

                                    <!-- Forgot Password Link -->
                                    <div class="forgot-password">
                                        <a href="#" class="small">{{__("Forgot Password?")}}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="footer-login">
    <p class="mb-0">
        2022 - {{date('Y')}}
        &copy; <a href="#">{{config('app.name')}}</a>
    </p>
</footer>

<script src="{{asset('assets/backend/js/vendor.min.js')}}"></script>
<script src="{{asset('assets/backend/js/app.min.js')}}"></script>
</body>
</html>

