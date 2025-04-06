<?php
require_once 'Auth.php';


$sections = Database::getSections();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO students (name, birthday, section_id) VALUES (?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['birthday'],
        $_POST['section_id'] ?: null
    ]);
    header('Location: admin_dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h1>Ajouter un étudiant</h1>
        <a href="admin_dashboard.php" class="btn">Retour</a>
    </div>

    <div class="content">
        <form method="POST">
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Date de naissance</label>
                <input type="date" name="birthday" required>
            </div>
            <div class="form-group">
                <label>Section</label>
                <select name="section_id">
                    <option value="">-- Sans section --</option>
                    <?php foreach ($sections as $section): ?>
                    <option value="<?= $section->getId() ?>">
                        <?= htmlspecialchars($section->getDesignation()) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">Ajouter</button>
        </form>
    </div>
</body>
</html>