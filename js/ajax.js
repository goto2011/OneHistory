// <!--  // created by duangan, 2015-4-3	-->
// <!--  // support ajax function.	-->

/*
* Name: xhr,AJAX封装函数
* Description: 一个ajax调用封装类,仿jquery的ajax调用方式
* 
* 参数说明:
1. url: 请求地址.可以不填,请求就不会发起,但如果不填又强行send,出了错不怪我
2. method: ‘GET'或'POST',全大写,默认GET
3. data: 要附带发送的数据,格式是一个object
4. async: 是否异步,默认true
5. type: 返回的数据类型,只有responseText或responseXML,默认responseText
6. complete: 请求完成时执行的函数
7. success: 请求成功时执行的函数
8. error: 请求失败时执行的函数

*/

var xhr = function () {
    var 
    ajax = function  () {
        return ('XMLHttpRequest' in window) ? function  () {
        	return new XMLHttpRequest();
           } : function  () {
            return new ActiveXObject("Microsoft.XMLHTTP");
        };
    }(),
    formatData= function (fd) {
        var res = '';
        for(var f in fd) {
            res += f+'='+fd[f]+'&';
        }
        return res.slice(0,-1);
    },
    
    AJAX = function(ops) {
        var     
        root = this,
        req = ajax();
        root.url = ops.url;
        root.type = ops.type || 'responseText';
        root.method = ops.method || 'GET';
        root.async = ops.async || true;     
        root.data = ops.data || {};
        root.complete = ops.complete || function  () {};
        root.success = ops.success || function(){};
        root.error =  ops.error || function (s) { alert(root.url+'->status:'+s+'error!');};
        root.abort = req.abort;
        root.setData = function  (data) {
            for(var d in data) {
                root.data[d] = data[d];
            }
        };
        
        root.send = function  () {
            var datastring = formatData(root.data),
            sendstring,get = false,
            async = root.async,
            complete = root.complete,
            method = root.method,
            type=root.type;
            if(method === 'GET') {
                root.url+='?'+datastring;
                get = true;
            }
            req.open(method,root.url,async);
            if(!get) {
                req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                sendstring = datastring;
            }
            
            // 在send之前重置onreadystatechange方法,否则会出现新的同步请求会执行两次成功回调.
            // chrome等在同步请求时也会执行onreadystatechange.
            req.onreadystatechange = async ? function  () {
                // console.log('async true');
                if (req.readyState == 4){
                    complete();
                    if(req.status == 200) {
                        root.success(req[type]);
                    } else {
                        root.error(req.status);
                    }                   
                }
            } : null;
            req.send(sendstring);
            if(!async) {
                //console.log('async false');
                complete();
                root.success(req[type]);
            }
        };
        root.url && root.send();        
    };
    return function(ops) {return new AJAX(ops);};
}();