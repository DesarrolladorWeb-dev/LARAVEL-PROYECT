var url = 'http://proyecto-laravel.com.devel';



window.addEventListener("load", function () {

	$('.btn-like').css('cursor','pointer');
	$('.btn-dislike').css('cursor','pointer');
 
	// Boton de like
	function like(){
		// unbind('click') - quita todos los click antiguos que haya
		$('.btn-like').unbind('click').click(function(){
			$(this).addClass('btn-dislike').removeClass('btn-like');
			$(this).attr('src', url+'/img/heart-red.png');
			$.ajax({
				url: url+'/like/'+$(this).data('id'),
				type:'GET',
				success: function(response){
					if(response.like){
						console.log('Like a la publicacion');
					}else{
						console.log('Error al dar like');
					}
				}
			});

			dislike();
		});
	}
	like();

	// Boton de dislike
	function dislike(){
			$('.btn-dislike').unbind('click').click(function(){
			$(this).addClass('btn-like').removeClass('btn-dislike');
			$(this).attr('src', url+'/img/heart-black.png');
			$.ajax({
				url: url+'/dislike/'+$(this).data('id'),
				type:'GET',
				success: function(response){
					if(response.like){
						console.log('Dislike a la publicacion');
					}else{
						console.log('Error al dar Dislike');
					}
				}
			});
			like();
		})
	}
	dislike();

	
	// BUSCADOR 
	$('#buscador').submit(function(e){
		// e.preventDefault();
		// creamos el url y lo ingresamos en el form como action
		$(this).attr('action',url+'/gente/'+$('#buscador #search').val());
		
	});

});


// 05:11