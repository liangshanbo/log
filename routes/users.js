var express = require('express');
var router = express.Router();

/* GET users listing. */
router.post('/', function(req, res, next) {
	var params = req.body;
	if(params.storage.ss){
		params.ss = [];
		for(var s in params.storage.ss){
			params.ss.push({name:s,val:params.storage.ss[s]});
		}
	}
	if(params.storage.ls){
		params.ls = [];
		for(var l in params.storage.ls){
			params.ls.push({name:l,val:params.storage.ls[l]});
		}
	}
	console.log(params);
	// res.render('users',{title:'params',params:params});
	
});

module.exports = router;
