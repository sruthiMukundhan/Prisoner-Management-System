<?php require SRC_PATH."/views/layouts/header_unified.php"; ?>

<div class="max-w-6xl mx-auto p-10">

<h2 class="text-3xl font-bold mb-8">📁 Case Notes</h2>

<!-- Add New Note -->
<div class="bg-white shadow p-6 rounded mb-10">

<form method="POST" action="?page=lawyer-notes">

<select name="prisoner_id" class="border p-3 w-full mb-4 rounded" required>
<option value="">-- Select Prisoner --</option>
<?php foreach($prisoners as $p): ?>
<option value="<?= $p['Prisoner_id'] ?>">
<?= htmlspecialchars($p['Full_Name']) ?>
</option>
<?php endforeach; ?>
</select>

<input type="text"
       name="title"
       placeholder="Note Title"
       class="border p-3 w-full mb-4 rounded"
       required>

<textarea name="content"
          rows="5"
          placeholder="Write legal notes..."
          class="border p-3 w-full mb-4 rounded"
          required></textarea>

<button class="bg-indigo-600 text-white px-6 py-2 rounded">
Save Note
</button>

</form>
</div>

<!-- All Saved Notes -->
<h3 class="text-xl font-semibold mb-6">All Saved Notes</h3>

<?php if(!empty($notes)): ?>

<?php foreach($notes as $n): ?>

<div class="bg-gray-100 p-6 rounded mb-6 border-l-4 border-indigo-500">

<div class="flex justify-between">
<div>
<h4 class="font-bold text-lg">
<?= htmlspecialchars($n['Prisoner_Name']) ?> - 
<?= htmlspecialchars($n['Title']) ?>
</h4>
<p class="text-sm text-gray-500">
<?= $n['Created_at'] ?>
</p>
</div>

<div class="space-x-2">
<a href="?page=lawyer-notes&delete=<?= $n['Note_id'] ?>"
   class="text-red-600 font-semibold">
Delete
</a>
</div>
</div>

<p class="mt-4 text-gray-700">
<?= nl2br(htmlspecialchars($n['Note_content'])) ?>
</p>

<!-- Edit Form -->
<form method="POST" action="?page=lawyer-notes" class="mt-4">
<input type="hidden" name="note_id" value="<?= $n['Note_id'] ?>">

<input type="text"
       name="title"
       value="<?= htmlspecialchars($n['Title']) ?>"
       class="border p-2 w-full mb-2 rounded"
       required>

<textarea name="content"
          rows="3"
          class="border p-2 w-full mb-2 rounded"
          required><?= htmlspecialchars($n['Note_content']) ?></textarea>

<button name="update_note"
        class="bg-yellow-500 text-white px-4 py-1 rounded">
Update
</button>

</form>

</div>

<?php endforeach; ?>

<?php else: ?>

<p class="text-gray-500">No notes available.</p>

<?php endif; ?>

</div>

<?php require SRC_PATH."/views/layouts/footer.php"; ?>