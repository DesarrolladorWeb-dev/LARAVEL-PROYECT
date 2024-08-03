
                <div class="card pub_image">



                    <div class="card-header">

                        @if($image->user->image)
                            <div class="container-avatar">

                                    <!-- Mostrara los usuarios que tengan imagen   -->
                                <img  class ="avatar"  src="{{route('user.avatar',['filename' => $image->user->image ])}}"/> 
                            </div>  
                        @endif
                        <div class="data-user">
                            <a href="{{route('profile',['id'=>$image->user->id])}}">
                                {{$image->user->name.' '.$image->user->surname}}
                           

                                <span class="nickname">
                                    {{' | @'.$image->user->nick}}
                                </span>
                            </a>

                        </div>
                        
                    </div>

                    <div class="card-body">
                        <div class="image-container">
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
                        <div class="comments">
                             <a href="{{route('image.detail',['id'=>$image->id])}}" class="btn btn-sm btn-warning btn-comments">

                             Comentarios ({{ count($image->comments)}})
                         </a>    
                        </div>
                       
                    </div>  
                </div>