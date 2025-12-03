<!-- resources/views/partials/header-password-modal.blade.php -->
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)" aria-label="Toggle sidebar">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="User" width="35" height="35" class="rounded-circle">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="profileDropdown">
                        <div class="message-body px-2 py-2">

                            <a href="javascript:void(0)"
                               class="d-flex align-items-center gap-2 dropdown-item"
                               data-bs-toggle="modal"
                               data-bs-target="#passwordChangeModal"
                               role="button"
                               aria-controls="passwordChangeModal">
                                <i class="ti ti-lock fs-6"></i>
                                <p class="mb-0 fs-3">Change Password</p>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="px-2 py-2 mb-0">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Logout</button>
                            </form>

                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>

<!-- Password Change Modal -->
<div class="modal fade custom-modal" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 overflow-hidden">
            <div class="modal-header" style="background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:#fff;">
                <h5 class="modal-title d-flex align-items-center gap-2" id="passwordChangeModalLabel">
                    <span class="logo rounded-circle d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;background:#fff;color:#667eea;font-weight:700;">C</span>
                    <span>Change Password</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="passwordForm" method="POST" action="{{ route('user.password.update') }}" novalidate>
                @csrf
                @method('PUT')

                <div class="modal-body bg-light p-4">

                    @if (session('password_success'))
                        <div class="alert alert-success small mb-3">{{ session('password_success') }}</div>
                    @endif

                    @if (session('password_error'))
                        <div class="alert alert-danger small mb-3">{{ session('password_error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger small mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3 row align-items-center">
                        <label for="oldPassword" class="col-sm-4 col-form-label small fw-semibold">Old Password</label>
                        <div class="col-sm-8">
                            <input
                                id="oldPassword"
                                name="oldPassword"
                                type="password"
                                class="form-control"
                                autocomplete="current-password"
                                required
                                minlength="6"
                                aria-describedby="oldPasswordHelp"
                            >
                            <div id="oldPasswordHelp" class="form-text small text-muted">Enter your current password.</div>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label for="newPassword" class="col-sm-4 col-form-label small fw-semibold">New Password</label>
                        <div class="col-sm-8">
                            <input
                                id="newPassword"
                                name="newPassword"
                                type="password"
                                class="form-control"
                                autocomplete="new-password"
                                required
                                minlength="8"
                                aria-describedby="strengthMessage"
                            >
                            <div id="strengthBar" class="progress mt-2" style="height:6px;">
                                <div id="strengthFill" class="progress-bar" role="progressbar" style="width:0%"></div>
                            </div>
                            <div id="strengthMessage" class="small mt-1 text-muted">Use at least 8 characters including uppercase & numbers.</div>
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label for="confirmPassword" class="col-sm-4 col-form-label small fw-semibold">Confirm Password</label>
                        <div class="col-sm-8">
                            <input
                                id="confirmPassword"
                                name="newPassword_confirmation"
                                type="password"
                                class="form-control"
                                autocomplete="new-password"
                                required
                                minlength="8"
                                aria-describedby="matchMessage"
                            >
                            <div id="matchMessage" class="small mt-1 text-muted"></div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button id="passwordSubmitBtn" type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>

                </div>

                <div class="modal-footer bg-dark text-white d-flex justify-content-between align-items-center py-3 px-4">
                    <p class="footer-text small mb-0">Designed &amp; Developed By: Moure Technologies</p>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
    .custom-modal .logo { font-size: 14px; }
    .custom-modal .modal-body { background: #f8f9fa; }
    .custom-modal .modal-footer { background: #111827; }
    .progress-bar { transition: width .25s ease; }
    .modal .form-text small { font-size: .8rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const strengthFill = document.getElementById('strengthFill');
    const strengthMessage = document.getElementById('strengthMessage');
    const matchMessage = document.getElementById('matchMessage');
    const submitBtn = document.getElementById('passwordSubmitBtn');
    const passwordForm = document.getElementById('passwordForm');

    function passwordScore(pw) {
        if (!pw) return 0;
        let score = 0;
        if (pw.length >= 8) score += 30;
        if (pw.match(/[a-z]/)) score += 15;
        if (pw.match(/[A-Z]/)) score += 20;
        if (pw.match(/[0-9]/)) score += 20;
        if (pw.match(/[^A-Za-z0-9]/)) score += 15;
        return Math.min(100, score);
    }

    function updateStrength() {
        const val = newPassword.value;
        const score = passwordScore(val);
        strengthFill.style.width = score + '%';
        if (score < 40) {
            strengthFill.className = 'progress-bar bg-danger';
            strengthMessage.textContent = 'Weak — include uppercase, numbers or symbols.';
        } else if (score < 75) {
            strengthFill.className = 'progress-bar bg-warning';
            strengthMessage.textContent = 'Medium — could be stronger.';
        } else {
            strengthFill.className = 'progress-bar bg-success';
            strengthMessage.textContent = 'Strong password.';
        }
    }

    function updateMatch() {
        if (!confirmPassword.value && !newPassword.value) {
            matchMessage.textContent = '';
            return false;
        }
        if (confirmPassword.value === newPassword.value) {
            matchMessage.innerHTML = '<span class="text-success">Passwords match</span>';
            return true;
        } else {
            matchMessage.innerHTML = '<span class="text-danger">Passwords do not match</span>';
            return false;
        }
    }

    newPassword.addEventListener('input', function () {
        updateStrength();
        updateMatch();
    });

    confirmPassword.addEventListener('input', function () {
        updateMatch();
    });

    passwordForm.addEventListener('submit', function (e) {
        const score = passwordScore(newPassword.value);
        const match = (newPassword.value === confirmPassword.value);

        if (!newPassword.value || !confirmPassword.value) {
            e.preventDefault();
            alert('Please fill new password and confirmation.');
            return false;
        }

        if (!match) {
            e.preventDefault();
            alert('Passwords do not match.');
            confirmPassword.focus();
            return false;
        }

        if (score < 40) {
            const proceed = confirm('Password seems weak. Do you want to proceed?');
            if (!proceed) {
                e.preventDefault();
                newPassword.focus();
                return false;
            }
        }
        // allow submit; server will re-validate and respond
    });

    // initialize UI
    updateStrength();
    updateMatch();
});
</script>
