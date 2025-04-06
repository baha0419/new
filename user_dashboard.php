<?php
require_once 'Auth.php';
require_once 'Database.php';
require_once 'Student.php';
require_once 'User.php';

$searchTerm = $_GET['search'] ?? '';
$students = [];

if ($searchTerm) {
    $db = Database::getInstance();
    $stmt = $db->prepare("
        SELECT s.*, sec.designation as section_name 
        FROM students s
        LEFT JOIN sections sec ON s.section_id = sec.id
        WHERE s.name LIKE ?
    ");
    $stmt->execute(["%$searchTerm%"]);
    $studentsData = $stmt->fetchAll();
} else {
    $studentsData = Database::getAllStudents();
}

// Conversion des données en objets Student
foreach ($studentsData as $data) {
    $students[] = new Student(
        $data['id'],
        $data['name'],
        $data['birthday'],
        $data['image'],
        $data['section_id'] ?? null
    );
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Espace Étudiant</title>
    <link rel="stylesheet" href="style.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
</head>
<body>
    <div class="header">
        <h1>Espace Étudiant</h1>
        <a href="logout.php" class="btn">Déconnexion</a>
    </div>

    <div class="content">
        <!-- Filtre PHP (soumission GET) -->
        <form method="GET" class="php-filter">
            <input type="text" name="search" placeholder="Filtrer par nom" 
                   value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="btn">Appliquer</button>
            <?php if ($searchTerm): ?>
                <a href="user_dashboard.php" class="btn">Réinitialiser</a>
            <?php endif; ?>
        </form>

        <!-- Tableau DataTables -->
        <table id="studentsTable" class="display">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de naissance</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): 
                    $section = $student->getSectionId() ? Database::getSectionById($student->getSectionId()) : null;
                ?>
                <tr>
                    <td><?= htmlspecialchars($student->getName()) ?></td>
                    <td><?= $student->getBirthday('d/m/Y') ?></td>
                    <td><?= $section ? htmlspecialchars($section->getDesignation()) : 'Non assigné' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="datatables-init.js"></script>
</body>
</html>