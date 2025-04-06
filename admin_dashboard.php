<?php
require_once 'Auth.php';
$students = Database::getAllStudents();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de bord Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- ... (header inchangé) ... -->

    <div class="content">
        <h2>Liste des étudiants</h2>
        <table class="student-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): 
                    $section = Database::getSectionById($student->getSectionId());
                ?>
                <tr>
                    <td><?= $student->getId() ?></td>
                    <td><?= htmlspecialchars($student->getName()) ?></td>
                    <td><?= $student->getBirthday() ?></td>
                    <td><?= htmlspecialchars($section->getDesignation()) ?></td>
                    <td>
                        <a href="edit_student.php?id=<?= $student->getId() ?>" class="btn">Modifier</a>
                        <a href="delete_student.php?id=<?= $student->getId() ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_student.php" class="btn">Ajouter un étudiant</a>
    </div>
</body>
</html>