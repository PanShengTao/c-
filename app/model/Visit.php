<?php


namespace app\model;

use think\facade\Db;
use think\Model;

class Visit extends Model
{
    public function VisitCount(): array
    {

        $sql = "SELECT vday,COUNT(vday) as visit_num from" . "
(
SELECT *,FROM_UNIXTIME(vtime,'%Y-%m-%d') as formatvisittime,FROM_UNIXTIME(vtime,'%d') as vday from sys_visit where FROM_UNIXTIME(vtime,'%m')=MONTH(CURDATE()) and FROM_UNIXTIME(vtime,'%Y')=YEAR(CURDATE())
) as temp_a GROUP BY temp_a.vday;";
        return Db::query("$sql");
    }
}