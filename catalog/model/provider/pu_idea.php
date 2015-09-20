<?php
require_once "provider.php";
require_once "settings.php";
class ModelProviderPuIdea extends Model {
	public function insert($user_id, $title, $content)
	{
		$con_PU_db = $GLOBALS['con_PU_db'];
		$sql_insert_string = "INSERT INTO `pu_idea_suggestion`" .
			"(`customer_id`, `title`, `content`)" .
			"VALUES ('$user_id', '$title', '$content');";
		$result_test_mod = mysqli_query($con_PU_db, $sql_insert_string) or die(mysqli_error());
		$id = mysqli_insert_id($con_PU_db);
		return $id;
	}
}
?>