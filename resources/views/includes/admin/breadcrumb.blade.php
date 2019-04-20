@if(isset($breadcrumb))
  <ol class="breadcrumb">
 @foreach($breadcrumb['pages'] as $key=>$pages)
<?php //pr(strtolower($key));exit;?>

  		@if(is_array($pages))

	     <li>  {!!  Html::decode(Html::linkAsset(route($pages[0],$pages[1]), strtolower($key))) !!}</li>
	     @else
             <?php //pr($pages);?>
             
	     <li>  <a href="{{ URL::to('admin/dashboard') }}">{!! $key !!}</a>
                 </li>
	     @endif
@endforeach
       


   <li class="active">{{ $breadcrumb['active'] }}</li>
         </ol>
@endif