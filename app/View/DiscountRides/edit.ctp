<div class="discountRides form">
<?php echo $this->Form->create('DiscountRide'); ?>
	<fieldset>
		<legend><?php echo __('Edit Discount Ride'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('driver_id');
		echo $this->Form->input('origin');
		echo $this->Form->input('destination');
		echo $this->Form->input('date');
		echo $this->Form->input('hour_min');
		echo $this->Form->input('hour_max');
		echo $this->Form->input('price');
		echo $this->Form->input('is_booked');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DiscountRide.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DiscountRide.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Discount Rides'), array('action' => 'index')); ?></li>
	</ul>
</div>
