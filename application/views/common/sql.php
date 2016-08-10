<h2><?php echo $title; ?></h2>
<?php echo validation_errors(); ?>
<?php echo form_open('jingubang/sql'); ?>
<h5>请不要忽略http/https</h5>
</div>
<div style="width:500px;"><label style="width:50px;text-align:right;" for="url">URL</label>
    <input type="text" name="url"  style="width:150px;"/><br/>
</div>
<!--<div style="width:500px;"><label style="width:50px;text-align:right;" for="email">邮 箱</label>
    <input type="text" name="email" maxlength="32" style="width:150px;"/><br/>
</div>
<div style="width:500px;"><label style="width:50px;text-align:right;" for="mobile">手机号</label>
    <input type="text" name="mobile" maxlength="32" style="width:150px;"/><br/>
</div>-->
<div style="width:500px;">
    <input  type="submit" name="submit" value="开始检测"/>
    <br/>
</div>
</form>
