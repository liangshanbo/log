/**
 * 日志
 * @author wanglonghai
 * @date  2016-03-18
 */
 localStorage.setItem('a',10);
 sessionStorage.setItem('a',10);
 document.cookie = 'name=shanbo';
(function(win,doc){
	var Log = {
		env:function(){
			var host = location.host;
			if(/m\.gomeplus/.test(host)){//生产环境
				return 1; 
			}else if(/pre/.test(host)){//预生产环境
				return 2;
			}else if(/test/.test(host)){//测试环境
				return 3;
			}else if(/dev/.test(host)){//开发环境
				return 4;
			}else{
				return 3;
			}
		}(),
		getData:function(url,callback){
			Log.request('get',url,callback);
		},
		postData:function(url,params,callback){
			Log.request('post',url,params,callback);
		},
		request:function(method,url,params,callback){
			var xhr = new (XMLHttpRequest || ActiveXObject("Microsoft.XMLHTTP"))(),
				method = method || 'get';
				url = url || '';
				params = params || {},
				isJSON = url.indexOf('.json') > 0?true:false;
			if(arguments.length === 3){
				callback = params;
				params = {};
			}
			xhr.open(method,url);
			method === 'post' && xhr.setRequestHeader("Content-type","application/json");
			isJSON?xhr.responseType="json":xhr.responseType="text";
			if(xhr.timeout !== undefined){
				xhr.onload = load;
			}else{
				xhr.onreadystatechange = load;
			}
			function load(){
				if(xhr.timeout !== undefined){
					callback&&callback(xhr.response);
					console.log('xhr success');
				}else if(xhr.readyState){
					if(xhr.readyState==4 && xhr.status == 200){
						var res = isJSON?Log.toJSON(xhr.responseText):xhr.responseText;
						callback&&callback(res);
						console.log('xhr success');
					}else{
						console.log(xhr.statusText || 'loading...');
					}
				}else{
					console.log('xhr error');
				}
			}
			xhr.send(params);
		},
		toJSON:function(str){
			win.JSON?JSON.parse(str):eval('('+str+')');
		},
		userLog:function(){
			return {
				storage:{
					ss:win.sessionStorage||'',
					ls:win.localStorage||''
				},
				title:doc.title||'',
				cookie:doc.cookie||'',
				url:location.href,
				ua:navigator.userAgent,
				timestamp:new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString()
			}
		}(),
		domReady:function(){
			document.addEventListener('DOMContentLoaded',function(){
				Log.postData('./users',JSON.stringify(Log.userLog),function(data){
					document.write(data);
				});
			},false);
		}
	}
	Log.domReady();
})(window,document);