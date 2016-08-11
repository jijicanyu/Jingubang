<hr>
<label>检测历史</label>
<?php foreach($history as $tasks): ?>
    <?php foreach($tasks as $task): ?>
        <div style="margin-left: 300px">
id: <h3><?php echo $task['id'];?></h3>
        <div>
            <p>url:<?php echo $task['url'];?></p>
            <p>taskid:<?php echo $task['taskid'];?></p>
            <p>isVulnerable:<?php echo $task['isVulnerable'];?></p>
            <p>HttpMethod:<?php echo $task['HttpMethod'];?></p>
            <p>banner:<?php echo $task['banner'];?></p>
            <p>parameter:<?php echo $task['parameter'];?></p>
            <br>
        </div>
        </div>
    <?php endforeach;?>
<?php endforeach;?>
<hr>

