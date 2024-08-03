<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// use App\Image;



Route::get('/', function () {

    /* ORM
    $images  = Image::all(); //todas imagenes de tabla
    foreach ($images as $image) {
        //var_dump($image); //nos traera mucha info y todas las img
        echo $image->image_path.'<br/>';
        echo $image->description.'<br/>';
        // var_dump($image->user); //nos devuel un objeto de tipo usuario
        // Usuarios que crearon las imagenes
        echo $image->user->name.' '.$image->user->surname.'<br>';

        
        // Comentarios de cada imagen
        if (count($image->comments) >= 1 ) {
            echo '<strong>Comentarios</strong><br>';
            foreach ($image->comments as $comment) {
                echo $comment->user->name.' '.$comment->user->surname." : ".$comment->content . '<br>';
            }
        }
        
        echo 'LIKES:' .count($image->likes);

        echo "<hr>";

    }

    die(); //para que solo muestre el bucle 
    */
    return view('welcome');
});


// GENERAL

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

// USUARIOS

Route::get('/configuracion', 'UserController@config')->name('config');

// nombre sera use.update para usarlo con route()
Route::post('/user/update', 'UserController@update')->name('user.update');

//Mostrar Avatar
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');

// Perfil Usuario
Route::get('/perfile/{id}', 'UserController@profile')->name('profile');

// Usuarios - Buscador - buscador opcional ?
Route::get('/gente/{search?}', 'UserController@index')->name('user.index');




// IMAGEN

// Formulario imagen
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');

// Subir image
Route::post('/image/save', 'ImageController@save')->name('image.save');

// para ver las imagenes
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');

//Detalle de la imagen 
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');

// Eliminar imagen
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');

// Editar imagen
Route::get('/image/editar/{id}', 'ImageController@edit')->name('image.edit');

// Actualizar imagen
Route::post('/image/update', 'ImageController@update')->name('image.update');

// COMENTARIO

// Comentarios
Route::post('/comment/save', 'CommentController@save')->name('comment.save');

// Eliminar Comentario
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

// LIKES

// Like
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');

// Dislike
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');

// Pagina Like
Route::get('/likes', 'LikeController@index')->name('likes');



