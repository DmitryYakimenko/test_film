function add_input(){
            var inputs = $('.stars .star');
            var new_id = inputs.length+1;
            $('.stars').append('<div id= '+new_id+' class="star" ><p><b>Актер '+new_id+'</b></p>Имя: <input type="text" name="stars['+new_id+'][name]" value=""></p><p>Фамилия: <input type="text" name="stars['+new_id+'][surname]" value=""></p></div>');
			console.log(inputs);
        }