<?php
require_once 'Database.php';
require_once 'SectionRepository.php';
require_once 'UserRepository.php';

// Initialisation de la connexion
$pdo = Database::getInstance();

// Test SectionRepository
$sectionRepo = new SectionRepository($pdo);

echo "=== TEST SECTION REPOSITORY ===\n";

// 1. Test findAll
echo "\n1. Tous les sections:\n";
print_r($sectionRepo->findAll());

// 2. Test create
echo "\n2. Création nouvelle section:\n";
$newSectionId = $sectionRepo->create([
    'designation' => 'Nouvelle Section',
    'description' => 'Description test'
]);
echo "Nouvelle section créée avec ID: $newSectionId\n";

// 3. Test findById
echo "\n3. Section par ID ($newSectionId):\n";
print_r($sectionRepo->findById($newSectionId));

// 4. Test delete
echo "\n4. Suppression section ($newSectionId):\n";
echo $sectionRepo->delete($newSectionId) ? "Supprimé avec succès\n" : "Échec suppression\n";

// Test UserRepository
$userRepo = new UserRepository($pdo);

echo "\n\n=== TEST USER REPOSITORY ===\n";

// 1. Test findAll
echo "\n1. Tous les utilisateurs:\n";
print_r($userRepo->findAll());

// 2. Test findByUsername
echo "\n2. Recherche par username (baha):\n";
print_r($userRepo->findByUsername('baha'));

// 3. Test create
echo "\n3. Création nouvel utilisateur:\n";
$newUserId = $userRepo->create([
    'username' => 'testuser',
    'email' => 'test@example.com',
    'password' => 'test123',
    'role' => 'user'
]);
echo "Nouvel utilisateur créé avec ID: $newUserId\n";

// 4. Test findById
echo "\n4. Utilisateur par ID ($newUserId):\n";
print_r($userRepo->findById($newUserId));

// 5. Test delete
echo "\n5. Suppression utilisateur ($newUserId):\n";
echo $userRepo->delete($newUserId) ? "Supprimé avec succès\n" : "Échec suppression\n";