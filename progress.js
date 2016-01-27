var app = app || {} ;
(function(o){
	var ajax , getFormData , setProgress ;

	ajax = function(data)
	{
		var xmlhttp = new XMLHttpRequest() , uploaded;
		xmlhttp.addEventListener('readystatechange' , function(){
			if(this.readyState === 4)
			{
				if(this.status === 200)
				{
					console.log("Reached here");
					window.location = "myuploads.php?" + document.getElementById("zip_name").value + "=1" ;
				}
			}
		});

		xmlhttp.upload.addEventListener('progress' , function(e){
			var percent ;
			// if(e.lengthComputable == true)
			{
				percent = Math.round((e.loaded/e.total) * 100) ;
				console.log(percent);
				setProgress(percent) ;
			}
		});

		xmlhttp.open("POST" , o.options.processor);
		xmlhttp.send(data);
	};

	getFormData = function(source)
	{
		var data = new FormData() , i;
		console.log(source);
		for(i = 0 ; i < source.length ; i++)
		{
			data.append('fileselect[]' , source[i]) ;
		}
		console.log(data);
		data.append('ajax' , true) ;
		if(document.getElementById("checkbox2").checked)
		{
			data.append('check' , 'yes');
			data.append('pass_word' , document.getElementById("pass").value);
		}
		data.append("zip_name" , document.getElementById("zip_name").value);
		console.log(data) ;
		return data ;

	};

	setProgress = function(value)
	{
		console.log(value);
		if(o.options.progressText !== undefined)
		{
			if(value === 100)
			{
				o.options.progressText.innerHTML = "Compressing.........." ;
			}
			else
				o.options.progressText.innerHTML = value + "%" ;
		}

		if(o.options.progressBar !== undefined)
		{
			console.log("value");
			o.options.progressBar.style.width = value + "%" ;
		}
	};

	o.uploader = function(options)
	{
		o.options = options ;

		if(o.options.files !== undefined)
		{
			ajax(getFormData(o.options.files.files))
			console.log(o.options.files.files);
		}
	}

}(app));