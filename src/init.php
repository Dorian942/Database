<?php
require_once('vendor/autoload.php');

define('SMTP_HOST', 'node-email-1.pulsepanel.eu');
define('SMTP_USER', 'concordiafinal@tcardonne.fr');
define('SMTP_PASSWORD', 'pppUl2ePxS');
define('SMTP_ENCRYPTION', 'tls');
define('SMTP_PORT', '587');
define('SMTP_FROM', SMTP_USER);
define('SMTP_FROM_NAME', 'Ready2Party Crew');

require_once('EmailManager.php');


/** Définition de variables globales pour faciliter la connexion à la bdd **/
define('DB_HOST', 'localhost');
define('DB_NAME', 'bdd2');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

/** Cette classe permet simplement de faire le lien entre les autorisations et les redirections de certains boutons, toutes les fonctionnalités ne sont pas implantées **/
class Core {
    /**
     * Avoid unauth access to the page
     */
    public static function requiresAuth() {
        if(!self::isAuth()) {
            header('Location: login.php');
        }
    }
    /**
    public static function requiresAdminAuth() {
        if(!self::isAdmin()) {
            header('Location: index.php');
        }
    }

    public static function isAuth() {
        if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {
            return true;
        }
        return false;
    }
    /**
    public static function isAdmin() {
        if(self::isAuth()) {
            return $_SESSION['user']->getIsAdmin();
        }

        return false;

    } **/

    public static function login(User $user) {
        $_SESSION['user'] = $user;
    }

    public static function logout() {
        session_destroy();
        session_start();
    }

    public static function refreshSession(User $user) {
        $_SESSION['user'] = $user;
    }

    public static function getCurrentUserID() {
        if(self::isAuth()) {
            return $_SESSION['user']->getId();
        }
        return null;
    }
}

/** Cette classe sert à se connecter à la base de données **/

class DatabaseManager {
    private $db;

    public function __construct($servername, $dbname, $username, $password) {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->db = $conn;
        } catch(PDOException $e) {
            echo 'Erreur dans la bdd : '. $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->db;
    }

    public function resetDatabase($filename) {
        $query = file_get_contents($filename);
        try {
            $req = $this->db->prepare($query);
            $req->execute();
        } catch(PDOException $e) {
            echo 'Erreur dans la bdd : '. $e->getMessage();
            exit;
        }
    }
}

/** Classe utilisateur **/

class User {
    private $id;
    private $email;
    private $nom;
    private $prenom;
    private $adresse;
    private $psw;
    /**
    private $active;
    **/private $confirmToken;/**
    private $isAdmin;

    /**
     * Gets the value of id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param mixed $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the value of firstname.
     *
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Sets the value of firstname.
     *
     * @param mixed $firstname the firstname
     *
     * @return self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Gets the value of lastname.
     *
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Sets the value of lastname.
     *
     * @param mixed $lastname the lastname
     *
     * @return self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Gets the value of phone.
     *
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Sets the value of phone.
     *
     * @param mixed $phone the phone
     *
     * @return self
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Gets the value of password.
     *
     * @return mixed
     */
    public function getPsw()
    {
        return $this->psw;
    }

    /**
     * Sets the value of password.
     *
     * @param mixed $password the password
     *
     * @return self
     */
    public function setPsw($psw)
    {
        $this->psw = $psw;

        return $this;
    }

    /**
     * Gets the value of active.
     *
     * @return mixed
     */
    /**
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the value of active.
     *
     * @param mixed $active the active
     *
     * @return self
     */
    /**
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Gets the value of confirmToken.
     *
     * @return mixed
     */
    
    public function getConfirmToken()
    {
        return $this->confirmToken;
    }

    /**
     * Sets the value of confirmToken.
     *
     * @param mixed $confirmToken the confirm token
     *
     * @return self
     */
    
    public function setConfirmToken($confirmToken)
    {
        $this->confirmToken = $confirmToken;

        return $this;
    }

    /**
     * Gets the value of isAdmin.
     *
     * @return mixed
     */
    /**
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    **/
    /**
     * Sets the value of isAdmin.
     *
     * @param mixed $isAdmin the is admin
     *
     * @return self
     */
    /**
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
    **/
}

class UserManager {
    private $db;

    public function __construct($db, EmailManager $emailManager) {
        $this->db = $db;
        $this->emailManager = $emailManager;
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function checkPasswordHash($password, $hash) {
        return password_verify($password, $hash);
    }

    public function getUserByEmail($email) {
        try {
            $req = $this->db->prepare('SELECT * FROM client WHERE Login = :email LIMIT 1');
            $req->execute(array('email' => $email));
        } catch(PDOException $e) {
            echo 'Erreur de bdd : '. $e->getMessage();
            exit;
        }

        $result = $req->fetch();

        if($result) {
            $user = new User();
            $user->setId($result['Client_ID'])
                ->setEmail($result['Login'])
                ->setNom($result['Nom'])
                ->setPrenom($result['Prenom'])
                ->setAdresse($result['Adresse'])
                ->setPsw($result['MotDePasse'])
                /**
                ->setActive($result['active'])
                **/->setConfirmToken($result['confirm_token']);/**
                ->setIsAdmin($result['is_admin']);
                **/
            return $user;
        } else {
            return null;
        }
    }

    public function getUserById($id) {
        try {
            $req = $this->db->prepare('SELECT * FROM client WHERE Client_ID = :id LIMIT 1');
            $req->execute(array('id' => $id));
        } catch(PDOException $e) {
            echo 'Erreur de bdd : '. $e->getMessage();
            exit;
        }

        $result = $req->fetch();

         if($result) {
            $user = new User();
            $user->setId($result['id'])
                ->setEmail($result['email'])
                ->setNom($result['nom'])
                ->setPrenom($result['prenom'])
                ->setAdresse($result['adresse'])
                ->setPsw($result['MotDePasse'])
                /**
                ->setActive($result['active'])
                **/->setConfirmToken($result['confirm_token']);/**
                ->setIsAdmin($result['is_admin']);
                **/
            return $user;
        } else {
            return null;
        }
    }

    public function persistUser(User $user) {
        try {
        	echo $user->getEmail();
            $req = $this->db->prepare('INSERT INTO client (Nom, Prenom, Adresse, Login, MotDePasse, confirm_token, Piece_Identite) /*active, confirm_token, is_admin*/
                                    VALUES (:nom, :prenom, :adresse, :email, :psw, :confirm_token, 1)');
            $req->bindValue(':email', $user->getEmail());
            $req->bindValue(':nom', $user->getNom());
            $req->bindValue(':prenom', $user->getPrenom());
            $req->bindValue(':adresse', $user->getAdresse());
            $req->bindValue(':psw', $user->getPsw());
            $req->bindValue(':confirm_token', $user->getConfirmToken());
            echo $user->getConfirmToken();
            $req->execute();
        } catch(PDOException $e) {
            echo 'Erreur de bdd : '. $e->getMessage();
            exit;
        }

        $user->setId($this->db->lastInsertId());
    }

    public function registerUser(User $user) {
        $confirmToken = md5(uniqid(mt_rand(), true)); // Generate "random" string for email verification.
        $user->setConfirmToken($confirmToken);
        $user->setPsw(self::hashPassword($user->getPsw()));

        $this->persistUser($user);
        $baseUrl = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://').$_SERVER['SERVER_NAME'].str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(dirname(__FILE__)));
        $confirmURI = $baseUrl.'/register_confirm.php?user='.$user->getId().'&token='.$user->getConfirmToken();

        $content = array();
        $content[] = "Dear ".$user->getNom().",";
        $content[] = "Please click on the following link to confirm your account.";
        $content[] = $confirmURI;
        $content[] = "Best regards,";
        $content[] = "Hugo Borsier";
        $this->emailManager->send($user->getEmail(), "[Hugo Borsier] Confirm your account", implode("\n", $content));
    }

    public function updateUser(User $user) {
        try {
            $req = $this->db->prepare('UPDATE client SET
                Nom = :nom,
                Prenom = :prenom,
                Adresse = :adresse,
                Login = :email,
               	MotDePasse = :psw,
               	Piece_Identite = 1,
               	confirm_token = :confirm_token
               	/**
                active = :active,
                confirm_token = :confirm_token,
                is_admin = :is_admin
                **/
                WHERE Client_ID = :id');

            $req->bindValue(':id', $user->getId());
            $req->bindValue(':email', $user->getEmail());
            $req->bindValue(':nom', $user->getNom());
            $req->bindValue(':prenom', $user->getPrenom());
            $req->bindValue(':adresse', $user->getAdresse());
            $req->bindValue(':psw', $user->getPsw());
            /**
            $req->bindValue(':active', $user->getActive());
            */
            $req->bindValue(':confirm_token', $user->getConfirmToken());/*
            $req->bindValue(':is_admin', $user->getIsAdmin());
            **/
            echo 'yolo';
            $req->execute();
        } catch(PDOException $e) {
            echo 'Erreur de la bdd : '. $e->getMessage();
            exit;
        }
    }
}
session_start();

$dbManager = new DatabaseManager(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
$emailManager = new EmailManager(SMTP_HOST, SMTP_USER, SMTP_PASSWORD, SMTP_ENCRYPTION, SMTP_PORT, SMTP_FROM, SMTP_FROM_NAME);
$userManager = new UserManager($dbManager->getConnection(), $emailManager);

?>