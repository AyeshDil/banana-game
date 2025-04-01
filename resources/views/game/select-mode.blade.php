@extends('layouts.main')

@section('content')
    
    <div class="position-absolute top-0 start-0 p-3">
        <button class="btn btn-light border" onclick="history.back()">
            <iconify-icon icon="solar:rewind-back-linear" noobserver></iconify-icon>
        </button>
    </div>

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg bg-opacity-75 w-75 h-75"
            style="background-color: rgba(255,255,255,0.75);">
            
            <!-- Top Bar -->
            <div class="w-100 d-flex justify-content-end align-items-center p-3 gap-4">
                <div class="badge bg-light text-dark p-2">Max Score: {{ $maxScore ?? '0' }}</div>
                {{-- <img src="{{ asset('assets/images/demo-profile-pic.jpg') }}" alt="Profile" class="rounded-circle" width="40" height="40"> --}}
            </div>

            <!-- Mode Selection -->
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <h4 class="mb-4">Select the mode</h4>
                <div class="d-flex justify-content-around w-50">
                    <a href="{{ route('game', 'easy') }}" class="btn btn-lg btn-success p-4 fs-5 w-100 mx-2">Easy</a>
                    <a href="{{ route('game', 'medium') }}" class="btn btn-lg btn-primary p-4 fs-5 w-100 mx-2">Medium</a>
                    <a href="{{ route('game', 'hard') }}" class="btn btn-lg btn-danger p-4 fs-5 w-100 mx-2">Hard</a>
                </div>
            </div>

            <!-- Mute/Unmute Button -->
            <div class="position-absolute bottom-0 end-0 p-3">
                <button class="btn btn-light border" id="mute-button">
                    <iconify-icon icon="solar:music-notes-outline" noobserver></iconify-icon>
                </button>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script>
        document.getElementById('mute-button').addEventListener('click', function() {
            let btn = this;
            btn.innerHTML = btn.innerHTML === '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>' 
                ? '<iconify-icon icon="solar:muted-outline" noobserver=""></iconify-icon>' 
                : '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>';
        });
    </script>
@endsection
