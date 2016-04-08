<?php
	// TODO: inventory in the future
	$sql_query="Call getInventoryByDay({?})";
	$result=$db->query($sql_query, array($date));
?>