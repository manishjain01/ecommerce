<?php if(isset($breadcrumb)): ?>
  <ol class="breadcrumb">
 <?php foreach($breadcrumb['pages'] as $key=>$pages): ?>
<?php //pr(strtolower($key));exit;?>

  		<?php if(is_array($pages)): ?>

	     <li>  <?php echo Html::decode(Html::linkAsset(route($pages[0],$pages[1]), strtolower($key))); ?></li>
	     <?php else: ?>
             <?php //pr($pages);?>
             
	     <li>  <a href="<?php echo e(URL::to('admin/dashboard')); ?>"><?php echo $key; ?></a>
                 </li>
	     <?php endif; ?>
<?php endforeach; ?>
       


   <li class="active"><?php echo e($breadcrumb['active']); ?></li>
         </ol>
<?php endif; ?>