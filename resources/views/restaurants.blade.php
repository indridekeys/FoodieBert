@include('components.loader')
@include('components.header')

<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Scoped Square Styles */
    .luxury-catalog-page {
        background: #fdfdfd;
        overflow-x: hidden;
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .luxury-catalog-page * { 
        border-radius: 0 !important; 
    }

    /* Layout Split: Right Sidebar */
    .master-container {
        display: flex;
        flex-direction: row-reverse; 
        max-width: 100%;
        margin: 0 auto;
        flex: 1;
        background: #fff;
    }

    /* RIGHT SIDEBAR */
    .sidebar-catalog {
        flex: 0 0 400px;
        border-left: 1px solid #eee;
        height: 100vh;
        position: sticky;
        top: 0;
        overflow-y: auto;
        padding: 40px 20px;
        background: #fff;
    }

    .res-list-item {
        cursor: pointer;
        border: 1px solid #f0f0f0;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        padding: 12px;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
    }

    .res-list-item:hover { border-color: #D4AF37; background: #fafafa; transform: translateX(-5px); }
    .res-list-item.active { border-right: 8px solid #D4AF37; background: #f9f9f9; }

    /* LEFT SHOWCASE STAGE */
    .showcase-stage {
        flex: 1;
        padding: 40px;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 90vh;
    }

    .btn-action {
        flex: 1; padding: 20px; font-weight: 800; font-size: 0.8rem; 
        cursor: pointer; transition: 0.3s; letter-spacing: 2px; 
        text-transform: uppercase; border: none; display: flex; 
        align-items: center; justify-content: center; gap: 10px;
    }

    .sidebar-catalog::-webkit-scrollbar { width: 5px; }
    .sidebar-catalog::-webkit-scrollbar-thumb { background: #D4AF37; }
</style>

<div class="luxury-catalog-page">
    
    <section style="position: relative; height: 80vh; background: linear-gradient(rgba(0,15,30,0.7), rgba(0,15,30,0.7)), url('data:image/jpeg;base64,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'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; border-bottom: 15px solid #D4AF37;">
        <div class="animate__animated animate__fadeInDown">
            <h1 style="font-size: 6rem; color: #fff; margin: 0; font-family: 'Playfair Display', serif; line-height: 0.9;">RESTAURANTS <br><span style="color: #D4AF37;">IN BERTOUA</span></h1>
            <p style="font-family: 'Great Vibes', cursive; color: #fff; font-size: 3rem; margin-top: 20px;">Discover the best places to eat.</p>
        </div>
    </section>

    <div class="master-container">
        
        <div class="sidebar-catalog">
            <div style="margin-bottom: 40px;">
                <h2 style="font-family: 'Playfair Display'; font-size: 1.8rem; color: #001f3f; margin-bottom: 5px;">Directory</h2>
                <div style="width: 40px; height: 3px; background: #D4AF37; margin-bottom: 25px;"></div>
                
                <input type="text" id="resSearch" placeholder="SEARCH BY NAME OR CUISINE..." 
                    style="width: 100%; padding: 18px; border: 2px solid #001f3f; font-weight: 700; outline: none; background: #fff;">
            </div>

            <div id="restaurantList">
                @foreach($restaurants as $res)
                <div class="res-list-item" onclick="launchShowcase(this, {{ json_encode($res) }})">
                    <img src="{{ $res->image_url ? asset('storage/' . $res->image_url) : 'https://via.placeholder.com/200x200' }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee;">
                    <div style="display: flex; flex-direction: column; justify-content: center;">
                        <h4 style="margin: 0; font-size: 1.1rem; color: #001f3f; font-family: 'Playfair Display';">{{ $res->name }}</h4>
                        <span style="font-size: 0.65rem; color: #D4AF37; font-weight: 800; letter-spacing: 2px;">{{ strtoupper($res->category) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="showcase-stage" id="stage">
            <div id="idle-message" class="animate__animated animate__fadeIn">
                <div style="text-align: center; border: 1px solid #ddd; padding: 80px; background: #fff;">
                    <h2 style="font-family: 'Playfair Display'; color: #001f3f; font-size: 2.5rem;">The Grand Showcase</h2>
                    <p style="color: #D4AF37; font-weight: 800; letter-spacing: 4px; font-size: 0.9rem;">SELECT A VENUE TO BEGIN</p>
                </div>
            </div>

            <div id="dynamic-content" style="display: none; width: 100%; max-width: 1200px;">
                </div>
        </div>
    </div>
</div>

<script>
    function launchShowcase(el, res) {
        document.querySelectorAll('.res-list-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        const stage = document.getElementById('dynamic-content');
        const idle = document.getElementById('idle-message');
        
        idle.style.display = 'none';
        stage.style.display = 'block';

        stage.className = "";
        void stage.offsetWidth; 
        stage.className = "animate__animated animate__fadeIn";

        stage.innerHTML = `
            <div style="background: #fff; border: 20px solid #001f3f; box-shadow: 0 80px 150px rgba(0,0,0,0.15); overflow: hidden;">
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; min-height: 600px;">
                    
                    <div class="animate__animated animate__zoomIn" style="height: 100%;">
                        <img src="${res.image_url ? '/storage/' + res.image_url : 'https://via.placeholder.com/800x1200'}" 
                             style="width: 100%; height: 100%; object-fit: cover; border-right: 10px solid #D4AF37;">
                    </div>

                    <div class="animate__animated animate__fadeInRight" style="padding: 50px; display: flex; flex-direction: column; justify-content: center;">
                        <span style="color: #FF4D4D; font-weight: 900; letter-spacing: 3px; font-size: 0.8rem;">${res.category.toUpperCase()}</span>
                        <h2 style="font-size: 3.5rem; font-family: 'Playfair Display', serif; margin: 10px 0; color: #001f3f; line-height: 1;">${res.name}</h2>
                        <p style="font-family: 'Great Vibes', cursive; color: #D4AF37; font-size: 2.5rem; margin-bottom: 25px;">Excellence personified.</p>
                        
                        <p style="color: #444; font-size: 1.1rem; line-height: 1.8; margin-bottom: 35px; border-left: 3px solid #eee; padding-left: 20px;">
                            ${res.description}
                        </p>
                        
                        <div style="display: flex; gap: 15px;">
                            <button class="btn-action" style="background: #001f3f; color: #D4AF37;">
                                <i class="fas fa-calendar-alt"></i> BOOK NOW
                            </button>
                            <a href="/restaurants/${res.id}/menu" style="flex: 1; text-decoration: none;">
                                <button class="btn-action" style="width: 100%; border: 3px solid #001f3f; color: #001f3f; background: transparent;">
                                    VIEW MENU
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    document.getElementById('resSearch').addEventListener('input', function(e) {
        let val = e.target.value.toLowerCase();
        let items = document.querySelectorAll('.res-list-item');
        items.forEach(item => {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(val) ? 'flex' : 'none';
        });
    });
</script>

@include('components.footer')