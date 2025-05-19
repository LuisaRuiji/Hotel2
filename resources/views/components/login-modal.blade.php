<style>
    .glassmorphism {
        background: rgba(30, 58, 95, 0.6); /* #1E3A5F with opacity */
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modal-content {
        background: none !important;
    }

    .btn-primary {
        background-color: #3B82F6;
        border-color: #3B82F6;
    }

    .btn-primary:hover {
        background-color: #D946EF;
        border-color: #D946EF;
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .form-control::placeholder {
        color: #d1d5db;
    }

    .form-label,
    .form-check-label,
    .text-muted,
    .form-check-input,
    .small,
    .text-center,
    .text-decoration-none {
        color: #5EEAD4 !important;
    }

    h2 {
        color: #ffffff;
    }

    .modal-body {
        color: #ffffff;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-content img {
        filter: drop-shadow(0 0 10px #D946EF);
    }

    .invalid-feedback {
        color: #FF6B6B;
    }
</style>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow" style="background: rgba(30, 58, 95, 0.6); backdrop-filter: blur(16px); border-radius: 16px; color: #ffffff;">
            <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4 pt-0">
                <div class="text-center mb-4">
                    <img src="/images/logo-only.png" alt="Hotel Logo" style="width: 150px; height: 90px;">
                </div>
                
                <h2 class="text-center mb-2 fw-bold">Login</h2>
                <p class="text-center text-muted mb-4">Sign in to your account</p>
                
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback" id="passwordError"></div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">Log in</button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <span class="text-muted">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-decoration-underline">Create Account</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset errors
        document.getElementById('emailError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Get form data
        const formData = new FormData(loginForm);
        
        // Check if there's an intended room booking in session storage
        const intendedRoomBooking = sessionStorage.getItem('intended_room_booking');
        if (intendedRoomBooking) {
            formData.append('intended_room_booking', intendedRoomBooking);
        }
        
        // Send AJAX request
        fetch('{{ route('login') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            if (response.ok) {
                return response.json().then(data => {
                    // Clear session storage
                    sessionStorage.removeItem('intended_room_booking');
                    
                    // Redirect based on user role or intended URL
                    window.location.href = data.redirect || '/dashboard';
                });
            } else {
                return response.json().then(errors => {
                    // Display validation errors
                    if (errors.errors) {
                        if (errors.errors.email) {
                            document.getElementById('email').classList.add('is-invalid');
                            document.getElementById('emailError').textContent = errors.errors.email[0];
                        }
                        if (errors.errors.password) {
                            document.getElementById('password').classList.add('is-invalid');
                            document.getElementById('passwordError').textContent = errors.errors.password[0];
                        }
                    }
                    
                    // Display general error
                    if (errors.message) {
                        document.getElementById('email').classList.add('is-invalid');
                        document.getElementById('emailError').textContent = errors.message;
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script> 