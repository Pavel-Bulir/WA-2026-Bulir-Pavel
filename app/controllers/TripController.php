<?php

class TripController {

    // 0. Výchozí metoda pro zobrazení úvodní stránky včetně seznamu výletů
    public function index() {
    require_once '../app/models/Database.php';
    require_once '../app/models/Trip.php';
    require_once '../app/models/Rating.php';
    require_once '../app/dto/TripDTO.php';

    $database = new Database();
    $db = $database->getConnection();

    $tripModel = new Trip($db);
    $ratingModel = new Rating($db);
    
    $rawTrips = $tripModel->getAll();
    $trips = array_map(fn($row) => new TripDTO($row), $rawTrips);
    
    // Načti hodnocení pro každý výlet
    $ratings = [];
    foreach ($trips as $trip) {
        $ratings[$trip->id] = $ratingModel->getAverageByTripId($trip->id);
    }
    
    require_once '../app/views/trips/trips_list.php';
}

    // 1. Zobrazení formuláře pro přidání nového výletu
    public function create() {
        if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání výletu musíte být přihlášeni.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
        }
        require '../app/views/trips/trip_create.php';
    }

    // 2. Zpracování dat odeslaných z formuláře
    public function store() {

        if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání výletu musíte být přihlášeni.');
        header('Location: ' . BASE_URL . '/index.php?url=auth/login');
        exit;
        }    

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $name = htmlspecialchars($_POST['name'] ?? '');
            $location = htmlspecialchars($_POST['location'] ?? '');
            $route_url = htmlspecialchars($_POST['route_url'] ?? '');
            $attractions = htmlspecialchars($_POST['attractions'] ?? '');
            $notes = htmlspecialchars($_POST['notes'] ?? '');
            $distance = (float)($_POST['distance'] ?? 0);
            $duration = (int)($_POST['duration'] ?? 0);
            $duration_unit = htmlspecialchars($_POST['duration_unit'] ?? 'hod');
            $difficulty_id = (int)($_POST['difficulty_id'] ?? 0);
            $no_dogs = isset($_POST['no_dogs']) ? 1 : 0;
            $created_by = $_SESSION['user_id'];
            $suitable_for = isset($_POST['suitable_for']) 
                ? json_encode($_POST['suitable_for']) 
                : null;

            require_once '../app/models/Database.php';
            require_once '../app/models/Trip.php';

            $database = new Database();
            $db = $database->getConnection();

            $tripModel = new Trip($db);

            // Zpracování obrázků
            $imagesArray = $this->processImageUploads();
            $images = !empty($imagesArray) ? json_encode($imagesArray) : null;

            $isSaved = $tripModel->store(
                $name, $distance, $duration, $duration_unit, $difficulty_id, $location, 
                $route_url, $attractions, $suitable_for, $no_dogs, $notes, $images, $created_by
            );

            if ($isSaved) {
                $this->addSuccessMessage('Výlet byl úspěšně uložen.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Nepodařilo se uložit výlet.');
            }
            
        } else {
            echo 'Pro přidání výletu je nutné odeslat formulář.';
        }
    }

    // 3. Smazání existujícího výletu
    public function delete($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Trip.php';

        $database = new Database();
        $db = $database->getConnection();

        $tripModel = new Trip($db);
        // Nejdřív načti výlet
        $rawTrip = $tripModel->getById($id);

        // Kontrola vlastnictví
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $rawTrip['created_by'] && !$isAdmin)) {
            $this->addErrorMessage('Nemáte oprávnění smazat tento výlet.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Smazání obrázků ze složky uploads
    $oldImages = json_decode($rawTrip['images'] ?? '[]', true);
    foreach ($oldImages as $oldImage) {
    $oldPath = __DIR__ . '/../../public/uploads/' . $oldImage;
    if (file_exists($oldPath)) {
        unlink($oldPath);
    }
    }
    $isDeleted = $tripModel->delete($id);  

        

        if ($isDeleted) {
            $this->addSuccessMessage('Výlet byl trvale smazán.');
        } else {
            $this->addErrorMessage('Nastala chyba. Výlet se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 4. Zobrazení formuláře pro úpravu existujícího výletu
    public function edit($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Trip.php';
        require_once '../app/dto/TripDTO.php';

        $database = new Database();
        $db = $database->getConnection();

        $tripModel = new Trip($db);
        $rawTrip = $tripModel->getById($id);

        if (!$rawTrip) {
            $this->addErrorMessage('Výlet nebyl nalezen.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Kontrola vlastnictví
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $rawTrip['created_by'] && !$isAdmin)) {
         $this->addErrorMessage('Nemáte oprávnění upravit tento výlet.');
         header('Location: ' . BASE_URL . '/index.php');
         exit;
        }

        $trip = new TripDTO($rawTrip);

        require_once '../app/views/trips/trip_edit.php';
    }

    // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = htmlspecialchars($_POST['name'] ?? '');
            $location = htmlspecialchars($_POST['location'] ?? '');
            $route_url = htmlspecialchars($_POST['route_url'] ?? '');
            $attractions = htmlspecialchars($_POST['attractions'] ?? '');
            $notes = htmlspecialchars($_POST['notes'] ?? '');
            $distance = (float)($_POST['distance'] ?? 0);
            $duration = (int)($_POST['duration'] ?? 0);
            $duration_unit = htmlspecialchars($_POST['duration_unit'] ?? 'hod');
            $difficulty_id = (int)($_POST['difficulty_id'] ?? 0);
            $no_dogs = isset($_POST['no_dogs']) ? 1 : 0;

            $suitable_for = isset($_POST['suitable_for'])
                ? json_encode($_POST['suitable_for'])
                : null;

            // Nejdřív vytvoříme připojení a model
            require_once '../app/models/Database.php';
            require_once '../app/models/Trip.php';

            $database = new Database();
            $db = $database->getConnection();
            $tripModel = new Trip($db);

            // Načtení existujícího výletu pro zachování starých obrázků
            $existingTrip = $tripModel->getById($id);

            // Zpracování nových obrázků
            $imagesArray = $this->processImageUploads();

            if (!empty($imagesArray)) {
    // Smazání starých souborů ze složky uploads
    $oldImages = json_decode($existingTrip['images'] ?? '[]', true);
    foreach ($oldImages as $oldImage) {
        $oldPath = __DIR__ . '/../../public/uploads/' . $oldImage;
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }
    // Byly nahrány nové obrázky
    $images = json_encode($imagesArray);
} else {
    // Žádné nové obrázky – zachováme staré
    $images = $existingTrip['images'];
}
            $updated_by = $_SESSION['user_id'] ?? null;

            $isUpdated = $tripModel->update(
                $id, $name, $distance, $duration, $duration_unit,
                $difficulty_id, $location, $route_url, $attractions,
                $suitable_for, $no_dogs, $notes, $images, $updated_by
            );

            if ($isUpdated) {
                $this->addSuccessMessage('Výlet byl úspěšně upraven.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }

        } else {
            echo 'Pro úpravu výletu je nutné odeslat formulář.';
        }
    }

    // 6. Zobrazení detailu výletu
    public function show($id = null) {
    if (!$id) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    require_once '../app/models/Database.php';
    require_once '../app/models/Trip.php';
    require_once '../app/models/Comment.php';
    require_once '../app/dto/TripDTO.php';

    $database = new Database();
    $db = $database->getConnection();

    $tripModel = new Trip($db);
    $rawTrip = $tripModel->getById($id);

    if (!$rawTrip) {
        $this->addErrorMessage('Výlet nebyl nalezen.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    $trip = new TripDTO($rawTrip);

    // Načtení komentářů
    $commentModel = new Comment($db);
    $comments = $commentModel->getByTripId((int)$id);

    // Načtení hodnocení
    require_once '../app/models/Rating.php';
    $ratingModel = new Rating($db);
    $ratingData = $ratingModel->getAverageByTripId((int)$id);
    $userRating = isset($_SESSION['user_id']) ? $ratingModel->getUserRating((int)$id, (int)$_SESSION['user_id']) : null;

    require_once '../app/views/trips/trip_show.php';
    }

    // 7. Přidání komentáře k výletu
public function addComment($id = null) {
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro přidání komentáře musíte být přihlášeni.');
        header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $content = htmlspecialchars($_POST['content'] ?? '');

        if (empty($content)) {
            $this->addErrorMessage('Komentář nemůže být prázdný.');
            header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Comment.php';

        $database = new Database();
        $db = $database->getConnection();

        $commentModel = new Comment($db);
        $isSaved = $commentModel->store((int)$id, (int)$_SESSION['user_id'], $content);

        if ($isSaved) {
            $this->addSuccessMessage('Komentář byl úspěšně přidán.');
        } else {
            $this->addErrorMessage('Nastala chyba. Komentář se nepodařilo uložit.');
        }
    }

    header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
    exit;
}

// 8. Smazání komentáře
public function deleteComment($id = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    require_once '../app/models/Database.php';
    require_once '../app/models/Comment.php';
    require_once '../app/models/Trip.php';

    $database = new Database();
    $db = $database->getConnection();

    $commentModel = new Comment($db);
    
    // Načti komentář
    $comment = $commentModel->getById((int)$id);
    
    if (!$comment) {
        $this->addErrorMessage('Komentář nebyl nalezen.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Načti výlet ke kterému komentář patří
    $tripModel = new Trip($db);
    $trip = $tripModel->getById($comment['trip_id']);

    // Kontrola oprávnění
    $isAuthor = $_SESSION['user_id'] == $comment['user_id'];
    $isTripOwner = $trip && $_SESSION['user_id'] == $trip['created_by'];
    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

    if (!$isAuthor && !$isTripOwner && !$isAdmin) {
        $this->addErrorMessage('Nemáte oprávnění smazat tento komentář.');
        header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $comment['trip_id']);
        exit;
    }

    $isDeleted = $commentModel->delete((int)$id);

    if ($isDeleted) {
        $this->addSuccessMessage('Komentář byl smazán.');
    } else {
        $this->addErrorMessage('Nastala chyba. Komentář se nepodařilo smazat.');
    }

    header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $comment['trip_id']);
    exit;
    }

    // 9. Zobrazení formuláře pro úpravu komentáře
public function editComment($id = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    require_once '../app/models/Database.php';
    require_once '../app/models/Comment.php';

    $database = new Database();
    $db = $database->getConnection();

    $commentModel = new Comment($db);
    $comment = $commentModel->getById((int)$id);

    if (!$comment) {
        $this->addErrorMessage('Komentář nebyl nalezen.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // Jen autor může upravit komentář
    if ($_SESSION['user_id'] != $comment['user_id']) {
        $this->addErrorMessage('Nemáte oprávnění upravit tento komentář.');
        header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $comment['trip_id']);
        exit;
    }

    require_once '../app/views/trips/comment_edit.php';
}

// 10. Zpracování úpravy komentáře
public function updateComment($id = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    require_once '../app/models/Database.php';
    require_once '../app/models/Comment.php';

    $database = new Database();
    $db = $database->getConnection();

    $commentModel = new Comment($db);
    $comment = $commentModel->getById((int)$id);

    if (!$comment || $_SESSION['user_id'] != $comment['user_id']) {
        $this->addErrorMessage('Nemáte oprávnění upravit tento komentář.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    $content = htmlspecialchars($_POST['content'] ?? '');

    if (empty($content)) {
        $this->addErrorMessage('Komentář nemůže být prázdný.');
        header('Location: ' . BASE_URL . '/index.php?url=trip/editComment/' . $id);
        exit;
    }

    $isUpdated = $commentModel->update((int)$id, $content);

    if ($isUpdated) {
        $this->addSuccessMessage('Komentář byl upraven.');
    } else {
        $this->addErrorMessage('Nastala chyba. Komentář se nepodařilo upravit.');
    }

    header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $comment['trip_id']);
    exit;
    }

    // 11. Hodnocení výletu
public function rate($id = null) {
    if (!isset($_SESSION['user_id'])) {
        $this->addErrorMessage('Pro hodnocení musíte být přihlášeni.');
        header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rating = (int)($_POST['rating'] ?? 0);

        if ($rating < 1 || $rating > 5) {
            $this->addErrorMessage('Hodnocení musí být mezi 1 a 5.');
            header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Rating.php';

        $database = new Database();
        $db = $database->getConnection();

        $ratingModel = new Rating($db);
        $isSaved = $ratingModel->store((int)$id, (int)$_SESSION['user_id'], $rating);

        if ($isSaved) {
            $this->addSuccessMessage('Hodnocení bylo uloženo.');
        } else {
            $this->addErrorMessage('Nastala chyba. Hodnocení se nepodařilo uložit.');
        }
    }

    header('Location: ' . BASE_URL . '/index.php?url=trip/show/' . $id);
    exit;
}

    // --- Pomocné metody pro systém notifikací ---

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }

    // --- Pomocná metoda pro zpracování nahrávání obrázků ---
    protected function processImageUploads() {
        $uploadedFiles = [];

        // Cesta ke složce pro ukládání obrázků
        $uploadDir = __DIR__ . '/../../public/uploads/';

        // Pokud složka neexistuje, vytvoříme ji
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Kontrola, zda byly nahrány soubory
        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {

            $fileCount = count($_FILES['images']['name']);
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            for ($i = 0; $i < $fileCount; $i++) {

                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {

                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    // Kontrola povolených typů
                    if (!in_array($extension, $allowedExtensions)) {
                        continue;
                    }

                    // Vytvoření unikátního názvu souboru
                    $newName = 'trip_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 5) . '.' . $extension;
                    $targetPath = $uploadDir . $newName;

                    // Fyzický přesun souboru do složky uploads
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $uploadedFiles[] = $newName;
                    }
                }
            }
        }

        return $uploadedFiles;
    }
}