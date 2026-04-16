<form action="/predict" method="POST">
  <?php echo csrf_field(); ?>
  <input type="text" name="prediction" placeholder="Enter your prediction">
  <button type="submit">Submit</button>
</form>
<?php if(isset($prediction)): ?>
  <p>Prediction: <?php echo e($prediction['result']); ?></p>
<?php endif; ?>
<?php /**PATH D:\codeforfyp\cyberbullying\resources\views/form.blade.php ENDPATH**/ ?>