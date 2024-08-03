@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>Todos Los Usuarios</h1>
            <form method="GET" action="{{route('user.index')}}" id="buscador">
                <div class="row">
                    <div class="form-group col" >
                        <!-- SIN NAME NO ME ENVIA NINGUN PARAMETRO -->
                         <input type="text" id="search" class="form-control" />
                    </div>
                    <div class="form-group col btn-search" >
                        <input type="submit" value="Buscar"  class="btn btn-success " />
                    </div>
                    </div>
            </form>
             
                
            <hr>
            @foreach($users as $user)
            
                    <div class="profile-user">

            
                <!-- En caso de que exista la imagen del usuario -->
                        @if($user->image)
                            <div class="container-avatar">
                                    <!-- Mostrara los usuarios que tengan imagen   -->
                                <img  class ="avatar"  src="{{route('user.avatar',['filename' => $user->image ])}}"/> 
                            </div>  
                        @endif
             
                        <div class="user-info">
                            <h2>{{'@'.$user->nick}}</h2>
                            <h3>{{$user->name.' '.$user->surname}}</h3>
                            <p>  {{ ' Se unio: | '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                            <a href="{{route('profile',['id' => $user->id])}}" class="btn btn-success"> Ver Perfil</a>
                        </div>
                        <div class="clearfix"> </div>
                        <hr>
                        
                    </div>
            @endforeach



             <!-- PAGINACION -->
            <div class="clearfix"></div>
                <!-- veremos la paginacion y nos crea un paginador y la url cambia -->
                {{$users->links()}}  
        </div>
    </div>
</div>
@endsection
