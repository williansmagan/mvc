<?php
defined('ROOTHPATH') OR exit('Access denied');
class Home {
    use \Core\Controller;
    use \Core\Model;

    public function index() {
        try {
            $str  = TYPE_DB . ':dbname=' . NAME_DB . ';host=' . HOST_DB . ';port=' . PORT_DB . CHAR_DB;
            $conn = new \PDO($str, USER_DB, PASS_DB, OPT_DB);
        } catch (PDOException $e) {
            redirect('/install');
        }


        /* READ MODEL
        $read_columns = [
            'user_id',
            'user_firstName',
            'user_lastName',
            'user_email',
        ];

        $read_where = [
            'user_email' => '%mvc%',
            'user_profile_id' => 2,
        ];

        $read_order_columns = [
            'user_email',
        ];

        $read_order_type = '';

        $read_limit = '';

        $read_offset = '';

        $this->read($read_columns, $read_where, $read_order_columns, $read_order_type, $read_limit, $read_offset);


        */



        /* CREATE MODEL
        $sql = "INSERT INTO `user` (user_firstName, user_lastName, user_email, user_password, user_dateRegistered, user_profile_id, user_status_id, user_dateStatus) 
        VALUES ('User', 'General', 'user@mvc.mvc', '" . hash_password('user') . "', '" . default_date() . "', 2, 1, '" . default_date() . "')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();	 

        $sql = "INSERT INTO `user` (user_firstName, user_lastName, user_email, user_password, user_dateRegistered, user_profile_id, user_status_id, user_dateStatus) 
        VALUES ('Test', 'User', 'test@mvc.mvc', '" . hash_password('test') . "', '" . default_date() . "', 2, 1, '" . default_date() . "')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();	 



        /*CREATE MODEL
        
        $values = [
            'user_firstName' => 'User',
            'user_lastName' => 'General',
            'user_email' => 'user@mvc.mvc',
            'user_password' => hash_password('user'),
            'user_dateRegistered' => default_date(),
            'user_profile_id' => 2, 
            'user_status_id' => 1, 
            'user_dateStatus' => default_date(),
        ];
        $this->create($values);

        */


        /*UPDATE MODEL
        $delete_keys = [
            'user_status_id' => 3,
        ];

        $delete_params = [
            'user_id' => 2,
        ];

        $this->delete($delete_keys, $delete_params);
        */


/*

        $user = new User();
        $values = [
            'user_firstName' => 'User',
            'user_lastName' => 'General',
            'user_email' => 'user@mvc.mvc',
            'user_password' => hash_password('user'),
            'user_dateRegistered' => default_date(),
            'user_profile_id' => 2, 
            'user_status_id' => 1, 
            'user_dateStatus' => default_date(),
        ];
        $result = $user->create($values);

*/

        $data = [
            'page_title' => '',
        ];

        $this->view('header', $data);
        $this->view('home/home');
        $this->view('footer');
    }
}


/*
        <form method="post">
<?php if(!empty($data['error'])):?>
            <?=implode('<br>', $data['error'])?>
<?php endif;?>

<?php if(!empty($data['success'])):?>
            <?=$data['success']?>
<?php endif;?>
            <label>Primeiro Nome:</label><input name="user_firstName" type="text">
            <label>Sobrenome:</label><input name="user_lastName" type="text">
            <label>E-mail:</label><input name="user_email" type="email">
            <label>Senha:</label><input name="user_password" type="password">
            <button type="submit">Gravar</button>
        </form>
        */