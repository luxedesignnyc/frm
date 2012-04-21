<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Counter_model extends Model
{
    function __construct()
	{
		parent::Model();
	}
	
	function get()
	{
        $this->db->cache_off();
		$sql = "SELECT cou_counter FROM tbtt_counter";
		#Query
		$query = $this->db->query($sql);
		$result = $query->row();
		$query->free_result();
		return $result;
	}
	
	function update()
    {
		$sql = "UPDATE tbtt_counter";
		$sql .= " SET cou_counter = cou_counter + 1";
		#Query
		$query = $this->db->query($sql);
    }
}