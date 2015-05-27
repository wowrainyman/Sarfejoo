<?php
require_once "settings.php";
require_once "provider.php";
class ModelSettingPuSetting extends Model
{
    public function getSettingValue($key)
    {
        $pu_database_name = $GLOBALS['pu_database_name'];
        $oc_database_name = $GLOBALS['oc_database_name'];
        $query = "SELECT * FROM $pu_database_name.pu_setting WHERE `key` = '$key'";
        $con_PU_db = $GLOBALS['con_PU_db'];
        echo $query;
        $query = $this->db->query($query);
        return $query->rows;
    }
}

?>