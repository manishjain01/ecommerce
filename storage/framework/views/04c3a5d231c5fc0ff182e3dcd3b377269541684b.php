<html>
<head>
    <title>IndiPay</title>
</head>
<body>
    <form method="post" name="redirect" action="<?php echo e($endPoint); ?>">
        <input type=hidden name="key" value="<?php echo e($parameters['key']); ?>">
        <input type=hidden name="hash" value="<?php echo e($hash); ?>">
        <input type=hidden name="txnid" value="<?php echo e($parameters['txnid']); ?>">
        <input type=hidden name="amount" value="<?php echo e($parameters['amount']); ?>">
        <input type=hidden name="firstname" value="<?php echo e($parameters['firstname']); ?>">
        <input type=hidden name="email" value="<?php echo e($parameters['email']); ?>">
        <input type=hidden name="phone" value="<?php echo e($parameters['phone']); ?>">
        <input type=hidden name="productinfo" value="<?php echo e($parameters['productinfo']); ?>">
        <input type=hidden name="surl" value="<?php echo e($parameters['surl']); ?>">
        <input type=hidden name="furl" value="<?php echo e($parameters['furl']); ?>">
        <input type=hidden name="service_provider" value="<?php echo e($parameters['service_provider']); ?>">


        <input type=hidden name="lastname" value="<?php echo e(isset($parameters['lastname']) ? $parameters['lastname'] : ''); ?>">
        <input type=hidden name="curl" value="<?php echo e(isset($parameters['curl']) ? $parameters['curl'] : ''); ?>">
        <input type=hidden name="address1" value="<?php echo e(isset($parameters['address1']) ? $parameters['address1'] : ''); ?>">
        <input type=hidden name="address2" value="<?php echo e(isset($parameters['address2']) ? $parameters['address2'] : ''); ?>">
        <input type=hidden name="city" value="<?php echo e(isset($parameters['city']) ? $parameters['city'] : ''); ?>">
        <input type=hidden name="state" value="<?php echo e(isset($parameters['state']) ? $parameters['state'] : ''); ?>">
        <input type=hidden name="country" value="<?php echo e(isset($parameters['country']) ? $parameters['country'] : ''); ?>">
        <input type=hidden name="zipcode" value="<?php echo e(isset($parameters['zipcode']) ? $parameters['zipcode'] : ''); ?>">
        <input type=hidden name="udf1" value="<?php echo e(isset($parameters['udf1']) ? $parameters['udf1'] : ''); ?>">
        <input type=hidden name="udf2" value="<?php echo e(isset($parameters['udf2']) ? $parameters['udf2'] : ''); ?>">
        <input type=hidden name="udf3" value="<?php echo e(isset($parameters['udf3']) ? $parameters['udf3'] : ''); ?>">
        <input type=hidden name="udf4" value="<?php echo e(isset($parameters['udf4']) ? $parameters['udf4'] : ''); ?>">
        <input type=hidden name="udf5" value="<?php echo e(isset($parameters['udf5']) ? $parameters['udf5'] : ''); ?>">
        <input type=hidden name="pg" value="<?php echo e(isset($parameters['pg']) ? $parameters['pg'] : ''); ?>">
    </form>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

