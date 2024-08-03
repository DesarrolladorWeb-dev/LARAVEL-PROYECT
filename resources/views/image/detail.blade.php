@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')

                <div class="card pub_image pub_image_detail">



                    <div class="card-header">

                        @if($image->user->image)
                            <div class="container-avatar">

                                    <!-- Mostrara los usuarios que tengan imagen   -->
                                <img  class ="avatar"  src="{{route('user.avatar',['filename' => $image->user->image ])}}"/> 
                            </div>  
                        @endif
                        <div class="data-user">
                            
                                {{$image->user->name.' '.$image->user->surname}}
                                <span class="nickname">
                                    {{' | @'.$image->user->nick}}
                                </span>

                            
                        </div>
                        
                    </div>

                    <div class="card-body">
                        <div class="image-container image-detail">
                            <!-- aqui le enviamos al route el nombre de la imagen de la tabla image-->
                            <img src="{{route('image.file',['filename' => $image->image_path])}}" />
                        </div>
                         
                        
                        <div class="description">
                            <span class="nickname">
                                 {{'@'.$image->user->nick}} 
                            </span>
                                <span class="nickname date">
                                <!-- hace tal hora - cambias el formato de fecha  -->
                                {{ ' | '.\FormatTime::LongTimeFilter($image->created_at)}}
                            </span>
                               <p>
                                {{$image->description}}
                               </p>
                        </div>  
                        <div class="likes">
                         <span class="number_likes">  {{count($image->likes)}}</span>  
                            <!-- Comprobar el usuario si le dio like a la imagen -->
                            <?php $user_like = false; ?>

                            @foreach($image->likes as $like)
                            <!-- Si le da like a la publicacion -->
                                @if($like->user->id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach

                            <!-- si es verdadero mostrara el corazon rojo -->
                            @if($user_like) 
                                <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike" />
                            @else
                                <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like" />
                            @endif
                        </div>

                        <!-- Aparecen en caso de que sea el dueño -->
                        @if(Auth::user() && Auth::user()->id == $image->user->id)
                            <div class="action">

                                <a href="{{ route('image.edit',['id' => $image->id]) }}" class="btn btn-sm btn-primary">
                                    Actualizar
                                </a>
   <!--                              <a href="{{route('image.delete',['id' => $image->id ])}}"    class="btn btn-sm btn-danger">
                                    Borrar
                                </a> -->

                                <!-- Modal -->
                <button type="button" class="btn btn-danger  btn-sm" data-toggle="modal" data-target="#myModal">
                  Eliminar
                </button>

                <!-- The Modal -->
                <div class="modal" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">¿Estas Seguro?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        Si eliminas esta imagen nunca podras recuperar , ¿Estas Seguro de Borrar?
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                        <a href="{{route('image.delete',['id' => $image->id ])}}" class="btn  btn-danger">Borrar Definitivamente </a>
                      </div>

                    </div>
                  </div>
                </div>
                            </div>
                        @endif


                        <div class="clearfix"></div>
                            <div class="comments">
                                   
                                 <h2>
                                     Comentarios ({{ count($image->comments)}})
                                 </h2>    
                                <hr>

                                <form method="POST" action="{{route('comment.save')}}">
                                    @csrf

                                    <input type="hidden" name="image_id" value="{{$image->id}}" />

                                    <p>
                                        <textarea class="form-control {{$errors->any() ? 'is-invalid' :  '' }}" name="content" >
                                            
                                        </textarea>
                                        @if ($errors->any())
                                               <strong class="invalid-feedback">{{$errors->first('content')}}</strong>
                                        @endif
                                    </p>
                                    <button type="submit" class="btn btn-success">
                                        Enviar
                                    </button>
                                </form>
                                <hr>
                                @foreach($image->comments as $comment)
                                    <div class="comment">
                                
                                            <span class="nickname">
                                                 {{'@'.$comment->user->nick}} 
                                            </span>
                                                <span class="nickname date">
                                                <!-- hace tal hora - cambias el formato de fecha  -->
                                                {{ ' | '.\FormatTime::LongTimeFilter($comment->created_at)}}
                                            </span>
                                               <p>
                                                {{$comment->content}} <br>
                                               
                                            <!-- Para ver si estoy identificado  Auth::check()

                                            SOLO BORRARA LOS COMENTARIOS DE MI USUARIO ACTUAL
                                            Y APARECERA EL BOTON DE BORRAR
                                            -->
                                            @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                                <a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">
                                                    Eliminar
                                                </a>
                                            @endif
                                   </p>
                                    </div>
                                @endforeach
                            </div>
                       </div>
                    </div>  
                </div>
        </div>
    </div>
</div>
@endsection
