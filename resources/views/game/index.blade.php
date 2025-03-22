@extends('layouts.main')

@section('content')
        
    <div class="position-absolute top-0 start-0 p-3">
        <button class="btn btn-light border" onclick="exitGame()">
            <iconify-icon icon="solar:close-circle-outline" noobserver></iconify-icon>
        </button>
    </div>

    <div class="position-absolute top-0 start-50 ">
        <img src="{{ asset('assets/images/banana-game.png') }}" alt="Profile" class="rounded-circle" width="100" height="100">
    </div>

    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg bg-opacity-75 w-75 h-75"
            style="background-color: rgba(255,255,255,0.75);">

            <!-- Lives/Hearts - Top Right Corner -->
            <div class="position-absolute top-0 end-0 p-3 d-flex gap-2" id="lives-container">
                <iconify-icon icon="mdi:heart" style="color:black;" width="24" height="24"></iconify-icon>
                <iconify-icon icon="mdi:heart" style="color:black;" width="24" height="24"></iconify-icon>
                <iconify-icon icon="mdi:heart" style="color:black;" width="24" height="24"></iconify-icon>
            </div>

            <!-- Top Bar -->
            <div class="w-100 d-flex justify-content-between align-items-center  p-3">
                <h5 class="text-center text-dark">Level: <span id="level">2</span></h5>
                <h5 class="text-center">Score: <span id="score">400</span></h5>
                {{-- <img src="{{ asset('assets/images/banana-game.png') }}" alt="Profile" class="rounded-circle" width="40" height="40"> --}}
            </div>


            <!-- Loading Indicator -->
            <div id="loading" class="text-center mt-3 d-none w-100 h-100 align-items-center justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            
            <!-- Game Content -->
            <div class="row">
                <div class="col-6">
                     <img id="question-img" src="" alt="Math Puzzle" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                </div>
                <div class="col-6">
                    <div id="answer-buttons" class="row mt-3"></div>
                    <div class="col-12">
                            <div id="timer-progress">
                                <div class="text-center mt-3">
                                    <div class="badge bg-light text-dark p-2"><iconify-icon icon="mdi:timer-outline"></iconify-icon> <span id="timer">49</span> s</div>
                                </div>
                                
                                <div class="progress mt-3" style="height: 10px;">
                                    <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="position-relative w-100 my-4 mt-5" >
                <!-- Monkey Image -->
                <img src="{{ asset('assets/images/walk.png') }}" alt="Monkey" class="position-absolute" id="monkey-icon"
                     style="top: -40px; left: 0%; height: 100px; transition: left 0.3s ease;">
            
                <!-- Finish Flag -->
                <div class="position-absolute end-0 top-0 mt-1 me-1" style="z-index: 2;">
                    <iconify-icon icon="twemoji:chequered-flag" width="80" height="80"></iconify-icon>
                </div>
                
                <!-- Progress Bar -->
                <div class="progress bg-light w-100 mt-5" style="height: 15px;">
                    <div class="progress-bar bg-success" id="monkey-progress" role="progressbar" style="width: 4%;"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        let marks = 0;
        let marksPerQuestion = {{ $playGround['marksPerQuestion'] }};
        let questionCount = 0;
        let level = 1;
        let score = 0;
        let round = 0;
        let lifes = 3;
        let timer = {{ $playGround['timer'] }};
        let monkeyProgress = 0;
        let timerInterval;

        document.getElementById('level').innerText = level;
        document.getElementById('score').innerText = score;

        const timerElement = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');

        document.getElementById('mute-button').addEventListener('click', function() {
            let btn = this;
            btn.innerHTML = btn.innerHTML === '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>' 
                ? '<iconify-icon icon="solar:muted-outline" noobserver=""></iconify-icon>' 
                : '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>';
        });

        
        async function fetchQuestion() {
            document.getElementById('answer-buttons').innerHTML = '';
            document.getElementById('question-img').src = '';
            document.getElementById('timer-progress').classList.add('d-none');
            document.getElementById('loading').classList.remove('d-none');
            const response = await fetch('https://marcconrad.com/uob/banana/api.php');
            const data = await response.json();
            document.getElementById('question-img').src = data.question;
            generateAnswerButtons(data.solution);
            document.getElementById('loading').classList.add('d-none');
            document.getElementById('timer-progress').classList.remove('d-none');

            // Start the timer
            runTimer({{ $playGround['timer'] }});
        }

        // Generate answer buttons
        function generateAnswerButtons(correctAnswer) {
            const answerContainer = document.getElementById('answer-buttons');
            answerContainer.innerHTML = '';
            
            let answers = new Set();
            answers.add(correctAnswer);
            while (answers.size < 4) {
                let randomNum = Math.floor(Math.random() * 10); // Generate random numbers (0-9)
                answers.add(randomNum);
            }
            
            let answerArray = Array.from(answers).sort(() => Math.random() - 0.5); // Shuffle answers
            
            answerArray.forEach(answer => {
                const div = document.createElement('div');
                div.classList.add('col-6', 'mb-3', 'text-center');
                answerContainer.appendChild(div);

                const button = document.createElement('button');
                button.classList.add('btn', 'btn-success', 'p-4', 'fs-5', 'mb-3');
                button.innerText = answer;
                button.onclick = () => checkAnswer(answer, correctAnswer);
                div.appendChild(button);
            });
        }

        // Check if answer is correct
        async function checkAnswer(selected, correct) {
            // Check if answer is correct
            if (selected == correct) {
                
                correctAnswer();
                
                // update monkey progress
                monkeyProgress += 10;
                updateMonkeyProgress(monkeyProgress);
            } else {
                wrongAnswer();
            }
        }

        // Update monkey progress
        function updateMonkeyProgress(percent) {
            document.getElementById('monkey-progress').style.width = percent + '%';
            document.getElementById('monkey-icon').style.left = `calc(${percent}% - 30px)`; // Adjust for monkey width
        }

        

        // Run the timer
        function runTimer(seconds){
            
            clearInterval(timerInterval);
            timer = seconds;
            timerElement.innerText = timer;
            progressBar.style.width = '100%';

            timerInterval = setInterval(() => {
                timer--;
                timerElement.innerText = timer;
                progressBar.style.width = `${(timer / seconds) * 100}%`;

                if (timer === 0) {
                    clearInterval(timerInterval);
                    fetchQuestion();
                }
            }, 1000);
        }


        // If user answers correct
        function correctAnswer() {
            // Fetch new question
            fetchQuestion();

            // Increase score
            score += marksPerQuestion;
            document.getElementById('score').innerText = score;

            // Increase question count
            questionCount++;

            // If question count is 10, upgrade level
            if (questionCount >= 10) {
                upgradeLevel();
            }

            // Show success alert
            let alertTimerInterval;
            Swal.fire({
                title: "You've got it!",
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(alertTimerInterval);
                }
            });

        }

        // If user answers wrong
        function wrongAnswer() {

            // Decrease lifes
            lifes--;

            // Update lifes
            updateHearts();
            
            // If lifes are 0, show game over alert
            if (lifes == 0) {
                clearInterval(timerInterval);

                // Show game over alert
                Swal.fire({
                    title: "Game Over!",
                    text: "You've lost all your lifes!",
                    icon: "error",
                    confirmButtonText: "Restart",
                    showDenyButton: true,
                    denyButtonText: "Dashboard",
                    allowOutsideClick: false
                }).then((result) => {
                    addScoreToDatabase();

                    if (result.isConfirmed) {
                        location.reload();
                    }

                    else if (result.isDenied) {
                        // Redirect to home
                        location.href = "{{ route('dashboard') }}";
                    }
                });

            } else {

                // Show failure alert
                let alertTimerInterval;
                Swal.fire({
                    title: "You've lost!",
                    icon: "error",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    willClose: () => {
                        clearInterval(alertTimerInterval);
                    }
                });
            }

            
        }

        // Exit Game
        function exitGame() {
            // Stop timer
            clearInterval(timerInterval);

            // Confirm Alert
            Swal.fire({
                title: "Are you sure?",
                text: "You want to exit the game?",
                icon: "error",
                confirmButtonText: "Yes, Exit",
                showDenyButton: true,
                denyButtonText: "No, Continue",
                allowOutsideClick: false
            }).then((result) => {
                
                if (result.isConfirmed) {
                    addScoreToDatabase();
                    // location.reload();
                    location.href = "{{ route('dashboard') }}";
                }

                // Continue
                else if (result.isDenied) {
                    // Run timer
                    runTimer(timer);
                    return;
                }

            });
        }

        // Upgrade Level
        function upgradeLevel() {
            level++;
            questionCount = 0;
            marksPerQuestion *= 2;
            monkeyProgress = 0;

            document.getElementById('level').innerText = level;
            fetchQuestion();
        }

        // Update Hearts
        function updateHearts() {
            const hearts = document.querySelectorAll('#lives-container iconify-icon');
            hearts.forEach((heart, index) => {
                if (index < lifes) {
                    heart.setAttribute('icon', 'mdi:heart');
                    heart.style.color = 'black';
                } else {
                    heart.setAttribute('icon', 'mdi:heart-outline');
                    heart.style.color = '#007bff';
                }
            });
        }

        // Add Score to Database
        function addScoreToDatabase() {
            fetch('/add-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    level: parseInt(document.getElementById('level').innerText), 
                    score: parseInt(document.getElementById('score').innerText) 
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


        // Start the game
        fetchQuestion();

    </script>
@endsection
