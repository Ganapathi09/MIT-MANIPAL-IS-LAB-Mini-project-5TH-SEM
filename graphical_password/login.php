<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="https://cdn.jsdelivr.net/npm/face-api.js"></script>
</head>
<body>
    <h1>Login</h1>
    <form id="loginForm" method="POST" action="verify.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>

        <h3>Select Points on the Images:</h3>
        <div id="image-grid">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <div class="image-container">
                    <img src="images/img<?= $i ?>.jpg" class="clickable-image" data-index="<?= $i ?>">
                    <div class="grid-overlay">
                        <?php for ($j = 0; $j < 16; $j++): ?>
                            <div></div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <h3>Face Recognition:</h3>
        <video id="video" width="300" height="200" autoplay></video>
        <button type="button" id="captureFace">Capture Face</button>
        
        <input type="hidden" name="selected_points" id="selectedPoints">
        <input type="hidden" name="face_data" id="faceData">
        <button type="submit">Login</button>
    </form>

    <script>
        const points = {};
        document.querySelectorAll('.clickable-image').forEach(img => {
            img.addEventListener('click', function(e) {
                const imgIndex = this.dataset.index;
                const x = e.offsetX;
                const y = e.offsetY;
                
                points[imgIndex] = { x, y };
                document.getElementById('selectedPoints').value = JSON.stringify(points);
            });
        });

        const video = document.getElementById('video');
        const faceDataInput = document.getElementById('faceData');

        async function startVideo() {
            const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
            video.srcObject = stream;
        }

        async function loadModels() {
            await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
            await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
            await faceapi.nets.faceRecognitionNet.loadFromUri('/models');
        }

        async function captureFaceData() {
            const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();
            if (detections) {
                faceDataInput.value = JSON.stringify(detections.descriptor);
                alert("Face data captured successfully.");
            } else {
                alert("No face detected. Please try again.");
            }
        }

        document.getElementById('captureFace').addEventListener('click', captureFaceData);
        startVideo();
        loadModels();
    </script>
</body>
</html>