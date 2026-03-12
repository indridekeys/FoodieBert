<div id="page-loader" class="loader-wrapper">
    <div class="loader-content">
        <div class="crazy-spinner">
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="logo-icon">
                <i class="fas fa-utensils"></i>
            </div>
        </div>

        <h2 class="loader-text">Foodie<span>Bert</span></h2>
        
        <div class="loading-bar">
            <div id="real-progress" class="progress"></div>
        </div>
        <p id="progress-text" class="percent-display">0%</p>

        <div class="quote-container">
            <i class="fas fa-quote-left"></i>
            <p id="chef-quote">Sharpening the knives...</p>
        </div>
        <button id="skip-loader-btn" class="skip-btn">Skip to Table</button>
    </div>
</div>

<style>
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0a192f;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
    }

    .loader-content { text-align: center; padding: 20px; }

    /* THE SPINNER */
    .crazy-spinner {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .crazy-spinner .ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid transparent;
        border-radius: 50%;
        animation: spin 2s linear infinite;
    }

    .crazy-spinner .ring:nth-child(1) { border-top-color: #C5A059; animation-duration: 1.5s; }
    .crazy-spinner .ring:nth-child(2) { width: 80%; height: 80%; border-bottom-color: #FF69B4; animation-duration: 1.2s; animation-direction: reverse; }
    .crazy-spinner .ring:nth-child(3) { width: 60%; height: 60%; border-right-color: #C5A059; animation-duration: 0.8s; }

    .logo-icon { color: #C5A059; font-size: 1.8rem; animation: pulse 1.5s ease-in-out infinite; }

    /* TEXT & PROGRESS */
    .loader-text {
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 1.6rem;
        letter-spacing: 3px;
        margin: 15px 0 5px;
        text-transform: uppercase;
    }
    .loader-text span { color: #C5A059; }

    .loading-bar {
        width: 180px;
        height: 4px;
        background: rgba(255, 255, 255, 0.05);
        margin: 10px auto;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress {
        width: 0%;
        height: 100%;
        background: linear-gradient(90deg, #C5A059, #FF69B4);
        transition: width 0.4s ease;
    }

    .percent-display { color: #C5A059; font-size: 12px; font-family: monospace; margin-bottom: 20px; }

    /* QUOTE STYLING */
    .quote-container {
        margin-top: 20px;
        color: #bdc3c7;
        max-width: 300px;
        font-style: italic;
    }
    .quote-container i { color: #C5A059; font-size: 10px; display: block; margin-bottom: 8px; }
    #chef-quote { font-size: 14px; line-height: 1.4; opacity: 0; animation: fadeIn 1s forwards 0.3s; }

    .loader-wrapper {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: #0a192f; display: flex; justify-content: center;
        align-items: center; z-index: 10000;
        transition: opacity 0.8s ease, visibility 0.8s;
    }

    .loader-content { text-align: center; }

    /* SKIP BUTTON STYLING */
    .skip-btn {
        margin-top: 30px;
        background: transparent;
        border: 1px solid rgba(197, 160, 89, 0.4);
        color: #C5A059;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        opacity: 0; /* Hidden by default */
        visibility: hidden;
        transition: all 0.4s ease;
    }

    .skip-btn:hover {
        background: #C5A059;
        color: #0a192f;
        box-shadow: 0 0 15px rgba(197, 160, 89, 0.3);
    }

    /* ANIMATIONS */
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.6; } 50% { transform: scale(1.2); opacity: 1; } }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }


    .loader-hidden { opacity: 0; visibility: hidden; pointer-events: none; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const quotes = [
            "Garnishing your experience...",
            "Warming up the ovens...",
            "Sourcing the freshest ingredients...",
            "Adding a pinch of secret spices...",
            "The Chef is tasting the sauce...",
            "Setting the table for excellence...",
            "Traditional recipes, modern magic..."
        ];

        // Pick a random quote
        document.getElementById('chef-quote').innerText = quotes[Math.floor(Math.random() * quotes.length)];

        const progressBar = document.getElementById("real-progress");
        const progressText = document.getElementById("progress-text");
        const loader = document.getElementById("page-loader");

        // Logic to track assets
        const assets = Array.from(document.querySelectorAll("img, script[src], link[rel='stylesheet']"));
        let loadedCount = 0;

        function updateUI(p) {
            p = Math.min(Math.round(p), 100);
            progressBar.style.width = p + "%";
            progressText.innerText = p + "%";
            if (p >= 100) {
                setTimeout(() => loader.classList.add("loader-hidden"), 800);
            }
        }

        if (assets.length === 0) {
            updateUI(100);
        } else {
            assets.forEach(asset => {
                if (asset.complete) {
                    increment();
                } else {
                    asset.addEventListener("load", increment);
                    asset.addEventListener("error", increment);
                }
            });
        }

        function increment() {
            loadedCount++;
            updateUI((loadedCount / assets.length) * 100);
        }

        // Failsafe
        setTimeout(() => updateUI(100), 5000);
    });

    document.addEventListener("DOMContentLoaded", () => {
        const progressBar = document.getElementById("real-progress");
        const progressText = document.getElementById("progress-text");
        const loader = document.getElementById("page-loader");
        const skipBtn = document.getElementById("skip-loader-btn");
        const quoteEl = document.getElementById('chef-quote');

        const quotes = [
            "Garnishing your experience...",
            "Warming up the ovens...",
            "Sourcing the freshest ingredients...",
            "The Chef is tasting the sauce..."
        ];

        quoteEl.innerText = quotes[Math.floor(Math.random() * quotes.length)];

        // 1. Show Skip Button after 5 seconds of waiting
        setTimeout(() => {
            skipBtn.classList.add("show-skip");
        }, 5000);

        // 2. Skip Button Click Event
        skipBtn.addEventListener("click", () => {
            loader.classList.add("loader-hidden");
        });

        // 3. Asset Tracking Logic
        const assets = Array.from(document.querySelectorAll("img, script[src], link[rel='stylesheet']"));
        let loadedCount = 0;

        function updateUI(p) {
            p = Math.min(Math.round(p), 100);
            progressBar.style.width = p + "%";
            progressText.innerText = p + "%";
            if (p >= 100) {
                setTimeout(() => loader.classList.add("loader-hidden"), 800);
            }
        }

        if (assets.length === 0) {
            updateUI(100);
        } else {
            assets.forEach(asset => {
                if (asset.complete) {
                    increment();
                } else {
                    asset.addEventListener("load", increment);
                    asset.addEventListener("error", increment);
                }
            });
        }

        function increment() {
            loadedCount++;
            updateUI((loadedCount / assets.length) * 100);
        }
    });
</script>