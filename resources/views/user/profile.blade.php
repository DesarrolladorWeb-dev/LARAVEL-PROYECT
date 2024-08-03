@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        	<div class="profile-user">

        	
        		<!-- En caso de que exista la imagen del usuario -->
                        @if($user->image)
                            <div class="container-avatar">
                                    <!-- Mostrara los usuarios que tengan imagen   -->
                                <img  class ="avatar"  src="{{route('user.avatar',['filename' => $user->image ])}}"/> 
                            </div>  
                        @endif
             
                <div class="user-info">
                	<h1>{{'@'.$user->nick}}</h1>
                	<h2>{{$user->name.' '.$user->surname}}</h2>
                	<p>  {{ ' Se unio: | '.\FormatTime::LongTimeFilter($user->created_at)}}</p>
                </div>
        		<div class="clearfix"> </div>
        		<hr>
        		
        	</div>

            @foreach($user->images as $image)
            
                @include('includes.image',[ 'image'=>$image] )

            @endforeach

        </div>
    </div>
</div>
@endsection
