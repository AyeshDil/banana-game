@extends('layouts.main')

@section('content')
        
    <!-- Leaderboard UI using Bootstrap 5 -->
<div class="container-fluid position-relative vh-100 d-flex align-items-center justify-content-center">

    <!-- Back Button -->
    <div class="position-absolute top-0 start-0 p-3">
        <button class="btn btn-light border rounded-circle">
            <iconify-icon icon="solar:arrow-left-line-duotone"></iconify-icon>
        </button>
    </div>

    <!-- Max Score Profile -->
    <div class="position-absolute top-0 end-0 p-3 d-flex align-items-center gap-2">
        <div class="badge bg-light text-dark px-3 py-2">Max Score: {{ $maxScore ?? '0' }}</div>
        {{-- <img src="{{ asset('assets/images/demo-profile-pic.jpg') }}" class="rounded-circle" width="40" height="40" alt="Profile"> --}}
    </div>

    <!-- Leaderboard Panels -->
    <div class="row w-100 px-5">
        <!-- Today - Top Players -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow rounded-4 bg-light bg-opacity-75">
                <h4 class="text-center mb-4 fw-bold">Today - Top Players</h4>
                <ul class="list-group" id="today-top-players">
                    @foreach ($todayTopPlayers as $todayTopPlayer)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-secondary bg-opacity-25">
                            <span>
                                {{ $todayTopPlayer->user->name }}
                            </span>
                            <span>{{ $todayTopPlayer->score }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Week - Top Players -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow rounded-4 bg-light bg-opacity-75">
                <h4 class="text-center mb-4 fw-bold">Week - Top Players</h4>
                <ul class="list-group" id="week-top-players">
                    @foreach ($thisWeekTopPlayers as $thisWeekTopPlayer)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-secondary bg-opacity-25">
                            <span>
                                {{ $thisWeekTopPlayer->user->name }}
                            </span>
                            <span>{{ $thisWeekTopPlayer->score }}</span>
                        </li>
                    @endforeach
                    
                </ul>
            </div>
        </div>
    </div>

    <!-- Music Toggle -->
    <div class="position-absolute bottom-0 end-0 p-3">
        <button class="btn btn-light border rounded-circle" id="mute-button"><iconify-icon icon="solar:muted-outline"></iconify-icon></button>
    </div>
</div>


@endsection

@section('page-scripts')

<script>
    // #today-top-players add  style="color:gold; to the li>span>iconify-icon

    document.getElementById('mute-button').addEventListener('click', function() {
        let btn = this;
        btn.innerHTML = (btn.innerHTML === '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>' )
            ? '<iconify-icon icon="solar:muted-outline" noobserver=""></iconify-icon>' 
            : '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>';
    });

    $('#today-top-players li').each(function(index) {
        if (index === 0) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:gold;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else if (index === 1) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:#cd7f32;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else if (index === 2) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:silver;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:rgb(255, 255, 255);"></iconify-icon> ' + $(this).find('span').eq(0).html());
        }
    }); 
        
    $('#week-top-players li').each(function(index) {
        if (index === 0) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:gold;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else if (index === 1) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:#cd7f32;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else if (index === 2) {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:silver;"></iconify-icon> ' + $(this).find('span').eq(0).html());
        } else {
            $(this).find('span').eq(0).html('<iconify-icon icon="mdi:crown" style="color:rgb(255, 255, 255);"></iconify-icon> ' + $(this).find('span').eq(0).html());
        }
    });

</script>

    
@endsection
