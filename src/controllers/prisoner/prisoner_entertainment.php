<?php
require_once SRC_PATH . "/views/layouts/header_unified.php";
global $pdo;

$username = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT Dob FROM Prisoner WHERE Prisoner_uname = ?");
$stmt->execute([$username]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$age = 0;
if ($data) {
    $dob = new DateTime($data['Dob']);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
}

$ageGroup = ($age < 18) ? 'youth' : 'adult';
?>

<div class="container px-5 py-10 mx-auto">

<h2 class="text-3xl font-bold mb-8 text-center">Entertainment</h2>

<div class="flex justify-center space-x-6 mb-8">
    <button onclick="showSection('books')" class="bg-indigo-800 text-white px-6 py-2 rounded">
        Books
    </button>
    <button onclick="showSection('videos')" class="bg-gray-300 px-6 py-2 rounded">
        Videos
    </button>
</div>

<!-- BOOKS -->
<div id="booksSection">
    <h3 class="text-2l font-bold mb-10">Available Books</h3>

    <ul class="grid grid-cols-2 gap-4">
        <?php
        $books = $pdo->prepare("SELECT * FROM Entertainment_Books WHERE age_group = ?");
        $books->execute([$ageGroup]);

        while ($row = $books->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><a href='{$row['book_url']}' target='_blank'>{$row['title']}</a></li>";
        }
        ?>
    </ul>
</div>

<!-- VIDEOS -->
<div id="videosSection" style="display:none;">
    <h3 class="text-2l font-bold mb-10">Recommended Videos</h3>

    <div class="grid grid-cols-3 gap-6">
        <?php
        $videos = $pdo->prepare("SELECT * FROM Entertainment_Videos WHERE age_group = ?");
        $videos->execute([$ageGroup]);

        while ($row = $videos->fetch(PDO::FETCH_ASSOC)) {

            // Convert YouTube watch URL to embed
            $embed = str_replace("watch?v=", "embed/", $row['youtube_url']);

            echo "<iframe height='200' src='$embed' allowfullscreen></iframe>";
        }
        ?>
    </div>
</div>

</div>

<script>
function showSection(section) {
    document.getElementById('booksSection').style.display =
        section === 'books' ? 'block' : 'none';

    document.getElementById('videosSection').style.display =
        section === 'videos' ? 'block' : 'none';
}
</script>

<?php require_once SRC_PATH . "/views/layouts/footer.php"; ?>