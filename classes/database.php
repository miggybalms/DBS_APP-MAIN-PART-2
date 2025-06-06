<?php
 
class database {
 
    function opencon(): PDO {
        return new PDO(
            dsn: 'mysql:host=localhost;dbname=dbs_app',
            username: 'root',
            password: ''
        );
    }
 
    function signupUser($firstname, $lastname, $username, $password, $email) {
        $con = $this->opencon();
        try {
            $con->beginTransaction();
            $stmt = $con->prepare("INSERT INTO Admin(admin_FN, admin_LN, admin_username, admin_password, admin_email) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $username, $password, $email]);
            $userId = $con->lastInsertId();
 
            $con->commit();
            return $userId;
        } catch (PDOException $e) {
            $con->rollBack();
            return false;
        }
    }
        public function isUsernameExists($username) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }
        public function isemailExists($email) {
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT COUNT(*) FROM Admin WHERE admin_email = ?");
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
        }


        function loginUser($username, $password) {
 
        $con = $this->opencon();
        $stmt = $con->prepare("SELECT * FROM Admin WHERE admin_username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password, $user['admin_password'])){
 
            return $user;
           
 
        } else {
 
            return false;
        }
       
 
 
    }
 
}


//$con = $this->opencon();
//$stmt = $con->prepare("SELECT * from admin Where admin_username = ?")
//$stmt -> excute([$username]);
//$user = $stmt->fetch(PDO::FETCH_ASSOC);