<?php

class Users extends Controller
{

    use Redirectable;

    public function __construct($private)
    {
        parent::__construct($private);
    }

    // Permission = true
    public function login()
    {

        if (isset($_GET['from']) && $_GET['from'] == 'nep')
            echo '<pre>$_COOKIE' . print_r($_COOKIE, true) . '</pre>';

        $user = new User('jponspons@gmail.com');
        $user->getAll();

        if (isset($_GET['message']) && $$_GET['message'] == 'nep')
            $message = 'nep';
        else
            $message = '';
        $view = new View(['loginForm'], ['message' => $message]);
    }


    // permission = true
    public function doLogin()
    {
        // do the login and redirect to the stories page

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user = new User($_POST['email'], 'name', $_POST['password']); // session started

            if (!$user->getJustEmail()) {
                $this->set2Session($user);
                if (isset($_GET['message']) && $_GET['message'] == 'nep') {
                    $nep = json_decode($_COOKIE['nep_get'], true);
                    echo '<pre>$nep' . print_r($nep, true) . '</pre>';
                    $ca = "/{$nep['controller']}/{$nep['action']}";
                    unset($nep['controller']);
                    unset($nep['action']);
                    $params = [];
                    foreach ($nep as $index => $item) {
                        $params[] = $index . '=' . $item;
                    }
                    $params = implode('&', $params);
                    header("Location: " . FORM_ACTION . "{$ca}?{$params}");
                } else {
                    header("Location: " . FORM_ACTION . "/bookings/showForms");
                }
            }
            if ($user->getRegistered()) {
                $params = '';
                if (isset($_GET['message']) && $_GET['message'] == 'nep') {
                    $params = '?message=nep';
                }
                header("Location: " . FORM_ACTION . "/users/login?{$params}");
                die;
            }
        }
    }

    private function set2Session(User $user)
    {
        $this->session = new Session();
        $this->session->setVar('userType', $user->getUserType());
        $this->session->setVar('logged', 'true');
        $this->session->setVar('userId', $user->getUserId());
        $this->session->setVar('userEmail', $user->getEmail());
        $this->session->setVar('userDNI', $user->getDNI());
        $this->session->setVar('userName', $user->getName());
    }

    // permission = true
    public function register()
    {
        if (isset($_GET['message']))
            $message = $_GET['message'];
        else
            $message = '';
        return new View(['registerForm' => 'registerForm'], ['message' => $message]);
    }

    public function create()
    {
        new View(['header']);
        new View([], [], ['MenuWidget' => [
            'userType' => $this->session->getVar('userType')
        ]]);

        return new View(['createUser']);
    }

    // permission = true
    public function doRegister()
    {
        // do the register and
        // redirect to login
        $passwordHashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $user = new User($_POST['email'], $_POST['name'], $passwordHashed, $_POST['dni'], true);
        if (isset($_GET['from']) && $_GET['from'] == 'createUser') {
            header("Location: " . FORM_ACTION . "/users/allUsers");
        } else {
            header("Location: " . FORM_ACTION . "/users/login?message={$_GET['message']}");
        }
    }

    // permission = false
    public function doLogout()
    {
        // redirection to login page
        $this->session->destroy();
        header("Location: " . FORM_ACTION . "/books/home");
    }

    // permission = falsec
    public function unregister()
    {
        // unregister the user and redirect to the login page

        $logged = $this->session->getVar('logged');

        if (isset($logged) && $logged == 'true') {
            $user = new User($this->session->getVar('userEmail'));
            if ($user->unregister())
                header("Location: " . FORM_ACTION . "/users/login");
        }
    }

    // permission = false;
    public function edit()
    {
        $user = new User($_GET['email']);
        // show edit user form
        new View(['header']);
        new View([], [], ['MenuWidget' => [
            'userType' => $this->session->getVar('userType')
        ]]);


        return new View([], [], ['UserEditProfile' => [
            'userName' => $user->getName(),
            'surnames' => $user->getSurnames(),
            'userEmail' => $user->getEmail(),
            'userType' => $user->getUserType(),
            'phone' => $user->getPhone()
        ]]);
    }

    // permission = false
    public function update()
    {
        // update and redirect to the stories list
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_GET['email'])) {
                $userEmail = $_GET['email'];
            } else {
                $userEmail = $this->session->getVar('userEmail');
            }

            $ficheroSubido = IMG_USERS . basename($userEmail . '.jpg');
            if (move_uploaded_file($_FILES['userImage']['tmp_name'], $ficheroSubido)) {
                echo "El fichero es válido y se subió con éxito.\n";
            } else {
                echo "¡Posible ataque de subida de ficheros!\n";
            }

            $userTypes = new UserType();
            $types = $userTypes->getAll();
            $type = $types[$_POST['userType']];

            $user = new User($userEmail);
            $user->setName($_POST['name']);
            $user->setSurnames($_POST['surnames']);
            $user->setPhone($_POST['phone']);
            $user->setEmail($_REQUEST['email']);
            if (isset($_POST['userType'])) {
                $user->setUserType($type, $user->getUserId());
                $this->redirect('/users/allUsers');
            } else {
                $this->redirect('/users/editCurrent');
            }
        }
    }

    public function allUsers()
    {
        $user = new User($this->session->getVar('userEmail'));
        $all = $user->getAllUsers(['dni', 'name', 'email']);
        new View(['header']);
        new View([], [], ['MenuWidget' => [
            'userType' => $this->session->getVar('userType')
        ]]);

        new View(['buttonNewUser'], [], ['TableWidget' => [
            'fields' => ['dni', 'name', 'email', 'edit', 'delete'],
            'values' => $all,
            'editable' => true,
            'editURI' => '/users/edit?email=',
            'editNum' => 2,
            'deletable' => true,
            'deleteURI' => '/users/delete?email='
        ]]);
    }

    public function editCurrent()
    {
        $this->menu();
        $user = new User($this->session->getVar('userEmail'));
        new View(['editUser'], [
            'name' => $user->getName(),
            'surnames' => $user->getSurnames(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'img' => FORM_ACTION . '/public/assets/img/users/' . $this->session->getVar('userEmail') . '.jpg'
        ]);

    }

    public function delete()
    {

        if (isset($_GET['email'])) {
            $user = new User($_GET['email']);
            if ($user->unregister())
                header("Location: " . FORM_ACTION . "/users/allUsers");
        }
    }

}