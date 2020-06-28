<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	public function getTransaction()
	{
		$sql = "SELECT
    `transaction`.`id`
    , `transaction`.`expired`
    , `transaction`.`status`
    , `users`.`name`
FROM
    `transaction`
    INNER JOIN `users` 
        ON (`transaction`.`user_id` = `users`.`id`)
	WHERE `transaction`.`status` = 'Payment'
	ORDER BY `transaction`.`date` ASC;";

		$result = $this->db->query($sql)->result();
		return $result;
	}

	public function getDetail($id)
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
    WHERE `transaction`.`id` = '$id';";
		$result = $this->db->query($sql)->result();
		return $result;
	}
}
