<?php
defined('ROOTHPATH') OR exit('Access denied');
class Install {
    use \Core\Controller;

    public function index() {
        try {
            $conn = new PDO(TYPE_DB . ':host=' . HOST_DB . ';port=' . PORT_DB, USER_DB, PASS_DB);
            $sql  = 'CREATE DATABASE IF NOT EXISTS ' . NAME_DB;
            $stmt = $conn->prepare($sql);
            $stmt->execute(); 
        } catch (PDOException $e) {
            // Caso a conexão falhe, exiba uma mensagem de erro
            die('Erro na conexão: ' . $e->getMessage());
        }
    
        $sql = 'USE ' . NAME_DB;
        $stmt = $conn->prepare($sql);
        $stmt->execute();

		$sql = 'CREATE TABLE IF NOT EXISTS `status` (
			status_id INT(2) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
			status_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
			KEY status_name (status_name)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
		';
		$stmt = $conn->prepare($sql);
		$stmt->execute();	
		
		$sql = 'CREATE TABLE IF NOT EXISTS `profile` (
			profile_id INT(2) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
			profile_name VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
			profile_status_id INT(2) NOT NULL,
			KEY profile_name (profile_name),
			KEY profile_status_id (profile_status_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
		';
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$sql = 'CREATE TABLE IF NOT EXISTS `user` (
			user_id INT(8) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            user_code_unique CHAR(11) COLLATE utf8mb4_general_ci NOT NULL,
			user_firstName VARCHAR(30) COLLATE utf8mb4_general_ci NOT NULL,
			user_lastName VARCHAR(70) COLLATE utf8mb4_general_ci NOT NULL,
			user_email VARCHAR(50) COLLATE utf8mb4_general_ci NOT NULL,
			user_password VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
			user_image VARCHAR(1024) COLLATE utf8mb4_general_ci NULL,
			user_dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP,
            user_dateUpdate DATETIME DEFAULT CURRENT_TIMESTAMP,
			user_profile_id INT(2) NOT NULL,
			user_status_id INT(2) NOT NULL,
			user_dateStatus DATETIME DEFAULT CURRENT_TIMESTAMP,
            KEY user_code_unique (user_code_unique),
			KEY user_firstName (user_firstName),
			KEY user_lastName (user_lastName),
			KEY user_email (user_email),
			KEY user_profile_id (user_profile_id),
			KEY user_status_id (user_status_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
		';
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		
        $sql = "SELECT user_id FROM `user` WHERE user_id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count == 0 || empty($count)) {
            $sql = "INSERT INTO `status` (status_name) VALUES ('enable')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
            $sql = "INSERT INTO `status` (status_name) VALUES ('disable')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();	
    
            $sql = "INSERT INTO `status` (status_name) VALUES ('deleted')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
    
    
            $sql = "INSERT INTO `profile` (profile_name, profile_status_id) VALUES ('administrator', '1')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            $sql = "INSERT INTO `profile` (profile_name, profile_status_id) VALUES ('user', '1')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();	
    
            $sql = "INSERT INTO `profile` (profile_name, profile_status_id) VALUES ('visited', '2')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();		
            
            $sql = "INSERT INTO `user` (user_code_unique, user_firstName, user_lastName, user_email, user_password, user_dateRegistered, user_dateUpdate, user_profile_id, user_status_id, user_dateStatus) VALUES ('00000000000', 'Administrador', 'Sistema', 'admin@admin.adm', '" . hash_password('admin') . "', '" . default_date() . "', '" . default_date() . "', 1, 1, '" . default_date() . "')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();	
        }

        $data = [
            'page_title' => 'Install | ',
        ];
        $this->view('header', $data);
        $this->view('admin/install');
        $this->view('footer');
    }
}