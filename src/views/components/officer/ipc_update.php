<h2>Prisoner List</h2>

<?php if (isset($_GET['deleted'])): ?>
    <p style="color:green;">Prisoner deleted successfully</p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php foreach ($prisoners as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['Full_Name']) ?></td>

            <td>
                <a href="?page=prisoner-update&id=<?= $p['Prisoner_id'] ?>">
                    Edit
                </a>
            </td>

            <td>
                <form method="POST" action="?page=prisoner-delete" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $p['Prisoner_id'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>