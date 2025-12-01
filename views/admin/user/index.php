<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Vai trò</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($data as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
