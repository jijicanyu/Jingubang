
    function show(issue) {
        var oMask = document.createElement('div');
        var sHeight = document.documentElement.scrollHeight;
        oMask.style.height = sHeight;
        oMask.id = "mask";
        document.body.appendChild(oMask);
        var msg = document.createElement('div');
        msg.innerHTML = '<div class="message" id="message"><textarea class="key" id="key"  cols="30" rows="10"></textarea></div>';
        document.body.appendChild(msg);
        document.getElementById('key').innerHTML = issue;
        var mHeight = msg.offsetHeight;
        var mWidth = msg.offsetWidth;
        var wHeight = document.documentElement.clientHeight;
        var wWidth = document.documentElement.clientWidth;
        msg.style.left = (wWidth - mWidth) / 2;
        msg.style.top = (wHeight - mHeight) / 2;
         oMask.onclick = function () {
            document.body.removeChild(oMask);
            document.body.removeChild(msg);
        }
    }
    function getPayLoads(taskid) {
        var url = $('#webUrl').text();
        url = url + '/jingubang/getPayLoads'
        var data = taskid;
        $.ajax({
            type: "POST",
            url: url,
            data: {"taskid": data},
            dataType: "text",
            async: false,
            success: function (payloads) {
                show(payloads);
            },
            error: function () {
                alert('something wrong error 002');
            }
        });

    }
    function deleteRecord(taskid) {
        var record = document.getElementById(taskid);
        document.body.removeChild(record);
        var url = $('#webUrl').text();
        url = url + '/jingubang/delete';
        var data = taskid;
        $.ajax({
                type: "POST",
                url: url,
                data: {"taskid": data},
                dataType: "text",
                async: false,
                success: function (log) {
                    show(log);
                },
                error: function () {
                    alert('something wrong error 000');
                }
            }
        );
    }

    function getLog(taskid) {
        var url = $('#webUrl').text();
        url = url + '/jingubang/log';
        var data = taskid;
        $.ajax({
                type: "POST",
                url: url,
                data: {"taskid": data},
                dataType: "text",
                async: false,
                success: function (log) {
                    show(log);
                },
                error: function () {
                    alert('something wrong error 001');
                }
            }
        );
    }

    function sql() {
        var optionArr = {};
        optionArr['method'] = document.getElementById('select_method').value;
        optionArr['flushSession'] = document.getElementById('select_fmethod').value;
        if (optionArr['method'] == "POST") {
            optionArr['data'] = document.getElementById('post_data').value;
        }
        optionArr['level'] = document.getElementById('select_scan_level').value;
        optionArr['threads'] = document.getElementById('select_thread_count').value;
        optionArr['tamper'] = document.getElementById('select_tamper').value;
        if (document.getElementById('select_proxy_support').value == 'enabled') {
            optionArr['proxy'] = document.getElementById('proxy_str').value;
        }
        optionArr['delay'] = document.getElementById('select_request_delay').value;
        var agent = document.getElementById('select_user_agent_type').value;
        if (agent == "mobile") {
            optionArr['mobile'] = 'true';
        }
        else if (agent == 'random') {
            optionArr['randomAgent'] = 'true';
        }
        else if (agent == 'custom') {
            optionArr['agent'] = document.getElementById('user_agent').value;
        }
        if (document.getElementById('select_cookie_support').value == 'enabled') {
            optionArr['cookie'] = document.getElementById('cookie_str').value;
        }
        var auth = document.getElementById('select_auth_type').value;
        if (auth != "") {
            optionArr['authCred'] = document.getElementById('auth_username').value + ":" + document.getElementById('auth_password').value;
            optionArr['authType'] = auth;
        }
        if (document.getElementById('select_referer_support').value == 'enabled') {
            optionArr['referer'] = document.getElementById('referer_str').value;
        }
        if (document.getElementById('select_request_prefix').value == 'enabled') {
            optionArr['prefix'] = document.getElementById('request_prefix_str').value;
        }
        if (document.getElementById('select_request_suffix').value == 'enabled') {
            optionArr['suffix'] = document.getElementById('request_suffix_str').value;
        }
        if (document.getElementById('select_request_header').value == 'enabled') {
            optionArr['headers'] = document.getElementById('request_header_str').value;
        }
        console.log('end');
        optionArr = JSON.stringify(optionArr);
        return optionArr;
    }

    var formatJson = function(json, options) {
    var reg = null,
    formatted = '',
    pad = 0,
    PADDING = '    '; // one can also use '\t' or a different number of spaces

    // optional settings
    options = options || {};
    // remove newline where '{' or '[' follows ':'
    options.newlineAfterColonIfBeforeBraceOrBracket = (options.newlineAfterColonIfBeforeBraceOrBracket === true) ? true : false;
    // use a space after a colon
    options.spaceAfterColon = (options.spaceAfterColon === false) ? false : true;

    // begin formatting...
    if (typeof json !== 'string') {
    // make sure we start with the JSON as a string
    json = JSON.stringify(json);
    } else {
    // is already a string, so parse and re-stringify in order to remove extra whitespace
    json = JSON.parse(json);
    json = JSON.stringify(json);
    }

    // add newline before and after curly braces
    reg = /([\{\}])/g;
    json = json.replace(reg, '\r\n$1\r\n');

    // add newline before and after square brackets
    reg = /([\[\]])/g;
    json = json.replace(reg, '\r\n$1\r\n');

    // add newline after comma
    reg = /(\,)/g;
    json = json.replace(reg, '$1\r\n');

    // remove multiple newlines
    reg = /(\r\n\r\n)/g;
    json = json.replace(reg, '\r\n');

    // remove newlines before commas
    reg = /\r\n\,/g;
    json = json.replace(reg, ',');

    // optional formatting...
    if (!options.newlineAfterColonIfBeforeBraceOrBracket) {
    reg = /\:\r\n\{/g;
    json = json.replace(reg, ':{');
    reg = /\:\r\n\[/g;
    json = json.replace(reg, ':[');
    }
    if (options.spaceAfterColon) {
    reg = /\:/g;
    json = json.replace(reg, ':');
    }

    $.each(json.split('\r\n'), function(index, node) {
    var i = 0,
    indent = 0,
    padding = '';

    if (node.match(/\{$/) || node.match(/\[$/)) {
    indent = 1;
    } else if (node.match(/\}/) || node.match(/\]/)) {
    if (pad !== 0) {
    pad -= 1;
    }
    } else {
    indent = 0;
    }

    for (i = 0; i < pad; i++) {
    padding += PADDING;
    }

    formatted += padding + node + '\r\n';
    pad += indent;
    });

    return formatted;
    };