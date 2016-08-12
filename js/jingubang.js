/**
 * Created by undefined on 16-8-11.
 */
function getPayLoads(taskid) {
    var url = $('#webUrl').text();
    url = url +'/jingubang/getPayLoads'
    var data = taskid;
    $.ajax({
        type:"POST",
        url:url,
        data:{"taskid":data},
        dataType:"text",
        async:false,
        success:function (payloads) {
            document.write(payloads);
        },
        error:function () {
            alert('something wrong error 002');
        }
    });

}

function getLog(taskid) {
    var url = $('#webUrl').text();
    url = url +'/jingubang/log';
    var data = taskid;
    $.ajax({
            type:"POST",
            url:url,
            data:{"taskid":data},
            dataType:"text",
            async:false,
            success:function (log) {
                document.write(log);
            },
            error:function () {
                alert('something wrong error 001');
            }
        }
    );
}

function sql() {
    var optionArr = {};
    optionArr['method'] = document.getElementById('select_method').value;
    optionArr['flushSession'] = document.getElementById('select_fmethod').value;
    if(optionArr['method']=="POST"){
        optionArr['data'] = document.getElementById('post_data').value;
    }
    optionArr['level'] = document.getElementById('select_scan_level').value;
    optionArr['threads'] = document.getElementById('select_thread_count').value;
    optionArr['tamper'] = document.getElementById('select_tamper').value;
    if(document.getElementById('select_proxy_support').value == 'enabled'){
        optionArr['proxy'] = document.getElementById('proxy_str').value;
    }
    optionArr['delay'] = document.getElementById('select_request_delay').value;
    var agent = document.getElementById('select_user_agent_type').value;
    if(agent == "mobile"){
        optionArr['mobile'] = 'true';
    }
    else if(agent == 'random'){
        optionArr['randomAgent'] = 'true';
    }
    else if(agent == 'custom'){
        optionArr['agent'] = document.getElementById('user_agent').value;
    }
    if(document.getElementById('select_cookie_support').value=='enabled'){
        optionArr['cookie'] = document.getElementById('cookie_str').value;
    }
    var auth = document.getElementById('select_auth_type').value;
    if(auth != ""){
        optionArr['authCred'] = document.getElementById('auth_username').value+":"+document.getElementById('auth_password').value;
        optionArr['authType'] = auth;
    }
    if(document.getElementById('select_referer_support').value == 'enabled'){
        optionArr['referer'] = document.getElementById('referer_str').value;
    }
    if(document.getElementById('select_request_prefix').value == 'enabled'){
        optionArr['prefix'] = document.getElementById('request_prefix_str').value;
    }
    if(document.getElementById('select_request_suffix').value == 'enabled'){
        optionArr['suffix'] = document.getElementById('request_suffix_str').value;
    }
    if(document.getElementById('select_request_header').value == 'enabled'){
        optionArr['headers'] = document.getElementById('request_header_str').value;
    }
    console.log('end');
    optionArr = JSON.stringify(optionArr);
    return optionArr;
}