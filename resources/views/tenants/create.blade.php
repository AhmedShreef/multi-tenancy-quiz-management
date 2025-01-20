<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Client Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg w-100" style="max-width: 700px;">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Create Client Page</h2>
        <form action="{{ route('tenants.store') }}" method="POST" id="create-tenant">
            {{ csrf_field() }}

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                type="text" id="name" name="name" class="form-control" placeholder="Your full name" required>
                @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <!-- domain Name -->
            <div class="mb-3">
                <label for="domain" class="form-label">Client Name (Domain Name)</label>
                <input type="text" id="domain" name="domain" class="form-control" placeholder="your-domain-name" required>
                @error('domain')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required>
                @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="*******" required>
                <div id="passwordError" class="text-danger mt-2 d-none"></div>
                @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!--confirm  Password -->
            <div class="mb-3">
                <label for="c_password" class="form-label">Confirm Password</label>
                <input  type="password" id="c_password" name="password_confirmation" class="form-control" placeholder="*******" required>

                <div id="confirmPasswordError" class="text-danger mt-2 d-none"></div>
                @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <button  type="submit"  class="btn btn-default text-white" id="submit-form" form="create-tenant" style="background-color: #de7e06;">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

        $('#domain').on('keyup', function (e) {
            if (e.which === 32) {
                this.value = this.value.replace(/ /g, "-");
            }
        });

        $("#create-tenant").on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            const password = $("#password").val();
            const confirmPassword = $("#c_password").val();
            let isValid = validatePassword(password, confirmPassword);

            if (isValid) {
                this.submit(); // Submit the form if validation passes
            }
        });

        $("#password, #c_password").on("blur", function () {
            const password = $("#password").val();
            const confirmPassword = $("#c_password").val();
            validatePassword(password, confirmPassword);
        });

        function validatePassword(password, confirmPassword) {
            let isValid = true;

            // Check if the password meets the required criteria
            if (!passwordRegex.test(password)) {
                $("#passwordError")
                .text(
                    "Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, and one number."
                    )
                .removeClass("d-none");
                isValid = false;
            } else {
                $("#passwordError").addClass("d-none");
            }

        // Check if the passwords match
            if (password !== confirmPassword) {
                $("#confirmPasswordError")
                .text("Passwords do not match.")
                .removeClass("d-none");
                isValid = false;
            } else {
                $("#confirmPasswordError").addClass("d-none");
            }

            return isValid;
        }
    });
</script>
</body>
</html>
