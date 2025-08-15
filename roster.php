<?php
session_start();
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="main-wrap">
    <?php
    require_once __DIR__ . '/config/config.php';

    // Načti všechny hráče včetně jejich avatarů
    $sql = "SELECT p.*, m.file_path AS avatar_path
            FROM sbp_players p
            LEFT JOIN sbp_media m ON p.avatar_media_id = m.id
            ORDER BY 
                CASE WHEN p.is_staff = 1 THEN 2 ELSE 1 END, 
                p.number IS NULL, 
                p.number, 
                p.name";
    $res = $conn->query($sql);
    ?>

    <h1>Soupiska</h1>
    <table class="player-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Avatar</th>
                <th>Jméno</th>
                <th>Přezdívka</th>
                <th>Pozice</th>
               <!-- <th>Číslo</th>
                <th>Typ</th>  -->
            </tr>
        </thead>
        <tbody>
            <?php while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['number'] ? htmlspecialchars($row['number']) : '' ?></td>
                    <td>
                        <?php if ($row['avatar_path']): ?>
                            <img src="<?= htmlspecialchars($row['avatar_path']) ?>" alt="avatar" style="height: 42px; border-radius: 50%;">
                        <?php else: ?>
                            <img src="/logo/sebranka-lebkoun-01.svg" alt="avatar" style="height: 42px; border-radius: 50%;">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['nickname'] ?? '') ?></td>
                    <td>
                        <?php 
                        $positions = [];
                        if (!empty($row['default_position'])) {
                            $positions[] = htmlspecialchars($row['default_position']);
                        }
                        if ($row['is_staff'] && !empty($row['staff_role'])) {
                            $positions[] = htmlspecialchars($row['staff_role']);
                        }
                        echo implode(' / ', $positions);
                        ?>
                    </td>
                   <!-- <td><?= $row['number'] ? htmlspecialchars($row['number']) : '' ?></td>     -->
                   <!-- <td>   -->
                        <?php
                    #    if ($row['is_staff']) {
                     #       if (!empty($row['default_position'])) {
                      #          echo "Hráč / RT";
                       #     } else {
                        #        echo "Realizační tým";
                      #      }
                       # } else {
                        #    echo "Hráč";
                       # }
                        ?>
                    <!--</td> --> 
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
