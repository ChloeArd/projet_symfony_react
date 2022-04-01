<?php
namespace Model\User;

use JetBrains\PhpStorm\Pure;
use Model\DB;
use Model\Entity\User;
use Model\Role\RoleManager;
use Model\Manager\Traits\ManagerTrait;

class UserManager {

    use ManagerTrait;

    private RoleManager $roleManager;

    #[Pure] public function __construct() {
        $this->roleManager = new RoleManager();
    }

    /**
     * Return all users.
     * @return array
     */
    public function getUsers(): array {
        $users = [];
        $request = DB::getInstance()->prepare("SELECT * FROM user");
        $result = $request->execute();
        if($result) {
            foreach($request->fetchAll() as $info) {
                $role = $this->roleManager->getRole($info['role_fk']);
                if ($role->getId()) {
                    $users[] = new User($info['id'], $info['firstname'], $info['lastname'], $info['email'],'', $role);
                }
            }
        }
        return $users;
    }

    /**
     * Return a user based on id.
     * @param $id
     * @return User
     */
    public function getUser( $id): User {
        $request = DB::getInstance()->prepare("SELECT * FROM user WHERE id = :id");
        $request->bindParam(":id", $id);
        $request->execute();
        $info = $request->fetch();
        $user = new User();
        if ($info) {
            $user->setId($info['id']);
            $user->setFirstname($info['firstname']);
            $user->setLastname($info['lastname']);
            $user->setEmail($info['email']);
            $user->setPassword(''); // We do not display the password
            $role = $this->roleManager->getRole($info['role_fk']);
            $user->setRoleFk($role);
        }
        return $user;
    }

    /**
     * Display a user based on id.
     * @param int $id
     * @return array
     */
    public function getUserID(int $id): array {
        $user = [];
        $request = DB::getInstance()->prepare("SELECT * FROM user WHERE id = :id");
        $request->bindParam(":id", $id);
        if($request->execute()) {
            foreach($request->fetchAll() as $info) {
                $role = $this->roleManager->getRole($info['role_fk']);
                if ($role->getId()) {
                    $user[] = new User($info['id'], $info['firstname'], $info['lastname'] ,$info['email'], '', $role);
                }
            }
        }
        return $user;
    }

    /**
     * Modifies the user's personal information.
     * @param User $user
     * @return bool
     */
    public function updateUser(User $user): bool {
        $request = DB::getInstance()->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id");
        $request->bindValue(':id', $user->getId());
        $_SESSION['firstname'] = $user->setFirstname($user->getFirstname());
        $request->bindValue(':firstname', $user->setFirstname($user->getFirstname()));
        $_SESSION['lastname'] = $user->setLastname($user->getLastname());
        $request->bindValue(':lastname', $user->setLastname($user->getLastname()));
        $_SESSION['email'] = $user->setEmail($user->getEmail());
        $request->bindValue(':email', $user->setEmail($user->getEmail()));

        return $request->execute();
    }

    /**
     * Change a user's role.
     * @param User $user
     * @return bool
     */
    public function updateRoleUser(User $user): bool {
        $request = DB::getInstance()->prepare("UPDATE user SET role_fk = :role_fk WHERE id = :id");
        $request->bindValue(':id', $user->getId());
        $request->bindValue(':role_fk', $user->setRoleFk($user->getRoleFk())->getId());

        return $request->execute();
    }

    /**
     * Deletes a user but also deletes the cart.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $request = DB::getInstance()->prepare("DELETE FROM cart WHERE user_fk = :user_fk");
        $request->bindParam(":user_fk", $id);
        $request->execute();
        $request = DB::getInstance()->prepare("DELETE FROM user WHERE id = :id");
        $request->bindParam(":id", $id);

        session_start();
        session_unset();
        session_destroy();

        return $request->execute();
    }
}