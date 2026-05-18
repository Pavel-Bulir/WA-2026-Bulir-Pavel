<?php

class AuthController {

    // 1. Zobrazení registračního formuláře
    public function register() {
        require_once '../app/views/auth/register.php';
    }

    // 2. Zpracování dat z registrace
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');
            
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $this->addErrorMessage('Vyplňte prosím všechna povinná pole.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if ($password !== $passwordConfirm) {
                $this->addErrorMessage('Zadaná hesla se neshodují.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if (strlen($password) < 8) {
                $this->addErrorMessage('Heslo musí mít alespoň 8 znaků.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if (!preg_match('/[0-9]/', $password)) {
                $this->addErrorMessage('Heslo musí obsahovat alespoň jedno číslo.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            if (!preg_match('/[A-Z]/', $password)) {
                $this->addErrorMessage('Heslo musí obsahovat alespoň jedno velké písmeno.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            if ($userModel->register($username, $email, $password, $firstName, $lastName, $nickname)) {
                $this->addSuccessMessage('Registrace byla úspěšná. Nyní se můžete přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            } else {
                $this->addErrorMessage('Uživatel s tímto e-mailem již existuje.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
        }
    }

    // 3. Zobrazení přihlašovacího formuláře
    public function login() {
        require_once '../app/views/auth/login.php';
    }

    // 4. Zpracování přihlášení
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = !empty($user['nickname']) ? $user['nickname'] : $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'] ?? 0;

                $this->addSuccessMessage('Vítejte zpět, ' . $_SESSION['user_name'] . '!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
                
            } else {
                $this->addErrorMessage('Nesprávný e-mail nebo heslo.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
        }
    }

    // 5. Odhlášení uživatele
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        
        $this->addSuccessMessage('Byli jste úspěšně odhlášeni.');
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    // 6. Zobrazení profilu uživatele
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro zobrazení profilu musíte být přihlášeni.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        $userModel = new User($db);
        $user = $userModel->findById((int)$_SESSION['user_id']);

        require_once '../app/views/auth/profile.php';
    }

    // 7. Zpracování úpravy profilu
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';

            $database = new Database();
            $db = $database->getConnection();

            $userModel = new User($db);
            $isUpdated = $userModel->update(
                (int)$_SESSION['user_id'],
                $firstName,
                $lastName,
                $nickname
            );

            if ($isUpdated) {
                $_SESSION['user_name'] = !empty($nickname) ? $nickname : $_SESSION['user_name'];
                $this->addSuccessMessage('Profil byl úspěšně upraven.');
            } else {
                $this->addErrorMessage('Nastala chyba. Profil se nepodařilo uložit.');
            }

            header('Location: ' . BASE_URL . '/index.php?url=auth/profile');
            exit;
        }
    }

    // 8. Seznam uživatelů (pouze admin)
    public function users() {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            $this->addErrorMessage('Nemáte oprávnění zobrazit tuto stránku.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        $userModel = new User($db);
        $users = $userModel->getAll();

        require_once '../app/views/auth/users.php';
    }

    // 9. Smazání uživatele (pouze admin)
    public function deleteUser($id = null) {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            $this->addErrorMessage('Nemáte oprávnění smazat uživatele.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/users');
            exit;
        }

        if ($id == $_SESSION['user_id']) {
            $this->addErrorMessage('Nemůžete smazat svůj vlastní účet.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/users');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/User.php';

        $database = new Database();
        $db = $database->getConnection();

        $userModel = new User($db);
        $isDeleted = $userModel->delete((int)$id);

        if ($isDeleted) {
            $this->addSuccessMessage('Uživatel byl smazán.');
        } else {
            $this->addErrorMessage('Nastala chyba. Uživatele se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php?url=auth/users');
        exit;
    }

    // --- Pomocné metody pro notifikace ---
    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }

    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }

    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }
}