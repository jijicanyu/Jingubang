<h2><?php echo $title; ?></h2>
<h5>请不要忽略http/https</h5>
</div>
<div style="width:500px;"><label style="width:50px;text-align:right;" for="url">URL</label>
    <input type="text" name="url" id="sqlurl" style="width:150px;"/><br/>
</div>
<div style="width:500px;">
    <input  type="submit" name="submit" id="subbtn" value="开始检测"/>
    <br/>
</div>
</form>
<script>
    $(document).ready(function () {
        $("#subbtn").click(function () {
            var sqlurl = $("#sqlurl").val();
            var url = "<?php echo site_url('jingubang/sql')?>";
            $.ajax({
                type:"POST",
                url:url,
                data:{"url":sqlurl},
                dataType:"text",
                async:true,
                success:function (msg) {
                    
                },
                error:function () {

                }
            });
        });
    });
</script>