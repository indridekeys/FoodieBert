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

    .loader-content { 
        text-align: center; 
        padding: 20px; 
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* THE SPINNER - Locked Aspect Ratio */
    .crazy-spinner {
        position: relative;
        width: 100px;
        height: 100px;
        aspect-ratio: 1 / 1; /* Forces a perfect square container */
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .crazy-spinner .ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); 
        border: 4px solid transparent;
        border-radius: 50%; 
        box-sizing: border-box; 
        aspect-ratio: 1 / 1; 
    }

    /* Outer Ring */
    .crazy-spinner .ring:nth-child(1) { 
        width: 100%; 
        height: 100%; 
        border-top: 4px solid #C5A059; 
        animation: spin 1.5s linear infinite;
    }

    /* Middle Ring */
    .crazy-spinner .ring:nth-child(2) { 
        width: 75%; 
        height: 75%; 
        border-bottom: 4px solid #C5A059; 
        animation: spin 1.2s linear infinite reverse; 
    }

    /* Inner Ring */
    .crazy-spinner .ring:nth-child(3) { 
        width: 50%; 
        height: 50%; 
        border-right: 4px solid #C5A059; 
        animation: spin 0.8s linear infinite; 
    }

    .logo-icon { 
        color: #C5A059; 
        font-size: 1.4rem; 
        animation: pulse 1.5s ease-in-out infinite;
        z-index: 2;
    }

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
        background: linear-gradient(90deg, #C5A059, #e74c3c);
        transition: width 0.3s ease-out;
    }

    .percent-display { color: #C5A059; font-size: 12px; font-family: monospace; margin-bottom: 20px; }

    .quote-container {
        margin-top: 20px;
        color: #bdc3c7;
        max-width: 300px;
        font-style: italic;
    }
    .quote-container i { color: #C5A059; font-size: 10px; display: block; margin-bottom: 8px; }
    
    #chef-quote { font-size: 14px; line-height: 1.4; min-height: 40px; }

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
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s ease;
    }

    .skip-btn.show-skip { opacity: 1; visibility: visible; }

    /* ANIMATIONS */
    @keyframes spin { 
        from { transform: translate(-50%, -50%) rotate(0deg); }
        to { transform: translate(-50%, -50%) rotate(360deg); } 
    }
    
    @keyframes pulse { 
        0%, 100% { transform: scale(1); opacity: 0.6; } 
        50% { transform: scale(1.15); opacity: 1; } 
    }
    
    .loader-hidden { opacity: 0; visibility: hidden; pointer-events: none; }
</style>

<script>
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
            "Adding a pinch of secret spices...",
            "The Chef is tasting the sauce...",
            "Setting the table for excellence...",
            "Traditional recipes, modern magic..."
        ];

        quoteEl.innerText = quotes[Math.floor(Math.random() * quotes.length)];

        const assets = Array.from(document.querySelectorAll("img, script[src], link[rel='stylesheet']"));
        let loadedCount = 0;

        function updateUI(p) {
            p = Math.min(Math.round(p), 100);
            progressBar.style.width = p + "%";
            progressText.innerText = p + "%";
            if (p >= 100) {
                setTimeout(() => loader.classList.add("loader-hidden"), 600);
            }
        }

        function increment() {
            loadedCount++;
            const percentage = assets.length > 0 ? (loadedCount / assets.length) * 100 : 100;
            updateUI(percentage);
        }

        if (assets.length === 0) {
            updateUI(100);
        } else {
            assets.forEach(asset => {
                if (asset.complete || asset.readyState === 4) {
                    increment();
                } else {
                    asset.addEventListener("load", increment);
                    asset.addEventListener("error", increment);
                }
            });
        }

        setTimeout(() => skipBtn.classList.add("show-skip"), 5000);
        skipBtn.addEventListener("click", () => loader.classList.add("loader-hidden"));
        setTimeout(() => updateUI(100), 10000);
    });
</script>