<p>engineid:<?php echo $engineid;?></p>
<p>taskid:<?php echo $taskid;?></p>
<a href="<?php echo $api."/scan/".$taskid."/status";?>">查看任务当前状态</a>
<a href="<?php echo $api."/scan/".$taskid."/data";?>">查看任务数据</a>
<a href="<?php echo $api."/scan/".$taskid."/log";?>">查看任务日志</a>