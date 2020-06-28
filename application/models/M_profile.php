<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_profile extends CI_Model
{

	public function getTransacton($id)
	{
		$sql = "SELECT
`transaction`.*,
`transaction`.`id` as transid,
`details_transaction`.*,
`users`.`name` AS username,
`ticket`.*
FROM
    `details_transaction`
    INNER JOIN `transaction` 
        ON (`details_transaction`.`transaction_id` = `transaction`.`id`)
    INNER JOIN `users` 
        ON (`transaction`.`user_id` = `users`.`id`)
    INNER JOIN `ticket` 
        ON (`details_transaction`.`ticket` = `ticket`.`id`)
	WHERE `transaction`.`id` = '$id'
	ORDER BY `transaction`.`date` DESC";
		$result = $this->db->query($sql)->result();
		return $result;
	}
}
