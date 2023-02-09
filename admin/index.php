<?php

require_once 'main.php';
$stmt = $pdo->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_admin_header('User accounts')?>

<h2>User accounts</h2>

<div class="links">
    <a href="account.php">Create user account</a>
</div>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Username</td>
                    <td class="responsive-hidden">Password</td>
                    <td class="responsive-hidden">Email</td>
                    <td class="responsive-hidden">Activation Code</td>
                    <td class="responsive-hidden">Role</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no users</td>
                </tr>
                <?php else: ?>
                <?php foreach ($users as $account): ?>
                <tr class="details" onclick="location.href='account.php?id=<?=$account['id']?>'">
                    <td><?=$account['id']?></td>
                    <td><?=$account['username']?></td>
                    <td class="responsive-hidden" style="word-break:break-all;"><?=$account['password']?></td>
                    <td class="responsive-hidden"><?=$account['private_email']?></td>
                    <td class="responsive-hidden"><?=$account['activation_code']?></td>
                    <td class="responsive-hidden"><?=$account['role']?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?=template_admin_footer()?>
