@extends('layouts.app')

@section('content')
<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card complaint-card">
                <div class="card-header py-3 px-4">
                    <h4 class="mb-0">
                        <i class="fas fa-headset me-2"></i>Kirim Keluhan ke Admin
                    </h4>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('complaint.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-section mb-3">
                            <label for="title" class="form-label mb-2">Subject</label>
                            <input type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                placeholder="Masukkan Subject"
                                required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-section mb-3">
                            <label for="description" class="form-label mb-2">Keluhan Anda</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="5" 
                                style="resize: vertical; width: 100%;"
                                placeholder="Jelaskan keluhan Anda secara detail"
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-section mb-3">
                            <label for="images" class="form-label mb-2">
                                Lampiran Gambar
                                <small class="text-muted">(Opsional, Max 5MB/file, Format: JPG, PNG, JPEG)</small>
                            </label>
                            <div class="image-upload-container">
                                <input type="file" 
                                    class="form-control @error('images.*') is-invalid @enderror" 
                                    id="images" 
                                    name="images[]"
                                    accept="image/jpeg,image/png,image/jpg"
                                    multiple>
                                @error('images.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer pt-3 mt-3">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                                Kembali ke Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Submit 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --ou-crimson: #8C1414;
        --white: #FFFFFF;
        --gold: #FFD500;
        --yellow-green: #87CE45;
    }
    .complaint-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: var(--white);
        max-width: 1200px;
        margin: 0 auto;
        width: 95%;
    }
    .card-header {
        background: var(--ou-crimson);
        color: var(--white);
        border-bottom: none;
    }
    .card-header h4 {
        font-weight: 600;
        font-size: 1.1rem;
    }
    .card-header i {
        font-size: 1.1rem;
        color: var(--gold);
    }
    .form-section {
        width: 100%;
    }
    .form-label {
        color: var(--ou-crimson);
        font-weight: 500;
        font-size: 0.9rem;
    }
    .form-label small {
        font-weight: normal;
        font-size: 0.8rem;
    }
    .form-control {
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
        background: var(--white);
        color: #222;
        width: 100%;
        border-radius: 6px;
        min-height: 38px;
    }
    textarea.form-control {
        min-height: 135px;
        width: 100% !important;
    }
    .form-control:focus {
        border-color: var(--ou-crimson);
        box-shadow: 0 0 0 0.15rem rgba(140,20,20,0.10);
    }
    .form-control::placeholder {
        color: #adb5bd;
        font-size: 0.9rem;
    }
    .image-upload-container {
        position: relative;
    }
    .form-control[type="file"] {
        padding: 0.5rem;
        line-height: 1.5;
        cursor: pointer;
    }
    .form-control[type="file"]::file-selector-button {
        background-color: var(--ou-crimson);
        color: white;
        padding: 0.375rem 0.75rem;
        border: 0;
        border-radius: 4px;
        margin-right: 1rem;
        cursor: pointer;
    }
    .form-control[type="file"]::file-selector-button:hover {
        background-color: #7a1111;
    }
    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #e9ecef;
        width: 100%;
    }
    .btn {
        padding: 0.35rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease-in-out;
    }
    .btn-primary {
        background: var(--gold);
        color: var(--ou-crimson);
        border: none;
        min-width: 110px;
    }
    .btn-primary:hover {
        background: var(--yellow-green);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(135, 206, 69, 0.2);
    }
    .btn-outline-secondary {
        border: 1px solid var(--ou-crimson);
        color: var(--ou-crimson);
        background: var(--white);
        min-width: 110px;
    }
    .btn-outline-secondary:hover {
        background-color: var(--ou-crimson);
        color: var(--white);
        border-color: var(--ou-crimson);
    }
    .alert {
        border-radius: 6px;
        background: var(--yellow-green);
        color: var(--ou-crimson);
        border: none;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
        color: var(--ou-crimson);
    }
    @media (max-width: 992px) {
        .complaint-card {
            width: 100%;
        }
        .card-body {
            padding: 1rem;
        }
    }
    @media (max-width: 768px) {
        .form-footer {
            flex-direction: column;
            gap: 0.75rem;
        }
        .btn {
            width: 100%;
        }
    }
</style>

<script>
function validateFiles(input) {
    if (input.files) {
        Array.from(input.files).forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                alert('File terlalu besar. Maksimal 5MB per file.');
                input.value = '';
                return;
            }
        });
    }
}

// Add event listener to validate files
document.getElementById('images').addEventListener('change', function() {
    validateFiles(this);
});
</script>
@endsection
