<?php 
require "../src/views/layouts/header_unified.php";
?>

<!-- HERO (SHORT PURPLE AREA) -->
<section class="relative bg-gradient-to-br from-indigo-900 via-purple-900 to-indigo-800 py-20">
    <div class="absolute inset-0 opacity-10"
        style="background-image:url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Ccircle cx=%2230%22 cy=%2230%22 r=%222%22 fill=%22white%22 fill-opacity=%220.1%22/%3E%3C/svg%3E');">
    </div>

    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-6">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            Prison Management System
        </h1>
        <div class="w-20 h-1 bg-indigo-400 mx-auto rounded-full mb-4"></div>
        <p class="text-lg md:text-xl text-gray-200">
            A comprehensive, secure, and modern management solution designed for correctional facilities.
        </p>
    </div>
</section>

<!-- FEATURES + STATS -->
<section class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-6">

        <!-- FEATURE CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

            <div class="bg-indigo-900 text-white rounded-xl p-8 shadow-lg hover:scale-105 transition">
                <div class="w-16 h-16 rounded-full bg-indigo-500 flex items-center justify-center mx-auto mb-6">
                    🔒
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Secure Access Control</h3>
                <p class="text-indigo-200 text-center">
                    Secure, reliable and efficient system functionality.
                </p>
            </div>

            <div class="bg-purple-900 text-white rounded-xl p-8 shadow-lg hover:scale-105 transition">
                <div class="w-16 h-16 rounded-full bg-purple-500 flex items-center justify-center mx-auto mb-6">
                    📂
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Comprehensive Records</h3>
                <p class="text-purple-200 text-center">
                    Secure, reliable and efficient system functionality.
                </p>
            </div>

            <div class="bg-blue-900 text-white rounded-xl p-8 shadow-lg hover:scale-105 transition">
                <div class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center mx-auto mb-6">
                    ⚡
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Real-time Updates</h3>
                <p class="text-blue-200 text-center">
                    Secure, reliable and efficient system functionality.
                </p>
            </div>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="counter text-4xl font-bold text-indigo-600" data-count="100">0</div>
                <p class="text-gray-600">Secure</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-purple-600">24/7</div>
                <p class="text-gray-600">Available</p>
            </div>
            <div>
                <div class="counter text-4xl font-bold text-blue-600" data-count="100">0</div>
                <p class="text-gray-600">Real-time</p>
            </div>
            <div>
                <div class="text-4xl font-bold text-green-600">Easy</div>
                <p class="text-gray-600">Management</p>
            </div>
        </div>

    </div>
</section>

<!-- AUTO COUNTER SCRIPT (EVERY 3 SECONDS) -->
<script>
function animateCounters() {
    document.querySelectorAll(".counter").forEach(el => {
        const target = parseInt(el.dataset.count);
        let current = 0;
        el.innerText = "0";

        const step = Math.ceil(target / 40);

        const interval = setInterval(() => {
            current += step;
            if (current >= target) {
                el.innerText = target;
                clearInterval(interval);
            } else {
                el.innerText = current;
            }
        }, 30);
    });
}

// first run
animateCounters();

// repeat every 3 seconds
setInterval(animateCounters, 3000);
</script>

<?php require "../src/views/layouts/footer.php"; ?>
