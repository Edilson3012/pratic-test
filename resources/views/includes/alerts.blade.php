<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('type') == 'success')
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 4500
        });
    </script>
@endif

@if (session('type') == 'error')
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
    <script>
        Swal.fire({
            icon: 'error',
            title: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 4500
        });
    </script>
@endif

@if (session('type') == 'info')
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
    <script>
        Swal.fire({
            icon: 'info',
            title: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 4500
        });
    </script>
@endif

@if (session('type') == 'warning')
    <div class="alert alert-warning">
        {{ session('message') }}
    </div>
    <script>
        Swal.fire({
            icon: 'warning',
            title: "{{ session('message') }}",
            showConfirmButton: false,
            timer: 4500
        });
    </script>
@endif
