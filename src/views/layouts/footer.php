    </main>

    <footer class="mt-auto bg-white py-4 text-center text-sm">
        Prison Management System © 2025–26
    </footer>

</div> <!-- END vanta-bg -->

<!-- VANTA -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector("#vanta-bg")) {
        VANTA.NET({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200,
            minWidth: 200,
            scale: 1,
            scaleMobile: 1,
            color: 0x4f46e5,
            backgroundColor: 0xffffff
        });
    }
});
</script>

</body>
</html>